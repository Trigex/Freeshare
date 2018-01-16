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

Admin::auth();

$err = 0;

if (isset($_POST['submit'])) {

    $videos = $_POST['local_videos'];
    $server_id = (int) $_POST['server'];

    $ftp_config = array();
    $ftp_config['must_upload'] = 0;
    $ftp_config['debug'] = $config['debug'];
    $ftp = new Ftp();

    for ($i = 0; $i < count($videos); $i ++) {
        $ftp_config['server_id'] = $server_id;
        $ftp_config['video_id'] = (int) $videos[$i];
        $ftp_config['log_file_name'] = 'move_video_' . $ftp_config['video_id'];
        $ftp->upload_video($ftp_config);
        $ftp_config['log_file_name'] = 'move_video_jpg' . $ftp_config['video_id'];
        $ftp_config['server_id'] = '';
        $ftp->upload_thumb($ftp_config);
    }
}

DB::close();

if ($config['debug'] == 0) {
    $redirect_url = VSHARE_URL . '/admin/video_local.php';
    Http::redirect($redirect_url);
}
