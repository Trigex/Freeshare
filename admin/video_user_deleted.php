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

if (isset($_GET['sort'])) {

    $allowed_sort = array(
        'video_id desc',
        'video_id asc',
        'video_title desc',
        'video_title asc',
        'video_type desc',
        'video_type asc',
        'video_duration desc',
        'video_duration asc',
        'video_featured desc',
        'video_featured asc',
        'video_featured asc',
        'video_add_date desc',
        'video_add_date asc'
    );

    if (in_array($_GET['sort'], $allowed_sort)) {
        $query = " ORDER BY " . $_GET['sort'];
    } else {
        echo '<p>Invalid sort : ' . $_GET['sort'] . '</p>';
    }
} else {
    $query = " ORDER BY `video_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_user_id`='0'";
$total = DB::getTotal($sql);

$start = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `videos` WHERE
       `video_user_id`='0'
        $query
        LIMIT $start, $admin_listing_per_page";
$videos = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->assign('videos', $videos);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_user_deleted.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
