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
require 'include/language/' . LANG . '/lang_email_unsubscribe.php';

$vkey = isset($_GET['vkey']) ? $_GET['vkey'] : 0;
$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$unsubscribed_success = 0;

$user_info = User::getByName($user_name);

if (! $user_info) {
    echo $lang['user_not_found'];
    exit;
}

$data1 = 'UNSUBSCRIBE_' . $user_info['user_id'];

$sql = "SELECT * FROM `verify_code` WHERE
	   `vkey`='" . DB::quote($vkey) . "' AND
	   `data1`='" . DB::quote($data1) . "'";
$verify_info = DB::fetch1($sql);

if (! $verify_info) {
    echo $lang['invalid_auth_key'];
    exit;
}

    if (isset($_POST['unsubscribe'])) {
    	$sql = "UPDATE `users` SET `user_subscribe_admin_mail`='0' WHERE
    		   `user_id`='" . $user_info['user_id'] . "'";
    	DB::query($sql);

    	$unsubscribe_txt = str_replace('[PRIVACY_SETTINGS_URL]', VSHARE_URL . '/privacy/', $lang['unsubscribed_success']);
    	$unsubscribe_txt = str_replace('[SITE_NAME]', $config['site_name'], $unsubscribe_txt);
    	$smarty->assign('unsubscribe_txt',$unsubscribe_txt);
    	$unsubscribed_success = 1;
    } elseif (isset($_POST['cancel'])) {
        Http::redirect(VSHARE_URL);
    }

$smarty->assign('unsubscribed_success', $unsubscribed_success);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('email_unsubscribe.tpl');
$smarty->display('footer.tpl');
DB::close();
