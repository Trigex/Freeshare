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
require 'include/language/' . LANG . '/lang_upload.php';

if (Config::get('guest_upload') != 1) {
    User::is_logged_in();
    if ($config['enable_package'] == 'yes') {
        check_subscriber_space($_SESSION['UID']);
        check_subscriber_videos($_SESSION['UID']);
    }
}

$num_max_channels = Config::get('num_max_channels');
$smarty->assign('num_max_channels', $num_max_channels);

if (isset($_POST['action_upload'])) {

    if (get_magic_quotes_gpc()) {
        $_POST['video_keywords'] = stripslashes($_POST['video_keywords']);
        $_POST['video_title'] = stripslashes($_POST['video_title']);
        $_POST['video_description'] = stripslashes($_POST['video_description']);
    }

    $channel = isset($_POST['channel']) ? (int) $_POST['channel'] : 0;

    $_POST['video_description'] = Xss::clean($_POST['video_description']);
    $_POST['video_title'] = htmlspecialchars_uni($_POST['video_title']);
    $_POST['video_keywords'] = strip_tags($_POST['video_keywords']);

    if (strlen_uni($_POST['video_title']) < 4) {
        $err = $lang['title_too_short'];
    } else if (strlen_uni($_POST['video_description']) < 4) {
        $err = $lang['description_too_short'];
    } else if (strlen_uni($_POST['video_keywords']) < 4) {
        $err = $lang['tags_too_short'];
    } else if (! check_field_exists($channel, 'channel_id', 'channels')) {
        $err = $lang['channel_not_selected'];
    }

    $upload_from = isset($_POST['upload_from']) ? $_POST['upload_from'] : 'local';

    if ($_POST['field_privacy'] != 'public') {
        $_POST['field_privacy'] = 'private';
    }

    if ($_POST['video_adult'] != 1) {
        $_POST['video_adult'] = 0;
    }

    $upload_id = md5($_SERVER['REQUEST_TIME'] . rand(1, 2000));
    $upload_info = array();
    $upload_info['title'] = $_POST['video_title'];
    $upload_info['description'] = $_POST['video_description'];
    $upload_info['keywords'] = $_POST['video_keywords'];
    $upload_info['channels'] = $channel;
    $upload_info['field_privacy'] = $_POST['field_privacy'];
    $upload_info['adult'] = $_POST['video_adult'];
    $upload_info['type'] = $_POST['field_privacy'];

    $_SESSION["$upload_id"] = $upload_info;

    if ($err == '') {
        if ($upload_from == 'remote') {
            $redirect_url = VSHARE_URL . '/upload_remote.php?upload_id=' . $upload_id;
        } else {
            $redirect_url = VSHARE_URL . '/upload_file.php?id=' . $upload_id;
        }
        Http::redirect($redirect_url);
    }
}

$channels = Channel::get();

$smarty->assign('channel_info', $channels);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('upload.tpl');
$smarty->display('footer.tpl');
DB::close();
