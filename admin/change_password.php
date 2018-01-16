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
require '../include/language/' . LANG . '/admin/change_password.php';

Admin::auth();

if (isset($_POST['submit'])) {
    if ($_POST['admin_name'] == '') {
        $err = $lang['admin_name_null'];
    } else if (md5($_POST['password']) != $_SESSION['APASSWORD']) {
        $err = $lang['password_wrong'];
    } else if (strlen($_POST['password_new']) < 4) {
        $err = $lang['password_short'];
    } else if ($_POST['password_new'] != $_POST['password_confirm']) {
        $err = $lang['password_confirm_error'];
    }

    if ($err == '') {
        if ($config['admin_name'] != $_POST['admin_name']) {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . DB::quote($_POST['admin_name']) . "' WHERE
                   `soption`='admin_name'";
            DB::query($sql);
            $_SESSION['AUID'] = $_POST['admin_name'];
            $smarty->assign('admin_name', $_POST['admin_name']);
        }

        $password_new_md5 = md5($_POST['password_new']);
        $sql = "UPDATE `sconfig` SET
               `svalue`='$password_new_md5' WHERE
               `soption`='admin_pass'";
        DB::query($sql);
        $_SESSION['APASSWORD'] = $password_new_md5;
        $msg = $lang['password_changed'];
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/change_password.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
