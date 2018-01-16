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

$current_folder = dirname(__FILE__);

chdir("$current_folder");

require $current_folder . '/include/config.php';

$sql = "SELECT * FROM `process_queue` WHERE
       `status`='0'";
$download = DB::fetch1($sql);

$sql = "SELECT * FROM `process_queue` WHERE
       `status`='2'";
$process = DB::fetch1($sql);

$cron = Config::get('cron');

echo 'cronjob started<br />';

if ($cron == 1) {

    $cron = 0;

    if ($download) {
        $video_id = $download['id'];
        Upload::downloadVideo($video_id);
    } else if ($process) {
        $video_id = $process['id'];
        Upload::processVideo($video_id);
    }
} else {

    $cron = 1;

    if ($process) {
        $video_id = $process['id'];
        Upload::processVideo($video_id);
    } else if ($download) {
        $video_id = $download['id'];
        Upload::downloadVideo($video_id);
    }
}

$sql = "UPDATE `config` SET
       `config_value`='" . (int) $cron . "' WHERE
       `config_name`='cron'";
DB::query($sql);
DB::close();
