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
require '../include/language/' . LANG . '/admin/groupmembers.php';

Admin::auth();

$admin_listing_per_page = Config::get('admin_listing_per_page');

$sql = "SELECT `group_name` FROM `groups` WHERE
       `group_id`='" . (int) $_GET['group_id'] . "'";
$tmp = DB::fetch1($sql);
$smarty->assign('group_name', $tmp['group_name']);

$sort_allowed = array(
    'user_id asc',
    'user_id desc',
    'user_name asc',
    'user_name desc',
    'user_country asc',
    'user_country desc',
    'user_last_login_time asc',
    'user_last_login_time desc',
    'user_account_status asc',
    'user_account_status desc'
);
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (in_array($sort, $sort_allowed)) {
    $query = 'ORDER BY ' . DB::quote($sort);
} else {
    $query = 'ORDER BY u.user_id DESC';
}

if (isset($_GET['action']) && $_GET['action'] == 'del') {
    if (is_numeric($_GET['uid'])) {
        $sql = "SELECT `group_owner_id` FROM `groups` WHERE
               `group_id`='" . (int) $_GET['group_id'] . "'";
        $tmp = DB::fetch1($sql);
        if ($tmp['group_owner_id'] == $_GET['uid']) {
            $err = $lang['group_owner_del'];
        } else {
            $sql = "DELETE FROM `group_members` WHERE
                   `group_member_group_id`='" . (int) $_GET['group_id'] . "' AND
                   `group_member_user_id`='" . (int) $_GET['uid'] . "'";
            DB::query($sql);
        }
    }
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM
       `group_members` AS gm,
       `users` AS u WHERE
        gm.group_member_group_id='" . (int) $_GET['group_id'] . "' AND
        gm.group_member_user_id=u.user_id";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM
       `group_members` AS gm,
       `users` AS u WHERE
        gm.group_member_group_id='" . (int) $_GET['group_id'] . "' AND
        gm.group_member_user_id=u.user_id
        $query
        LIMIT $start_from, $result_per_page";
$users = DB::fetch($sql);

$smarty->assign('link', $links);
$smarty->assign('grandtotal', $total);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('users', $users);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_members.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
