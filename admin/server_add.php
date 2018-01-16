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
require '../include/language/' . LANG . '/admin/server_add.php';

Admin::auth();

if (isset($_POST['submit'])) {
    $server_url = $_POST['server_url'];
    $server_ip = $_POST['server_ip'];

    $server_user_name = $_POST['server_username'];
    $server_password = $_POST['server_password'];
    $server_folder = $_POST['server_folder'];
    $server_type = $_POST['server_type'];
    $server_secdownload_secret = isset($_POST['server_secdownload_secret']) ? $_POST['server_secdownload_secret'] : '';

    if ($server_url == '') {
        $err = $lang['server_url_null'];
    } else if (check_field_exists($server_url, 'url', 'servers') == 1) {
        $err = $lang['server_url_exist'];
    } else if (! preg_match("/^http:\/\//i", $server_url)) {
        $err = $lang['server_url_invalid'];
    } else if ($server_ip == '') {
        $err = $lang['server_ip_null'];
    } else if ($server_user_name == '') {
        $err = $lang['server_user_name_null'];
    } else if ($server_password == '') {
        $err = $lang['password_empty'];
    } else if (! is_numeric($server_type)) {
        $err = $lang['server_type_invalid'];
    } else if ($server_type == 2 || $server_type == 3) {
        if (strlen($server_secdownload_secret) < 4) {
            $err = $lang['server_secdownload_secret_empty'];
        }
    }

    if ($err == '') {
        $sql = "INSERT INTO `servers` SET
               `ip`='" . DB::quote($server_ip) . "',
               `url`='" . DB::quote($server_url) . "',
               `user_name`='" . DB::quote($server_user_name) . "',
               `password`='" . DB::quote($server_password) . "',
               `folder` = '" . DB::quote($server_folder) . "',
               `status`='1',
               `server_type`='" . (int) $server_type . "',
               `server_secdownload_secret`='" . (int) $server_secdownload_secret . "'";
        DB::query($sql);
        DB::close();
        set_message($lang['server_added'], 'success');
        $redirect_url = VSHARE_URL . '/admin/server_manage.php';
        Http::redirect($redirect_url);
    }
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/server_add.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
