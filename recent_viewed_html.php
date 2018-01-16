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
        LIMIT 0, 6";
$videos = DB::fetch($sql);

if (empty($videos)) exit();

$video_chunks = array_chunk($videos, 3);

echo '
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-facetime-video"></span> <strong>Videos being watched right now...</strong></h3>
    </div>
    <div class="panel-body">
        <div id="recent-videos-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">';
                foreach ($video_chunks as $key => $videos) {
                echo '<div class="item';
                if ($key == 0) {
                echo ' active';
                }
                echo '">
                <div class="video-block home-videos">';
                foreach ($videos as $video) {
                $video_url = VSHARE_URL . '/view/' . $video['video_id'] . '/' . $video['video_seo_name'] . '/';
                $thumb_url = $servers[$video['video_thumb_server_id']] . '/thumb/' . $video['video_folder'] . '1_' . $video['video_id'] . '.jpg';
                echo '
                <div class="col-orient-ls col-md-4 col-sm-4">
                    <div class="thumbnail" style="height: 160px;">
                        <div class="preview">
                            <a href="' . VSHARE_URL . '/view/' . $video['video_id'] . '/' . $video['video_seo_name'] . '">
                                <img class="img-responsive" src="' . $thumb_url . '" width="100%">
                                <div class="badge video-time">' . $video['video_length'] . '</div>
                            </a>
                        </div>
                        <div class="caption">
                            <h5 class="video-title">
                                <a href="' . VSHARE_URL . '/view/' . $video['video_id'] . '/' . $video['video_seo_name'] . '">' . $video['video_title'] . '</a>
                            </h5>
                        </div>
                    </div>
                </div>';
                }
                echo '</div></div>';
                }

                echo '
            </div>
            <a class="left carousel-control" href="#recent-videos-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#recent-videos-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<script>
$("#recent-videos-carousel").carousel("cycle");
</script>';

DB::close();
