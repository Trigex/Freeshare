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

if (isset($_GET['action']) && ($_GET['action'] == 'del')) {
    $sql = "DELETE FROM `channels` WHERE
           `channel_id`='" . (int) $_GET['chid'] . "'";
    DB::query($sql);

    $ch_img = VSHARE_DIR . '/chimg/' . (int) $_GET['chid'] . '.jpg';
    if (file_exists($ch_img)) {
        @unlink($ch_img);
    }
}

$allowedSort = array(
    'channel_name asc',
    'channel_id desc',
    'channel_name desc',
    'channel_id desc'
);

$channel_sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (! in_array($channel_sort, $allowedSort)) {
    $query = " ORDER BY `channel_id` ASC";
} else {
    $query = " ORDER BY " . $channel_sort;
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

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

foreach ($channels_all as $channel) {
    $channel['channel_name'] = htmlspecialchars_uni($channel['channel_name']);
    $channels[] = $channel;
}

$smarty->assign('links', $links);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('channels', $channels);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channels.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
