<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_group_topics.php';

$ajax_debug = 0;

if (! isset($_SESSION['UID'])) {
    $err = 'Please Login to post new topic';
    if ($ajax_debug) error_log("$err \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
    Ajax::returnJson($err, 'error');
    exit();
}

$video_insert = 1;

if (isset($_POST['add_topic'])) {
    $group_id = isset($_POST['group_id']) ? (int) $_POST['group_id'] : 0;
    $topic_video = isset($_POST['topic_video']) ? (int) $_POST['topic_video'] : '';
    $topic_title = isset($_POST['topic_title']) ? $_POST['topic_title'] : '';
    $topic_title = htmlspecialchars_uni($topic_title);

    $sql = "SELECT * FROM
           `groups` AS `gs`,
           `group_members` AS `gm` WHERE
            gs.group_id='" . (int) $group_id . "' AND
            gm.group_member_user_id='" . (int) $_SESSION['UID'] . "' AND
            gm.group_member_approved='yes'";
    $groups_info = DB::fetch1($sql);

    if ($groups_info) {
        if (mb_strlen($topic_title, 'UTF-8') > 4) {
            if ($_SESSION['UID'] == $group_info['group_owner_id']) {
                $approved = 'yes';
            } else if ($group_info['group_posting'] == 'owner_only') {
                $err = $lang['topic_add_owner_only'];
                if ($ajax_debug) error_log("$err \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
                Ajax::returnJson($err, 'error');
                exit();
            } else if ($group_info['group_posting'] == 'owner_approve') {
                $approved = 'no';
            } else {
                $approved = 'yes';
            }

            if ($topic_video < 1) {
                $topic_video = '';
            }

            $sql = "INSERT INTO `group_topics` SET
                   `group_topic_group_id`='" . (int) $group_id . "',
                   `group_topic_user_id`='" . (int) $_SESSION['UID'] . "',
                   `group_topic_add_time`='" . date("Y-m-d H:i:s") . "',
                   `group_topic_title`='" . DB::quote($topic_title) . "',
                   `group_topic_video_id`='$topic_video',
                   `group_topic_approved`='$approved'";

            DB::query($sql);

            if ($topic_video != '') {
                if ($_SESSION['UID'] == $group_info['group_owner_id']) {
                    $video_approved = 'yes';
                } else if ($group_info['group_upload'] == 'owner_approve') {
                    $video_approved = 'no';
                } else if ($group_info['group_upload'] == 'owner_only' && $_SESSION['UID'] != $group_info['group_owner_id']) {
                    $video_insert = 0;
                } else {
                    $video_approved = 'yes';
                }

                if ($video_insert == 1) {
                    $sql = "SELECT * FROM `group_videos` WHERE
                           `group_video_group_id`='" . (int) $group_id . "' AND
                           `group_video_video_id`='$topic_video'";
                    $group_videos = DB::fetch($sql);

                    if (! $group_videos) {
                        $sql = "INSERT INTO `group_videos` SET
                               `group_video_group_id`='" . (int) $group_id . "',
                               `group_video_video_id`='$topic_video',
                               `group_video_member_id`='" . (int) $_SESSION['UID'] . "',
                               `group_video_approved`='$video_approved'";
                        DB::query($sql);
                    }
                }
            }

            if ($approved == 'yes') {
                $msg = $lang['topic_add_success'];
                if ($ajax_debug) error_log("$msg \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
                Ajax::returnJson($msg, 'success');
                exit();
            } else {
                $msg = $lang['topic_approval_required'];
                if ($ajax_debug) error_log("$msg \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
                Ajax::returnJson($msg, 'success');
                exit();
            }
        } else {
            $err = $lang['topic_add_security_error'];
            if ($ajax_debug) error_log("$err \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
            Ajax::returnJson($err, 'error');
            DB::close();
            exit();
        }
    } else {
        $err = $lang['topic_add_security_error'];
        if ($ajax_debug) error_log("$err \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
        Ajax::returnJson($err, 'error');
        DB::close();
        exit();
    }
}
