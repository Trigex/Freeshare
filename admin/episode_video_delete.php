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

$ep_video_id = isset($_GET['ep_video_id']) ? (int) $_GET['ep_video_id'] : 0;
$ep_video_info = EpisodeVideo::getById($ep_video_id);

EpisodeVideo::delete($ep_video_id);

DB::close();

set_message('Video removed from episode.', 'success');
Http::redirect('episode_videos.php?eid=' . $ep_video_info['ep_video_eid']);
