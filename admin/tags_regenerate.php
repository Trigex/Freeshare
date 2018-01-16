<?php

require 'admin_config.php';
require '../include/config.php';

Admin::auth();

$result_per_page = 50;

if (isset($_GET['tags_regenerate'])) {
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    if ($page < 1) {
        $page = 1;
    }

    if ($page == 1) {
        $sql = "DROP TABLE IF EXISTS `tags_backup`, `tag_video_backup`";
        DB::query($sql);

        $sql = "RENAME TABLE `tags` TO `tags_backup`,
               `tag_video` TO `tag_video_backup`";
        DB::query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `tags` (
               `id` int(11) NOT NULL auto_increment,
               `tag` varchar(255) NOT NULL,
               `tag_count` int(11) NOT NULL default '0',
               `used_on` int(11) NOT NULL default '0',
               `active` tinyint(1) NOT NULL default '1',
                PRIMARY KEY  (`id`)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;";
        DB::query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `tag_video` (
               `id` int(11) NOT NULL auto_increment,
               `tag_id` int(11) NOT NULL,
               `vid` int(11) NOT NULL,
               `chid` varchar(255) NOT NULL,
                PRIMARY KEY  (`id`)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;";
        DB::query($sql);
    }

    $items_per_page = isset($_GET['items_per_page']) ? (int) $_GET['items_per_page'] : $result_per_page;
    $items_per_page = ($items_per_page < 1) ? $result_per_page : $items_per_page;
    $start = ($page - 1) * $items_per_page;
    $page ++;

    $sql = "SELECT `video_id`,`video_user_id`,`video_keywords`,`video_channels`,`video_add_time`
            FROM `videos` WHERE
           `video_type`='public'
            ORDER BY `video_id` ASC
            LIMIT $start, $items_per_page";
    $videos_all = DB::fetch($sql);

    if ($videos_all) {
        foreach ($videos_all as $video_info) {
            $tags = new Tag($video_info['video_keywords'], $video_info['video_id'], $video_info['video_user_id'], $video_info['video_channels']);
            $tags->settime($video_info['video_add_time']);
            $tags->add();

            $video_tags = $tags->get_tags();
            $video_keywords_new = implode(' ', $video_tags);

            $sql = "UPDATE `videos` SET
                   `video_keywords`='" . DB::quote($video_keywords_new) . "' WHERE
                   `video_id`='" . (int) $video_info['video_id'] . "'";
            DB::query($sql);

            echo "<p>" . $video_info['video_id'] . " = $video_keywords_new</p>";
        }
        echo "<p>Please wait...</p>";
        echo '<meta http-equiv="refresh" content="3;url=' . VSHARE_URL . '/admin/tags_regenerate.php?tags_regenerate&items_per_page=' . $items_per_page . '&page=' . $page . '">';
    } else {
        set_message('Tags created successfully');
        $redirect_url = VSHARE_URL . '/admin/tags_regenerate.php';
        Http::redirect($redirect_url);
    }
} else {
    $smarty->assign('result_per_page', $result_per_page);
    $smarty->assign('err', $err);
    $smarty->assign('msg', $msg);
    $smarty->display('admin/header.tpl');
    $smarty->display('admin/tags_regenerate.tpl');
    $smarty->display('admin/footer.tpl');
}

DB::close();
