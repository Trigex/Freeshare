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

if ($config['allow_download'] != 1) {
    echo 'Video download disabled';
    exit();
}

User::is_logged_in();

$video_info = Video::getById($_GET['video_id']);
$video_name = $video_info['video_name'];

$file_path = VSHARE_DIR . '/video/' . $video_name;

if (($video_name == '') || (! is_file($file_path)) || (! file_exists($file_path))) {
    echo 'File not found.';
    exit();
}

if (ini_get('zlib.output_compression')) {
    ini_set('zlib.output_compression', 'Off');
}

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($video_name) . '";');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file_path));
readfile("$file_path");
exit();
