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
require 'include/language/' . LANG . '/lang_video_response.php';

$video_id = isset($_GET['video_id']) ? $_GET['video_id'] : '';

if (! is_numeric($video_id)) {
    Http::redirect(VSHARE_URL);
}

Cache::init();

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_POST['remove_video'])) {
    User::is_logged_in();

    if (is_numeric($_POST['response_video_id'])) {
        $sql = "DELETE FROM `video_responses` WHERE
               `video_response_video_id`='" . (int) $_POST['response_video_id'] . "' AND
               `video_response_to_video_id`='" . (int) $video_id . "'";
        DB::query($sql);

        set_message($lang['video_removed'], 'success');

        $redirect_url = VSHARE_URL . '/response/' . $video_id . '/videos/' . $page;
        Http::redirect($redirect_url);
    }
}

$cache_id = 'video_response' . $video_id . $page;

$view = Cache::load($cache_id);

if (! $view) {

    $view = array();

    $video_info = Video::getById($video_id);
    $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
    $view['video_info'] = $video_info;

    $sql = "SELECT count(*) AS `total` FROM `video_responses` WHERE
           `video_response_to_video_id`='" . (int) $video_id . "' AND
           `video_response_active`='1'";
    $view['total'] = DB::getTotal($sql);

    $start_from = ($page - 1) * $config['num_watch_videos'];

    $sql = "SELECT v.* FROM `video_responses` AS `vr`,`videos` AS `v` WHERE
            vr.video_response_to_video_id='" . (int) $video_id . "' AND
            vr.video_response_active='1' AND
            vr.video_response_video_id=v.video_id
            ORDER BY vr.video_response_add_time DESC
            LIMIT $start_from, $config[num_watch_videos]";
    $videos_all = DB::fetch($sql);
    $video_count = count($videos_all);
    $videos = array();

    foreach ($videos_all as $video) {
        $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
        $videos[] = $video;
    }

    $view['start_num'] = $start_from + 1;
    $view['end_num'] = $start_from + $video_count;
    $view['page'] = $page;
    $view['page_links'] = Paginate::getLinks($view['total'], $config['num_watch_videos'], '.', '', $page);
    $view['videos'] = $videos;
}

$smarty->assign('view', $view);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('video_responses.tpl');
$smarty->display('footer.tpl');
DB::close();
