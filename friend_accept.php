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
require 'include/language/' . LANG . '/lang_friend_accept.php';

User::is_logged_in();

if (isset($_GET['id']) && (is_numeric($_GET['key']))) {

    $id = base64_decode($_GET['id']);
    $key = $_GET['key'];

    $sql = "SELECT * FROM `verify_code` WHERE
           `id`='" . (int) $id . "' AND
           `vkey`='" . DB::quote($key) . "'";
    $verify_info = DB::fetch1($sql);

    if ($verify_info) {

        $fid = $verify_info['data1'];

        $sql = "SELECT * FROM `friends` WHERE
               `friend_id`='" . (int) $fid . "'";
        $tmp = DB::fetch1($sql);

        $invite_for = $tmp['friend_friend_id'];

        if ($_SESSION['UID'] == $tmp['friend_user_id']) {

            $sql = "DELETE FROM `friends` WHERE
                    `friend_id`='$fid'";
            DB::query($sql);

            set_message('You cannot invite yourself as a friend', 'error');
            $redirect_url = VSHARE_URL . '/friends.php';
            Http::redirect($redirect_url);
        }

        if (empty($invite_for)) {
            $sql = "UPDATE `friends` SET
                   `friend_friend_id`='" . (int) $_SESSION['UID'] . "',
                   `friend_name`='" . DB::quote($_SESSION['USERNAME']) . "' WHERE
                   `friend_id`='" . (int) $fid . "'";
            DB::query($sql);
        } else {
            if ($invite_for != $_SESSION['UID']) {
                set_message($lang['invitation_is_not_for_you'], 'error');
                $redirect_url = VSHARE_URL . '/friend_accept.php';
                Http::redirect($redirect_url);
            }
        }

        $smarty->assign('AID', $fid);
        $smarty->assign('id', $id);
        $smarty->assign('UID', $tmp['friend_user_id']);
        $smarty->assign('user_name', User::get_user_name_by_id($tmp['friend_user_id']));
    } else {
        $err = $lang['invalid_invite_key'];
    }
}

# accept friend request

if (isset($_POST['friend_accept'])) {

    $id = $_POST['id'];
    $fid = $_POST['AID'];

    if ((! is_numeric($id)) || (! is_numeric($fid))) {
        exit();
    }

    $sql = "SELECT * FROM `verify_code` WHERE
           `id`='" . (int) $id . "' AND
           `data1`='" . (int) $fid . "'";
    $verify_info = DB::fetch($sql);

    if ($verify_info) {

        $sql = "SELECT * FROM `friends` WHERE
               `friend_id`=" . (int) $fid . " AND
               `friend_status`='Pending'";
        $tmp = DB::fetch1($sql);

        if ($tmp)
        {
            $friend_id = $tmp['friend_user_id'];
            $tmp = User::getById($friend_id);

            $friend_user_name = $tmp['user_name'];

            $sql = "UPDATE `friends` SET
                   `friend_friend_id`='" . (int) $_SESSION['UID'] . "',
                   `friend_name`='" . DB::quote($_SESSION['USERNAME']) . "',
                   `friend_status`='Confirmed' WHERE
                   `friend_id`='" . (int) $fid . "'";
            DB::query($sql);

            $sql = "INSERT INTO `friends` SET
                   `friend_user_id`='" . (int) $_SESSION['UID'] . "',
                   `friend_friend_id`='" . (int) $friend_id . "',
                   `friend_name`='" . DB::quote($friend_user_name) . "',
                   `friend_type`='All|Friends',
                   `friend_invite_date`='" . date("Y-m-d") . "',
                   `friend_status`='Confirmed'";
            DB::query($sql);

            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $id . "'";
            DB::query($sql);

            set_message($lang['friend_added'], 'success');
            $redirect_url = VSHARE_URL . '/';
            Http::redirect($redirect_url);
        }

    } else {
        $err = $lang['invalid_add_request'];
    }
}

# deny friend request

if (isset($_POST['friend_deny'])) {

    $id = $_POST['id'];
    $fid = $_POST['AID'];
    $sql = "DELETE FROM `verify_code` WHERE
           `id`='" . (int) $id . "'";
    DB::query($sql);

    $sql = "DELETE FROM `friends` WHERE
           `friend_id`='" . (int) $fid . "'";
    DB::query($sql);

    set_message($lang['friend_deny'], 'success');
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('friend_accept.tpl');
$smarty->display('footer.tpl');
DB::close();
