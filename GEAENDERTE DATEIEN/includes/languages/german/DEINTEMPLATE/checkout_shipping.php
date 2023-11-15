<?php
/**
 * Zen Cart German Specific (158 code in 157)
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: checkout_shipping.php for COWOA 2023-11-15 15:59:40Z webchills $
 */

// cowoa do not change
if (isset($_SESSION['COWOA']) && $_SESSION['COWOA'] == true) {
define('HEADING_TITLE', 'Schritt 2 von 4 : Lieferinformationen');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Weiter zu Schritt 3');
} else {
define('HEADING_TITLE', 'Schritt 1 von 3 : Lieferinformationen');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Weiter zu Schritt 2');
}

// ab hier koennen Sie falls noetig Anpassungen vornehmen, die Definitionen weiter oben NIE aendern!
define('NAVBAR_TITLE_1','Bestellung');
define('NAVBAR_TITLE_2','Versandart wählen');


define('TEXT_CHOOSE_SHIPPING_DESTINATION','Ihre Bestellung wird an die links angezeigte Anschrift geliefert. Sie können die Lieferanschrift ändern, wenn Sie auf den Button <em>Adresse ändern</em> klicken.');
define('TITLE_SHIPPING_ADDRESS','Lieferanschrift:');


define('TEXT_CHOOSE_SHIPPING_METHOD','Bitte wählen Sie die Versandart für Ihre Bestellung.');
define('TITLE_PLEASE_SELECT','Bitte wählen Sie');
define('TEXT_ENTER_SHIPPING_INFORMATION','Dies ist zur Zeit die einzige Versandart.');
define('TITLE_NO_SHIPPING_AVAILABLE', 'Zur Zeit nicht verfügbar');
define('TEXT_NO_SHIPPING_AVAILABLE','<span class="alert">Entschuldigung, aber wir können nicht in Ihre Region versenden .</span><br>Bitte setzen Sie sich mit uns in Verbindung, um Alternativen zu suchen.');



define('TEXT_CONTINUE_CHECKOUT_PROCEDURE','- wählen Sie Ihre Zahlungsart ...');


define('FREE_SHIPPING_TITLE', 'Versandkostenfreie Lieferung');

define('ERROR_PLEASE_RESELECT_SHIPPING_METHOD', 'Die verfügbaren Versandarten haben sich geändert. Bitte wählen Sie erneut Ihre gewünschte Versandart aus.');
