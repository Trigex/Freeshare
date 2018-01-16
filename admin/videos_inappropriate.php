<?php

require 'admin_config.php';
require '../include/config.php';

Admin::auth();

$admin_listing_per_page = Config::get('admin_listing_per_page');
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $sql = "DELETE FROM `inappropriate_requests`";
        DB::query($sql);
    } else if ($_GET['action'] == 'del' && isset($_GET['video_id'])) {
        $sql = "DELETE FROM `inappropriate_requests` WHERE
              `inappropriate_request_video_id`=" . (int) $_GET['video_id'];
        DB::query($sql);
    }
}

if (isset($_GET['sort']) && $_GET['sort'] != '') {
    $query = " ORDER BY " . $_GET['sort'];
} else {
    $query = " ORDER BY `inappropriate_request_date` DESC";
}

$sql = "SELECT count(inappropriate_request_video_id) AS `total` FROM `inappropriate_requests`
       $query";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `inappropriate_requests`
       $query
       LIMIT $start_from, $admin_listing_per_page";
$videos = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('grandtotal', $total);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/videos_inappropriate.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
