<?php

require '../include/config.php';

if (isset($_COOKIE['video_queue'])) {
    if (!empty($_COOKIE['video_queue'])) {

        $video_ids = $_COOKIE['video_queue'];

        if (preg_match('/,$/',$_COOKIE['video_queue'], $match)) {
            $video_ids = preg_replace('/,$/','',$_COOKIE['video_queue']);
        }

        $sql = "SELECT * FROM `videos` WHERE
               `video_id` IN($video_ids)";
        $videos_all = DB::fetch($sql);

        $video_queue = array();

        foreach ($videos_all as $video_info) {
            $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
            $video_queue[] = $video_info;
        }

        $smarty->assign('video_info', $video_queue);
        $smarty->display('video_queue.tpl');
    }
}
