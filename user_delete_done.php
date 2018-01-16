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
require 'include/language/' . LANG . '/lang_user_delete_done.php';

if (isset($_GET['k']) && isset($_GET['i'])) {

    $data1 = "DELETE_USER";
    $sql = "SELECT * FROM `verify_code` WHERE
           `data1`='" . DB::quote($data1) . "' AND
           `vkey`='" . DB::quote($_GET['k']) . "' AND
           `id`='" . DB::quote($_GET['i']) . "'";
    $verify_info = DB::fetch1($sql);

    if ($verify_info) {

        $verify_id = $verify_info['id'];
        $verify_key = $verify_info['vkey'];
        $user_id = $verify_info['data2'];

        User::delete($user_id, 0); // 0 for soft del

        $sql = "DELETE FROM `verify_code` WHERE
               `id`='" . (int) $_GET['i'] . "'";
        DB::query($sql);

        if (isset($_SESSION['UID'])) {
            User::logout();
        }

        DB::close();
        set_message($lang['account_deleted'], 'success');
        $redirect_url = VSHARE_URL . '/';
        Http::redirect($redirect_url);
    }
    else
    {
        $err = $lang['invalid_vkey'];
    }
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('header.tpl');
$smarty->display('footer.tpl');
DB::close();
