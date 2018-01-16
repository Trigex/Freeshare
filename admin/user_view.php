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
require '../include/language/' . LANG . '/admin/user_search.php';

Admin::auth();

if (isset($_GET['user_id'])) {
    $user_id = (int) $_GET['user_id'];

    $sql = "SELECT * FROM `users` WHERE
           `user_id`='" . $user_id . "'";
    $user_info = DB::fetch1($sql);

    if (! $user_info) {
        $err = str_replace('[USER_ID]', $user_id, $lang['userid_not_found']);
    } else {
        $smarty->assign('user', $user_info);
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_view.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
