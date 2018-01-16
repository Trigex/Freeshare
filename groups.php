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

$category = '';

if (isset($_GET['chid']) && is_numeric($_GET['chid'])) {
    $sql = "SELECT * FROM `channels` WHERE
           `channel_id`='" . (int) $_GET['chid'] . "'";
    $tmp = DB::fetch1($sql);
    $category_tpl = htmlspecialchars_uni($tmp['channel_name']);
} else {
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
    } else {
        $redirect_url = VSHARE_URL . '/groups/featured/1';
        Http::redirect($redirect_url);
    }
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_GET['chid']) && is_numeric($_GET['chid'])) {
    $sql = "SELECT count(*) AS `total` FROM `groups` WHERE
           `group_channels` LIKE '%|" . (int) $_GET['chid'] . "|%'";
    $rows = '';
} else {

    if ($category == 'featured') {
        $sql = "SELECT count(*) AS `total` FROM `groups` WHERE
               `group_featured`='yes'";
        $rows = 0;
        $category_tpl = 'Featured';
    } else if ($category == 'recent') {
        $sql = "SELECT count(*) AS `total` FROM `groups`";
        $rows = 0;
        $category_tpl = 'Most Recent';
    } else if ($category == 'members') {
        $sql = "SELECT DISTINCT count(*) AS `total`,`group_member_user_id` FROM
               `group_members` AS gm,
               `groups` AS g WHERE
                gm.group_member_group_id=g.group_id
                GROUP BY gm.group_member_group_id";
        $rows = 1;
        $category_tpl = 'Most Members';
    } else if ($category == 'videos') {
        $sql = "SELECT DISTINCT *,count(group_video_video_id) AS `total` FROM
               `group_videos` AS gv,
               `groups` AS g WHERE
                gv.group_video_group_id=g.group_id
                GROUP BY gv.group_video_group_id
                ORDER BY `total` DESC";
        $rows = 1;
        $category_tpl = 'Most Videos';
    } else {
        $sql = "SELECT DISTINCT *,count(gt.group_topic_group_id) AS `total` FROM
               `group_topics` AS gt,
               `groups` AS g WHERE
                gt.group_topic_group_id=g.group_id
                GROUP BY gt.group_topic_group_id
                ORDER BY `total` DESC";
        $rows = 1;
        $category_tpl = 'Most Topics';
    }
}

if ($rows == 0) {
    $tmp = DB::fetch1($sql);
    $total = $tmp['total'];
} else if ($rows == 1) {
    $tmp = DB::fetch($sql);
    $total = count($tmp);
}

$start_from = ($page - 1) * $config['items_per_page'];

if (isset($_GET['chid']) && is_numeric($_GET['chid'])) {
    $sql = "SELECT * FROM `groups` WHERE
           `group_channels` LIKE '%|" . (int) $_GET['chid'] . "|%'
            LIMIT $start_from, $config[items_per_page]";
} else {
    if ($category == 'featured') {
        $sql = "SELECT * FROM `groups` WHERE
               `group_featured`='yes'
                LIMIT $start_from, $config[items_per_page]";
    } else if ($category == 'recent') {
        $sql = "SELECT * FROM `groups`
                ORDER BY `group_create_time` DESC
                LIMIT $start_from, $config[items_per_page]";
    } else if ($category == 'members') {
        $sql = "SELECT DISTINCT *,count(gm.group_member_user_id) AS `total` FROM
               `group_members` AS gm,
               `groups` AS g WHERE
                gm.group_member_group_id=g.group_id
                GROUP BY gm.group_member_group_id
                ORDER BY `total` DESC
                LIMIT $start_from, $config[items_per_page]";
    } else if ($category == 'videos') {
        $sql = "SELECT DISTINCT *,count(gv.group_video_video_id) AS `total` FROM
               `group_videos` AS gv,
               `groups` AS g WHERE
                gv.group_video_group_id=g.group_id
                GROUP BY gv.group_video_group_id
                ORDER BY `total` DESC
                LIMIT $start_from, $config[items_per_page]";
    } else {
        $sql = "SELECT DISTINCT *,count(gt.group_topic_group_id) AS `total` FROM
               `group_topics` AS gt,
               `groups` AS g WHERE
                gt.group_topic_group_id=g.group_id
                GROUP BY gt.group_topic_group_id
                ORDER BY `total` DESC
                LIMIT $start_from, $config[items_per_page]";
    }
}

$group_info = DB::fetch($sql);

if (count($group_info) == 0 && $category == 'featured') {
    $sql = "SELECT * FROM `groups` LIMIT 4";
    $group_info = DB::fetch($sql);
    $total = count($group_info);
}

$start_num = $start_from + 1;
$end_num = $start_from + count($group_info);

$page_link = Paginate::getLinks2($total, $config['items_per_page'], '.', '', $page);

$channels = Channel::get();

$html_title = "$category_tpl Groups - page $page";

$smarty->assign(array(
    'html_title' => $html_title,
    'html_description' => $html_title,
    'html_keywords' => $html_title
));

$smarty->assign('channels', $channels);
$smarty->assign('category', $category_tpl);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_link);
$smarty->assign('total', $total);
$smarty->assign('group_info', $group_info);
$smarty->assign('sub_menu', 'menu_groups.tpl');
$smarty->display('header.tpl');
$smarty->display('groups.tpl');
$smarty->display('footer.tpl');
DB::close();
