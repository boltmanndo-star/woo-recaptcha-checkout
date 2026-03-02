# 🛡️ WooCommerce reCAPTCHA v3 Checkout

Protects WooCommerce checkout with invisible Google reCAPTCHA v3 against bot orders and card-testing attacks.

Schützt den WooCommerce Checkout mit unsichtbarem Google reCAPTCHA v3 gegen Bot-Bestellungen und Card-Testing-Attacken.

---

## Features

- 🔒 Invisible reCAPTCHA v3 protection (no user input required)
- 🎚️ Configurable score threshold
- 🧪 Test mode for setup (logs only, does not block)
- 📋 Logging under WooCommerce > Status > Logs
- 🟢 Fail-open: if Google is unreachable, real customers are let through
- ☁️ Cloudflare-compatible IP detection
- 📦 HPOS compatible

## Setup

```bash
# 1. Upload plugin folder to wp-content/plugins/
cp -r woo-recaptcha-checkout /path/to/wp-content/plugins/

# 2. Activate in WordPress Admin under Plugins
```

Then configure:

1. Get your reCAPTCHA v3 keys at [google.com/recaptcha/admin](https://www.google.com/recaptcha/admin)
2. Go to **WooCommerce > Settings > reCAPTCHA**
3. Enter **Site Key** and **Secret Key**
4. Check **Enabled** and save
5. Done!

> **Tip:** Enable test mode first and place a few test orders. Check the scores under **WooCommerce > Status > Logs** (source: `woo-recaptcha-checkout`).

## FAQ

| Question | Answer |
|----------|--------|
| Do customers have to click anything? | No! reCAPTCHA v3 is completely invisible. |
| What if Google is unreachable? | Orders still go through (fail-open). |
| What score threshold should I use? | Start with 0.5. Increase to 0.6–0.7 if needed. |
| Block checkout support? | Classic checkout only (shortcode). Block checkout not yet supported. |

## Tech Stack

- **PHP 7.4+** / WordPress 5.8+
- **WooCommerce 5.0+** (tested up to 9.0)
- **Google reCAPTCHA v3** API

## License

GPL-2.0+ — see [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html)
