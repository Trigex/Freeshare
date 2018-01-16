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

$group_id = isset($_GET['group_id']) ? $_GET['group_id'] : 0;

$sql = "SELECT * FROM `groups` WHERE
       `group_id`='" . (int) $group_id . "'";
$group_info = DB::fetch1($sql);
$smarty->assign('group', $group_info);

$mych = explode('|', $group_info['group_channels']);
$ch = Channel::get();

$ch_checkbox = '';

for ($i = 0; $i < count($ch); $i ++) {
    if (in_array($ch[$i]['channel_id'], $mych)) {
        $ch_checkbox .= htmlspecialchars($ch[$i]['channel_name'], ENT_QUOTES, 'UTF-8') . '<br />';
    }
}

$smarty->assign('ch_checkbox', $ch_checkbox);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_view.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
