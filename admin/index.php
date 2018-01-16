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
require '../include/language/' . LANG . '/admin/index.php';

if (isset($_SESSION['AUID']) && isset($_SESSION['APASSWORD'])) {
    if (($_SESSION['AUID'] == $config['admin_name']) && ($_SESSION['APASSWORD'] == $config['admin_pass'])) {
        $redirect_url = VSHARE_URL . '/admin/home.php';
        Http::redirect($redirect_url);
    }
}

if (isset($_POST['submit'])) {
    $user_password = $_POST['password'];
    $user_name = $_POST['user_name'];

    if (get_magic_quotes_gpc()) {
        $user_password = stripslashes($user_password);
        $user_name = stripslashes($user_name);
    }

    $user_password_md5 = md5($user_password);

    if ($user_name == '' || $user_password == '') {
        $err = $lang['login_empty'];
    } else if (($user_name == $config['admin_name']) && ($user_password_md5 == $config['admin_pass'])) {
        $_SESSION['AUID'] = $config['admin_name'];
        $_SESSION['APASSWORD'] = $config['admin_pass'];
        $redirect_url = VSHARE_URL . '/admin/home.php';
        Http::redirect($redirect_url);
    } else {
        $err = $lang['login_invalid'];
    }
}

$login_error = '';

if ($err != '') {
    $login_error = $err;
    $err = '';
} else if ($msg != '') {
    $login_error = $msg;
    $msg = '';
}

$smarty->assign('login_error', $login_error);
$smarty->display('admin/index.tpl');
DB::close();
