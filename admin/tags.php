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

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'Disable') {
        $active = 0;
    } else {
        $active = 1;
    }

    $sql = "UPDATE `tags` SET
           `active`='" . (int) $active . "' WHERE
           `id`='" . (int) $_POST['action_tag'] . "'";
    DB::query($sql);
    $msg = 'Tag has been ' . $_POST['action'] . 'd.';
}

$sql = "SELECT count(*) AS `total` FROM `tags` WHERE `active`='1'";
$total = DB::getTotal($sql);

$admin_listing_per_page = Config::get('admin_listing_per_page');
$start = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM `tags` WHERE
	   `active`='1'
        LIMIT $start, $admin_listing_per_page";
$tags = DB::fetch($sql);

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('tags', $tags);
$smarty->assign('links', $links);
$smarty->assign('total', $total + 0);
$smarty->display('admin/header.tpl');
$smarty->display('admin/tags.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
