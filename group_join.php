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
require 'include/language/' . LANG . '/lang_group_join.php';

User::is_logged_in();

$group_id = isset($_GET['group_id']) ? $_GET['group_id'] : 0;

$uer_info = User::get_user_by_id($_SESSION['UID']);

if ($uer_info == 0) {
    set_message($lang['group_security_error'], 'error');
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$group_info = Group::getById($group_id);

if ($group_info == 0) {
    set_message($lang['group_security_error'], 'error');
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$_GET['action'] = isset($_GET['action']) ? $_GET['action'] : '';

if ($_GET['action'] == 'join') {
    if ($group_info['group_type'] == 'protected') {
        $approved = 'no';
    } else {
        $approved = 'yes';
    }

    $sql = "SELECT * FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
    $group_member_info = DB::fetch1($sql);

    if ($group_member_info) {
        if ($group_info['group_type'] == 'protected' && $group_member_info['group_member_approved'] == 'no') {
            $msg = $lang['group_membership_requested'];
        } else {
            $msg = $lang['group_join_ok'];
        }
    } else {
        $sql = "INSERT INTO `group_members` SET
               `group_member_group_id`='" . (int) $group_info['group_id'] . "',
               `group_member_user_id`='" . (int) $_SESSION['UID'] . "',
               `group_member_since`='" . date("Y-m-d H:i:s") . "',
               `group_member_approved`='" . DB::quote($approved) . "'";
        DB::query($sql);

        if ($group_info['group_type'] == 'protected') {
            $msg = $lang['group_membership_requested'];
        } else {
            $msg = $lang['group_join_ok'];
        }
    }
}

if ($_GET['action'] == 'remove') {
    $sql = "DELETE FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
    DB::query($sql);
    $msg = $lang['group_membership_revoked'];
}

DB::close();

set_message($msg, 'success');
$redirect_url = VSHARE_URL . '/group/' . $group_info['group_url'] . '/';
Http::redirect($redirect_url);
