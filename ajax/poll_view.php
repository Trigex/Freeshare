<?php

require '../include/config.php';

$id = $_GET['pollid'];

if (! is_numeric($id))
{
    Ajax::returnJson('Hacking attempt.', 'error');
    exit(0);
}

$poll_info = Poll::display($id);

$smarty->assign('poll_info', $poll_info);
$fetch_view_vote = $smarty->fetch('view_vote.tpl');
Ajax::returnJson($fetch_view_vote, 'success');
DB::close();
