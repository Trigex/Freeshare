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

require 'admin_config.php';
require '../include/config.php';
require '../include/language/' . LANG . '/admin/video_rename_flv.php';

Admin::auth();

if (! is_numeric($_GET['id'])) {
    $err = $lang['video_id_numeric'];
} else {
    $video_info = Video::getById($_GET['id']);
    $flv_video = $video_info['video_flv_name'];

    $pos = strrpos($flv_video, '.');
    $file_extn = strtolower(substr($flv_video, $pos + 1, strlen($flv_video) - $pos));

    $rand1 = $_SERVER['REQUEST_TIME'];
    $rand2 = mt_rand();
    $rand_name = $rand1 . $rand2;
    $rand_name = md5($rand_name);

    if ($file_extn == 'mp4') {
        $file_extn = '.mp4';
    } else {
        $file_extn = '.flv';
    }

    $new_flv_video = $rand_name . $file_extn;

    while (check_field_exists($new_flv_video, 'video_flv_name', 'videos') == 1) {
        $rand1 = time();
        $rand2 = mt_rand();
        $rand_name = $rand1 . $rand2;
        $rand_name = md5($rand_name);
        $new_flv_video = $rand_name . $file_extn;
    }

    $old_flv_path = VSHARE_DIR . '/flvideo/' . $video_info['video_folder'] . $flv_video;
    $new_flv_path = VSHARE_DIR . '/flvideo/' . $video_info['video_folder'] . $new_flv_video;

    if ($video_info['video_server_id'] == 0) {
        if (strlen($flv_video) > 4) {
            if (file_exists($old_flv_path)) {
                if (rename($old_flv_path, $new_flv_path)) {
                    update_video($new_flv_video, $_GET['id'], $flv_video);
                    $msg = $lang['rename_ok'];
                } else {
                    $err = $lang['rename_failed'];
                }
            } else {
                $err = $lang['file_not_found'];
            }
        } else {
            $err = str_replace('[FILENAME]', $flv_video, $lang['file_name_short']);
        }
    } else {
        $ftp_config = array();
        $ftp_config['video_id'] = $_GET['id'];
        $ftp_config['server_id'] = $video_info['video_server_id'];
        $ftp_config['debug'] = $config['debug'];
        $ftp_config['log_file_name'] = 'rename';
        $ftp_config['flv_name_source'] = $flv_video;
        $ftp_config['flv_name_new'] = $new_flv_video;
        $ftp_config['video_folder'] = $video_info['video_folder'];

        $ftp = new Ftp();

        if ($ftp->video_rename($ftp_config)) {
            update_video($new_flv_video, $_GET['id'], $flv_video);
            $msg = $lang['rename_ok'];
        }
    }
}

function update_video($new_flv_video, $id, $flv_video)
{
    global $lang , $smarty;

    $sql = "UPDATE `videos` SET
           `video_flv_name`='$new_flv_video' WHERE
           `video_id`='" . (int) $id . "'";
    DB::query($sql);

    $video_info = Video::getById($id);

    $smarty->assign('old_name', $flv_video);
    $smarty->assign('video_info', $video_info);
    $smarty->assign('new_flv_name', $new_flv_video);
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_rename_flv.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
