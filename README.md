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
- 🛒 Works with standard checkout, One Page Checkout, and custom checkout pages

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
| Block checkout support? | Classic checkout and One Page Checkout are supported. Block-based checkout not yet supported. |

## Tech Stack

- **PHP 7.4+** / WordPress 5.8+
- **WooCommerce 5.0+** (tested up to 9.0)
- **Google reCAPTCHA v3** API

---

## 🇩🇪 Deutsch

### Features

- 🔒 Unsichtbarer reCAPTCHA v3 Schutz (kein Nutzer-Input nötig)
- 🎚️ Konfigurierbarer Score-Schwellenwert
- 🧪 Testmodus zum Einrichten (loggt nur, blockiert nicht)
- 📋 Logging unter WooCommerce > Status > Logs
- 🟢 Fail-Open: Wenn Google nicht erreichbar, werden echte Kunden durchgelassen
- ☁️ Cloudflare-kompatible IP-Erkennung
- 📦 HPOS-kompatibel
- 🛒 Funktioniert mit Standard-Checkout, One Page Checkout und Custom-Checkout-Seiten

### Einrichtung

```bash
# 1. Plugin-Ordner nach wp-content/plugins/ hochladen
cp -r woo-recaptcha-checkout /path/to/wp-content/plugins/

# 2. Plugin im WordPress Admin unter Plugins aktivieren
```

Dann konfigurieren:

1. reCAPTCHA v3 Keys holen unter [google.com/recaptcha/admin](https://www.google.com/recaptcha/admin)
2. Gehe zu **WooCommerce > Einstellungen > reCAPTCHA**
3. **Site Key** und **Secret Key** eintragen
4. **Aktiviert** ankreuzen und speichern
5. Fertig!

> **Tipp:** Zuerst den Testmodus aktivieren und ein paar Testbestellungen machen. Unter **WooCommerce > Status > Logs** (Quelle: `woo-recaptcha-checkout`) siehst du die Scores.

### FAQ

| Frage | Antwort |
|-------|---------|
| Müssen Kunden etwas anklicken? | Nein! reCAPTCHA v3 ist komplett unsichtbar. |
| Was passiert wenn Google nicht erreichbar ist? | Bestellungen werden trotzdem durchgelassen (Fail-Open). |
| Welchen Score-Schwellenwert nehmen? | Start mit 0.5. Bei vielen Bots auf 0.6–0.7 erhöhen. |
| Block-Checkout Support? | Klassischer Checkout und One Page Checkout werden unterstützt. Block-Checkout noch nicht. |

---

## License

GPL-2.0+ — see [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html)
