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
require '../include/language/' . LANG . '/admin/channel_videos.php';

Admin::auth();

$admin_listing_per_page = Config::get('admin_listing_per_page');

$channel = Channel::getById($_GET['chid']);
$smarty->assign('channel_name', $channel['channel_name']);

if (isset($_GET['action']) && $_GET['action'] == 'del') {
    $sql = "SELECT `video_channels` FROM `videos` WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    $tmp = DB::fetch1($sql);
    $ch = explode('|', $tmp['video_channels']);

    if (count($ch) <= 3) {
        $err = $lang['channel_only_one'];
    } else {
        $new_type = str_replace("|$_GET[chid]|", '|', $tmp['video_channels']);
        $sql = "UPDATE `videos` SET
               `video_channels`='$new_type' WHERE
               `video_id`='" . (int) $_GET['video_id'] . "'";
        DB::query($sql);
    }
}

$query = " WHERE `video_channels` LIKE '%|$_GET[chid]|%'";

if (isset($_GET['sort'])) {
    $query .= " ORDER BY $_GET[sort]";
} else {
    $query .= " ORDER BY `video_id` ASC";
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM `videos` $query";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `videos`
       $query
       LIMIT $start_from, $admin_listing_per_page";
$channel_videos_all = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('grandtotal', $total);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('channel_videos_all', $channel_videos_all);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_videos.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
