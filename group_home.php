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

require 'include/config.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$group_url = htmlspecialchars_uni($_GET['group_url']);

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($group_url) . "'";
$group_info = DB::fetch1($sql);

if (! $group_info) {
    Http::redirect(VSHARE_URL);
}

if (isset($_SESSION['UID']) && $group_info['group_owner_id'] == $_SESSION['UID']) {
    $flag = 'self';
} else {
    $flag = 'guest';
}

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($_GET['group_url']) . "'";
$group_info = DB::fetch1($sql);

if ($group_info) {
    if (isset($_SESSION['UID']) && $_SESSION['UID'] == $group_info['group_owner_id']) {
        $sql = "SELECT count(*) AS `total` FROM
               `group_topics` WHERE
               `group_topic_group_id`='" . (int) $group_info['group_id'] . "'";
    } else {
        $sql = "SELECT count(*) AS `total` FROM
               `group_topics` WHERE
               `group_topic_group_id`=" . (int) $group_info['group_id'] . " AND
               `group_topic_approved`='yes'";
    }
    $total = DB::getTotal($sql);
    $tpage = ceil($total / $config['items_per_page']);

    if ($tpage == 0) {
        $spage = $tpage + 1;
    } else {
        $spage = $tpage;
    }

    $start_from = ($page - 1) * $config['items_per_page'];

    if (isset($_SESSION['UID']) && $_SESSION['UID'] == $group_info['group_owner_id']) {
        $sql = "SELECT * FROM `group_topics` WHERE
               `group_topic_group_id`=" . (int) $group_info['group_id'] . "
                ORDER BY `group_topic_id` DESC
                LIMIT $start_from, $config[items_per_page]";
    } else {
        $sql = "SELECT * FROM `group_topics` WHERE
               `group_topic_group_id`=" . (int) $group_info['group_id'] . " AND
               `group_topic_approved`='yes'
                ORDER BY `group_topic_id` DESC
                LIMIT $start_from, $config[items_per_page]";
    }

    $tarry = DB::fetch($sql);
    $smarty->assign('grptps', $tarry);

    $start_num = $start_from + 1;
    $end_num = $start_from + count($tarry);

    $page_link = '';

    for ($k = 1; $k <= $tpage; $k ++) {
        if ($page != $k) {
            $page_link .= '<a class="pagination" href="' . VSHARE_URL . '/group/' . $group_url . '/?page=' . $k . '">' . $k . '</a>';
        } else {
            $page_link .= "<span class=pagination>$k</span>";
        }
    }

    $smarty->assign('start_num', $start_num);
    $smarty->assign('end_num', $end_num);
    $smarty->assign('page_link', $page_link);
}

# fetch recent videos from current group
$sql = "SELECT * FROM `group_videos` WHERE
       `group_video_group_id`=" . (int) $group_info['group_id'] . " AND
       `group_video_approved`='yes'
        ORDER BY `AID` DESC
        LIMIT 0, 4";
$grp_videos = DB::fetch($sql);
$group_videos = array();
foreach ($grp_videos as $tmp) {
    if (isset($tmp['group_video_video_id'])) {
        $sql = "SELECT * FROM `videos` WHERE
    	       `video_id`=" . $tmp['group_video_video_id'];
        $video_row = DB::fetch1($sql);
        $video_row['video_thumb_url'] = $servers[$video_row['video_thumb_server_id']];
    }

    $group_videos[] = $video_row;
}

$smarty->assign('group_videos', $group_videos);

$sql = "SELECT count(*) AS `total` FROM `group_videos` WHERE
       `group_video_approved`='no' AND
       `group_video_group_id`='" . (int) $group_info['group_id'] . "'";
$total_new_video = DB::getTotal($sql);
$smarty->assign('total_new_video', $total_new_video + 0);

$sql = "SELECT count(*) AS `total` FROM `group_members` WHERE
       `group_member_approved`='no' AND
       `group_member_group_id`='" . (int) $group_info['group_id'] . "'";
$total_new_member = DB::getTotal($sql);
$smarty->assign('total_new_member', $total_new_member + 0);

# fetch recent members from current group
$sql = "SELECT * FROM `group_members` WHERE
       `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
       `group_member_approved`='yes'
        ORDER BY `AID` DESC
        LIMIT 0, 4";
$group_members = DB::fetch($sql);

foreach ($group_members as $row) {
    $group_member_array[] = $row['group_member_user_id'];
}

if ($group_member_array[0] != '') {
    $group_member_list = implode(',', $group_member_array);
    $sql = "SELECT * FROM `users` WHERE
           `user_id` IN ($group_member_list)";
    $group_members = DB::fetch($sql);
    $smarty->assign('group_members', $group_members);
}

if (isset($_SESSION['UID'])) {
    $sql = "SELECT `video_id`, `video_title` FROM `videos` WHERE
           `video_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `video_active`='1' AND
           `video_approve`='1' AND
           `video_type`='public'
            ORDER BY `video_id` DESC";
    $videos = DB::fetch($sql);
    $video_ops = '<option value="" selected="selected">- Your Videos -</option>';

    foreach ($videos as $tmp) {
        $video_ops .= '<option value=' . $tmp['video_id'] . '>' . $tmp['video_title'] . '</option>';
    }

    $smarty->assign('video_ops', $video_ops);

    $sql = "SELECT * FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
    $mem_info = DB::fetch1($sql);
    $is_member = $mem_info['group_member_approved'];

} else {
    $is_member = 'guest';
}

$show_group = 0;

if ($group_info['group_type'] == 'public') {
    $show_group = 1;
} else if ($group_info['group_type'] == 'private' || $flag == 'self') {
    $show_group = 1;
} else {
    $show_group = 1;
}

$smarty->assign('show_group', $show_group);
$smarty->assign('html_title', $group_info['group_name']);
$smarty->assign('html_keywords', $group_info['group_keyword']);
$smarty->assign('html_description', $group_info['group_description']);

$add = base64_encode("&urlkey=$group_url");

$smarty->assign('is_member', $is_member);
$smarty->assign('add', $add);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('group_info', $group_info);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');
$smarty->display('group_home.tpl');
$smarty->assign('html_extra', $smarty->fetch('group_home_js.tpl'));
$smarty->display('footer.tpl');
DB::close();
