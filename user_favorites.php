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
require 'include/language/' . LANG . '/lang_user_favorites.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$user_info = User::getByName($_GET['user_name']);

if (! $user_info) {
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$smarty->assign('user_name', $user_info['user_name']);

if (isset($_POST['removfavour']) && is_numeric($_POST['rvid'])) {
    $sql = "DELETE FROM `favourite` WHERE
           `favourite_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `favourite_video_id`='" . (int) $_POST['rvid'] . "'";
    DB::query($sql);
}

$sql = "SELECT count(*) AS `total` FROM
       `videos` AS `v`,
       `favourite` AS `f` WHERE
        f.favourite_user_id='" . (int) $user_info['user_id'] . "' AND
        f.favourite_video_id=v.video_id";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM
       `videos` AS `v`,
       `favourite` AS `f` WHERE
        f.favourite_user_id='" . (int) $user_info['user_id'] . "' AND
        f.favourite_video_id=v.video_id
        ORDER BY v.video_add_time DESC
        LIMIT $start_from, $config[items_per_page]";
$result = DB::fetch($sql);
$results_on_this_page = count($result);

$video_keywords_all = '';
$favorite_videos = array();

foreach ($result as $favorite_video) {
    $favorite_video['video_thumb_url'] = $servers[$favorite_video['video_thumb_server_id']];
    $favorite_video['video_keywords_array'] = explode(' ', $favorite_video['video_keywords']);
    $video_keywords_all .= $favorite_video['video_keywords'] . ' ';
    $favorite_videos[] = $favorite_video;
}

$view = array();
$video_keywords_all = explode(' ', $video_keywords_all);
$view['video_keywords_all_array'] = array_remove_duplicate($video_keywords_all);

$start_num = $start_from + 1;
$end_num = $start_from + $results_on_this_page;
$page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

$allow_playlist = $user_info['user_playlist_public'];
$allow_favorite = $user_info['user_favourite_public'];

if (isset($_SESSION['UID'])) {
    if ($_SESSION['UID'] == $user_info['user_id']) {
        $allow_playlist = $allow_favorite = 1;
    }
}

$smarty->assign('allow_playlist', $allow_playlist);
$smarty->assign('allow_favorite', $allow_favorite);
$smarty->assign('view', $view);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('favVideos', $favorite_videos);
$smarty->assign('user_info', $user_info);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_favorites.tpl');
$smarty->display('footer.tpl');
DB::close();
