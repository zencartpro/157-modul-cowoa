<?php
/**
 * Header code file for the COWOA order status page (which displays details for a single specific order)
 *
 * Zen Cart German Specific
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: header_php.php 2022-03-27 19:28:00 webchills

 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ORDER_STATUS');
$errorInvalidID='';
$errorInvalidEmail='';
$_SESSION['customer_country_id'] = STORE_COUNTRY;
$_SESSION['customer_zone_id'] = STORE_ZONE;
if (!isset($_GET['order_id']) || (isset($_GET['order_id']) && !is_numeric($_GET['order_id'])))
$_GET['order_id']='';
if (!isset($_POST['order_id']) || (isset($_POST['order_id']) && !is_numeric($_POST['order_id'])))
  $errorInvalidID=TRUE;

if(!isset($_POST['query_email_address']) || zen_validate_email($_POST['query_email_address']) == false)
  $errorInvalidEmail=TRUE;

if(!$errorInvalidID && !$errorInvalidEmail)
{

  $customer_info_query = "SELECT customers_email_address, customers_id
                          FROM   " . TABLE_ORDERS . "
                          WHERE  orders_id = :ordersID";

  $customer_info_query = $db->bindVars($customer_info_query, ':ordersID', $_POST['order_id'], 'integer');
  $customer_info = $db->Execute($customer_info_query);

  if (isset($_POST['query_email_address']) && $customer_info->fields['customers_email_address'] != $_POST['query_email_address']) {
    $errorNoMatch=TRUE;
  } else {
    $_SESSION['email_address'] = $_POST['query_email_address'];
    $_SESSION['customer_id'] = $customer_info->fields['customers_id'];
    $_SESSION['COWOA']= 'True';
    $_SESSION['ORDER_STATUS'] = 'True';
$statuses_query = "SELECT os.orders_status_name, osh.*
                       FROM   " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh
                       WHERE      osh.orders_id = :ordersID
                       AND        osh.orders_status_id = os.orders_status_id
                       AND        os.language_id = :languagesID
                       AND        osh.customer_notified >= 0
                       ORDER BY   osh.date_added";

$statuses_query = $db->bindVars($statuses_query, ':ordersID', $_POST['order_id'], 'integer');
    $statuses_query = $db->bindVars($statuses_query, ':languagesID', $_SESSION['languages_id'], 'integer');
    $statuses = $db->Execute($statuses_query);
$statusArray = array();

while (!$statuses->EOF) {
  $statusArray[] = $statuses->fields;
  $statuses->MoveNext();
}

    require(DIR_WS_CLASSES . 'order.php');
    $order = new order($_POST['order_id']);
  }
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));


// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ORDER_STATUS');