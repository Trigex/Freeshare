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

$count_real_video_views = 1;
$video_id = isset($_GET['id']) ? $_GET['id'] : 0;
$video_info = Video::getById($video_id);

if ($video_info) {

    if ($video_info['video_vtype'] == 0) {
        $url = File::getVideoUrl($video_info['video_server_id'], $video_info['video_folder'], $video_info['video_flv_name']);
    }

    header('content-type:text/xml;charset=utf-8');
    echo '<playlist version="1" xmlns="http://xspf.org/ns/0/">';
    echo '<tracklist>';
    echo '<track>';
    echo '<title>' . $video_info['video_title'] . '</title>';
    echo '<annotation>' . $video_info['video_description'] . '</annotation>';
    echo '<location>' . $url . '</location>';
    echo '<image>' . $servers[$video_info['video_thumb_server_id']] . '/thumb/' . $video_info['video_folder'] . $id . '.jpg</image>';
    echo '</track>';
    echo '</tracklist>';
    echo '</playlist>';
}

DB::close();
