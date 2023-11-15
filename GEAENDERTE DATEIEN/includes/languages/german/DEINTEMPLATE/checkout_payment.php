<?php
/**
 * Zen Cart German Specific (158 code in 157)
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: checkout_payment.php for COWOA 2023-11-15 15:39:14Z webchills $
 */

// cowoa do not change
if (isset($_SESSION['COWOA']) && $_SESSION['COWOA'] == true) {
define('HEADING_TITLE', 'Schritt 3 von 4 : Zahlungsinformationen');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Weiter zu Schritt 4</strong>');
} else {
define('HEADING_TITLE', 'Schritt 2 von 3 : Zahlungsinformationen');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Weiter zu Schritt 3</strong>');
}

// ab hier koennen Sie falls noetig Anpassungen vornehmen, die Definitionen weiter oben NIE aendern!

define('NAVBAR_TITLE_1', 'Bestellung - Schritt 2');
define('NAVBAR_TITLE_2', ' Schritt 2 - Zahlungsart wählen');
define('TABLE_HEADING_BILLING_ADDRESS', 'Rechnungsanschrift');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Ihre Rechnungsanschrift steht links. Sie können Ihre Rechnungsanschrift ändern indem Sie auf <em>Adresse ändern</em> klicken.');
define('TITLE_BILLING_ADDRESS', 'Rechnungsanschrift:');


define('TEXT_SELECT_PAYMENT_METHOD', 'Bitte wählen Sie eine Zahlungsart für diese Bestellung.');
define('TITLE_PLEASE_SELECT', 'Bitte wählen Sie');


define('TEXT_NO_PAYMENT_OPTIONS_AVAILABLE','<span class="alert">Entschuldigung, aber wir können Zahlungen aus Ihrer Region nicht annehmen .</span><br>Bitte setzen Sie sich mit uns in Verbindung, um Alternativen zu suchen. ');

define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- um Ihre Bestellung fortzuführen ...');

define('TABLE_HEADING_CONDITIONS', '<span class="termsconditions">Allgemeine Geschäftsbedingungen</span>');
define('TEXT_CONDITIONS_DESCRIPTION', '<span class="termsdescription">Bitte bestätigen Sie unsere Allgemeinen Geschäftsbedingungen durch Anklicken der Checkbox. Unsere AGB können Sie <a href="' . zen_href_link(FILENAME_CONDITIONS, '', 'SSL') . '" rel="noopener" target="_blank"><span class="pseudolink">hier</span></a> nachlesen.</span>');
define('TEXT_CONDITIONS_CONFIRM', '<span class="termsiagree">Ich habe die AGB gelesen und akzeptiert. Den Hinweis zu meinem <a href="' . zen_href_link(FILENAME_WIDERRUFSRECHT, '', 'SSL') . '" rel="noopener" target="_blank"><span class="pseudolink">Widerrufsrecht</span></a> habe ich verstanden.</span>');


define('TEXT_YOUR_TOTAL', 'Gesamtsumme');