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

$video_id = $_GET['id'];

if (! is_numeric($video_id)) {
    Http::redirect(VSHARE_URL);
}

$video_info = Video::getById($video_id);

if (! $video_info || $video_info['video_user_id'] == 0) {
    set_message($lang['video_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/';
} else {
    $redirect_url = VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . urlencode($video_info['video_seo_name']) . '/';
}

DB::close();
Http::redirect($redirect_url);
