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

$query = '';

if (isset($_GET['sort'])) {
    $allowedSort = array(
        'adv_id desc',
        'adv_id asc',
        'adv_name asc',
        'adv_name desc'
    );
    if (in_array($_GET['sort'], $allowedSort)) {
        $query .= ' ORDER BY ' . DB::quote($_GET['sort']);
    }
}

$sql = "SELECT * FROM `adv` $query";
$advertisements_all = DB::fetch($sql);

$smarty->assign('advertisements_all', $advertisements_all);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/advertisements.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
