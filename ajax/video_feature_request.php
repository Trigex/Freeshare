<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_video_feature_request.php';

$videoId = isset($_POST['vid']) ? $_POST['vid'] : '';

if (! is_numeric($videoId)) {
    $err = $lang['video_id_invalid'];
} else if (! isset($_SESSION['UID'])) {
    $err = $lang['guest'];
}

if ($err != '') {
    if ($config['debug']) error_log("$err \n", 3, VSHARE_DIR . '/templates_c/ajax_video_feature_log.txt');
    Ajax::returnJson($err, 'error');
    exit();
}

$sql = "SELECT count(*) AS `total` FROM `feature_requests` WHERE
       `feature_request_video_id`='" . (int) $videoId . "'";
$already_requested = DB::getTotal($sql);

if ($already_requested) {
    $sql = "UPDATE `feature_requests` SET
           `feature_request_count`=feature_request_count + 1,
           `feature_request_date`='" . date("Y-m-d") . "' WHERE
           `feature_request_video_id`='" . (int) $videoId . "'";
} else {
    $sql = "INSERT `feature_requests` SET
           `feature_request_video_id`=" . (int) $videoId . ",
           `feature_request_count`=1,
           `feature_request_date`='" . date("Y-m-d") . "'";
}

DB::query($sql);

if ($config['debug']) error_log("$err \n", 3, VSHARE_DIR . '/templates_c/ajax_video_feature_log.txt');
Ajax::returnJson($lang['feature_request_ok'], 'success');
DB::close();
