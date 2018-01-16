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

User::is_logged_in();

$user_info = User::getByName($_SESSION['USERNAME']);

if (! $user_info) {
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$smarty->assign('user_info', $user_info);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('myaccount.tpl');
$smarty->display('footer.tpl');
DB::close();
