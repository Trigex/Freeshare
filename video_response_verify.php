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
require 'include/language/' . LANG . '/lang_video_response.php';

if (isset($_GET['k']) && isset($_GET['u']) && isset($_GET['i'])) {
    if (! is_numeric($_GET['u'])) {
        $err = $lang['invalid_vcode'];
    } else if (! is_numeric($_GET['i'])) {
        $err = $lang['invalid_vcode'];
    } else if (strlen($_GET['k']) > 40) {
        $err = $lang['invalid_vcode'];
    } else {

        $data1 = 'VIDEO_RESPONSE' . $_GET['u'];
        $sql = "SELECT * FROM `verify_code` WHERE
               `id`=" . (int) $_GET['i'] . " AND
               `vkey`='" . DB::quote($_GET['k']) . "' AND
               `data1`='" . DB::quote($data1) . "'";
        $verify_info = DB::fetch1($sql);

        if (! $verify_info) {
            set_message($lang['invalid_vcode'], 'error');
            Http::redirect(VSHARE_URL . '/');
        }

        $video_info = Video::getById($_GET['u']);

        $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
        $smarty->assign('video_info', $video_info);

            if (isset($_POST['accept'])) {

                $sql = "UPDATE `video_responses` SET
                       `video_response_active`='1' WHERE
                       `video_response_video_id`='" . (int) $_GET['u'] . "' AND
                       `video_response_to_video_id`='" . (int) $verify_info['data2'] . "'";
                DB::query($sql);

                $sql = "DELETE FROM `verify_code` WHERE
                       `id`='" . (int) $_GET['i'] . "' AND
                       `vkey`='" . DB::quote($_GET['k']) . "' AND
                       `data1`='" . DB::quote($data1) . "'";
                DB::query($sql);

                set_message($lang['video_response_activated'], 'success');
                $redirect_url = VSHARE_URL . '/response/' . $verify_info['data2'] . '/videos/1';
                Http::redirect($redirect_url);
            } else if (isset($_POST['reject'])) {

                $sql = "DELETE FROM `verify_code` WHERE
                       `id`='" . (int) $_GET['i'] . "' AND
                       `vkey`='" . DB::quote($_GET['k']) . "' AND
                       `data1`='" . DB::quote($data1) . "'";
                DB::query($sql);

                $sql = "DELETE FROM `video_responses` WHERE
                       `video_response_video_id`='" . (int) $_GET['u'] . "' AND
                       `video_response_to_video_id`='" . (int) $verify_info['data2'] . "'";
                DB::query($sql);

                set_message($lang['video_response_rejected'], 'success');
                $redirect_url = VSHARE_URL . '/response/' . $verify_info['data2'] . '/videos/1';
                Http::redirect($redirect_url);
            }
    }
}

$smarty->assign('err', $err);
$smarty->display('header.tpl');
$smarty->display('video_response_verify.tpl');
$smarty->display('footer.tpl');
DB::close();
