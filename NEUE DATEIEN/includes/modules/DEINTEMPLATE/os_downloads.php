<?php
/**
 * @package Bestellen ohne Kundenkonto (COWOA)
 * Zen Cart German Specific
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: os_downloads.php 2022-06-10 16:55:16Z webchills $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
  $last_order = $_POST['order_id'];
// Now get all downloadable products in the posted order number and match it to the e-mail address used when it was downloaded
$downloads_query = "select date_format(o.date_purchased, '%Y-%m-%d') as date_purchased_day,
                    opd.download_maxdays, op.products_name, opd.orders_products_download_id,
                    opd.orders_products_filename, opd.download_count, opd.download_maxdays
                    from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, ". TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
                    where o.customers_email_address = '" . $_SESSION['email_address'] . "'  
                    and(o.orders_status >= '" . DOWNLOADS_CONTROLLER_ORDERS_STATUS . "'
                    and o.orders_status <= '" . DOWNLOADS_CONTROLLER_ORDERS_STATUS_END . "')
                    and o.orders_id = '" . (int)$last_order . "'
                    and o.orders_id = op.orders_id
                    and op.orders_products_id = opd.orders_products_id
                    and opd.orders_products_filename != ''";

$downloads = $db->Execute($downloads_query);


// If there is a download in the order and they cannot get it, tell customer about download rules
$downloads_check_query = $db->Execute("select o.orders_id, opd.orders_products_download_id
                          from " .
TABLE_ORDERS . " o, " .
TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
                          where
                          o.orders_id = opd.orders_id
                          and o.orders_id = '" . (int)$last_order . "'
                          and opd.orders_products_filename != ''
                          ");