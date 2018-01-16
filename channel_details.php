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

if (! is_numeric($_GET['id']) || $_GET['id'] < 1)
{
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$channel = Channel::getById($_GET['id']);

if ($channel) {

    $num_channel_videos = Config::get('num_channel_video');

    $sql = "SELECT count(video_id) AS `total`, `video_user_id` FROM `videos` WHERE
           `video_channels` LIKE '%|" . (int) $_GET['id'] . "|%' AND
           `video_approve`='1' AND
           `video_active`='1' AND
           `video_type`='public' AND
           `video_user_id` > '0'
            GROUP BY `video_user_id`
            ORDER BY `total` DESC
            LIMIT 5";
    $most_active_users = DB::fetch($sql);
    $smarty->assign('most_active_users', $most_active_users);

    $sql = "SELECT * FROM `videos` WHERE
           `video_channels` LIKE '%|" . (int) $_GET['id'] . "|%' AND
           `video_approve`='1' AND
           `video_active`='1' AND
           `video_type`='public'
            ORDER BY `video_add_time` DESC
            LIMIT $num_channel_videos";
    $recent_channel_videos_all = DB::fetch($sql);

    $recent_channel_videos = array();

    foreach ($recent_channel_videos_all AS $recent_channel_video) {
        $recent_channel_video['video_thumb_url'] = $servers[$recent_channel_video['video_thumb_server_id']];
        $recent_channel_videos[] = $recent_channel_video;
    }

    $smarty->assign('recent_channel_videos', $recent_channel_videos);

    # find popular videos on channel

    $sql = "SELECT * FROM `videos` WHERE
           `video_channels` LIKE '%|" . (int) $_GET['id'] . "|%' AND
           `video_approve`='1' AND
           `video_active`='1' AND
           `video_type`='public'
            ORDER BY `video_view_number` DESC
            LIMIT $num_channel_videos";
    $channel_videos_all = DB::fetch($sql);
    $total = count($recent_channel_videos_all);

    $mostview = array();

    foreach ($channel_videos_all as $video)
    {
        $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
        $mostview[] = $video;
    }

    $smarty->assign('mostview', $mostview);
    $smarty->assign('total', $total);
    $smarty->assign('channel', $channel);
}

$channels = Channel::get();
$smarty->assign('channels', $channels);
$smarty->assign('html_title', $channel['channel_name']);
$smarty->assign('html_keywords', $channel['channel_name']);
$smarty->assign('html_description', $channel['channel_description']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('channel_details.tpl');
$smarty->display('footer.tpl');
DB::close();
