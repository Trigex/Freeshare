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

if (filesize('include/config.php') < 100)
{
	Header('Location: ./install/install.php');
	exit;
}

require 'include/config.php';

Cache::init();

$sql_adult_filter = '';

if (getFamilyFilter()) {
	$sql_adult_filter = "AND `video_adult`='0'";
}

$mydate = date('Y-m-d');

$sql = "SELECT * FROM `poll_question` WHERE
       `start_date`<='$mydate' AND
       `end_date`>='$mydate'
        ORDER BY rand()
        LIMIT 1";
$poll = DB::fetch1($sql);

if ($poll) {
    $poll_answer = explode("|", $poll['poll_answer']);
    $smarty->assign('poll_id', $poll['poll_id']);
    $smarty->assign('poll_question', $poll['poll_qty']);
    $smarty->assign('list', $poll_answer);

    $pollingpanel = 'Enable';
    $smarty->assign('pollinganel', $pollingpanel);
}

$cache_id = 'home_page';
$view = Cache::load($cache_id);

if (! $view) {
    $view = array();

    # featured videos
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1' AND
           `video_featured`='yes'
            $sql_adult_filter
            ORDER BY `video_add_time` DESC";
    $videos = DB::fetch($sql);


    if (! $videos) {
        $sql = "SELECT * FROM `videos` WHERE
               `video_type`='public' AND
               `video_active`='1' AND
               `video_approve`='1'
                $sql_adult_filter
                LIMIT 4";
        $videos = DB::fetch($sql);
    }

    $featured_videos = array();

    foreach ($videos as $featured_video) {
        $featured_video['video_thumb_url'] = $servers[$featured_video['video_thumb_server_id']];
        $featured_video['video_keywords_array'] = explode(' ', $featured_video['video_keywords']);
        $featured_videos[] = $featured_video;
    }

    if (count($featured_videos) > 0) {
        $smarty->assign('featured_videos', $featured_videos);
        $view['featured_video_block'] = $smarty->fetch('index_featured_videos.tpl');
    } else {
        $view['featured_video_block'] = '';
    }

    # recent videos

    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $sql_adult_filter ORDER BY
           `video_view_number` DESC,
           `video_com_num` DESC,
           `video_rated_by` DESC
            LIMIT 0, $config[recently_viewed_video]";
    $videos = DB::fetch($sql);

    $recent_videos = array();

    foreach ($videos as $recent_video) {
        $recent_video['video_thumb_url'] = $servers[$recent_video['video_thumb_server_id']];
        $recent_videos[] = $recent_video;
    }

    $view['recent_videos'] = $recent_videos;
    $view['recent_total'] = count($recent_videos);

    # new videos

    $sql = "SELECT * FROM `videos` WHERE
           `video_active`='1' AND
           `video_approve`='1' AND
           `video_type`='public'
            $sql_adult_filter
            ORDER BY `video_id` DESC
            LIMIT $config[num_new_videos]";
    $videos = DB::fetch($sql);

    $new_videos = array();

    foreach ($videos as $new_video) {
        $new_video['video_thumb_url'] = $servers[$new_video['video_thumb_server_id']];
        $new_videos[] = $new_video;
    }

    $view['home_tags'] = insert_tags();
    $view['new_videos'] = $new_videos;
    $view['new_video_total'] = count($new_videos);
    Cache::save($cache_id, $view);
}

$smarty->assign('html_keywords', '');
$smarty->assign('html_description', '');
$smarty->assign('view', $view);
$smarty->assign('html_extra', $smarty->fetch('index_js.tpl'));
$smarty->assign('num_last_users_online', Config::get('num_last_users_online'));
$smarty->assign('home_num_tags', Config::get('home_num_tags'));
$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('header.tpl');
$smarty->display('index.tpl');
$smarty->display('footer.tpl');
DB::close();
