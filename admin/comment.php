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
include '../include/config.php';

Admin::auth();

$admin_listing_per_page = Config::get('admin_listing_per_page');

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_GET['action']) && $_GET['action'] == 'del') {
    if (is_numeric($_GET['id'])) {
        $sql = "DELETE FROM `comments` WHERE
               `comment_id`='" . (int) $_GET['id'] . "'";
        DB::query($sql);
    }
}

$sql = "SELECT count(*) AS `total` FROM `comments`";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM
       `comments` AS c,
       `users` AS u WHERE
        c.comment_user_id=u.user_id
        ORDER BY c.comment_id DESC
        LIMIT $start_from, $admin_listing_per_page";
$comments = DB::fetch($sql);

$smarty->assign('links', $links);
$smarty->assign('page', $page);
$smarty->assign('total', $total);
$smarty->assign('comments', $comments);
$smarty->display('admin/header.tpl');
$smarty->display('admin/comment.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
