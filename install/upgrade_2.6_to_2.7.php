<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 3.2
 *   LICENSE: http://buyscripts.in/vshare-license
 *   WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 *   This program is a commercial software and any kind of using it must agree
 *   to vShare license.
 *
 ******************************************************************************/

$html_title = 'VSHARE UPGRADE';
require '../include/config.php';
require './inc/class.sql_import.php';
require './inc/functions_upgrade.php';
require './tpl/header.php';

if ($config['version'] != '2.6') {
    die('<p>This upgrade script can only upgrade if you are using version: 2.6</p>');
}

write_log('#### UPGRADE 2.6 to 2.7 STARTED ####', 'vshare_upgrade', 0,'txt');

$sql = "ALTER DATABASE `$db_name`
        CHARACTER SET `utf8`";
DB::query($sql);

write_log($sql, 'vshare_upgrade', 0,'txt');

$sql_file = VSHARE_DIR . '/install/sql/upgrade_2.6_to_2.7.sql';
$sql_import = new Sql2Db($sql_file);
$sql_import->import();

$sql = "SELECT * FROM `channels`";
$channels_all = DB::fetch($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

foreach ($channels_all as $channel) {
    $seo_name = Url::seoName($channel['channel_name']);
    $sql = "UPDATE `channels` SET
           `channel_seo_name`='" . DB::quote($seo_name) . "' WHERE
           `channel_id`='" . $channel['channel_id'] . "'";
    DB::query($sql);
    write_log($sql, 'vshare_upgrade', 0,'txt');
}

$sql = "ALTER TABLE `videos` ADD
       `video_view_time` INT( 11 ) NOT NULL
        AFTER `viewtime` ";
DB::query($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

$sql = "SELECT `video_id`,`viewtime` FROM `videos`";
$videos_all = DB::fetch($sql);

write_log($sql, 'vshare_upgrade', 0,'txt');

foreach ($videos_all as $video) {
    $unix_time = strtotime($video['viewtime']);
    $sql = "UPDATE `videos` SET
           `video_view_time`='$unix_time' WHERE
           `video_id`='" . (int) $video['video_id'] . "'";
    DB::query($sql);
    write_log($sql, 'vshare_upgrade', 0,'txt');
}

$sql = "ALTER TABLE `videos` CHANGE
       `viewtime` `not_used_viewtime` INT( 11 ) NOT NULL";
DB::query($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

$dir = VSHARE_DIR . '/photo/';

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (preg_match("/.jpg/i", $file)) {
                $user_id = str_replace('.jpg', '',$file);
                if (preg_match('/^[0123456789]+$/', $user_id)) {
                    $sql = "UPDATE `users` SET `user_photo`='1' WHERE `user_id`='" . (int) $user_id . "'";
                    DB::query($sql);
                    $size = getimagesize($dir . $file);
                    if ($size[0] > 121 || $size[1] > 91) {
                        $location_photo = VSHARE_DIR . '/photo/' . $user_id . '.jpg';
                        $location_avatar = VSHARE_DIR . '/photo/1_' . $user_id . '.jpg';
                        $current_file = $dir . $file;
                        $file_tmp_name = $dir . $user_id . '_tmp.jpg';
                        rename($current_file, $file_tmp_name);
                        Image::createThumb($file_tmp_name, $location_photo, $config['img_max_width'], $config['img_max_height']);
                        Image::createThumb($file_tmp_name, $location_avatar, 50, 40);
                        unlink($file_tmp_name);
                    }
                }
            }
        }
        closedir($dh);
    }
}

write_log('#### UPGRADE 2.6 to 2.7 FINISHED ####', 'vshare_upgrade', 0,'txt');

$next_step = VSHARE_URL . '/install/build_tags_2.7.php';
upgrade_next_step("2.7","$next_step");
