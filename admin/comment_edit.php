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

if (isset($_POST['submit'])) {
    if (is_numeric($_GET['id']) && ! empty($_POST['comments'])) {
        $sql = "UPDATE `comments` SET
               `comment_text`='" . DB::quote($_POST['comments']) . "' WHERE
               `comment_id`='" . (int) $_GET['id'] . "'";
        DB::query($sql);
        $redirect_url = VSHARE_URL . '/admin/comment.php?page=' . $page;
        Http::redirect($redirect_url);
    }
}

$sql = "SELECT * FROM `comments` WHERE
       `comment_id`='" . (int) $_GET['id'] . "'";
$comment = DB::fetch1($sql);

$smarty->assign('msg', $msg);
$smarty->assign('vid', $comment['comment_video_id']);
$smarty->assign('page', $page);
$smarty->assign('comid', $_GET['id']);
$smarty->assign('comments', $comment['comment_text']);
$smarty->display('admin/header.tpl');
$smarty->display('admin/comment_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
