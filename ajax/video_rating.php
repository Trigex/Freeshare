<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_video_rating.php';

$video_id = $_POST['video_id'];
$new_rate = $_POST['new_rate'];

$units = 5;
$err = '';

if (! is_numeric($new_rate)) {
    $err = $lang['rate_numeric'];
} else if ($new_rate > 5 || $new_rate < 1) {
    $err = $lang['invalid_vote'];
} else if (! is_numeric($video_id)) {
    $err = $lang['id_numeric'];
} else if (! isset($_SESSION['UID'])) {
    $err = $lang['invalid_user'];
}

if ($err != '') {
    echo $err;
    exit();
}

$video_info = Video::getById($video_id);

$video_voter_id = $video_info['video_voter_id'];
$video_rated_by = $video_info['video_rated_by'];
$video_rate = $video_info['video_rate'];
$video_rate_new = $new_rate + $video_rate;

if ($_SESSION['UID'] == $video_info['video_user_id']) {
    echo $lang['cannot_rate'];
    exit();
}

if ($video_rate_new == 0) {
    $video_rated_by_new = 0;
} else {
    $video_rated_by_new = $video_rated_by + 1;
}

$voters = explode('|', $video_voter_id);

if (in_array($_SESSION['UID'], $voters)) {
    $video_voter_id_new = $video_voter_id;
} else {
    $video_voter_id_new = $video_voter_id . $_SESSION['UID'] . '|';
}

unset($voters);

$sql = "UPDATE `videos` SET
       `video_rated_by`='" . (int) $video_rated_by_new . "',
       `video_rate`='" . (int) $video_rate_new . "',
       `video_voter_id`='" . DB::quote($video_voter_id_new) . "' WHERE
       `video_id`='" . (int) $video_id . "'";
DB::query($sql);

$video_rated_by = $video_rated_by_new;
$video_rate = $video_rate_new;

if ($video_rated_by > 1) {
    $tense = $lang['votes'];
} else {
    $tense = $lang['vote'];
}

$new_back = array();
$rating_unitwidth = 20;

$new_back[] .= '<ul class="unit-rating" style="width:' . $units * $rating_unitwidth . 'px;">';
$new_back[] .= '<li class="current-rating" style="width:' . @number_format($video_rate / $video_rated_by, 2) * $rating_unitwidth . 'px;">Current rating.</li>';
$new_back[] .= '<li class="r1-unit">1</li>';
$new_back[] .= '<li class="r2-unit">2</li>';
$new_back[] .= '<li class="r3-unit">3</li>';
$new_back[] .= '<li class="r4-unit">4</li>';
$new_back[] .= '<li class="r5-unit">5</li>';
$new_back[] .= '<li class="r6-unit">6</li>';
$new_back[] .= '<li class="r7-unit">7</li>';
$new_back[] .= '<li class="r8-unit">8</li>';
$new_back[] .= '<li class="r9-unit">9</li>';
$new_back[] .= '<li class="r10-unit">10</li>';
$new_back[] .= '</ul>';
$new_back[] .= '<span class="small voted">(' . $video_rated_by . ' ' . $tense . ') ';
$new_back[] .= '<span class="thanks">' . $lang['vote_added'] . '</span></span>';

$output = join("\n", $new_back);
echo $output;
DB::close();
