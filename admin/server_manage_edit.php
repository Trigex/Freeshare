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
require '../include/language/' . LANG . '/admin/server_manage_edit.php';

Admin::auth();

if (isset($_POST['submit'])) {
    $server_id = (int) $_POST['server_id'];
    if ($_POST['server_ip'] == '') {
        $err = $lang['ip_numeric'];
    } else if ($_POST['server_url'] == '') {
        $err = $lang['server_url_empty'];
    } else if ($_POST['user_name'] == '') {
        $err = $lang['user_name_empty'];
    } else if ($_POST['password'] == '') {
        $err = $lang['password_empty'];
    } else if ($_POST['server_type'] == 2 || $_POST['server_type'] == 3) {
        $server_secdownload_secret = isset($_POST['server_secdownload_secret']) ? $_POST['server_secdownload_secret'] : '';
        if (strlen($server_secdownload_secret) < 10) {
            $err = 'You must enter secdownload.secret';
        }
    }

    if ($err == '') {
        $sql = "UPDATE `servers` SET
               `ip`='" . DB::quote($_POST['server_ip']) . "',
               `url`='" . DB::quote($_POST['server_url']) . "',
               `user_name`='" . DB::quote($_POST['user_name']) . "',
               `password`='" . DB::quote($_POST['password']) . "',
               `folder`='" . DB::quote($_POST['folder']) . "',
               `server_type`='" . (int) $_POST['server_type'] . "',
               `server_secdownload_secret`='" . DB::quote($server_secdownload_secret) . "' WHERE
               `id`='" . (int) $server_id . "'";
        DB::query($sql);
        set_message($lang['server_info_updated'], 'success');
        $redirect_url = VSHARE_URL . '/admin/server_manage.php';

    } else {
        set_message($err, 'error');
        $redirect_url = VSHARE_URL . '/admin/server_manage_edit.php?id=' . $server_id;
    }

    DB::close();
    Http::redirect($redirect_url);
}

$server_id = isset($_GET['id']) ? $_GET['id'] : 0;

if (! is_numeric($server_id)) {
    $err = $lang['id_numeric'];
}

$sql = "SELECT * FROM `servers` WHERE
       `id`='" . (int) $server_id . "'";
$server_info = DB::fetch1($sql);

$smarty->assign('server_info', $server_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/server_manage_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
