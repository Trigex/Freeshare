<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_user_rate.php';

$voter = isset($_POST['voter']) ? $_POST['voter'] : '';
$candidate = isset($_POST['candidate']) ? $_POST['candidate'] : '';
$rate = isset($_POST['rate']) ? $_POST['rate'] : '';

if (! is_numeric($voter) || ! is_numeric($candidate) || ! is_numeric($rate)) {
    if ($config['debug']) error_log("Hacking attempt \n", 3, VSHARE_DIR . '/templates_c/log_ajax_user_rate.txt');
    Ajax::returnJson('Hacking attempt', 'error');
    exit(0);
}

$sql = "SELECT count(*) AS `total` FROM `uservote` WHERE
       `candate_id`=" . (int) $candidate . " AND
       `voter_id`=" . (int) $voter;
$user_already_voted = DB::getTotal($sql);

if (! $user_already_voted) {
    $sql = "INSERT INTO `uservote` SET
           `candate_id`='" . (int) $candidate . "',
           `voter_id`='" . (int) $voter . "',
           `vote`='" . (int) $rate . "'";
    DB::query($sql);
    if ($config['debug']) error_log("$lang[rated] \n", 3, VSHARE_DIR . '/templates_c/log_ajax_user_rate.txt');
    Ajax::returnJson($lang['rated'], 'success');
} else {
    if ($config['debug']) error_log("$lang[already_rated] \n", 3, VSHARE_DIR . '/templates_c/log_ajax_user_rate.txt');
    Ajax::returnJson($lang['already_rated'], 'success');
}
