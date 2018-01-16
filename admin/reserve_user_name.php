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
require '../include/language/' . LANG . '/admin/reserve_user_name.php';

Admin::auth();

if (isset($_GET['action']) && $_GET['action'] == 'del' && is_numeric($_GET['id'])) {
    $sql = "DELETE FROM `disallow` WHERE
           `disallow_id`='" . (int) $_GET['id'] . "'";
    DB::query($sql);
}

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    if ($_POST['name'] == '') {
        $err = $lang['user_name_null'];
        $smarty->assign('err', $err);
    } else {
        $user_name = mb_strtolower($_POST['name']);
        $user_name = trim($user_name);
        $sql = "INSERT INTO `disallow` SET
               `disallow_username`='" . DB::quote($user_name) . "'";
        DB::query($sql);
        $msg = str_replace('[USERNAME]', $user_name, $lang['user_name_reserved']);
        $smarty->assign('msg', $msg);
    }
}

$sql = "SELECT * FROM `disallow`";
$disallow = DB::fetch($sql);

$smarty->assign('disallow', $disallow);
$smarty->display('admin/header.tpl');
$smarty->display('admin/reserve_user_name.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
