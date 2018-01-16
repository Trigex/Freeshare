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
require '../include/language/' . LANG . '/admin/channel_search.php';

Admin::auth();

if (isset($_GET['action']) && $_GET['action'] == 'search') {

    if (isset($_GET['id']) && $_GET['id'] != null) {
        if (is_numeric($_GET['id'])) {
            $channel_info = Channel::getById($_GET['id']);
            if (! $channel_info) {
                $err = str_replace("[CHANNEL_ID]", $_GET['id'], $lang['id_not_found']);
            } else {
                $channel_info = array_map("htmlspecialchars", $channel_info);
                $smarty->assign('channel', $channel_info);
            }
        } else {
            $err = $lang['id_invalid'];
        }

    } else if (isset($_GET['name']) && $_GET['name'] != null) {
        $channel_info = Channel::getByName($_GET['name']);
        if (! $channel_info) {
            $err = str_replace('[CHANNEL_NAME]', $_GET['name'], $lang['name_not_found']);
        } else {
            $channel_info = array_map("htmlspecialchars", $channel_info);
            $smarty->assign('channel', $channel_info);
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_search.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
