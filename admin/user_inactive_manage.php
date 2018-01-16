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

if ($config['signup_verify'] != 2) {
    set_message('Admin activation disabled.', 'error');
    Http::redirect($_SERVER['HTTP_REFERER']);
}

if (isset($_POST['user_ids'])) {
    foreach ($_POST['user_ids'] as $user_id) {
        User::delete($user_id, 1);
    }
    set_message('Selected users have been deleted.', 'success');
    $redirect_url = VSHARE_URL . '/admin/user_inactive_manage.php';
    Http::redirect($redirect_url);
}

$admin_listing_per_page = Config::get('admin_listing_per_page');
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;

$sql = "SELECT COUNT(`user_id`) AS `total` FROM `users` WHERE
       `user_account_status`='Inactive'";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $admin_listing_per_page;
$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql_extra = '';

if (! empty($_GET['sort'])) {
    $sql_extra .= " ORDER BY " . DB::quote($_GET['sort']);
} else {
    $sql_extra .= " ORDER BY `user_id` DESC";
}

$sql = "SELECT * FROM `users` WHERE
       `user_account_status`='Inactive'
        $sql_extra
        LIMIT $start_from, $admin_listing_per_page";
$users = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('users', $users);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_inactive_manage.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
