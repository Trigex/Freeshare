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

$_GET['a'] = isset($_GET['a']) ? $_GET['a'] : 'all';

if ($_GET['a'] == '') {
    $_GET['a'] = 'all';
}

if (isset($_GET['action']) && $_GET['action'] == 'del') {
    $sql = "DELETE FROM `groups` WHERE
           `group_id`='" . (int) $_GET['gid'] . "'";
    DB::query($sql);
    $sql = "DELETE FROM `group_videos` WHERE
           `group_video_group_id`='" . (int) $_GET['gid'] . "'";
    DB::query($sql);
    $sql = "DELETE FROM `group_topics` WHERE
           `group_topic_group_id`='" . (int) $_GET['gid'] . "'";
    DB::query($sql);
    $sql = "DELETE FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $_GET['gid'] . "'";
    DB::query($sql);
}

if (($_GET['a'] == 'all') || ($_GET['a'] == 'public') || ($_GET['a'] == 'private') || ($_GET['a'] == 'protected')) {

    if ($_GET['a'] != 'all') {
        $query = "WHERE `group_type`='$_GET[a]'";
    } else {
        $query = '';
    }

    $_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : '';

    if ($_GET['sort'] != '') {
        $sort = $_GET['sort'];
    } else {
        $sort = " `group_id` DESC";
    }

    $sql = "SELECT count(*) AS `total` FROM `groups`
            $query";
    $total = DB::getTotal($sql);

    $start_from = ($page - 1) * $admin_listing_per_page;

    $links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

    $sql = "SELECT * FROM `groups`
            $query
            ORDER BY $sort
            LIMIT  $start_from, $admin_listing_per_page";
    $groups = DB::fetch($sql);

    $smarty->assign('sort', $sort);
    $smarty->assign('links', $links);
    $smarty->assign('total', $total);
    $smarty->assign('page', $page);
    $smarty->assign('groups', $groups);

}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/groups.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
