=== WooCommerce reCAPTCHA v3 Checkout ===
Contributors: benni
Tags: woocommerce, recaptcha, checkout, fraud, card-testing
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
WC requires at least: 5.0
WC tested up to: 9.0
Stable tag: 1.1.0
License: GPL-2.0+

Protects WooCommerce checkout with invisible Google reCAPTCHA v3 against bot orders and card-testing attacks.

== Description ==

This plugin adds invisible Google reCAPTCHA v3 to the WooCommerce checkout. Customers won't notice a thing - no image puzzles, no clicking. Bots and card-testing attacks are automatically blocked.

**Features:**
* Invisible reCAPTCHA v3 protection (no user input required)
* Configurable score threshold
* Test mode for setup (logs only, does not block)
* Logging under WooCommerce > Status > Logs
* Fail-open: if Google is unreachable, real customers are let through
* Cloudflare-compatible IP detection
* HPOS compatible

== Installation ==

1. Upload the `woo-recaptcha-checkout` folder to `wp-content/plugins/`
2. Activate the plugin in WordPress Admin under Plugins
3. Get your Google reCAPTCHA v3 keys:
   - Go to https://www.google.com/recaptcha/admin
   - Select "reCAPTCHA v3"
   - Enter your domain(s)
   - Copy the Site Key and Secret Key
4. Go to WooCommerce > Settings > reCAPTCHA and enter your keys
5. Check "Enabled" and save
6. Done!

**Tip:** Enable test mode first and place a few test orders. Check the scores under WooCommerce > Status > Logs (source: woo-recaptcha-checkout).

== FAQ ==

= Do customers have to enter or click anything? =
No! reCAPTCHA v3 is completely invisible. It analyzes behavior in the background.

= What happens if Google is unreachable? =
Orders will still go through (fail-open). Better to let a bot through than to block real customers.

= What score threshold should I use? =
Start with 0.5 (default). If you see many bots, increase to 0.6-0.7. Check the logs to understand the scores.

= Does it work with the block checkout? =
Currently only with the classic WooCommerce checkout (shortcode). The block-based checkout is not yet supported.

---

== Beschreibung (Deutsch) ==

Dieses Plugin fügt Google reCAPTCHA v3 unsichtbar zum WooCommerce Checkout hinzu. Kunden merken nichts davon - keine Bilder auswählen, nichts anklicken. Bots und Card-Testing-Attacken werden automatisch blockiert.

**Features:**
* Unsichtbarer reCAPTCHA v3 Schutz (kein Nutzer-Input nötig)
* Konfigurierbarer Score-Schwellenwert
* Testmodus zum Einrichten (loggt nur, blockiert nicht)
* Logging unter WooCommerce > Status > Logs
* Fail-Open: Wenn Google nicht erreichbar, werden echte Kunden durchgelassen
* Cloudflare-kompatible IP-Erkennung
* HPOS-kompatibel

== Installation (Deutsch) ==

1. Plugin-Ordner `woo-recaptcha-checkout` nach `wp-content/plugins/` hochladen
2. Plugin im WordPress Admin unter Plugins aktivieren
3. Google reCAPTCHA v3 Keys holen:
   - Gehe zu https://www.google.com/recaptcha/admin
   - "reCAPTCHA v3" auswählen
   - Deine Domain(s) eintragen
   - Site Key und Secret Key kopieren
4. Unter WooCommerce > Einstellungen > reCAPTCHA die Keys eintragen
5. "Aktiviert" ankreuzen und speichern
6. Fertig!

**Tipp:** Zuerst den Testmodus aktivieren und ein paar Testbestellungen machen. Unter WooCommerce > Status > Logs (Quelle: woo-recaptcha-checkout) siehst du die Scores.

== FAQ (Deutsch) ==

= Müssen Kunden etwas eingeben oder anklicken? =
Nein! reCAPTCHA v3 ist komplett unsichtbar. Es analysiert das Verhalten im Hintergrund.

= Was passiert wenn Google nicht erreichbar ist? =
Bestellungen werden trotzdem durchgelassen (Fail-Open). Lieber einen Bot durchlassen als echte Kunden blockieren.

= Welchen Score-Schwellenwert soll ich nehmen? =
Start mit 0.5 (Default). Wenn du viele Bots siehst, erhöhe auf 0.6-0.7. Schau dir die Logs an um die Scores zu verstehen.

= Funktioniert es mit dem Block-Checkout? =
Aktuell nur mit dem klassischen WooCommerce Checkout (Shortcode). Der Block-basierte Checkout wird noch nicht unterstützt.

== Changelog ==

= 1.1.0 =
* Version sync and bilingual readme

= 1.0.0 =
* Initial release
* reCAPTCHA v3 on WooCommerce checkout
* Admin settings under WooCommerce > Settings > reCAPTCHA
* Test mode and logging
