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
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (! isset($_GET['a']) || $_GET['a'] == '') {
    $_GET['a'] = 'all';
}

$view_types = array('all', 'public', 'private', 'adult', 'embedded');

if (isset($_POST['video_id_arr'])) {
    $video_id_arr = $_POST['video_id_arr'];
    $video_id_arr = array_unique($video_id_arr);
    $video_id_arr_count = count($video_id_arr);

    for ($i = 0;$i < $video_id_arr_count;$i++) {
        $video_info = Video::getById($video_id_arr[$i]);
        if ($video_info) {
            Video::delete($video_info['video_id'], $video_info['video_user_id']);
        }
    }
    $msg = 'Selected Videos are Deleted.';
}

if (! in_array($_GET['a'], $view_types)) {
    die('Invalid video type: ' . $_GET['a']);
}

if ($_GET['a'] == 'all') {
    $query = '';
} else if ($_GET['a'] == 'adult') {
    $query = "WHERE `video_adult`='1'";
} else if ($_GET['a'] == 'embedded') {
    $query = "WHERE `video_vtype`>'0'";
} else {
    $query = "WHERE `video_type`='$_GET[a]'";
}

if (! isset($_GET['sort']) || $_GET['sort'] == '') {
    $query .= " ORDER BY `video_id` DESC";
} else {
    $query .= " ORDER BY $_GET[sort]";
}

$sql = "SELECT count(*) AS `total` FROM
       `videos` $query";
$total = DB::getTotal($sql);

$start = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `videos`
       $query
       LIMIT $start, $admin_listing_per_page";
$videos = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('grandtotal', $total);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('videos', $videos);
$smarty->assign('a', $_GET['a']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/videos.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
