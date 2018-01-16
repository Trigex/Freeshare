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

$sql = "SELECT * FROM `servers` ORDER BY `id` ASC";
$servers = DB::fetch($sql);

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->assign('server_info', $servers);
$smarty->display('admin/header.tpl');
$smarty->display('admin/server_manage.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
