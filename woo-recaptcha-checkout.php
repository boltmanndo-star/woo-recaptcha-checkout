<?php
/**
 * Plugin Name: WooCommerce reCAPTCHA v3 Checkout
 * Plugin URI:  https://github.com/boltmanndo-star/woo-recaptcha-checkout
 * Description: Schützt den WooCommerce Checkout mit unsichtbarem Google reCAPTCHA v3 gegen Bot-Bestellungen und Card-Testing-Attacken.
 * Version:     1.1.0
 * Author:      Benni
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: woo-recaptcha-checkout
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 * WC requires at least: 5.0
 * WC tested up to: 9.0
 */

defined( 'ABSPATH' ) || exit;

define( 'WRC_VERSION', '1.1.0' );
define( 'WRC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WRC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// ─── Activation Check ──────────────────────────────────────────────────
register_activation_hook( __FILE__, 'wrc_on_activation' );

function wrc_on_activation() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die(
            esc_html__( 'WooCommerce reCAPTCHA Checkout benötigt WooCommerce. Bitte zuerst WooCommerce installieren und aktivieren.', 'woo-recaptcha-checkout' ),
            'Plugin-Abhängigkeit',
            array( 'back_link' => true )
        );
    }
}

// ─── HPOS Compatibility ────────────────────────────────────────────────
add_action( 'before_woocommerce_init', function () {
    if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            'custom_order_tables',
            __FILE__,
            true
        );
    }
} );

// ─── Bootstrap ─────────────────────────────────────────────────────────
add_action( 'plugins_loaded', 'wrc_init' );

function wrc_init() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', 'wrc_missing_wc_notice' );
        return;
    }

    require_once WRC_PLUGIN_DIR . 'includes/class-wrc-settings.php';

    // Settings tab
    add_filter( 'woocommerce_get_settings_pages', 'wrc_add_settings_page' );

    // Settings link on Plugins page
    add_filter( 'plugin_action_links_' . WRC_PLUGIN_BASENAME, 'wrc_plugin_action_links' );

    // Frontend + backend hooks only when enabled and configured
    if ( wrc_is_enabled() ) {
        add_action( 'wp_enqueue_scripts', 'wrc_enqueue_recaptcha_script' );
        add_action( 'woocommerce_after_checkout_billing_form', 'wrc_add_hidden_token_field' );
        add_action( 'woocommerce_after_checkout_form', 'wrc_output_recaptcha_js' );
        add_action( 'woocommerce_after_checkout_validation', 'wrc_verify_recaptcha', 10, 2 );
    }
}

// ─── Helpers ───────────────────────────────────────────────────────────

function wrc_is_enabled() {
    return 'yes' === get_option( 'wrc_enabled', 'no' )
        && '' !== get_option( 'wrc_site_key', '' )
        && '' !== get_option( 'wrc_secret_key', '' );
}

function wrc_get_client_ip() {
    $headers = array(
        'HTTP_CF_CONNECTING_IP',   // Cloudflare
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR',
    );
    foreach ( $headers as $header ) {
        if ( ! empty( $_SERVER[ $header ] ) ) {
            $ip = sanitize_text_field( wp_unslash( $_SERVER[ $header ] ) );
            if ( strpos( $ip, ',' ) !== false ) {
                $ip = trim( explode( ',', $ip )[0] );
            }
            if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
                return $ip;
            }
        }
    }
    return '0.0.0.0';
}

function wrc_log( $message, $level = 'warning' ) {
    if ( 'yes' !== get_option( 'wrc_enable_logging', 'yes' ) ) {
        return;
    }
    if ( function_exists( 'wc_get_logger' ) ) {
        wc_get_logger()->log( $level, $message, array( 'source' => 'woo-recaptcha-checkout' ) );
    }
}

// ─── Admin ─────────────────────────────────────────────────────────────

function wrc_missing_wc_notice() {
    echo '<div class="error"><p><strong>'
       . esc_html__( 'WooCommerce reCAPTCHA Checkout benötigt WooCommerce.', 'woo-recaptcha-checkout' )
       . '</strong></p></div>';
}

function wrc_add_settings_page( $settings ) {
    $settings[] = new WRC_Settings();
    return $settings;
}

function wrc_plugin_action_links( $links ) {
    $url  = admin_url( 'admin.php?page=wc-settings&tab=wrc_recaptcha' );
    $link = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Einstellungen', 'woo-recaptcha-checkout' ) . '</a>';
    array_unshift( $links, $link );
    return $links;
}

// ─── Frontend: Load reCAPTCHA v3 ───────────────────────────────────────

function wrc_enqueue_recaptcha_script() {
    if ( ! is_checkout() || is_order_received_page() ) {
        return;
    }

    $site_key = get_option( 'wrc_site_key', '' );
    if ( empty( $site_key ) ) {
        return;
    }

    wp_enqueue_script(
        'google-recaptcha-v3',
        'https://www.google.com/recaptcha/api.js?render=' . rawurlencode( $site_key ),
        array(),
        null,
        true
    );
}

// ─── Frontend: Hidden token field via PHP ──────────────────────────────

function wrc_add_hidden_token_field() {
    echo '<input type="hidden" name="wrc_recaptcha_token" id="wrc_recaptcha_token" value="" />';
}

