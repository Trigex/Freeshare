<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_video_add_favorite.php';

if (! isset($_SESSION['UID'])) {
    Ajax::returnJson($lang['user_must_login'], 'error');;
    exit(0);
}

$video_id = isset($_POST['video_id']) ? $_POST['video_id'] : '';

if (! is_numeric($video_id)) {
    Ajax::returnJson($lang['hacking'], 'error');
    exit(0);
}

$video_info = Video::getById($video_id);

if ($_SESSION['UID'] == $video_info['video_user_id']) {
    Ajax::returnJson($lang['favorite_self'], 'error');
    exit(0);
}

$sql = "SELECT * FROM `favourite` WHERE
       `favourite_user_id`=" . (int) $_SESSION['UID'] . " AND
       `favourite_video_id`='" . (int) $video_id . "'";
$is_favourite = DB::fetch($sql);

if (! $is_favourite) {
    $sql = "INSERT INTO `favourite` SET
	       `favourite_user_id`='" . (int) $_SESSION['UID'] . "',
	       `favourite_video_id`='" . (int) $video_id . "'";
    DB::query($sql);
    $sql = "UPDATE `videos` SET
	       `video_fav_num`=`video_fav_num`+1
	        WHERE `video_id`=" . (int) $video_id;
    DB::query($sql);
    Ajax::returnJson($lang['favorite_added'], 'success');
} else {
    Ajax::returnJson($lang['favorite_exists'], 'success');
}

DB::close();
