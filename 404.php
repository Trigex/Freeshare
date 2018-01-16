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

require_once 'include/config.php';

header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');

$sql = "SELECT * FROM `videos` WHERE
       `video_featured`='yes' AND
       `video_type`='public' AND
       `video_approve`='1' AND
       `video_active`='1'
       LIMIT 0,4";
$videos = DB::fetch($sql);

if (!$videos) {
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_approve`='1' AND
           `video_active`='1'
           LIMIT 0,4";
    $videos = DB::fetch($sql);
}

$video_info = array();

foreach($videos as $video) {
    $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
    $video_info[] = $video;
}

$smarty->assign('video_info', $video_info);
$smarty->assign('msg_404', 'We\'re sorry, the page you requested cannot be found.');
$smarty->assign('html_title', '404 Not Found');
$smarty->display('header.tpl');
$smarty->display('404.tpl');
$smarty->display('footer.tpl');
DB::close();
