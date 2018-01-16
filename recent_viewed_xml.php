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

header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

$sql_adult_filter = '';

if (getFamilyFilter()) {
    $sql_adult_filter = "AND `video_adult`='0'";
}

$sql = "SELECT * FROM `videos` WHERE
       `video_type`='public' AND
       `video_active`='1' AND
       `video_approve`='1'
        $sql_adult_filter
        ORDER BY `video_view_time` DESC
        LIMIT 0, 5";
$videos = DB::fetch($sql);

echo '<vshare><video_list>';

foreach ($videos as $video) {
    $video_url = VSHARE_URL . '/view/' . $video['video_id'] . '/' . $video['video_seo_name'] . '/';
    $thumb_url = $servers[$video['video_thumb_server_id']] . '/thumb/' . $video['video_folder'] . '1_' . $video['video_id'] . '.jpg';
    echo '<video>' .
         '<title>' . $video['video_title'] . '</title>' .
         '<run_time>' . $video['video_length'] . '</run_time>' .
         '<url>' . $video_url . '</url>' .
         '<thumbnail_url>' . $thumb_url . '</thumbnail_url>' .
         '</video>';
}

echo '</video_list></vshare>';

DB::close();
