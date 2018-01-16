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
require '../include/language/' . LANG . '/admin/video_delete.php';

Admin::auth();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $video_id = $_GET['id'];
    $video_info = Video::getById($video_id);
    if (! $video_info) {
        $err = str_replace('[VIDEO_ID]', $video_id, $lang['video_not_found']);
    } else {
        $video_uid = $video_info['video_user_id'];
        if (Video::delete($video_id, $video_uid)) {
            $msg = $lang['video_deleted'];
        } else {
            $err = $tmp;
        }
    }
} else {
    $err = $lang['video_id_empty'];
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
