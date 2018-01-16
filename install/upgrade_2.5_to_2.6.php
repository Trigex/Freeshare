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
require './tpl/header.php';

if ($config['version'] != '2.5') {
    die('<p>This upgrade script can only upgrade if you are using version: 2.5</p>');
}

write_log('#### UPGRADE 2.5 to 2.6 STARTED ####', 'vshare_upgrade', 0,'txt');

$sql = "SELECT * FROM `video`";
$videos_all = DB::fetch($sql);

foreach ($videos_all as $tmp) {

    $seo_name = Url::seoName($tmp['title']);
    $duration = $tmp['duration'];
    $duration_hms = sec2hms($duration);
    $seo_name_org = $seo_name;

    $i = 1;

    while (check_field_exists($seo_name, 'seo_name', 'video')) {
        $seo_name = $seo_name_org . '-' . $i;
        $i ++;
    }

    $sql = "UPDATE `video` SET
           `seo_name`='$seo_name',
           `video_length`='$duration_hms' WHERE
           `VID`=" . $tmp['VID'];

    DB::query($sql);
}

// import sql file


$sql_file = VSHARE_DIR . '/install/sql/upgrade_2.5_to_2.6.sql';
$sql_import = new Sql2Db($sql_file);
$sql_import->import();

// rebuild tags

$sql = "SELECT * FROM `video` WHERE `type`='public'";
$videos_all = DB::fetch($sql);

foreach ($videos_all as $video_info) {
    $vid = $video_info['VID'];
    $keywords = $video_info['keyword'];
    $chid = $video_info['channel'];
    $uid = $video_info['UID'];
    $addtime = $video_info['addtime'];
    $tags = new Tag($keywords, $vid, $uid, $chid);
    $tags->settime($addtime);
    $tags->add();
}

write_log('#### UPGRADE 2.5 to 2.6 FINISHED ####', 'vshare_upgrade', 0,'txt');

upgrade_next_step("2.6");
