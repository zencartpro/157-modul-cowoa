<?php
/**
 * @package Bestellen ohne Kundenkonto (COWOA)
 * @copyright Copyright 2003-2019 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 3_5_0.php  2019-07-20 16:13:51Z webchills $
 */
 
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'COWOA'
LIMIT 1;");


$db->Execute("INSERT IGNORE INTO ".TABLE_CONFIGURATION." (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES
('COWOA - General', 'COWOA_STATUS', 'false', 'Activate COWOA Checkout? <br />Set to True to allow a customer to checkout without an account.', @gid, 1, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),'),
('COWOA - Enable Order Status', 'COWOA_ORDER_STATUS', 'false', 'Enable The Order Status Function of COWOA?<br />Set to True so that a Customer that uses COWOA will receive an E-Mail with instructions on how to view the status of their order.', @gid, 2, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),'),
('Enable Forced Logoff', 'COWOA_LOGOFF', 'false', 'Enable The Forced LogOff Function of COWOA?<br />Set to True so that a Customer that uses COWOA will be logged off automatically after a sucessfull checkout. If they are getting a file download, then they will have to wait for the Status E-Mail to arrive in order to download the file.', @gid, 12, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')");

$db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
('COWOA - Allgemein', 'COWOA_STATUS', 'COWOA aktivieren?<br/>Stellen Sie auf True, wenn Sie Bestellung ohne Kundenkonto anbieten wollen.', 43),
('COWOA - Bestellstatus aktivieren', 'COWOA_ORDER_STATUS', 'Wollen Sie die Bestellstatus Funktionalität von COWOA aktivieren?<br/>Stellen Sie auf True, damit ein Kunde, der ohne Kundenkonto bestellt ein Mail mit Informationen bekommt, wie er den Status seiner Bestellung einsehen kann', 43),
('COWOA - Automatisches Ausloggen', 'COWOA_LOGOFF','Wollen Sie die automatische Logoff Funktion von COWOA aktivieren?<br/>Stellen Sie auf True, so dass ein Kunde der ohne Kundenkonto bestellt nach erfolgreicher Bestellung automatisch ausgeloggt wird. Falls der COWOA Kunde einen Download gekauft hat, kann er diesen dann erst mittels Link im Bestellstatusupdate-Email herunterladen.', 43)");

//check if COWOA_account column already exists - if not add it
    $sql ="SHOW COLUMNS FROM ".TABLE_CUSTOMERS." LIKE 'COWOA_account'";
    $result = $db->Execute($sql);
    if(!$result->RecordCount())
    {
        $sql = "ALTER TABLE ".TABLE_CUSTOMERS." ADD COWOA_account tinyint(1) NOT NULL default 0";
        $db->Execute($sql);
    }
    
//check if COWOA_order column already exists - if not add it
    $sql ="SHOW COLUMNS FROM ".TABLE_ORDERS." LIKE 'COWOA_order'";
    $result = $db->Execute($sql);
    if(!$result->RecordCount())
    {
        $sql = "ALTER TABLE ".TABLE_ORDERS." ADD COWOA_order tinyint(1) NOT NULL default 0";
        $db->Execute($sql);
    }

$db->Execute("INSERT IGNORE INTO ".TABLE_QUERY_BUILDER." (query_id , query_category , query_name , query_description , query_string ) VALUES ( '', 'email,newsletters', 'Permanent Account Holders Only', 'Send email only to permanent account holders ', 'select customers_email_address, customers_firstname, customers_lastname from TABLE_CUSTOMERS where COWOA_account != 1 order by customers_lastname, customers_firstname, customers_email_address')");
$db->Execute("UPDATE ".TABLE_CONFIGURATION." SET configuration_value = 'True' WHERE configuration_title = 'Use split-login page'");


$admin_page = 'configProdCowoa';
// delete configuration menu
$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
// add configuration menu
if (!zen_page_key_exists($admin_page)) {
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'COWOA'
LIMIT 1;");

$db->Execute("INSERT IGNORE INTO " . TABLE_ADMIN_PAGES . " (page_key,language_key,main_page,page_params,menu_key,display_on_menu,sort_order) VALUES 
('configProdCowoa','BOX_CONFIGURATION_PRODUCT_COWOA','FILENAME_CONFIGURATION',CONCAT('gID=',@gid),'configuration','Y',@gid)");
$messageStack->add('COWOA Konfiguration erfolgreich hinzugefügt.', 'success');  
}

