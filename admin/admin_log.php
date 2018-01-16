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

$allow_sort = array(
    'admin_log_ip asc',
    'admin_log_ip desc',
    'admin_log_time asc',
    'admin_log_time desc'
);

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (! in_array($sort, $allow_sort)) {
    $query = " ORDER BY `admin_log_id` DESC";
} else {
    $query = " ORDER BY " . DB::quote($sort);
}

$sql = "SELECT count(*) AS `total` FROM
	   `admin_log` $query";
$total = DB::getTotal($sql);

$start = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `admin_log`
		$query
		LIMIT $start, $admin_listing_per_page";
$admin_log_info = DB::fetch($sql);

$smarty->assign('admin_log_info', $admin_log_info);
$smarty->assign('links', $links);
$smarty->assign('page', $page + 0);
$smarty->assign('sort', $sort);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/admin_log.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
