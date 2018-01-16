<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_vote_add.php';

$answer = $_POST['value'];
$id = $_POST['poll_id'];

if (! is_numeric($id)) {
    $err = $lang['id_invalid'];
} else if (! isset($_SESSION['UID'])) {
    $err = $lang['guest'];
}

if (! empty($err)) {
    Ajax::returnJson($err, 'error');
    exit(0);
}

$today = date('Y-m-d');
$user_ip = User::get_ip();

if ($config['user_poll'] == "Once") {
    $sql = "SELECT COUNT(*) AS `total` FROM `poll_results` WHERE
           `poll_result_vote_id`='" . (int) $id . "' AND
           `poll_result_voter_id`='" . (int) $_SESSION['UID'] . "'";
    $total = DB::getTotal($sql);
    if ($total > 0) {
        Ajax::returnJson($lang['already_voted'], 'error');
        exit();
    }
}

$sql = "INSERT INTO `poll_results` SET
       `poll_result_vote_id`='" . (int) $id . "',
       `poll_result_voter_id`='" . (int) $_SESSION['UID'] . "',
       `poll_result_answer`='" . DB::quote($answer) . "',
       `poll_result_client_ip`='" . DB::quote($user_ip) . "',
       `poll_result_date`='" . DB::quote($today) . "'";
DB::query($sql);

if (DB::affectedRows() > 0) {
    $poll_info = Poll::display($id);
    $smarty->assign('poll_info', $poll_info);
    $fetch_view_vote = $smarty->fetch('view_vote.tpl');
    Ajax::returnJson($fetch_view_vote, 'success');
}

DB::close();
