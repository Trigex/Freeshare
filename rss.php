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

$url = parse_url(VSHARE_URL);
$rss_email = 'rss@' . $url['host'];

$type = isset($_GET['type']) ? $_GET['type'] : 1;

if ($type == 'new') {
    $sql = "SELECT videos.*, users.user_id, users.user_name FROM
             `videos` AS `videos`,
             `users` AS `users` WHERE
              videos.video_user_id=users.user_id AND
              videos.video_type='public' AND
              videos.video_active='1' AND
              videos.video_approve='1'
              ORDER BY videos.video_id DESC
              LIMIT 20";
    $feed_title = '[20 Newest videos on ' . $config['site_name'] . ']';
    $url = VSHARE_URL . '/rss/new/';
} else if ($type == 'views') {
    $sql = "SELECT videos.*,users.user_id,users.user_name FROM
             `videos` AS `videos`,
             `users` AS `users` WHERE
              videos.video_user_id=users.user_id AND
              videos.video_type='public' AND
              videos.video_active=1 AND
              videos.video_approve=1
              ORDER BY videos.video_view_number DESC
              LIMIT 20";
    $feed_title = "[20 Most Viewed videos on " . $config['site_name'] . "]";
    $url = VSHARE_URL . '/rss/views/';
} else if ($type == 'comments') {
    $sql = "SELECT videos.*,users.user_id,users.user_name FROM
             `videos` AS `videos`,
             `users` AS `users` WHERE
              videos.video_user_id=users.user_id AND
              videos.video_type='public' AND
              videos.video_active=1 AND
              videos.video_approve=1
              ORDER BY videos.video_com_num DESC
              LIMIT 20";
    $feed_title = '[20 Most Commented videos on ' . $config['site_name'] . ']';
    $url = VSHARE_URL . '/rss/comments/';
} else {
    $sql = "SELECT videos.*,users.user_id,users.user_name FROM
             `videos` AS `videos`,
             `users` AS `users` WHERE
              videos.video_user_id=users.user_id AND
              videos.video_type='public' AND
              videos.video_active=1 AND
              videos.video_approve=1
              ORDER BY videos.video_id DESC
              LIMIT 20";
    $feed_title = '[20 Newest videos on ' . $config['site_name'] . ']';
    $url = VSHARE_URL . '/rss/new/';
}

header("Content-Type: application/xml; charset=utf-8");
header("Expires: 0");

echo '<?xml version="1.0" encoding="utf-8" ?>';
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
echo '<channel>';
echo '<title><![CDATA[' . $config['site_name'] . ']]></title>';
echo '<link>' . $url . '</link>';
echo '<description>' . $feed_title . '</description>';
echo '<copyright>Copyright (c) by ' . $config['site_name'] . ' - All rights reserved.</copyright>';
echo '<image>';
echo '<url>' . $config['logo_url_md'] . '</url>';
echo '<title>' . $config['site_name'] . '</title>';
echo '<link>' . $url . '</link>';
echo '</image>';
echo '<atom:link href="' . $url . '" rel="self" type="application/rss+xml" />';

$videos_all = DB::fetch($sql);

foreach ($videos_all as $video_info) {

    $photo = $servers[$video_info['video_thumb_server_id']] . '/thumb/' . $video_info['video_folder'] . '1_' . $video_info['video_id'] . '.jpg';

    $video = VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/';
    $description = $video_info['video_description'];
    $description = str_replace('&amp', '', htmlspecialchars(stripslashes($description), ENT_QUOTES, 'UTF-8'));
    $photo = htmlspecialchars(stripslashes($photo), ENT_QUOTES, 'UTF-8');
    $video_title = htmlspecialchars(stripslashes($video_info['video_title']), ENT_QUOTES, 'UTF-8');

    echo '<item>';
    echo '<title>' . $video_title . '</title>';
    echo '<link>' . $video . '</link>';
    echo '<guid>' . $video . '</guid>';
    echo '<description>';
    echo '<![CDATA[';
    echo '<a href=' . $video . ' target=_blank><img src="' . $photo . '" border="0" width="174" height="130" vspace="4" hspace="4"></a><p>' . $description . '</p>' . '<p>Added by: <a href="' . VSHARE_URL . '/' . $video_info['user_name'] . '">' . $video_info['user_name'] . '</a>';
    echo '<br />Tags: ';

    $tag = new Tag($video_info['video_keywords'], $video_info['video_id'], '', "0||0");
    $tags = $tag->get_tags();
    unset($tag);

    $i = 0;
    foreach ($tags as $my_tag) {
        if ($i > 0) echo ', ';
        $i ++;
        echo '<a href="' . VSHARE_URL . '/tag/' . $my_tag . '/">' . $my_tag . '</a>';
    }

    echo '<br />Date: ' . $video_info['video_add_date'] . '<br />';
    echo '<br /></p><hr />';
    echo '    ]]>';
    echo '  </description>';
    echo '  <author>' . $rss_email . '(' . $video_info['user_name'] . ')</author>';
    echo '</item>';
}

echo '
</channel>
</rss>
';

DB::close();
