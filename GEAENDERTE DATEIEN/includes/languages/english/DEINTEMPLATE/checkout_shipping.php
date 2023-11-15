<?php
/**
 * Zen Cart German Specific (158 code in 157)
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: checkout_shipping.php for COWOA 2023-11-15 15:41:40Z webchills $
 */
 
// cowoa do not change
if (isset($_SESSION['COWOA']) && $_SESSION['COWOA'] == true) {
define('HEADING_TITLE', 'Step 2 of 4 - Delivery Information');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue to Step 3');
} else {
define('HEADING_TITLE', 'Step 1 of 3 - Delivery Information');	
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue to Step 2');
}

// ab hier koennen Sie falls noetig Anpassungen vornehmen, die Definitionen weiter oben NIE aendern!

define('NAVBAR_TITLE_1', 'Checkout - Step 1');
define('NAVBAR_TITLE_2', 'Shipping Method');


define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'Your order will be shipped to the address at the left or you may change the shipping address by clicking the <em>Change Address</em> button.');
define('TITLE_SHIPPING_ADDRESS', 'Delivery Information:');


define('TEXT_CHOOSE_SHIPPING_METHOD', 'Please select the preferred shipping method to use on this order.');
define('TITLE_PLEASE_SELECT', 'Please Select');
define('TEXT_ENTER_SHIPPING_INFORMATION', 'This is currently the only shipping method available to use on this order.');
define('TITLE_NO_SHIPPING_AVAILABLE', 'Not Available At This Time');
define('TEXT_NO_SHIPPING_AVAILABLE','<span class="alert">Sorry, we are not shipping to your region at this time.</span><br>Please contact us for alternate arrangements.');



define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- to choose your payment method.');


define('FREE_SHIPPING_TITLE', 'Free Shipping');


define('ERROR_PLEASE_RESELECT_SHIPPING_METHOD', 'Your available shipping options have changed. Please re-select your desired shipping method.');
