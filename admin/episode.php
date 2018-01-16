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

Admin::auth();

$video_id = isset($_GET['video_id']) ? (int) $_GET['video_id'] : 0;

$episode_video_info = EpisodeVideo::getByVideoId($video_id);
$err_top = '';

if ($episode_video_info) {
    $episode_name = Episode::getNameById($episode_video_info['ep_video_eid']);
    $err_top = 'Video exist in episode <strong>' . $episode_name . '</strong>. Please continue, if you want to add this video to another episode (previous will be lost).';
}

if (isset($_POST['submit'])) {
    $episode_new = $_POST['episode_new'];

    if ($episode_new == 'yes') {
        $episode_name = $_POST['episode_name'];

        if (Episode::exists($episode_name)) {
            $err = 'Episode name already exist.';
        } else {
            $episode_id = Episode::add($episode_name);
            $msg = 'New Episode created.';
        }
    } else {
        $episode_id = $_POST['episode_id'];
    }

    if ($err == '') {
        EpisodeVideo::add($episode_id, $video_id);
        $msg .= ' Video added to Episode <strong>' . Episode::getNameById($episode_id) . '</strong>.';
    }
}

$video_info = Video::getById($video_id);

if ($err == '') {
    $err = $err_top;
}
if ($msg != '') {
    $err = '';
}

$smarty->assign(array(
    'err' => $err,
    'msg' => $msg,
    'video_info' => $video_info,
));
$smarty->display('admin/header.tpl');
$smarty->display('admin/episode.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
