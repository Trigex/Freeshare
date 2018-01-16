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
require 'include/language/' . LANG . '/lang_reset_password.php';

if (isset($_GET['k']) && isset($_GET['u']) && isset($_GET['i'])) {

    if (! is_numeric($_GET['i'])) {
        $err = $lang['vcode_invalid'];
    } else if (! is_numeric($_GET['u'])) {
        $err = $lang['vcode_invalid'];
    }

    if ($err == '') {

        $data1 = 'PWD_RESET' . $_GET['u'];

        $sql = "SELECT * FROM `verify_code` WHERE
               `id`='" . (int) $_GET['i'] . "' AND
               `vkey`='" . DB::quote($_GET['k']) . "' AND
               `data1`='" . DB::quote($data1) . "'";
        $verify_info = DB::fetch1($sql);

        if ($verify_info) {
            $password = $verify_info['data2'];
            $user_name = User::get_user_name_by_id($_GET['u']);

            User::changePassword($user_name, $password);

            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $_GET['i'] . "'";
            DB::query($sql);

            set_message($lang['password_changed'], 'success');
            $redirect_url = VSHARE_URL . '/login/';
            Http::redirect($redirect_url);
        } else {
            $err = $lang['vcode_invalid'];
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('footer.tpl');
DB::close();
