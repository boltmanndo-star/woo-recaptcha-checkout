<?php
/**
 * WooCommerce reCAPTCHA Settings
 *
 * Adds a "reCAPTCHA" tab under WooCommerce > Settings.
 */

defined( 'ABSPATH' ) || exit;

class WRC_Settings extends WC_Settings_Page {

    public function __construct() {
        $this->id    = 'wrc_recaptcha';
        $this->label = __( 'reCAPTCHA', 'woo-recaptcha-checkout' );
        parent::__construct();
    }

    protected function get_settings_for_default_section() {
        return array(

            array(
                'title' => __( 'reCAPTCHA v3 Checkout-Schutz', 'woo-recaptcha-checkout' ),
                'desc'  => sprintf(
                    /* translators: %s = link to Google reCAPTCHA admin */
                    __( 'Schützt deinen Checkout vor Bot-Attacken mit Google reCAPTCHA v3 (unsichtbar). Keys bekommst du unter %s.', 'woo-recaptcha-checkout' ),
                    '<a href="https://www.google.com/recaptcha/admin" target="_blank">google.com/recaptcha/admin</a>'
                ),
                'type' => 'title',
                'id'   => 'wrc_section_main',
            ),

            array(
                'title'   => __( 'Aktiviert', 'woo-recaptcha-checkout' ),
                'desc'    => __( 'reCAPTCHA v3 auf dem Checkout aktivieren', 'woo-recaptcha-checkout' ),
                'id'      => 'wrc_enabled',
                'type'    => 'checkbox',
                'default' => 'no',
            ),

            array(
                'title'    => __( 'Site Key', 'woo-recaptcha-checkout' ),
                'desc'     => __( 'Dein reCAPTCHA v3 Site Key (öffentlich).', 'woo-recaptcha-checkout' ),
                'id'       => 'wrc_site_key',
                'type'     => 'text',
                'default'  => '',
                'css'      => 'min-width: 400px;',
                'desc_tip' => true,
            ),

            array(
                'title'    => __( 'Secret Key', 'woo-recaptcha-checkout' ),
                'desc'     => __( 'Dein reCAPTCHA v3 Secret Key (geheim, wird nie öffentlich angezeigt).', 'woo-recaptcha-checkout' ),
                'id'       => 'wrc_secret_key',
                'type'     => 'password',
                'default'  => '',
                'css'      => 'min-width: 400px;',
                'desc_tip' => true,
            ),

            array(
                'title'             => __( 'Score-Schwellenwert', 'woo-recaptcha-checkout' ),
                'desc'              => __( 'Minimaler Score um den Checkout zuzulassen. 0.0 = alles durchlassen, 1.0 = sehr streng. Empfohlen: 0.5', 'woo-recaptcha-checkout' ),
                'id'                => 'wrc_score_threshold',
                'type'              => 'number',
                'default'           => '0.5',
                'css'               => 'width: 80px;',
                'custom_attributes' => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '0.1',
                ),
                'desc_tip'          => true,
            ),

            array(
                'title'    => __( 'Fehlermeldung', 'woo-recaptcha-checkout' ),
                'desc'     => __( 'Diese Meldung sehen Kunden, wenn die Überprüfung fehlschlägt.', 'woo-recaptcha-checkout' ),
                'id'       => 'wrc_error_message',
                'type'     => 'textarea',
                'default'  => __( 'Sicherheitsüberprüfung fehlgeschlagen. Bitte versuchen Sie es erneut.', 'woo-recaptcha-checkout' ),
                'css'      => 'min-width: 400px; height: 60px;',
                'desc_tip' => true,
            ),

            array(
                'title'   => __( 'Testmodus', 'woo-recaptcha-checkout' ),
                'desc'    => __( 'Im Testmodus werden Bestellungen NICHT blockiert, aber der Score wird geloggt. Ideal zum Einrichten.', 'woo-recaptcha-checkout' ),
                'id'      => 'wrc_test_mode',
                'type'    => 'checkbox',
                'default' => 'no',
            ),

            array(
                'title'   => __( 'Logging', 'woo-recaptcha-checkout' ),
                'desc'    => __( 'Geblockte Versuche unter WooCommerce > Status > Logs protokollieren', 'woo-recaptcha-checkout' ),
                'id'      => 'wrc_enable_logging',
                'type'    => 'checkbox',
                'default' => 'yes',
            ),

            array(
                'type' => 'sectionend',
                'id'   => 'wrc_section_main',
            ),
        );
    }
}
