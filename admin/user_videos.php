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
require '../include/language/' . LANG . '/admin/user_videos.php';

Admin::auth();

if (! is_numeric($_GET['uid'])) {
    echo $lang['user_id_invalid'];
    exit(0);
}

$admin_listing_per_page = Config::get('admin_listing_per_page');

$user_info = User::getById($_GET['uid']);
$smarty->assign('user_name', $user_info['user_name']);
$smarty->assign('user_id', $_GET['uid']);

$query = " WHERE `video_user_id`='" . (int) $_GET['uid'] . "'";

if (isset($_GET['sort'])) {
    $query .= " ORDER BY $_GET[sort]";
} else {
    $query .= " ORDER BY `video_id` ASC";
}

$sql = "SELECT count(*) AS `total` FROM `videos`
        $query";
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
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_videos.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
