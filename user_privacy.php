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
require 'include/language/' . LANG . '/lang_user_privacy.php';

User::is_logged_in();

$user_info = User::getById($_SESSION['UID']);

if (isset($_POST['submit'])) {
    $sql = "UPDATE `users` SET
		   `user_friend_invition`=" . (int) $_POST['user_friend_invition'] . ",
		   `user_private_message`=" . (int) $_POST['user_private_message'] . ",
		   `user_profile_comment`=" . (int) $_POST['user_profile_comment'] . ",
		   `user_favourite_public`=" . (int) $_POST['user_favourite_public'] . ",
		   `user_playlist_public`=" . (int) $_POST['user_playlist_public'] . ",
		   `user_subscribe_admin_mail`=" . (int) $_POST['user_subscribe_admin_mail'] . "
		    WHERE `user_id`='" . (int) $_SESSION['UID'] . "'";
    DB::query($sql);
    set_message($lang['settings_updated'], 'success');
    $redirect_url = VSHARE_URL . '/' . $_SESSION['USERNAME'];
    Http::redirect($redirect_url);
}

$smarty->assign('user_info', $user_info);
$smarty->display('header.tpl');
$smarty->display('user_privacy.tpl');
$smarty->display('footer.tpl');
DB::close();
