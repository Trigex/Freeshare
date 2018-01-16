<?php

require '../include/config.php';

$video_id = isset($_POST['video_id']) ? $_POST['video_id'] : '';
$comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : '';

if (! is_numeric($video_id) || ! is_numeric($comment_id) || ! isset($_SESSION['UID']))
{
    Ajax::returnJson('Hacking attempt.', 'error');
    exit(0);
}

$video_info = Video::getById($video_id);

if (isset($_SESSION['UID']) && $video_info) {
    if ($video_info['video_user_id'] == $_SESSION['UID']) {
        $sql = "DELETE FROM `comments` WHERE
               `comment_id`=" . (int) $comment_id . " AND
               `comment_video_id`=" . (int) $video_id;
        DB::query($sql);

        if (DB::affectedRows() == 1) {
            $sql = "UPDATE `videos` SET
		           `video_com_num`=`video_com_num`-1 WHERE
		           `video_id`='" . (int) $video_id . "'";
            DB::query($sql);
            Ajax::returnJson($comment_id, 'success');
        }
    }
}

DB::close();
