<?php

$html_title = 'Rebuilding Video Tags';

require '../include/config.php';
require './inc/functions_upgrade.php';
require './tpl/header.php';


echo '<h1>' . $html_title . '</h1>';

$sql = "DROP TABLE IF EXISTS `tags`, `tag_video`";
DB::query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL auto_increment,
  `tag` varchar(255) NOT NULL,
  `tag_count` int(11) NOT NULL default '0',
  `used_on` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

DB::query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS `tag_video` (
  `id` int(11) NOT NULL auto_increment,
  `tag_id` int(11) NOT NULL,
  `vid` int(11) NOT NULL,
  `chid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

DB::query($sql);

$sql = "SELECT * FROM `videos` WHERE `video_type`='public'";
$videos_all = DB::fetch($sql);

foreach ($videos_all as $video_info) {

    $video_id = $video_info['video_id'];
    $video_keywords = $video_info['video_keywords'];
    $video_channels = $video_info['video_channels'];
    $video_user_id = $video_info['video_user_id'];
    $video_add_time = $video_info['video_add_time'];

    $tags = new Tags($video_keywords, $video_id, $video_user_id, $video_channels);
    $tags->settime($video_add_time);
    $tags->add();

    $video_tags = $tags->get_tags();
    $video_keywords_new = implode(' ', $video_tags);
    unset($tags);

    $sql = "UPDATE `videos` SET
           `video_keywords`='" . DB::quote($video_keywords_new) . "' WHERE
           `video_id`='" . (int) $video_id . "'";
    DB::query($sql);
    echo "<p>video id =  $video_id Tag = $video_keywords_new</p>";
}

$sql = "SELECT `group_id`,`group_keyword` FROM `groups`";
$group_all = DB::fetch($sql);

echo '<h1>Rebuilding Group Tags</h1>';

foreach ($group_all as $group_info) {

    $keywords = str_replace(' ', ',', $group_info['group_keyword']);
    $keywords = ereg_replace("[,]+", " ", $keywords);
    $keywords = ereg_replace("[ ]+", " ", $keywords);
    $keywords = trim($keywords);
    $keywords = Tags::clean_tags($keywords);

    $sql = "UPDATE `groups` SET
           `group_keyword`='$keywords' WHERE
           `group_id`='" . (int) $group_info['group_id'] . "'";
    DB::query($sql);
    echo "<p>$sql</p>";
}

echo '<h2>Finished</h2>';

upgrade_next_step();
