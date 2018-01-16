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
require 'include/language/' . LANG . '/lang_view_video.php';

$video_id = $_GET['id'];

Cache::init();

if (! is_numeric($video_id)) {
    Http::redirect(VSHARE_URL);
}

$video_info = Video::getById($video_id);

if (! $video_info || $video_info['video_user_id'] == 0) {
    set_message($lang['video_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
} else {
    $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
}

if ($video_info['video_adult']) {
	if (getFamilyFilter()) {
		$redirect_url = VSHARE_URL . '/family_filter/';
		Http::redirect($redirect_url);
	}
}

if ($config['guest_limit'] > 36000) {
    $config['guest_limit'] = 0;
}

if (! isset($_SESSION['UID']) && $err == '' && $config['guest_limit'] != 0) {
    if (isset($_COOKIE['video_watch_duration'])) {
        $video_watch_duration = $_COOKIE['video_watch_duration'] + $video_info['video_duration'];
    } else {
        $video_watch_duration = $video_info['video_duration'];
    }
    /*
     * 43200 for 12 hours 60 * 60 * 12
     */
    setcookie('video_watch_duration', $video_watch_duration, time() + 43200);

    if ($video_watch_duration > $config['guest_limit']) {
        $next = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $_SESSION['REDIRECT'] = $next;
        Http::redirect(VSHARE_URL . '/signup/');
    }
}

if ($err == '') {
    if ($video_info['video_type'] == 'private') {
        if (isset($_SESSION['UID']) && is_numeric($_SESSION['UID'])) {
            if ($video_info['video_user_id'] == $_SESSION['UID']) {
                $show_video = 1;
            } else {
                $sql = "SELECT count(*) AS `total` FROM `friends` WHERE
                       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
                       `friend_friend_id`='" . (int) $video_info['video_user_id'] . "' AND
                       `friend_status`='Confirmed'";
                $is_friend = DB::getTotal($sql);

                if ($is_friend) {
                    $show_video = 1;
                } else {
                    $msg = $lang['friends_only'];
                }
            }
        } else {
            $show_video = 0;
            $_SESSION['REDIRECT'] = VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/';
            if (Config::get('signup_enable')) {
                $redirect_url = $config['baseurl'] . '/signup/';
            } else {
                $redirect_url = $config['baseurl'] . '/login/';
            }
            Http::redirect($redirect_url);
        }
    } else {
        $show_video = 1;
    }
}

if (isset($show_video) && $show_video == 1 && $err == '') {

    $sql = "UPDATE `videos` SET
           `video_view_time`='" . DB::quote($_SERVER['REQUEST_TIME']) . "' WHERE
           `video_id`='" . (int) $video_id . "'";
    DB::query($sql);

    $sql = "UPDATE `videos` SET
           `video_view_number`=`video_view_number`+1 WHERE
           `video_id`='" . (int) $video_id . "'";
    DB::query($sql);

    if (isset($_SESSION['UID'])) {
        $sql = "UPDATE `users` SET
               `user_watched_video`=`user_watched_video`+1 WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        DB::query($sql);

        if ($_SESSION['UID'] != $video_info['video_user_id']) {
            $sql = "UPDATE `users` SET
                   `user_video_viewed`=`user_video_viewed`+1 WHERE
                   `user_id`='" . (int) $video_info['video_user_id'] . "'";
            DB::query($sql);
        }
    }

    $cache_id = 'view_video_' . $video_id;
    $view = Cache::load($cache_id);

    if (! $view) {
        $view = array();
        $view['video_info'] = $video_info;

        $player = new VideoPlayer();
        $view['VSHARE_PLAYER'] = $player->getPlayerCode($video_id);

        $tags = explode(' ', $video_info['video_keywords']);
        $view['tags'] = $tags;

        $view['video_responses'] = Video::getVideoResponse($video_id, 5);

		$related_video_string =  trim($video_info['video_title']) . ' ' . trim($video_info['video_description']) . ' ' . trim($video_info['video_keywords']);
        $related_videos = Video::getRelatedVideos($video_id, $related_video_string);
        $view['related_videos'] = $related_videos;

        $video_this = '';

        for ($i = 0; $i < count($related_videos); $i ++) {
            if ($related_videos[$i]['video_id'] == $video_id) {
                $video_this = $i;
                break;
            }
        }

        if ($video_this === '') {
            $num_related_videos = count($related_videos);
            if ($num_related_videos > 4) {
                $video_this = (int) $num_related_videos / 2;
                $related_videos[$video_this] = $video_info;
            } else if ($num_related_videos > 2) {
                $video_this = 0;
            }
        }

        $video_next = $video_this + 1;
        $video_prev = $video_this - 1;

        if (! isset($related_videos[$video_next])) {
            $view['video_next'] = 0;
        } else {
            $view['video_next'] = $related_videos[$video_next];
        }

        if (! isset($related_videos[$video_prev])) {
            $view['video_prev'] = 0;
        } else {
            $view['video_prev'] = $related_videos[$video_prev];
        }

        $package_allow_video_download = 0;

        if (isset($_SESSION['UID'])) {
            $sql = "SELECT * FROM  `favourite` WHERE
                   `favourite_user_id`=" . (int) $_SESSION['UID'] . " AND
                   `favourite_video_id`=" . (int) $video_id;
            $is_favourite = DB::fetch1($sql);
            if ($is_favourite) {
                $smarty->assign('favourite', 1);
            }

            if ($config['allow_download'] == 1) {
                if ($config['enable_package'] == 'yes') {
                    $sql = "SELECT `pack_id` FROM `subscriber` WHERE
                           `UID`='" . (int) $_SESSION['UID'] . "'";
                    $subscriber_info = DB::fetch1($sql);

                    $sql = "SELECT `package_allow_download` FROM `packages` WHERE
                           `package_id`='" . (int) $subscriber_info['pack_id'] . "'";
                    $package_info = DB::fetch1($sql);
                    $package_allow_video_download = $package_info['package_allow_download'];
                } else {
                    $package_allow_video_download = 1;
                }
            }
        }

        $view['package_allow_video_download'] = $package_allow_video_download;

        $sql = "SELECT v.* FROM `videos` AS `v`,`video_responses` AS `vr` WHERE
                vr.video_response_video_id='" . (int) $video_id . "' AND
                vr.video_response_to_video_id=v.video_id";
        $owner_video_info = DB::fetch1($sql);
        $view['owner_video_info'] = $owner_video_info;

        $sql = "SELECT `user_name`,`user_website`,`user_about_me` FROM `users` WHERE
               `user_id`='" . (int) $video_info['video_user_id'] . "'";
        $user_info = DB::fetch1($sql);
        $view['user_info'] = $user_info;

        if ($config['episode_enable'] == 1) {
            $ep_video_info = EpisodeVideo::getByVideoId($video_info['video_id']);
            if ($ep_video_info) {
                $episode_info = Episode::getById($ep_video_info['ep_video_eid']);
                $view['episode_info'] = $episode_info;
                $episode_videos = EpisodeVideo::getInfo($ep_video_info['ep_video_eid']);
                $view['episode_videos'] = $episode_videos;
            }
        }

        Cache::save($cache_id, $view);
    }

    $html_title = htmlspecialchars_uni($video_info['video_title']);
    $html_keywords = htmlspecialchars_uni($video_info['video_keywords']);
    $html_description = htmlspecialchars_uni($video_info['video_description']);
    $html_keywords_array = explode(' ', $html_keywords);
    $html_keywords = implode(', ', $html_keywords_array);

    $smarty->assign('html_description', $html_description);
    $smarty->assign('html_title', $html_title);
    $smarty->assign('html_keywords', $html_keywords);
    $smarty->assign('view', $view);
}

$user_id_js = isset($_SESSION['UID']) ? (int) $_SESSION['UID'] : 0;

$html_head_extra = '
<meta name="video_type" content="application/x-shockwave-flash" />
<meta name="video_height" content="360" />
<meta name="video_width" content="640" />
<link rel="image_src" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="image_src" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . '1_' . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="image_src" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . '2_' . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="thumbnail" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . '3_' . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="video_src" href="' . VSHARE_URL . '/v/' . $video_info['video_id'] . '&hl=en_US&fs=1&"/>
<meta name="video_type" content="application/x-shockwave-flash" />';

$html_extra = '
<script type="text/javascript">
var vid=' . $video_id . ';
var user_id=' . $user_id_js . ';
$(function(){
    show_comments(' . $video_id . ',1);
});
</script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_feature_request.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_inappropriate.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_rating.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_comments_show.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_comment_add.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_add_favorite.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_comment_delete.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/user_videos.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/playlist.js"></script>
<script language="JavaScript" src="' . VSHARE_URL . '/js/video_like.js"></script>
';

$smarty->assign('html_head_extra', $html_head_extra);
$smarty->assign('html_extra', $html_extra);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('view_video.tpl');
$smarty->display('footer.tpl');
DB::close();
