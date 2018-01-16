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
require '../include/language/' . LANG . '/admin/video_details.php';

Admin::auth();

$vid = (int) $_GET['id'];

if (is_numeric($vid)) {

    $video_info = Video::getById($vid);

    if ($video_info) {
        $player = new VideoPlayer();
        $smarty->assign('VSHARE_PLAYER', $player->getPlayerCode($vid));
        $smarty->assign('video', $video_info);
        $smarty->assign('video_type', $video_info['video_vtype']);
        $sql = "SELECT * FROM `process_queue` WHERE
               `vid`='" . (int) $vid . "'";
        $process_queue_info = DB::fetch1($sql);

        if ($process_queue_info) {
            $source_video = VSHARE_DIR . '/video/' . $video_info['video_name'];
            if (file_exists($source_video)) {
                $smarty->assign('reprocess', 1);
                $smarty->assign('reprocess_id', $process_queue_info['id']);
            }
        }
    } else {
        $err = str_replace('[VIDEO_ID]', $_GET['id'], $lang['video_not_found']);
    }
} else {
    $err = $lang['video_id_empty'];
}

if (isset($_REQUEST['a'])) {
    $smarty->assign('a', $_REQUEST['a']);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_details.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
