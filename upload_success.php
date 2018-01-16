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
require 'include/language/' . LANG . '/lang_upload_success.php';

$guest_upload = Config::get('guest_upload');

if ($guest_upload == 0) {
    User::is_logged_in();
}

$upload_id = $_GET['upload_id'];

if ($upload_id != 'remote') {

    $id = $_GET['id'];

    if (! is_numeric($id)) {
        echo 'Invalid id';
        exit(0);
    }

    $sql = "SELECT * FROM `process_queue` WHERE
           `id`='" . (int) $id . "'";
    $queue_info = DB::fetch1($sql);
    $status = $queue_info['status'];
    $user = $queue_info['user'];

    if ($guest_upload == 0) {
        if ($user != $_SESSION['USERNAME']) {
            echo "Invalid user";
            exit(0);
        }
    }

    if ($status == 5) {
        $video_processed = 1;
        $vid = $queue_info['vid'];
        $video_info = Video::getById($vid);
        $video_flv_name = $video_info['video_flv_name'];
        $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];

        if (! $video_info) {
            $err = $lang['video_not_found'];
        }

        $smarty->assign('video_info', $video_info);
    } else {
        $video_processed = 0;
    }

} else {
    $vid = $_GET['id'];
    $video_info = Video::getById($vid);

    $video_flv_name = $video_info['video_flv_name'];

    if (! $video_info) {
        $err = $lang['video_not_found'];
    }

    $smarty->assign('video_info', $video_info);
    $video_processed = 1;
}

if ($video_processed == 1) {
    if ($video_info['video_vtype'] == 0) {
        if ($video_info['video_server_id'] == 0) {
            $flv_url = VSHARE_URL . '/flvideo/' . $video_info['video_folder'] . $video_info['video_flv_name'];
        } else {
            $sql = "SELECT * FROM `servers` WHERE
                   `id`='" . (int) $video_info['video_server_id'] . "'";
            $server_info = DB::fetch1($sql);
            $flv_url = $server_info['url'] . '/' . $video_info['video_folder'] . $video_info['video_flv_name'];
        }

        $smarty->assign('flv_url', $flv_url);
    }

    if ($video_info['video_active'] == 1 && $video_info['video_approve'] == 1) {
        if (isset($_SESSION['UID'])) {
	        User::updateVideoCount($_SESSION['UID'], 1);
        } else if ($guest_upload == 1) {
            $guest_upload_user = Config::get('guest_upload_user');
	        $user_info = User::getByName($guest_upload_user);
	        User::updateVideoCount($user_info['user_id'], 1);
        }
    }
}

if ($upload_id != 'remote') {
    unset($_SESSION["$upload_id"]['field_privacy']);
    unset($_SESSION["$upload_id"]['description']);
    unset($_SESSION["$upload_id"]['title']);
    unset($_SESSION["$upload_id"]['keywords']);
    unset($_SESSION["$upload_id"]['channels']);
    unset($_SESSION["$upload_id"]['adult']);
}

$smarty->assign('video_processed', $video_processed);
$smarty->assign('err', $err);
if (isset($_GET['vid'])) $smarty->assign('vidid', $_GET['vid']);
$smarty->display('header.tpl');
$smarty->display('upload_success.tpl');
$smarty->display('footer.tpl');
DB::close();
