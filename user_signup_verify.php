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

require 'include/config.php';
require 'include/language/' . LANG . '/lang_activate.php';

if (isset($_GET['k']) && isset($_GET['u']) && isset($_GET['i'])) {

    if (! is_numeric($_GET['u'])) {
        $err = $lang['invalid_vcode'];
    } else if (! is_numeric($_GET['i'])) {
        $err = $lang['invalid_vcode'];
    } else if (strlen($_GET['k']) > 40) {
        $err = $lang['invalid_vcode'];
    } else {
        $data1 = 'SIGNUP' . $_GET['u'];
        $sql = "SELECT * FROM `verify_code` WHERE
               `id`=" . (int) $_GET['i'] . " AND
               `vkey`='" . DB::quote($_GET['k']) . "' AND
               `data1`='" . DB::quote($data1) . "'";
        $verify_info = DB::fetch1($sql);

        if ($verify_info) {
            $sql = "UPDATE `users` SET
                   `user_email_verified`='yes',
                   `user_account_status`='active' WHERE
                   `user_id`='" . (int) $_GET['u'] . "'";
            DB::query($sql);

            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $_GET['i'] . "'";
            DB::query($sql);

            $user_info = User::getById($_GET['u']);
            User::login($user_info['user_name']);

            $redirect_url = VSHARE_URL . '/friends/invite/?welcome=1';
            Http::redirect($redirect_url);

        } else {
            $err = $lang['invalid_vcode'];
        }
    }

} else {
    $err = $lang['invalid_vcode'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('footer.tpl');
DB::close();
