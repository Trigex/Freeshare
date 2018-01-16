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
require '../include/language/' . LANG . '/admin/process_status_edit.php';

Admin::auth();

$err = '';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_POST['submit'])) {
    $sql = "UPDATE `process_queue` SET
           `status`='" . (int) $_POST['status'] . "' WHERE
           `id`='" . (int) $_POST['id'] . "'";
    DB::query($sql);
    set_message($lang['process_status_updated'], 'success');
    $redirect_url = VSHARE_URL . '/admin/process_queue.php?page=' . $page;
    Http::redirect($redirect_url);
}

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `process_queue` WHERE
          `id`='" . (int) $_GET['id'] . "'";
    $video_info = DB::fetch1($sql);
    $smarty->assign('video_info', $video_info);
}

$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->display('admin/header.tpl');
$smarty->display('admin/process_status_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
