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

$sitemap = new Sitemap();
$create = isset($_GET['create']) ? $_GET['create'] : 1;
$sitemap_name = isset($_GET['sitemap']) ? $_GET['sitemap'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$video_count = isset($_GET['video_count']) ? $_GET['video_count'] : 0;
$last_video_id = isset($_GET['last_video_id']) ? $_GET['last_video_id'] : 0;
$sql_where = '';
$items_per_page = 200;

if (! empty($last_video_id)) {
    $sql_where = 'AND `video_id`>' . $last_video_id;
}

$start = ($page - 1) * $items_per_page;
$smarty->display('admin/header.tpl');
$sitemap_xml = '';

echo '<h1>Creating Sitemap : ' . $sitemap_name . '</h1>
        <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr class="tabletitle">
                <td>
                    <b>Sitemap Video Url No</b>
                </td>
                <td>
                    <b>Sitemap Video Id</b>
                </td>
                <td>
                    <b>Sitemap Video Title</b>
                </td>
                <td>
                    <b>Action</b>
                </td>
            </tr>';

if ($create == 1) {
    if (empty($last_video_id)) {
        $sitemap->deleteSitemap();
    }
    $sitemap_name = $sitemap->createNewSitemapName();
    $fp = fopen(VSHARE_DIR . '/sitemap/' . $sitemap_name, 'w');
    fwrite($fp, $sitemap->sitemap_xml_header . $sitemap->sitemap_urlset_open);
    $create = 0;
} else {
    if (empty($sitemap_name)) {
        $sitemap_name = $sitemap->createNewSitemapName();
    }
    $fp = fopen(VSHARE_DIR . '/sitemap/' . $sitemap_name, 'a');
}

$sql = "SELECT * FROM `videos` WHERE
       `video_approve`='1' AND
       `video_active`='1'
        $sql_where
        ORDER BY `video_id` DESC
        LIMIT $start, $items_per_page";
$videos_all = DB::fetch($sql);

if ($videos_all) {

    $sitemap_size = filesize(VSHARE_DIR . '/sitemap/' . $sitemap_name);

    if ($sitemap_size > $sitemap->sitemap_size_limit) {
        fwrite($fp, $sitemap->sitemap_urlset_close);
        $sitemap->insert_sitemap($video_count, $sitemap_name);
        $sitemap->xml_to_gz($sitemap_name);
        $sitemap_name = $sitemap->createNewSitemapName();
        $fp = fopen(VSHARE_DIR . '/sitemap/' . $sitemap_name, 'w');
        fwrite($fp, $sitemap->sitemap_xml_header . $sitemap->sitemap_urlset_open);
        $video_count = 0;
    }

    foreach ($videos_all as $video_info) {
        $video_count ++;
        $tr_class = 'class="tablerow1"';
        if ($video_count % 2 == 0) {
            $tr_class = 'class="tablerow2"';
        }

        echo '<tr ' . $tr_class . '>
                <td>' . $video_count . ' </td>
                <td>' . $video_info['video_id'] . '</td>
                <td>' . $video_info['video_title'] . '</td>
                <td>Added to sitemap</td>
            </tr>';

        $video_info['video_title'] = $sitemap->cleanSitemap($video_info['video_title']);
        $video_info['video_description'] = $sitemap->cleanSitemap($video_info['video_description']);

        $sitemap_xml .= '
        <url>
            <loc>' . VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/</loc>
            <video:video>
                <video:player_loc allow_embed="yes" autoplay="ap=1">' . VSHARE_URL . '/v/' . $video_info['video_id'] . '&amp;hl=en_US&amp;fs=1</video:player_loc>
                <video:thumbnail_loc>' . $servers[$video_info['video_server_id']] . '/thumb/' . $video_info['video_folder'] . '1_' . $video_info['video_id'] . '.jpg</video:thumbnail_loc>
                <video:title>' . $video_info['video_title'] . '</video:title>
                <video:description>' . $video_info['video_description'] . '</video:description>
                <video:duration>' . $video_info['video_duration'] . '</video:duration>
            </video:video>
        </url>';

        if ($video_count >= $sitemap->sitemap_url_limit) {
            $last_video_id = $video_info['video_id'];
            $sitemap_xml .= $sitemap->sitemap_urlset_close;
            $sitemap->insert_sitemap($video_count, $sitemap_name);
            $sitemap->xml_to_gz($sitemap_name);
            $create = 1;
            $video_count = 0;
            $page = 0;
            break;
        }
    }

    fwrite($fp, $sitemap_xml);
} else {
    fwrite($fp, $sitemap->sitemap_urlset_close);
    $sitemap->insert_sitemap($video_count, $sitemap_name);
    $sitemap->xml_to_gz($sitemap_name);
    $_SESSION['vshare_message'] = $sitemap->createSitemapIndex();
    $redirect_url = VSHARE_URL . '/admin/sitemap.php';
    $_SESSION['vshare_message_type'] = 'success';
    Http::redirect($redirect_url);
}

echo '</table>';
$page ++;

?>

<meta http-equiv="refresh" content="2;url=<?php echo VSHARE_URL;?>/admin/sitemap_generate.php?create=<?php echo $create;?>&sitemap=<?php echo $sitemap_name;?>&page=<?php echo $page;?>&video_count=<?php echo $video_count;?>&last_video_id=<?php echo $last_video_id;?>">
