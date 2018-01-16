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
require '../include/language/' . LANG . '/admin/group_search.php';

Admin::auth();

$found = 0;

if (! empty($_POST['group_name'])) {
    $sql = "SELECT * FROM `groups` WHERE
           `group_name`='" . DB::quote($_POST['group_name']) . "'";
    $group_info = DB::fetch1($sql);
    if (! $group_info) {
        $err = str_replace('[GROUP_NAME]', $_POST['group_name'], $lang['group_not_found_name']);
    } else {
        $found = 1;
        $group_id = $group_info['group_id'];
    }
}

if ($found) {
    $redirect_url = VSHARE_URL . '/admin/group_view.php?group_id=' . $group_id;
    Http::redirect($redirect_url);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_search.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
