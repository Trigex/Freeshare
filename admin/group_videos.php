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

$admin_listing_per_page = Config::get('admin_listing_per_page');

$sql = "SELECT `group_name` FROM `groups` WHERE
       `group_id`='" . (int) $_GET['gid'] . "'";
$tmp = DB::fetch1($sql);
$smarty->assign('group_name', $tmp['group_name']);

$gid = $_GET['gid'];

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'v.video_id ASC';
}

if ($sort == 'video_id asc' || $sort == 'video_id desc') {
    $sort = 'v.' . $sort;
}

if (isset($_GET['action']) && $_GET['action'] == 'del') {
    $VID = $_GET['video_id'];
    $sql = "DELETE FROM `group_videos` WHERE
           `group_video_group_id`=" . (int) $gid . " AND
           `group_video_video_id`='" . (int) $VID . "'";
    DB::query($sql);
}

$query = ' WHERE gv.group_video_group_id=' . (int) $gid;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM
       `group_videos` AS gv,
       `videos` AS v
        $query AND
        gv.group_video_video_id=v.video_id";
$total = DB::getTotal($sql);
$grandtotal = $total;
$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM
       `group_videos` AS gv,
       `videos` AS v
        $query AND
        gv.group_video_video_id=v.video_id
        ORDER BY $sort
        LIMIT $start_from, $admin_listing_per_page";
$videos = DB::fetch($sql);

$smarty->assign('link', $links);
$smarty->assign('grandtotal', $grandtotal + 0);
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_videos.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
