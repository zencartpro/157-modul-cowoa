<?php
/**
 * functions_osh_update
 * Zen Cart German Specific (158 code in 157 / zencartpro adaptations)
 *
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: functions_osh_update.php for COWOA 2023-11-15 15:27:42Z webchills $
 */
if (!defined('IS_ADMIN_FLAG')) {
    exit('Invalid Access');
}

// -----
// A common-use (both storefront and admin) that updates an order's status-history.
//
// Inputs:
// - $order_id ................ The order for which the status record is to be created
// - $message ................. The comments associated with the history record, if non-blank.
// - $updated_by .............. If non-null, the specified value will be used for the like-named field.  Otherwise,
//                              the value will be calculated based on some defaults.
// - $orders_new_status ....... The orders_status value for the update.  If set to -1, no change in the status value was detected.
// - $notify_customer ......... Identifies whether the history record is sent via email and visible to the customer via the "account_history_info" page:
//                               0 ... No emails sent, customer can view on "account_history_info"
//                               1 ... Email sent, customer can view on "account_history_info"
//                              -1 ... No emails sent, comments and status-change hidden from customer view
//                              -2 ... Email sent only to configured admins; status-change hidden from customer view
// - $email_include_message ... Identifies whether (true) or not (false) to include the status message ($osh_additional_comments) in any email sent.
// - $email_subject ........... If specified, overrides the default email subject line.
// - $send_extra_mails_to ..... If specified, overrides the "standard" database settings SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_STATUS and
//                              SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO.
//
// Returns:
// - $osh_id ............ A value > 0 if the record has been written (the orders_status_history_id number)
//                        -2 if no order record was found for the specified $orders_id
//                        -1 if no status change was detected (i.e. no record written).
//
function zen_update_orders_history($orders_id, $message = '', $updated_by = null, $orders_new_status = -1, $notify_customer = -1, $email_include_message = true, $email_subject = '', $send_extra_emails_to = '') 
{
    global $osh_sql, $osh_additional_comments;
    
    // -----
    // Initialize return value to indicate no change and sanitize various inputs.
    //
    $osh_id = -1;
    $orders_id = (int)$orders_id;
    $message = (string)$message;
    $email_subject = (string)$email_subject;
    $send_extra_emails_to = (string)$send_extra_emails_to;
    
    $osh_info = $GLOBALS['db']->ExecuteNoCache(
        "SELECT customers_id, customers_name, customers_email_address, orders_status, date_purchased, COWOA_order
           FROM " . TABLE_ORDERS . " 
          WHERE orders_id = $orders_id
          LIMIT 1" 
    );    
     
    $customer_gender = $GLOBALS['db']->Execute(
        "SELECT customers_gender from " . TABLE_CUSTOMERS . "
         WHERE customers_id = '" . $osh_info->fields['customers_id'] . "'"
         );
    
    // BOF pdf Rechnung  
        if(RL_INVOICE3_STATUS=='true'){                                     
        $rlStat = explode('|', RL_INVOICE3_SEND_ORDERSTATUS_CHANGE);
        $rl_invoice3_send = in_array($orders_new_status, $rlStat);
        if ( ($osh_info->fields['orders_status'] != $orders_new_status  && $orders_new_status==RL_INVOICE3_ORDERSTATUS)  || ($rl_invoice3_send == true)){
            require_once (DIR_FS_CATALOG . DIR_WS_INCLUDES . 'classes/class.rl_invoice3.php');     
            require_once ('../' . DIR_WS_LANGUAGES . $_SESSION['language'] . '/extra_definitions/rl_invoice3.php');
            $paper = rl_invoice3::getDefault(RL_INVOICE3_PAPER, array('format' => 'A4', 'unit' => 'mm', 'orientation' => 'P'));
            $pdfT = new rl_invoice3($orders_id, $paper['orientation'], $paper['unit'], $paper['format']);
            $pdfT->createPdfFile(true);
            $attach = $pdfT->getPDFAttachments('ALL');
        } else {
            $attach = null;
        }
      }
        // EOF pdf Rechnung
    
    if ($osh_info->EOF) {
        $osh_id = -2; 
    } else {
        // -----
        // Determine the message to be included in any email(s) sent.  If an observer supplies an additional
        // message, that text is appended to the message supplied on the function's call.
        //
        $message = stripslashes($message);
        $email_message = '';
        if ($email_include_message === true) {
            $email_message = $message;
            if (empty($osh_additional_comments)) {
                $osh_additional_comments = '';
            }
            $GLOBALS['zco_notifier']->notify('ZEN_UPDATE_ORDERS_HISTORY_PRE_EMAIL', array('message' => $message), $osh_additional_comments);
            if (!empty($osh_additional_comments)) {
                if (!empty($email_message)) {
                    $email_message .= "\n\n";
                }
                $email_message .= (string)$osh_additional_comments;
            }
            if (!empty($email_message)) {
                $email_message = OSH_EMAIL_TEXT_COMMENTS_UPDATE . $email_message . "\n\n";
            }
        }
        
        $orders_current_status = $osh_info->fields['orders_status'];
        $orders_new_status = (int)$orders_new_status;
        if (($orders_new_status != -1 && $orders_current_status != $orders_new_status) || !empty($email_message)) {
            if ($orders_new_status == -1) {
                $orders_new_status = $orders_current_status;
            }
            $GLOBALS['zco_notifier']->notify('ZEN_UPDATE_ORDERS_HISTORY_STATUS_VALUES', array('orders_id' => $orders_id, 'new' => $orders_new_status, 'old' => $orders_current_status));
        
            $GLOBALS['db']->Execute( 
                "UPDATE " . TABLE_ORDERS . " 
                    SET orders_status = $orders_new_status,
                        last_modified = now() 
                  WHERE orders_id = $orders_id
                  LIMIT 1" 
            );
        
            $notify_customer = ($notify_customer == 1 || $notify_customer == -1 || $notify_customer == -2) ? $notify_customer : 0;
        
            if ($notify_customer == 1 || $notify_customer == -2) {
                $new_orders_status_name = zen_get_orders_status_name($orders_new_status);
                if ($new_orders_status_name == '') {
                    $new_orders_status_name = 'N/A';
                }

                if ($orders_new_status != $orders_current_status) {
                    $status_text = OSH_EMAIL_TEXT_STATUS_UPDATED;
                    $status_value_text = sprintf(OSH_EMAIL_TEXT_STATUS_CHANGE, zen_get_orders_status_name($orders_current_status), $new_orders_status_name);
                } else {
                    $status_text = OSH_EMAIL_TEXT_STATUS_NO_CHANGE;
                    $status_value_text = sprintf(OSH_EMAIL_TEXT_STATUS_LABEL, $new_orders_status_name);
                }
                
                //send emails
                
                
                if ($customer_gender->fields['customers_gender'] == 'm') {
        $email_greeting = EMAIL_TEXT_ORDER_CUSTOMER_GENDER_MALE;
      } else if ($customer_gender->fields['customers_gender'] == 'f') { 
        $email_greeting = EMAIL_TEXT_ORDER_CUSTOMER_GENDER_FEMALE;
      } else {
        $email_greeting = EMAIL_TEXT_ORDER_CUSTOMER_NEUTRAL;      
      }
    if ((COWOA_ORDER_STATUS == 'true') && ($osh_info->fields['COWOA_order'] == 1)) {
         $email_text =
                $email_greeting .
                $osh_info->fields['customers_name']. "\n\n" .
                OSH_EMAIL_TEXT_UPDATEINFO . STORE_NAME . "\n\n" .
                OSH_EMAIL_TEXT_ORDER_NUMBER . ' ' . $orders_id . "\n\n" .                
                OSH_EMAIL_TEXT_COWOA_URL . ' ' . zen_catalog_href_link(FILENAME_ORDER_STATUS, "order_id=$orders_id", 'SSL') . "\n\n" .
                OSH_EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($osh_info->fields['date_purchased']) . "\n\n" .
                strip_tags($email_message) .
                $status_text . $status_value_text .
                OSH_EMAIL_TEXT_STATUS_PLEASE_REPLY;
      } else if ((COWOA_ORDER_STATUS == 'false') && ($osh_info->fields['COWOA_order'] == 1)) {
          $email_text =
                $email_greeting .
                $osh_info->fields['customers_name']. "\n\n" .
                OSH_EMAIL_TEXT_UPDATEINFO . STORE_NAME . "\n\n" .
                OSH_EMAIL_TEXT_ORDER_NUMBER . ' ' . $orders_id . "\n\n" .
                OSH_EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($osh_info->fields['date_purchased']) . "\n\n" .
                strip_tags($email_message) .
                $status_text . $status_value_text .
                OSH_EMAIL_TEXT_STATUS_PLEASE_REPLY;                  	
          } else {
          	 $email_text =
                $email_greeting .
                $osh_info->fields['customers_name']. "\n\n" .
                OSH_EMAIL_TEXT_UPDATEINFO . STORE_NAME . "\n\n" .
                OSH_EMAIL_TEXT_ORDER_NUMBER . ' ' . $orders_id . "\n\n" .
                OSH_EMAIL_TEXT_INVOICE_URL . ' ' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, "order_id=$orders_id", 'SSL') . "\n\n" .
                OSH_EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($osh_info->fields['date_purchased']) . "\n\n" .
                strip_tags($email_message) .
                $status_text . $status_value_text .
                OSH_EMAIL_TEXT_STATUS_PLEASE_REPLY;     
          	
          }
        
                          
            if ($customer_gender->fields['customers_gender'] == 'm') {
            $html_msg['EMAIL_CUSTOMER_GREETING']    = OSH_EMAIL_TEXT_ORDER_CUSTOMER_GENDER_MALE;
            } else if ($customer_gender->fields['customers_gender'] == 'f') {
            $html_msg['EMAIL_CUSTOMER_GREETING']    = OSH_EMAIL_TEXT_ORDER_CUSTOMER_GENDER_FEMALE;
            } else {
            $html_msg['EMAIL_CUSTOMER_GREETING']    = OSH_EMAIL_TEXT_ORDER_CUSTOMER_NEUTRAL;            
            }
            $html_msg['EMAIL_TEXT_UPDATEINFO']    = OSH_EMAIL_TEXT_UPDATEINFO;
            $html_msg['EMAIL_CUSTOMERS_NAME']    = $osh_info->fields['customers_name'];
            $html_msg['EMAIL_TEXT_ORDER_NUMBER'] = OSH_EMAIL_TEXT_ORDER_NUMBER . ' ' . $orders_id;
            if ((COWOA_ORDER_STATUS == 'false') && ($osh_info->fields['COWOA_order'] == 1)) {
            // do not include a status update or invoice link
           } else if ((COWOA_ORDER_STATUS == 'true') && ($osh_info->fields['COWOA_order'] == 1)) {
            $html_msg['EMAIL_TEXT_INVOICE_URL']  = '<a href="' . zen_catalog_href_link(FILENAME_ORDER_STATUS, 'order_id=' . $orders_id, 'SSL') .'">'.str_replace(':','',OSH_EMAIL_TEXT_COWOA_URL_CLICK).'</a>';
            } else {
          	$html_msg['EMAIL_TEXT_INVOICE_URL']  = '<a href="' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders_id, 'SSL') .'">'.str_replace(':','',OSH_EMAIL_TEXT_INVOICE_URL).'</a>';
            }
            $html_msg['EMAIL_TEXT_DATE_ORDERED'] = OSH_EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($osh_info->fields['date_purchased']);
            $html_msg['EMAIL_TEXT_STATUS_COMMENTS'] = nl2br($email_message);
            $html_msg['EMAIL_TEXT_STATUS_UPDATED'] = str_replace("\n", '', $status_text);
            $html_msg['EMAIL_TEXT_STATUS_LABEL'] = str_replace("\n", '', $status_value_text);
            $html_msg['EMAIL_TEXT_NEW_STATUS'] = $new_orders_status_name;
            $html_msg['EMAIL_TEXT_STATUS_PLEASE_REPLY'] = str_replace('\n','', OSH_EMAIL_TEXT_STATUS_PLEASE_REPLY);
            $html_msg['EMAIL_PAYPAL_TRANSID'] = '';
                
                
                if (empty($email_subject)) {
                    $email_subject = OSH_EMAIL_TEXT_SUBJECT . ' #' . $orders_id;
                }

                if ($notify_customer == 1) { 
                	// BOF pdf Rechnung 
                	if(RL_INVOICE3_STATUS=='true'){ 
                    zen_mail($osh_info->fields['customers_name'], $osh_info->fields['customers_email_address'], $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status', $attach);
                } else {
                	zen_mail($osh_info->fields['customers_name'], $osh_info->fields['customers_email_address'], $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status');
                // BOF pdf Rechnung 
                }
              }

                // PayPal Trans ID, if any
                $result = $GLOBALS['db']->Execute(
                    "SELECT txn_id, parent_txn_id 
                       FROM " . TABLE_PAYPAL . " 
                      WHERE order_id = $orders_id
                   ORDER BY last_modified DESC, date_added DESC, parent_txn_id DESC, paypal_ipn_id DESC"
                );
                if (!$result->EOF) {
                    $email_text .= "\n\n" . ' PayPal Trans ID: ' . $result->fields['txn_id'];
                    $html_msg['EMAIL_PAYPAL_TRANSID'] = $result->fields['txn_id'];
                }

                //send extra emails
                if (empty($send_extra_emails_to) && SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_STATUS == '1') {
                    $send_extra_emails_to = (string)SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO;
                }
                if (!empty($send_extra_emails_to)) {
                	// BOF pdf Rechnung 
                  if(RL_INVOICE3_STATUS=='true'){ 
                    zen_mail('', $send_extra_emails_to, SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_SUBJECT . ' ' . $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status_extra', $attach);
                } else {
                	 zen_mail('', $send_extra_emails_to, SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_SUBJECT . ' ' . $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status_extra');
                
                }
                // EOF pdf Rechnung 
            }
            
          }
            
            
    
            if (empty($updated_by)) {
                if (IS_ADMIN_FLAG === true && isset($_SESSION['admin_id'])) {
                    $updated_by = zen_updated_by_admin();
                } else if (isset($_SESSION['emp_admin_id'])) {
                   $updated_by = zen_updated_by_admin($_SESSION['emp_admin_id']);
                } elseif (IS_ADMIN_FLAG === false && isset($_SESSION['customer_id'])) {
                    $updated_by = '';
                } else {
                    $updated_by = 'N/A';
                }
            }
    
            $osh_sql = array(
                'orders_id' => $orders_id,
                'orders_status_id' => $orders_new_status,
                'date_added' => 'now()',
                'customer_notified' => $notify_customer,
                'comments' => $message,
                'updated_by' => $updated_by
            );
                       
            $GLOBALS['zco_notifier']->notify('ZEN_UPDATE_ORDERS_HISTORY_BEFORE_INSERT', array(), $osh_sql);
    
            zen_db_perform (TABLE_ORDERS_STATUS_HISTORY, $osh_sql);
            $osh_id = $GLOBALS['db']->Insert_ID();
        }    
    }
    return $osh_id;
}
