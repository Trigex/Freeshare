<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_user_comment_delete.php';

$ajax_debug = 0;

$comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : '';
if ($ajax_debug) error_log("$comment_id \n",3, VSHARE_DIR . '/ajax/log.txt');

if (!is_numeric($comment_id)) {
	$err =  $lang['comment_id_invalid'];
} else if (!isset($_SESSION['UID'])) {
	$err = $lang['guest_user'];
}

if (!empty($err)) {
    if ($ajax_debug) error_log("ERROR: $err \n",3, VSHARE_DIR . '/ajax/log.txt');
    Ajax::returnJson($err,'error');
	exit(0);
}

$sql = "DELETE FROM `profile_comments` WHERE
       `profile_comment_id`=" . (int) $comment_id . " AND
       `profile_comment_user_id`='" . (int) $_SESSION['UID'] . "'";
DB::query($sql);

if ($ajax_debug) error_log("SQL EXECUTED: $sql \n",3, VSHARE_DIR . '/ajax/log.txt');

if (DB::affectedRows() >= 1) {
	$msg = $comment_id;
}

Ajax::returnJson($comment_id,'success');
