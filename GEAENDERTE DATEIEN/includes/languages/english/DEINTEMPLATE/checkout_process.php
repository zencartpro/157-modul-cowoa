<?php
/**
 * Zen Cart German Specific
 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: checkout_process.php for COWOA 2022-11-28 16:40:14Z webchills $
 */
// cowoa do not change
if (isset($_SESSION['COWOA']) && $_SESSION['COWOA'] == true) {
define('EMAIL_TEXT_INVOICE_URL', 'Check order status:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Click here to check the status of your order');
} else {
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');	
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Click here for a Detailed Invoice');
}

// ab hier koennen Sie falls noetig Anpassungen vornehmen, die Definitionen weiter oben NIE aendern!

define('EMAIL_TEXT_SUBJECT', 'Order Confirmation');
define('EMAIL_TEXT_HEADER', 'Order Confirmation');
define('EMAIL_TEXT_FROM',' from ');
define('EMAIL_THANKS_FOR_SHOPPING','Thanks for shopping with us today!');
define('EMAIL_DETAILS_FOLLOW','The following are the details of your order.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');

define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_PRODUCTS', 'Products');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Delivery Address');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Billing Address');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Payment Method');

define('EMAIL_SEPARATOR', '------------------------------------------------------');

define('EMAIL_GREETING_MR', 'Dear Mr.');
define('EMAIL_GREETING_MS', 'Dear Mrs.');
define('EMAIL_GREETING_NEUTRAL', 'Dear');

// suggest not using # vs No as some spamm protection block emails with these subjects
define('EMAIL_ORDER_NUMBER_SUBJECT', ' No: ');
define('HEADING_ADDRESS_INFORMATION','Address Information');
define('HEADING_SHIPPING_METHOD','Shipping Method');