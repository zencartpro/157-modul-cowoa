<?php
/**
 * Zen Cart German Specific
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_edit.<br />
 * Displays information related to a single specific order
 * 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: tpl_orders_status_default.php 2022-03-27 16:11:45Z webchills $
 */
?>
<div class="centerColumn" id="accountHistInfo">
<h1 id="orderHistoryHeading"><?php echo HEADING_TITLE; ?></h1><br />
<?php
if(isset($_POST['action']) && $_POST['action'] == "process") {
  if($errorInvalidID) echo ERROR_INVALID_ORDER;
  if($errorInvalidEmail) echo ERROR_INVALID_EMAIL;
  if(isset($errorNoMatch)) echo ERROR_NO_MATCH; 
}?>

<?php if(isset($order)) { ?>
  <h2 id="orderHistoryDetailedOrder"><?php echo HEADING_TITLE . ORDER_HEADING_DIVIDER . sprintf(HEADING_ORDER_NUMBER, zen_output_string_protected($_POST['order_id'])); ?></h2>
  <div class="forward"><?php echo HEADING_ORDER_DATE . ' ' . zen_date_long($order->info['date_purchased']); ?></div>
  <br class="clearBoth" />
<table id="orderHistoryHeading">
      <tr class="tableHeading">
          <th scope="col" id="myAccountQuantity"><?php echo HEADING_QUANTITY; ?></th>
          <th scope="col" id="myAccountProducts"><?php echo HEADING_PRODUCTS; ?></th>
  <?php
  if (isset($order->info['tax_groups']) && count($order->info['tax_groups']) > 1) {
  ?>
          <th scope="col" id="myAccountTax"><?php echo HEADING_TAX; ?></th>
  <?php
   }
  ?>
          <th scope="col" id="myAccountTotal"><?php echo HEADING_TOTAL; ?></th>
      </tr>
  <?php
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    ?>
    <tr>
        <td class="accountQuantityDisplay"><?php echo  $order->products[$i]['qty'] . QUANTITY_SUFFIX; ?></td>
        <td class="accountProductDisplay"><?php

            echo  $order->products[$i]['name'];

    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      echo '<ul class="orderAttribsList">';
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '<li>' . $order->products[$i]['attributes'][$j]['option'] . TEXT_OPTION_DIVIDER . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])) . '</li>';
      }
        echo '</ul>';
    }
?>
        </td>
<?php
    if (isset($order->info['tax_groups']) && count($order->info['tax_groups']) > 1) {
?>
        <td class="accountTaxDisplay"><?php echo zen_display_tax_value($order->products[$i]['tax']) . '%' ?></td>
<?php
    }
?>
        <td class="accountTotalDisplay">
        <?php
         $ppe = zen_round(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), $currencies->get_decimal_places($order->info['currency']));
         $ppt = $ppe * $order->products[$i]['qty'];        
         echo $currencies->format($ppt, true, $order->info['currency'], $order->info['currency_value']) . ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '');
        ?></td>
    </tr>
  <?php
    }
  ?>
  </table>
  <hr />
  <div id="orderTotals">
  <?php
    for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
  ?>
       <div class="amount larger forward"><?php echo $order->totals[$i]['text'] ?></div>
       <div class="lineTitle larger forward"><?php echo $order->totals[$i]['title'] ?></div>
  <br class="clearBoth" />
  <?php
    }
  ?>

  </div>

  <?php
  /**
   * Used to display any downloads associated with the cutomers account
   */
    if (DOWNLOAD_ENABLED == 'true') require($template->get_template_dir('tpl_modules_os_downloads.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_os_downloads.php');
  ?>


  <?php
  /**
   * Used to loop thru and display order status information
   */
  if (sizeof($statusArray)) {
  ?>

<h2 id="orderHistoryStatus"><?php echo HEADING_ORDER_HISTORY; ?></h2>
<table id="myAccountOrdersStatus">
    <tr class="tableHeading">
        <th scope="col" id="myAccountStatusDate"><?php echo TABLE_HEADING_STATUS_DATE; ?></th>
        <th scope="col" id="myAccountStatus"><?php echo TABLE_HEADING_STATUS_ORDER_STATUS; ?></th>
        <th scope="col" id="myAccountStatusComments"><?php echo TABLE_HEADING_STATUS_COMMENTS; ?></th>
       </tr>
<?php
  $first = true; 
  foreach ($statusArray as $statuses) {
?>
    <tr>
        <td><?php echo zen_date_short($statuses['date_added']); ?></td>
        <td><?php echo $statuses['orders_status_name']; ?></td>
        <td>
<?php 
    if (!empty($statuses['comments'])) {
      if ($first) { 
         echo nl2br(zen_output_string_protected($statuses['comments']));
         $first = false; 
      } else {
         echo nl2br(zen_output_string($statuses['comments']));
      }
    }
?>
       </td> 
      </tr>
  <?php
    }
  ?>
  </table>
  <?php } ?>

  <hr />
  <div id="myAccountShipInfo" class="floatingBox back">
<?php
  if (!empty($order->delivery['format_id'])) {
?>
<h3><?php echo HEADING_DELIVERY_ADDRESS; ?></h3>
<address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
<?php
  }
?>

  <?php
      if (zen_not_null($order->info['shipping_method'])) {
  ?>
  <h4><?php echo HEADING_SHIPPING_METHOD; ?></h4>
  <div><?php echo $order->info['shipping_method']; ?></div>
  <?php } else { // temporary just remove these 4 lines ?>
  <div>WARNING: Missing Shipping Information</div>
  <?php
      }
  ?>
  </div>

  <div id="myAccountPaymentInfo" class="floatingBox forward">
<h3><?php echo HEADING_BILLING_ADDRESS; ?></h3>
<address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>
  <h4><?php echo HEADING_PAYMENT_METHOD; ?></h4>
  <div><?php echo $order->info['payment_method']; ?></div>
  </div>
  <br class="clearBoth">
  
  <br>
<?php } ?>

<?php 
echo zen_draw_form('order_status', zen_href_link(FILENAME_ORDER_STATUS, '', 'SSL'), 'post') . zen_draw_hidden_field('action', 'process');
?>
<fieldset>
<legend><?php echo HEADING_TITLE; ?></legend>


<?php echo TEXT_LOOKUP_INSTRUCTIONS; ?><br /><br />

<label class="inputLabel"><?php echo ENTRY_ORDER_NUMBER; ?></label>
<?php echo zen_draw_input_field('order_id',$_GET['order_id'],'', 'size="10" id="order_id"'); ?> 
<br class="clearBoth" />
<label class="inputLabel"><?php echo ENTRY_EMAIL; ?></label>
<?php echo zen_draw_input_field('query_email_address', '' , 'size="35" id="query_email_address"'); ?> 
<br />

<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT); ?></div>
</fieldset>
</form>
<!--Kills session after COWOA customer looks at order status-->
<?php
if (isset($_SESSION['COWOA']) && $_SESSION['COWOA'] == true) { 
  zen_session_destroy();
} 
?>
</div>