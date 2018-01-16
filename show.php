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

if (! is_numeric($_GET['id'])) {
    echo "id must be numeric";
    exit(0);
}

$video_id = isset($_GET['id']) ? $_GET['id'] : 0;

$video_info = Video::getById($video_id);

if (! $video_info || $video_info['video_active'] != 1 || $video_info['video_approve'] != 1) {
    $err = 1;
} else {
    $video_video_flv_name = $video_info['video_flv_name'];
    $player = new VideoPlayer();
    $vshare_player = $player->getPlayerCode($video_id);
}

$smarty->assign('err', $err);
$smarty->assign('VSHARE_PLAYER', $vshare_player);
$smarty->display('show.tpl');
DB::close();
