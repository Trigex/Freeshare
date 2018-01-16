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
require 'include/language/' . LANG . '/lang_playlist.php';

$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$user_name = trim($user_name);

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$user_info = User::getByName($user_name);

if (! $user_info) {
    Http::redirect(VSHARE_URL);
}

if (isset($_POST['create_playlist'])) {

    User::is_logged_in();

    $playlist_name = trim($_POST['playlist_name']);

    if (! empty($playlist_name)) {

       $sql = "SELECT * FROM `playlists` WHERE
              `playlist_user_id`='" . (int) $_SESSION['UID'] . "' AND
              `playlist_name`='" . DB::quote($playlist_name) . "'";
       $playlist = DB::fetch1($sql);

       if (! $playlist) {
           $sql = "INSERT INTO `playlists` SET
                  `playlist_user_id`='" . (int) $_SESSION['UID'] . "',
                  `playlist_name`='" . DB::quote($playlist_name) . "',
                  `playlist_add_date`='" . (int) time() . "'";
           DB::query($sql);
       } else {
           $err = $lang['playlist_duplicate'];
       }

       $_GET['playlist_id'] = $playlist_name;
    }
}

$html_playlist_name = '';

$sql = "SELECT * FROM `playlists` WHERE
       `playlist_user_id`='" . (int) $user_info['user_id'] . "'
        ORDER BY `playlist_id` ASC";
$playlists = DB::fetch($sql);

if ($playlists) {

    $smarty->assign('playlists', $playlists);

    $_GET['playlist_id'] = isset($_GET['playlist_id']) ? trim($_GET['playlist_id']) : $playlists[0]['playlist_name'];

    $sql = "SELECT * FROM `playlists` WHERE
           `playlist_user_id`='" . (int) $user_info['user_id'] . "' AND
           `playlist_name`='" . DB::quote($_GET['playlist_id']) . "'";
    $playlist_info = DB::fetch1($sql);

    if ($playlist_info) {

        $smarty->assign('playlist_info', $playlist_info);
        $html_playlist_name = $playlist_info['playlist_name'] . ' - ';

        $sql = "SELECT count(*) AS `total` FROM
               `videos` AS `v`, `playlists` AS `pl`, `playlists_videos` AS `pv` WHERE
                pl.playlist_user_id='" . (int) $user_info['user_id'] . "' AND
                pl.playlist_id='" . (int) $playlist_info['playlist_id'] . "' AND
                pl.playlist_id=pv.playlists_videos_playlist_id AND
                pv.playlists_videos_video_id=v.video_id";
        $total = DB::getTotal($sql);

        $start_from = ($page - 1) * $config['items_per_page'];

        $sql = "SELECT * FROM
               `videos` AS `v`, `playlists` AS `pl`, `playlists_videos` AS `pv` WHERE
                pl.playlist_user_id='" . (int) $user_info['user_id'] . "' AND
                pl.playlist_id='" . (int) $playlist_info['playlist_id'] . "' AND
                pl.playlist_id=pv.playlists_videos_playlist_id AND
                pv.playlists_videos_video_id=v.video_id
                ORDER BY v.video_add_time DESC
                LIMIT $start_from, $config[items_per_page]";
        $videos = DB::fetch($sql);
        $results_on_this_page = count($videos);
        $video_keywords_all = '';
        $video_info = array();

        foreach ($videos as $video) {
            $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
            $video['video_keywords_array'] = preg_split('[ ]', $video['video_keywords']);
            $video_keywords_all .= $video['video_keywords'] . ' ';
            $video_info[] = $video;
        }

        $start_num = $start_from + 1;
        $end_num = $start_from + $results_on_this_page;
        $page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

        $smarty->assign('start_num', $start_num);
        $smarty->assign('end_num', $end_num);
        $smarty->assign('page_links', $page_links);
        $smarty->assign('total', $total);
        $smarty->assign('videos', $video_info);
    }
}

$allow_playlist = $user_info['user_playlist_public'];
$allow_favorite = $user_info['user_favourite_public'];

if (isset($_SESSION['UID'])) {
    if ($_SESSION['UID'] == $user_info['user_id']) {
        $allow_playlist = $allow_favorite = 1;
    }
}

$smarty->assign('allow_playlist', $allow_playlist);
$smarty->assign('allow_favorite', $allow_favorite);

$html_title = "$html_playlist_name $user_info[user_name]'s playlists - page $page";

$smarty->assign('html_title', $html_title);
$smarty->assign('html_description', '');
$smarty->assign('html_keywords', '');
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('user_info', $user_info);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_playlist.tpl');
$smarty->display('footer.tpl');
DB::close();