// ─── Frontend: JS for token capture ────────────────────────────────────

function wrc_output_recaptcha_js() {
    $site_key = esc_attr( get_option( 'wrc_site_key', '' ) );
    if ( empty( $site_key ) ) {
        return;
    }
    ?>
    <script type="text/javascript">
    (function($) {
        var siteKey = '<?php echo $site_key; ?>';
        var wrcTokenReady = false;

        function wrcSetToken(token) {
            var el = document.getElementById('wrc_recaptcha_token');
            if (el) el.value = token;
        }

        // Pre-load token on page load for faster checkout
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, { action: 'woo_checkout' })
                    .then(wrcSetToken)
                    .catch(function() {});
            });
        }

        // Refresh token on submit (tokens expire after 2 min)
        $(document.body).on('checkout_place_order', function() {
            if (wrcTokenReady) {
                wrcTokenReady = false;
                return true;
            }

            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, { action: 'woo_checkout' })
                    .then(function(token) {
                        wrcSetToken(token);
                        wrcTokenReady = true;
                        $('form.checkout').trigger('submit');
                    })
                    .catch(function(err) {
                        // Fail open: if reCAPTCHA JS fails, let checkout proceed
                        console.error('reCAPTCHA error:', err);
                        wrcTokenReady = true;
                        $('form.checkout').trigger('submit');
                    });
            });

            return false;
        });
    })(jQuery);
    </script>
    <?php
}

// ─── Backend: Verify reCAPTCHA token ───────────────────────────────────

function wrc_verify_recaptcha( $data, $errors ) {
    $token      = isset( $_POST['wrc_recaptcha_token'] ) ? sanitize_text_field( wp_unslash( $_POST['wrc_recaptcha_token'] ) ) : '';
    $secret_key = get_option( 'wrc_secret_key', '' );
    $threshold  = floatval( get_option( 'wrc_score_threshold', 0.5 ) );
    $test_mode  = 'yes' === get_option( 'wrc_test_mode', 'no' );

    $error_message = get_option(
        'wrc_error_message',
        __( 'Sicherheitsüberprüfung fehlgeschlagen. Bitte versuchen Sie es erneut.', 'woo-recaptcha-checkout' )
    );

    // No secret key = misconfigured, fail open
    if ( empty( $secret_key ) ) {
        return;
    }

    // No token = bot posted directly without JS
    if ( empty( $token ) ) {
        wrc_log( 'Kein reCAPTCHA-Token erhalten. IP: ' . wrc_get_client_ip() );
        if ( ! $test_mode ) {
            $errors->add( 'wrc_recaptcha', $error_message );
        }
        return;
    }

    // Verify with Google
    $response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
        'timeout' => 5,
        'body'    => array(
            'secret'   => $secret_key,
            'response' => $token,
            'remoteip' => wrc_get_client_ip(),
        ),
    ) );

    // Google API unreachable -> fail open
    if ( is_wp_error( $response ) ) {
        wrc_log( 'Google reCAPTCHA API nicht erreichbar: ' . $response->get_error_message() );
        return;
    }

    $status_code = wp_remote_retrieve_response_code( $response );
    if ( $status_code !== 200 ) {
        wrc_log( 'Google reCAPTCHA API HTTP ' . $status_code );
        return;
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( empty( $body ) ) {
        wrc_log( 'Google reCAPTCHA API: ungültige Antwort.' );
        return;
    }

    // Verification failed
    if ( empty( $body['success'] ) ) {
        $codes = isset( $body['error-codes'] ) ? implode( ', ', $body['error-codes'] ) : 'unbekannt';
        wrc_log( 'reCAPTCHA Verifikation fehlgeschlagen. Fehler: ' . $codes . '. IP: ' . wrc_get_client_ip() );
        if ( ! $test_mode ) {
            $errors->add( 'wrc_recaptcha', $error_message );
        }
        return;
    }

    // Action mismatch (token from wrong page)
    if ( isset( $body['action'] ) && 'woo_checkout' !== $body['action'] ) {
        wrc_log( 'reCAPTCHA Action-Mismatch: erwartet "woo_checkout", erhalten "' . $body['action'] . '". IP: ' . wrc_get_client_ip() );
        if ( ! $test_mode ) {
            $errors->add( 'wrc_recaptcha', $error_message );
        }
        return;
    }

    // Score check
    $score = isset( $body['score'] ) ? floatval( $body['score'] ) : 0.0;

    if ( $score < $threshold ) {
        wrc_log( sprintf(
            'reCAPTCHA Score zu niedrig: %.2f (Schwellenwert: %.2f). IP: %s',
            $score,
            $threshold,
            wrc_get_client_ip()
        ) );
        if ( $test_mode ) {
            wrc_log( sprintf( 'TESTMODUS: Bestellung wäre blockiert worden. Score: %.2f', $score ), 'info' );
        } else {
            $errors->add( 'wrc_recaptcha', $error_message );
        }
        return;
    }

    // Passed
    wrc_log( sprintf( 'reCAPTCHA bestanden. Score: %.2f. IP: %s', $score, wrc_get_client_ip() ), 'info' );
}
