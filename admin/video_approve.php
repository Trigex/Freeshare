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

if (isset($_GET['sort']) && ! empty($_GET['sort'])) {
    $query = "WHERE `video_approve`=0 ORDER BY $_GET[sort]";
} else {
    $query = "WHERE `video_approve`=0 ORDER BY `video_id` DESC";
}

if (isset($_GET['action']) && $_GET["action"] == 'approve') {
    $sql = "UPDATE `videos` SET
           `video_approve`='1',
           `video_active`='1' WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    DB::query($sql);

    $msg = 'Video [VID: <a href="' . VSHARE_URL . '/show.php?id=' . $_GET['video_id'] . '" target=_blank>' . $_GET['video_id'] . '</a>] Approved';

    $tmp = Video::getById($_GET['video_id']);
    $type = $tmp['video_type'];
    $keyword = $tmp['video_keywords'];
    $channel = $tmp['video_channels'];
    $keyword = DB::quote($keyword);

    if ($type == 'public') {
        $tags = new Tag($keyword, $_GET['video_id'], 'user_id_not_used', $channel);
        $tags->add();
        $video_tags = $tags->get_tags();
        $sql = "UPDATE `videos` SET
               `video_keywords`='" . DB::quote(implode(' ', $video_tags)) . "' WHERE
               `video_id`='" . (int) $_GET['video_id'] . "'";
        DB::query($sql);
    }

    User::updateVideoCount($tmp['video_user_id'], 1);
}

if (isset($_GET['action']) && $_GET['action'] == 'approve_all') {
    $sql = "SELECT `video_user_id` FROM `videos` WHERE
           `video_approve`='0'";
    $approved_video_users = DB::fetch($sql);

    foreach ($approved_video_users as $video_user) {
        User::updateVideoCount($video_user['video_user_id'], 1);
    }

    $sql = "UPDATE `videos` SET `video_approve`='1'";
    DB::query($sql);
    $msg = 'All Videos Approved';
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_approve`='0'";
$total = DB::getTotal($sql);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `videos`
       $query
       LIMIT $start_from, $admin_listing_per_page";
$videos = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_approve.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
