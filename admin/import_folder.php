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
require '../include/settings/upload.php';

Admin::auth();

$import_folder = VSHARE_DIR . '/templates_c/import';

$videos = array();

$folder_empty = 0;

if (is_dir($import_folder)) {
    $import_video = dir($import_folder);
    while (false !== ($video = $import_video->read())) {
        if ($video != '.' && $video != '..') {
            $pos = strrpos($video, '.');
            $upload_file_extn = strtolower(substr($video, $pos + 1, strlen($video) - $pos));
            for ($i = 0; $i < count($file_types); $i ++) {
                if ($upload_file_extn == $file_types[$i]) {
                    $video_details[0] = $video;
                    $video_details[1] = urlencode($video);
                    $videos[] = $video_details;
                }
            }
        }
    }

} else {
    $folder_empty = 1;
}

$smarty->assign('folder_empty', $folder_empty);
$smarty->assign('import_video', $videos);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_folder.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
