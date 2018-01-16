<?php

require '../include/config.php';

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

if ($user_id == '') {
    echo "Invalid user.";
    exit(0);
}

$user_info = User::getById($user_id);

if (! $user_info) {
    exit(0);
}

$smarty->assign('user_name', $user_info['user_name']);

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
	   `video_user_id`='" . (int) $user_id . "' AND
	   `video_type`='public' AND
	   `video_active`='1' AND
	   `video_approve`='1'";
$video_count = DB::getTotal($sql);

$sql = "SELECT * FROM `videos` WHERE
	   `video_user_id`='" . (int) $user_id . "' AND
	   `video_type`='public' AND
	   `video_active`='1' AND
	   `video_approve`='1'
	    ORDER BY `video_id` DESC
	    LIMIT 15";
$user_videos_all = DB::fetch($sql);

foreach ($user_videos_all as $video) {
    $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
    $user_videos[] = $video;
}

$smarty->assign('user_videos', $user_videos);
$smarty->assign('video_count', $video_count);
$smarty->display('user_videos_ajax.tpl');
