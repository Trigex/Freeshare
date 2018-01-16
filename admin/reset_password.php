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
require '../include/language/' . LANG . '/admin/reset_password.php';

if (isset($_GET['k']) && isset($_GET['i'])) {
    if (! is_numeric($_GET['i'])) {
        $err = $lang['invalid_key'];
    } else if (strlen($_GET['k']) > 40) {
        $err = $lang['invalid_key'];
    } else {

        $data1 = 'ADMIN_PWD_CHANGE';

        $sql = "SELECT * FROM `verify_code` WHERE
               `id`='" . (int) $_GET['i'] . "' AND
               `vkey`='" . $_GET['k'] . "' AND
               `data1`='" . $data1 . "'";
        $verify_info = DB::fetch1($sql);

        if ($verify_info) {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . md5($verify_info['data2']) . "' WHERE
                   `soption`='admin_pass'";
            DB::query($sql);

            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $_GET['i'] . "'";
            DB::query($sql);
            set_message($lang['password_changed'], 'success');
            $redirect_url = VSHARE_URL . '/admin/index.php';
            Http::redirect($redirect_url);
        } else {
            $err = $lang['invalid_key'];
        }
    }
} else {
    $err = $lang['invalid_key'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('error.tpl');
$smarty->display('footer.tpl');
DB::close();
