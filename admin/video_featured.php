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

if ((isset($_GET['todo'])) && ($_GET['todo'] == 'un_feature')) {
    $sql = "UPDATE `videos` SET
           `video_featured`='no' WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    DB::query($sql);
}

if ((isset($_GET['todo'])) && ($_GET['todo'] == 'un_feature_all')) {
    $sql = "UPDATE `videos` SET
           `video_featured`='no'";
    DB::query($sql);
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sort_allowed = array(
    'video_id asc',
    'video_id desc'
);

if ((isset($_GET['sort'])) && (in_array($_GET['sort'], $sort_allowed))) {
    $sort = $_GET['sort'];
} else {
    $sort = "`video_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_type`='public' AND
       `video_active`='1' AND
       `video_approve`=1 AND
       `video_featured`='yes'
        ORDER BY $sort";
$total = DB::getTotal($sql);

$start = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `videos` WHERE
       `video_type`='public' AND
       `video_active`=1 AND
       `video_approve`=1 AND
       `video_featured`='yes'
        ORDER BY $sort
        LIMIT $start, $admin_listing_per_page";
$featured_videos = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('video_featured_all', $featured_videos);
$smarty->assign('total', $total);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_featured.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
