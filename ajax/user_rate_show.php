<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_user_rate.php';

$candidate_id = isset($_POST['candidate']) ? $_POST['candidate'] : 0;

if (! is_numeric($candidate_id)) {
    Ajax::returnJson('Hacking attempt', 'error');
    exit(0);
}

$sql = "SELECT count(*) AS `total`, sum(vote) FROM `uservote` WHERE
       `candate_id`=" . (int) $candidate_id . "
        GROUP BY `candate_id`";
$vote_info = DB::fetch1($sql);

$list = '';
$rate = $vote_info['sum(vote)'];
$rating = $vote_info['total'];

if ($rate > 0) {
    $rate = $rate / $rating;
    $num_full_star = floor($rate);
    for ($i = 0; $i < $num_full_star; $i ++) {
        $list .= '<img src="' . IMG_CSS_URL . '/images/star.gif" alt="star">&nbsp;';
    }
    if ($rate == $num_full_star) {
        $num_falf_star = 0;
    } else {
        $num_falf_star = 1;
        $list .= '<img src="' . IMG_CSS_URL . '/images/half_star.gif" alt="half star">';
    }
    $num_blank_star = 5 - $num_full_star - $num_falf_star;
    for ($i = 0; $i < $num_blank_star; $i ++) {
        $list .= '<img src="' . IMG_CSS_URL . '/images/blank_star.gif" alt="blank star">';
    }
} else {
    $rate = 0;
}

if ($rate > 0) {
    Ajax::returnJson($list, 'success');
} else {
    if ($config['debug']) error_log(__FILE__ . " $err \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
    Ajax::returnJson($lang['not_yet_rated'], 'error');
}
