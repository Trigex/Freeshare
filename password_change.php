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
require 'include/language/' . LANG . '/lang_password_change.php';

User::is_logged_in();

$user_info = User::get_user_by_id($_SESSION['UID']);

if (isset($_POST['submit'])) {
    if ($_POST['user_password'] == '') {
        $err = $lang['password_current_null'];
    } else if ($_POST['password_new'] == '') {
        $err = $lang['password_new_null'];
    } else if ($_POST['password_confirm'] == '') {
        $err = $lang['password_confirm_null'];
    } else if (mb_strlen($_POST['password_new']) < 4) {
        $err = $lang['password_length_error'];
    } else if ($_POST['password_new'] != $_POST['password_confirm']) {
        $err = $lang['password_match_error'];
    }

    if ($err == '') {
        if (! User::validate($user_info['user_name'], $_POST['user_password'])) {
            $err = $lang['password_invalid'];
        } else {
            User::changePassword($user_info['user_name'], $_POST['password_new']);

            set_message($lang['password_success'], 'success');
            $redirect_url = VSHARE_URL . '/' . $user_info['user_name'];
            Http::redirect($redirect_url);
        }
    }
}

$smarty->assign(array(
    'err' => $err,
    'msg' => $msg
));

$smarty->display('header.tpl');
$smarty->display('password_change.tpl');
$smarty->display('footer.tpl');
DB::close();
