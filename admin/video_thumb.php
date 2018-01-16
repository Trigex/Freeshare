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
require '../include/language/' . LANG . '/admin/video_thumb.php';

Admin::auth();

if (is_numeric($_GET['id'])) {

    ob_start();

    $video_info = Video::getById($_GET['id']);
    $video_src = VSHARE_DIR . '/video/' . $video_info['video_name'];
    $log_file_name = 're_create_thumb_' . $video_info['video_id'];

    if ($config['debug']) {
        $log_text = '<p>$video_src = ' . $video_src . '</p>';
        write_log($log_text, $log_file_name, $config['debug'], 'html');
    }

    if (file_exists($video_src) && is_file($video_src)) {
        if ($config['debug']) {
            $log_text = '<p>File found = ' . $video_src . '</p>';
            write_log($log_text, $log_file_name, $config['debug'], 'html');
        }

        if ($video_info['video_folder'] != '') {
            if (! is_dir(VSHARE_DIR . '/thumb/' . $video_info['video_folder'])) {
                mkdir(VSHARE_DIR . '/thumb/' . $video_info['video_folder']);
            }
        }

        if ($config['debug']) {
            $log_text = '<p>thumb_folder = ' . VSHARE_DIR . '/thumb/' . $video_info['video_folder'] . '</p>';
            write_log($log_text, $log_file_name, $config['debug'], 'html');
        }

        $thumb_data = array();
        $thumb_data['src'] = $video_src;
        $thumb_data['vid'] = (int) $_GET['id'];
        $thumb_data['video_folder'] = $video_info['video_folder'];
        $thumb_data['debug'] = $config['debug'];

        $tool_video_thumb = Config::get('tool_video_thumb');
        $thumb_data['tool'] = $tool_video_thumb;

        $tmp = VideoThumb::make($thumb_data);

        if ($video_info['video_thumb_server_id'] > 0) {
            if ($config['debug']) {
                $log_text = '<p>$video_info[\'video_thumb_server_id\'] = ' . $video_info['video_thumb_server_id'] . '</p>';
                write_log($log_text, $log_file_name, $config['debug'], 'html');
            }
            $ftp_config = array();
            $ftp_config['debug'] = $config['debug'];
            $ftp_config['video_id'] = $_GET['id'];
            $ftp_config['log_file_name'] = 'log_create_thumb';
            $ftp_config['must_upload'] = 1;
            $ftp = new Ftp();
            $ftp->upload_thumb($ftp_config);
        }

        $debug_log = ob_get_contents();
        ob_end_clean();

        $smarty->assign('debug_log', $debug_log);
        $msg = str_replace('[FIND_WIDTH]', $tool_video_thumb, $lang['thumb_created']);
        $smarty->assign('video_folder', $video_info['video_folder']);
        $video_thumb_url = $servers[$video_info['video_thumb_server_id']];
        $smarty->assign('video_thumb_url', $video_thumb_url);
    } else {
        $err = str_replace('[VIDEO_SRC]', $video_src, $lang['file_not_found']);
    }
} else {
    $err = $lang['video_id_invalid'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_thumb.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
