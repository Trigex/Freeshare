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

if (isset($_POST['submit'])) {
    $sql = "UPDATE `pages` SET
           `page_content`='" . DB::quote($_POST['content']) . "',
           `page_title`='" . DB::quote($_POST['title']) . "',
           `page_description`='" . DB::quote($_POST['description']) . "',
           `page_keywords`='" . DB::quote($_POST['keywords']) . "',
           `page_members_only`='" . DB::quote($_POST['members_only']) . "' WHERE
           `page_id`='" . (int) $_POST['page_id'] . "'";
    DB::query($sql);
    $redirect_url = VSHARE_URL . '/admin/page.php?name=' . $_POST['page_name'];
    Http::redirect($redirect_url);
}

$sql = "SELECT * FROM `pages` WHERE
       `page_id`='" . (int) $_GET['id'] . "'";
$page_edit = DB::fetch1($sql);

$page_edit['page_content'] = htmlspecialchars($page_edit['page_content'], ENT_QUOTES, 'UTF-8');

$smarty->assign('page_edit', $page_edit);
$smarty->assign('editor_wysiwyg_admin', Config::get('editor_wysiwyg_admin'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/page_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
