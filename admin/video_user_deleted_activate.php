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
require '../include/language/' . LANG . '/admin/video_user_deleted_activate.php';

Admin::auth();

if (isset($_POST['activate'])) {

    $user_name = $_POST['user_name'];

    if ($user_name == '') {
        $err = $lang['user_name_empty'];
    }

    if ($err == '') {

        $user_info = User::getByName($_POST['user_name']);

        if ($user_info) {

            $sql = "UPDATE `videos` SET `video_user_id`=" . $user_info['user_id'] . ",
                   `video_active`='1' WHERE
                   `video_id`='" . (int) $_POST['video_id'] . "'";
            DB::query($sql);

            $video_info = Video::getById($_POST['video_id']);

            $flv_size = $video_info['video_space'];

            $sql = "UPDATE `subscriber` SET
                   `used_space`=`used_space`+$flv_size,
                   `total_video`=`total_video`+1 WHERE
                   `UID`='" . (int) $user_info['user_id'] . "'";
            DB::query($sql);

            User::updateVideoCount($user_info['user_id'], 1);

            $tags = new Tag($video_info['video_keywords'], $_POST['video_id'], $video_info['video_user_id'], $video_info['video_channels']);
            $tags->add();
            $msg = str_replace('[USERNAME]', $user_info['user_name'], $lang['video_activated']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/video_user_deleted.php';
            Http::redirect($redirect_url);
        } else {
            $err = $lang['user_not_found'];
        }
    }
}

if (is_numeric($_GET['id'])) {
    $video_info = Video::getById($_GET['id']);
    $smarty->assign('video', $video_info);
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_user_deleted_activate.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
