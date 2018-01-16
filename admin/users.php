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

if (! isset($_GET['a']) || $_GET['a'] == '') {
    $_GET['a'] = 'All';
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if ($_GET['a'] != 'All') {
    $query = "WHERE `user_account_status`='" . DB::quote($_GET['a']) . "'";
} else {
    $query = '';
}

if (! empty($_GET['sort'])) {
    $query .= " ORDER BY " . DB::quote($_GET['sort']);
} else {
    $query .= " ORDER BY `user_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `users`
        $query";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `users`
        $query
        LIMIT $start_from, $admin_listing_per_page";
$users = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('users', $users);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/users.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
