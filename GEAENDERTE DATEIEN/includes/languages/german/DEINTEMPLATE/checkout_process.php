<?php
/**
 * Zen Cart German Specific (158 code in 157)
 
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: checkout_process.php for COWOA 2023-11-15 15:40:14Z webchills $
 */
// cowoa do not change
if (isset($_SESSION['COWOA']) && $_SESSION['COWOA'] == true) {
define('EMAIL_TEXT_INVOICE_URL', 'Bestellstatus einsehen:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Um Ihren Bestellstatus zu überprüfen bitte hier klicken');
} else {
define('EMAIL_TEXT_INVOICE_URL', 'Bestelldetails:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Für Details zur Bestellung bitte hier klicken');
}

// ab hier koennen Sie falls noetig Anpassungen vornehmen, die Definitionen weiter oben NIE aendern!

define('EMAIL_TEXT_SUBJECT', 'Bestellbestätigung');
define('EMAIL_TEXT_HEADER', 'Bestellbestätigung ');
define('EMAIL_TEXT_FROM', ' von ');
define('EMAIL_THANKS_FOR_SHOPPING', 'Vielen Dank für Ihren Einkauf!');
define('EMAIL_DETAILS_FOLLOW', 'Im Nachfolgenden sehen Sie die Details Ihrer Bestellung.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Bestellnummer:');

define('EMAIL_TEXT_DATE_ORDERED', 'Bestelldatum:');
define('EMAIL_TEXT_PRODUCTS', 'Artikel');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Lieferanschrift');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Rechnungsanschrift');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Zahlungsart');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_ORDER_NUMBER_SUBJECT',' Bestellnummer ');

define('EMAIL_GREETING_MR', 'Sehr geehrter Herr');
define('EMAIL_GREETING_MS', 'Sehr geehrte Frau');
define('EMAIL_GREETING_NEUTRAL', 'Guten Tag');

