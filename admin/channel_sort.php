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
require '../include/language/' . LANG . '/admin/channel_sort.php';

Admin::auth();

$admin_listing_per_page = Config::get('admin_listing_per_page');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $sortorder = $_POST['sortorder'];
    for ($i = 0; $i < count($id); $i ++) {
        $sql = "UPDATE `channels` SET
               `channel_sort_order`='" . (int) $sortorder[$i] . "'
                WHERE `channel_id`='" . (int) $id[$i] . "'";
        DB::query($sql);
    }
    $smarty->assign('msg', $lang['channel_sort_updated']);
}

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'asc';

if ($sort != 'asc') {
    $sort = 'desc';
}

$query = "ORDER BY `channel_sort_order` $sort";

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM `channels` $query";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `channels`
       $query
       LIMIT $start_from, $admin_listing_per_page";
$channels_all = DB::fetch($sql);

$channels = array();

foreach ($channels_all as $channel) {
    $channel['channel_name'] = htmlspecialchars_uni($channel['channel_name']);
    $channels[] = $channel;
}

$smarty->assign('link', $links);
$smarty->assign('page', $page);
$smarty->assign('channels', $channels);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_sort.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
