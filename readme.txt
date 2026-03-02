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

Schützt den WooCommerce Checkout mit unsichtbarem Google reCAPTCHA v3 gegen Bot-Bestellungen und Card-Testing-Attacken.

== Beschreibung ==

Dieses Plugin fügt Google reCAPTCHA v3 unsichtbar zum WooCommerce Checkout hinzu. Kunden merken nichts davon - keine Bilder auswählen, nichts anklicken. Bots und Card-Testing-Attacken werden automatisch blockiert.

**Features:**
* Unsichtbarer reCAPTCHA v3 Schutz (kein Nutzer-Input nötig)
* Konfigurierbarer Score-Schwellenwert
* Testmodus zum Einrichten (loggt nur, blockiert nicht)
* Logging unter WooCommerce > Status > Logs
* Fail-Open: Wenn Google nicht erreichbar, werden echte Kunden durchgelassen
* Cloudflare-kompatible IP-Erkennung
* HPOS-kompatibel

== Installation ==

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

== FAQ ==

= Müssen Kunden etwas eingeben oder anklicken? =
Nein! reCAPTCHA v3 ist komplett unsichtbar. Es analysiert das Verhalten im Hintergrund.

= Was passiert wenn Google nicht erreichbar ist? =
Bestellungen werden trotzdem durchgelassen (Fail-Open). Lieber einen Bot durchlassen als echte Kunden blockieren.

= Welchen Score-Schwellenwert soll ich nehmen? =
Start mit 0.5 (Default). Wenn du viele Bots siehst, erhöhe auf 0.6-0.7. Schau dir die Logs an um die Scores zu verstehen.

= Funktioniert es mit dem Block-Checkout? =
Aktuell nur mit dem klassischen WooCommerce Checkout (Shortcode). Der Block-basierte Checkout wird noch nicht unterstützt.

== Changelog ==

= 1.0.0 =
* Erste Version
* reCAPTCHA v3 auf WooCommerce Checkout
* Admin-Einstellungen unter WooCommerce > Settings > reCAPTCHA
* Testmodus und Logging
