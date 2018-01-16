<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_video_like.php';

$video_id = $_GET['video_id'];

if (! is_numeric($video_id)) {
    $err = $lang['id_numeric'];
} else if (! isset($_SESSION['UID'])) {
    $err = $lang['invalid_user'];
}

if ($err != '') {
    Ajax::returnJson($err, 'error');
    exit();
}

$video_info = Video::getById($video_id);

$voters = explode('|', $video_info['video_voter_id']);

if (in_array($_SESSION['UID'], $voters)) {
    Ajax::returnJson($lang['already_liked'], 'error');
} else {
    $video_voter_id = $video_info['video_voter_id'] . '|' . $_SESSION['UID'];
    $sql = "UPDATE `videos` SET
           `video_rated_by`=`video_rated_by`+1,
           `video_voter_id`='$video_voter_id' WHERE
           `video_id`='$video_id'";
    DB::query($sql);
    Ajax::returnJson('liked', 'success');
}

DB::close();
