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
require 'include/language/' . LANG . '/lang_group_invite_confirm.php';

User::is_logged_in();

$group_url = htmlspecialchars_uni($_GET['group_url']);

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($group_url) . "'";
$group_info = DB::fetch1($sql);

if (! $group_info) {
    Http::redirect(VSHARE_URL);
}

if (! isset($_GET['key'])) {
    DB::close();
    Http::redirect(VSHARE_URL);
}

$sql = "SELECT * FROM `verify_code` AS v,
       `groups` AS g WHERE
        v.vkey='" . DB::quote($_GET['key']) . "' AND
        v.data1=g.group_id";
$verify_info = DB::fetch1($sql);

if (! $verify_info) {
    DB::close();
    set_message($lang['invalid_invite_key'], 'error');
    $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
    Http::redirect($redirect_url);
}

$join_group_id = $group_info['group_id'];

$sql = "SELECT * FROM `group_members` WHERE
       `group_member_group_id`='" . (int) $join_group_id . "' AND
       `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
$is_member = DB::fetch1($sql);

if (! $is_member) {
    $sql = "INSERT INTO `group_members` SET
           `group_member_group_id`='" . (int) $join_group_id . "',
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "',
           `group_member_since`='" . date("Y-m-d H:i:s") . "',
           `group_member_approved`='yes'";
    DB::query($sql);
    $msg = $lang['user_added'];
}

$sql = "DELETE FROM `verify_code` WHERE
       `vkey`='" . DB::quote($_GET['key']) . "'";
DB::query($sql);
DB::close();

$smarty->assign('accept_mem', 'true');

set_message($msg, 'success');

$redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
Http::redirect($redirect_url);
