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

if (isset($_GET['keyword'])) {
    $search_string = $_GET['keyword'];
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    $user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
    $channel_id = isset($_GET['channel']) ? (int) $_GET['channel'] : 0;
    $admin_listing_per_page = Config::get('admin_listing_per_page');
    $user_info = User::getByName($user_name);

    if ($search_string == '') {
        $err = 'Please enter keyword for search.';
    } else if (! $user_info) {
        $err = 'User not found - ' . $_GET['user_name'];
    } else if (! Channel::getById($channel_id)) {
        $err = 'Please select a channel.';
    }

    if ($err == '') {
        $videos = Youtube::getVideos($search_string, 10, $page);

        if (count($videos['videos']) > 1) {
            $smarty->assign('videos', $videos);
        } else {
            $err = 'There are no videos found with keyword.';
        }

        $smarty->assign('user_name', $user_name);
        $smarty->assign('channel_id', $channel_id);
    }
}

$smarty->assign('channels', Channel::get());
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_bulk.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
