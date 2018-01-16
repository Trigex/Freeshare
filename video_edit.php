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
require 'include/language/' . LANG . '/lang_video_edit.php';

User::is_logged_in();

$video_id = isset($_GET['video_id']) ? (int) $_GET['video_id'] : 0;
$num_max_channels = Config::get('num_max_channels');
$smarty->assign('num_max_channels', $num_max_channels);

if (isset($_POST['submit'])) {
    $video_id = $_POST['video_id'];
    $video = new Video();
    $video->video_id = $video_id;
    $video->video_title = $_POST['video_title'];
    $video->video_description = $_POST['video_description'];
    $video->video_keywords = $_POST['video_keywords'];
    $video->video_channels = $_POST['channel_list'];
    $video->video_type = $_POST['video_type'];
    $video->video_allow_comment = $_POST['video_allow_comment'];
    $video->video_allow_rated = $_POST['video_allow_rated'];
    $video->video_allow_embed = $_POST['video_allow_embed'];
    $save = $video->video_update();

    if ($save == 1) {
        set_message($lang['video_info_update'], 'success');
        $redirect_url = VSHARE_URL . '/view/' . $video_id . '/' . $video->video_info['video_seo_name'] . '/';
        Http::redirect($redirect_url);
    } else {
        $err = $save;
    }
}

$video_info = Video::getById($video_id);

if ($video_info['video_user_id'] == $_SESSION['UID']) {
    $video_info['video_description'] = str_replace(array('<p>', '</p>'), '', $video_info['video_description']);
    $is_video_owner = 1;
} else {
    $err = $lang['video_owner'];
    $is_video_owner = 0;
}

$chid = explode('|', $video_info['video_channels']);

$smarty->assign('channels_all', Channel::get());
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('chid', $chid);
$smarty->assign('video_info', $video_info);
$smarty->display('header.tpl');
if ($is_video_owner) $smarty->display('video_edit.tpl');
$smarty->display('footer.tpl');
DB::close();
