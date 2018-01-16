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

$episode_id = isset($_GET['eid']) ? (int) $_GET['eid'] : 0;

$episode_info = Episode::getById($episode_id);
$episode_videos = EpisodeVideo::getInfo($episode_id);

$smarty->assign(array(
    'episode_info' => $episode_info,
    'episode_videos' => $episode_videos,
    'msg' => $msg,
));
$smarty->display('admin/header.tpl');
$smarty->display('admin/episode_videos.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
