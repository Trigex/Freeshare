<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: 3.2
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'admin_config.php';
require '../include/config.php';

Admin::auth();

if (isset($_GET['sort']) && $_GET['sort'] != '') {
    $query = " ORDER BY $_GET[sort]";
} else {
    $query = " ORDER BY `email_id` ASC";
}

$sql = 'SELECT * FROM `email_templates` ' . $query;
$email_templates_all = DB::fetch($sql);

$smarty->assign('email_templates_all', $email_templates_all);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/email_templates.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
