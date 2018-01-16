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
require '../include/language/' . LANG . '/admin/video_inactive.php';

Admin::auth();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if ($action == 'activate') {
    if (is_numeric($_GET['video_id'])) {
        $video_info = Video::getById($_GET['video_id']);
        if ($video_info) {
	        $sql = "UPDATE `videos` SET
	               `video_active`='1' WHERE
	               `video_id`='" . (int) $_GET['video_id'] . "'";
	        DB::query($sql);
	        User::updateVideoCount($video_info['video_user_id'], 1);
	        $msg = $lang['activate_video'];
        }
    }
}

if ($action == 'activate_all')
{
    $sql = "SELECT `video_user_id` FROM `videos` WHERE
           `video_active`='0'";
    $videos_inactive_all = DB::fetch($sql);

    foreach($videos_inactive_all as $inactive_video) {
        User::updateVideoCount($inactive_video['video_user_id'], 1);
    }

    $sql = "UPDATE `videos` SET `video_active`='1'";
    DB::query($sql);
    $msg = $lang['activate_all_video'];
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = " `video_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='0' AND
       `video_user_id`!='0'
        ORDER BY $sort";
$total = DB::getTotal($sql);

$admin_listing_per_page = Config::get('admin_listing_per_page');
$start = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `videos` WHERE
       `video_active`='0' AND
       `video_user_id`!='0'
        ORDER BY $sort
        LIMIT $start, $admin_listing_per_page";
$videos_inactive_all = DB::fetch($sql);

$smarty->assign('videos_inactive_all', $videos_inactive_all);
$smarty->assign('msg', $msg);
$smarty->assign('links', $links);
$smarty->assign('total', $total);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_inactive.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
