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

User::is_logged_in();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT `friend_friend_id` FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `friend_status`='Confirmed'";
$friends_all = DB::fetch($sql);

if ($friends_all) {

    foreach ($friends_all as $friend) {
        $friends[] = $friend['friend_friend_id'];
    }

    $my_friends = implode(',', $friends);

    if (isset($_REQUEST['type']) && $_REQUEST['type'] != "private") {
        $_REQUEST['type'] = 'public';
    }

    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_user_id` IN (" . DB::quote($my_friends) . ")";
    $total = DB::getTotal($sql);

    $start_from = ($page - 1) * $config['items_per_page'];

    $page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

    $sql = "SELECT * FROM `videos` WHERE
           `video_user_id` IN (" . DB::quote($my_friends) . ")
            ORDER BY `video_add_time` DESC
            LIMIT $start_from, $config[items_per_page]";
    $videos_all = DB::fetch($sql);

    $video_keywords_all = '';

    foreach ($videos_all as $videoRow) {
        $videoRow['video_thumb_url'] = $servers[$videoRow['video_thumb_server_id']];
        $videoRow['video_keywords_array'] = explode(' ', $videoRow['video_keywords']);
        $video_keywords_all .= $videoRow['video_keywords'] . ' ';
        $videoRows[] = $videoRow;
    }

    $view = array();
    $video_keywords_array_all = explode(' ', $video_keywords_all);
    $view['video_keywords_array_all'] = array_remove_duplicate($video_keywords_array_all);

    $start_num = $start_from + 1;
    $end_num = $start_from + count($videoRows);
    $smarty->assign('view', $view);
    $smarty->assign('start_num', $start_num);
    $smarty->assign('end_num', $end_num);
    $smarty->assign('total', $total);
    $smarty->assign('page_links', $page_links);
    $smarty->assign('videoRows', $videoRows);
    $smarty->assign('page', $page);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_friends.tpl');
$smarty->display('header.tpl');
$smarty->display('user_friends_videos.tpl');
$smarty->display('footer.tpl');
DB::close();
