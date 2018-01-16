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

$video_id = isset($_GET['video_id']) ? (int) $_GET['video_id'] : 0;

if ($video_id == 0) {
    echo "invalid video id";
    exit();
}

$video_info = Video::getById($video_id);

$video_thumb_url = $servers[$video_info['video_thumb_server_id']];
$logo = $config['watermark_image_url'];
$image = $video_thumb_url . '/thumb/' . $video_info['video_folder'] . '/' . $video_id . '.jpg';
$vshare_player = Config::get('vshare_player');

if ($vshare_player == 'StrobeMediaPlayback') {
    $file_url = 'src=' . VSHARE_URL . '/flvideo/' . $video_info['video_folder'] . $video_info['video_flv_name'];
    $video_flv_player = VSHARE_URL . '/player/player_adobe.swf?';
    $poster = '&poster=' . $image;
    $video_flv_player .= $file_url . $poster;
} else {
    $file_url = 'file=' . VSHARE_URL . '/xml_playlist.php?id=' . $video_info['video_id'];
    $video_flv_player = VSHARE_URL . '/player/player.swf?';
    $video_flv_player .= $file_url;
    $video_flv_player .= '&logo=' . $logo;
}

$sql = "UPDATE `videos` SET `video_view_number`=`video_view_number`+1 WHERE `video_id`=$video_id";
$result = DB::query($sql);

header('Content-Type: video/flv');
Header("Location: $video_flv_player");
