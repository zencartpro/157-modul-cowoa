<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2019 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: gv_redeem.php for COWOA 2019-07-20 16:05:14Z webchills $
 */


define('NAVBAR_TITLE', 'Redeem ' . TEXT_GV_NAME);
define('HEADING_TITLE', 'Redeem ' . TEXT_GV_NAME);
define('TEXT_INFORMATION', 'For more information regarding ' . TEXT_GV_NAME . ', please see our <a href="' . zen_href_link(FILENAME_GV_FAQ, '', 'NONSSL').'">' . GV_FAQ . '.</a>');
define('TEXT_INVALID_GV', 'The ' . TEXT_GV_NAME . ' number %s may be invalid or has already been redeemed. To contact the shop owner please use the Contact Page');
define('TEXT_VALID_GV', 'Congratulations, you have redeemed a ' . TEXT_GV_NAME . ' worth %s.');
define('ERROR_GV_CREATE_ACCOUNT', 'To redeem a Gift Voucher you must create an account.');
define('ERROR_GV_COWOA', 'To redeem a Gift Voucher you must create an account.  You may not enter a Gift Voucher once you have begun checking out without an account. If you would like to use a Gift Voucher, you may <a href="' . zen_href_link(FILENAME_LOGOFF, '', 'SSL', false) . '">click here</a> to end your session, empty your cart, and begin again.');
