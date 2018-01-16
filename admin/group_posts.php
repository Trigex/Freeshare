<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: 3.2
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'admin_config.php';
require '../include/config.php';
require '../include/language/' . LANG . '/admin/group_posts.php';

Admin::auth();

$TID = $_GET['TID'];
$gid = $_GET['gid'];

$sql = "SELECT `group_name` FROM `groups` WHERE
       `group_id`='" . (int) $gid . "'";
$tmp = DB::fetch1($sql);
$smarty->assign('group_name', $tmp['group_name']);

if (isset($_POST['update'])) {
    if ($_POST['title'] == '') {
        $err = $lang['title_null'];
    } else {
        $sql = "UPDATE `group_topics` SET
               `group_topic_title`='" . DB::quote($_POST['title']) . "',
               `group_topic_approved`='" . DB::quote($_POST['approved']) . "' WHERE
               `group_topic_id`=" . (int) $TID;
        DB::query($sql);
        $redirect_url = VSHARE_URL . '/admin/group_posts.php?gid=' . $gid . '&TID=' . $TID;
        Http::redirect($redirect_url);
    }
}

if (isset($_POST['pupdate'])) {
    if ($_POST['post'] == '') {
        $err = $lang['post_null'];
    } else {
        $sql = "UPDATE `group_topic_posts` SET
               `group_topic_post_description`='" . DB::quote($_POST['post']) . "' WHERE
               `group_topic_post_id`=" . (int) $_GET['PID'];
        DB::query($sql);
        $redirect_url = VSHARE_URL . '/admin/group_posts.php?gid=' . $gid . '&TID=' . $TID;
        Http::redirect($redirect_url);
    }
}

if ((isset($_GET['action']) && $_GET['action'] == 'pdel') && (isset($_GET['PID']) && $_GET['PID'] != '')) {
    $sql = "DELETE FROM `group_topic_posts` WHERE
           `group_topic_post_id`='" . (int) $_GET['PID'] . "'";
    DB::query($sql);
    $redirect_url = VSHARE_URL . '/admin/group_posts.php?gid=' . $gid . '&TID=' . $TID;
    Http::redirect($redirect_url);
}

$sql = "SELECT * FROM `group_topics` WHERE
       `group_topic_id`='" . (int) $TID . "'";
$topic = DB::fetch1($sql);

if ($topic['group_topic_video_id'] != 0) {
    $sql = "SELECT video_folder,video_thumb_server_id FROM `videos` WHERE
			`video_id`=" . $topic['group_topic_video_id'];
    $tmp = DB::fetch1($sql);
    $topic['video_thumb_url'] = $servers[$tmp['video_thumb_server_id']];
    $topic['video_folder'] = $tmp['video_folder'];
}

$smarty->assign('topic', $topic);

$sql = "SELECT * FROM `group_topic_posts` WHERE
       `group_topic_post_topic_id`='" . (int) $TID . "'
        ORDER BY `group_topic_post_id` ASC";
$group_posts = DB::fetch($sql);

$posts = array();

foreach ($group_posts as $tmp) {
    if ($tmp['group_topic_post_video_id'] != 0) {
        $sql = "SELECT video_folder,video_thumb_server_id FROM `videos` WHERE
				`video_id`=" . $tmp['group_topic_post_video_id'];
        $tmp_1 = DB::fetch1($sql);
        $tmp['video_thumb_url'] = $servers[$tmp_1['video_thumb_server_id']];
        $tmp['video_folder'] = $tmp_1['video_folder'];
    }

    $posts[] = $tmp;
}

$smarty->assign('post', $posts);
$smarty->assign('total_post', count($posts));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_posts.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
