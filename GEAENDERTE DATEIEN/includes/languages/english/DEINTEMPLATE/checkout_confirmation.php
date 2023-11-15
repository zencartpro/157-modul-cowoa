<?php
/**
 * Zen Cart German Specific (158 code in 157 /zencartpro adaptations)
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: checkout_confirmation.php for COWOA 2023-11-15 15:05:14Z webchills $
 */

// cowoa do not change
if (isset($_SESSION['COWOA']) && $_SESSION['COWOA'] == true) {
define('HEADING_TITLE', 'Step 4 of 4 - Confirm Purchase');
} else {
define('HEADING_TITLE', 'Step 3 of 3 - Confirm Purchase');
}

// ab hier koennen Sie falls noetig Anpassungen vornehmen, die Definitionen weiter oben NIE aendern!

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Confirmation');

define('TEXT_ZUSATZ_SCHRITT3','Please verify your order and confirm by clicking the "Confirm Purchase" button at the bottom of this page.');
define('BRAINTREE_MESSAGE_PLEASE_CONFIRM_ORDER', '<b>Your credit card has been successfully verified, but no payment has been made yet. Please confirm your order now with the button below. Only then payment and order will be executed.</b>');
define('HEADING_PRODUCTS', 'Shopping Cart Contents');
define('NO_COMMENTS_TEXT', 'None');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Final Step');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- continue to confirm your order. Thank you!');

// buttonloesung
define('TABLE_HEADING_SINGLEPRICE','Price');
define('TABLE_HEADING_PRODUCTIMAGE','Image');
define('TEXT_CONDITIONS_ACCEPTED_IN_LAST_STEP','I have read and agreed to the <a href="' . zen_href_link(FILENAME_CONDITIONS, '', 'SSL') . '" target="_blank"><u>terms and conditions</u></a> bound to this order.');
define('TEXT_NON_EU_COUNTRIES','Note:<br>Your order will be shipped to a country outside the European Union. Your packages may be subject to the customs fees and import duties of the country to which you have your order shipped. These charges are always the recipient\'s responsibility.');
