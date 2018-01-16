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
require '../include/language/' . LANG . '/admin/email_edit.php';

Admin::auth();

$sql = "SELECT * FROM `email_templates` WHERE
       `email_id`='" . DB::quote($_GET['email_id']) . "'";
$email = DB::fetch1($sql);
$email['email_body'] = htmlentities($email['email_body'], ENT_QUOTES, 'UTF-8');
$smarty->assign('email', $email);

if (isset($_POST['submit'])) {
    $sql = "UPDATE `email_templates` SET
           `email_subject`='" . DB::quote($_REQUEST['email_subject']) . "',
           `email_body`='" . DB::quote($_REQUEST['email_body']) . "',
           `comment`='" . DB::quote($_REQUEST['comment']) . "' WHERE
           `email_id`='" . DB::quote($_GET['email_id']) . "'";
    DB::query($sql);
    set_message($lang['email_updated'], 'success');
    $redirect_url = VSHARE_URL . '/admin/email_templates.php';
    Http::redirect($redirect_url);
}

$smarty->assign('editor_wysiwyg_email', Config::get('editor_wysiwyg_email'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/email_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
