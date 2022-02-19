<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2019 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: tpl_no_account_default.php 2018-04-10 10:49:16Z webchills $
 */
?>
<div class="centerColumn" id="createAcctDefault">
<h1 id="createAcctDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<h4 id="createAcctDefaultLoginLink"><?php echo sprintf(TEXT_ORIGIN_LOGIN, zen_href_link(FILENAME_LOGIN, zen_get_all_get_params(array('action')), 'SSL')); ?></h4>


<?php echo zen_draw_form('no_account', zen_href_link(FILENAME_NO_ACCOUNT, '', 'SSL'), 'post', 'onsubmit="return check_form(no_account);"') . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_pref_html', 'email_format'); ?>


<?php require($template->get_template_dir('tpl_modules_no_account.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_no_account.php'); ?>

<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT); ?></div>
<div class="buttonRow back"><?php echo '<strong>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</strong><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>


</form>
</div>
