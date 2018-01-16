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
require '../include/language/' . LANG . '/admin/settings.php';

Admin::auth();

if (isset($_POST['submit']))
{

    if ($_POST['guest_upload'] == 1) {
        if ($_POST['guest_upload_user'] == '') {
            $err = $lang['guest_user_name_empty'];
        } else if (! check_field_exists($_POST['guest_upload_user'], 'user_name', 'users')) {
            $err = $lang['user_name_invalid'];
        }
    }

    if (in_array($_POST['video_output_format'], array('mp4', 'flv'))) {
        $sql = "UPDATE `config` SET
               `config_value`='" . DB::quote($_POST['video_output_format']) . "' WHERE
               `config_name`='video_output_format'";
        DB::query($sql);
    }

    if (is_numeric($_POST['process_upload'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['process_upload'] . "' WHERE
               `config_name`='process_upload'";
        DB::query($sql);
    }

    if (in_array($_POST['tool_video_thumb'], array('ffmpeg', 'mplayer'))) {
        $sql = "UPDATE `config` SET
               `config_value`='" . $_POST['tool_video_thumb'] . "' WHERE
               `config_name`='tool_video_thumb'";
        DB::query($sql);
    }

    if (is_numeric($_POST['video_flv_delete'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['video_flv_delete'] . "' WHERE
               `config_name`='video_flv_delete'";
        DB::query($sql);
    }

    if (isset($_POST['flv_metadata'])) {
        if ($_POST['flv_metadata'] == 'yamdi' || $_POST['flv_metadata'] == 'flvtool' || $_POST['flv_metadata'] == 'none') {
            $sql = "UPDATE `config` SET
                   `config_value`='" . DB::quote($_POST['flv_metadata']) . "' WHERE
                   `config_name`='flv_metadata'";
            DB::query($sql);
        }
    }

    if (is_numeric($_POST['process_notify_user'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['process_notify_user'] . "' WHERE
               `config_name`='process_notify_user'";
        DB::query($sql);
    }

    if (is_numeric($_POST['guest_upload'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['guest_upload'] . "' WHERE
               `config_name`='guest_upload'";
        DB::query($sql);
    }

    if (! empty($_POST['guest_upload_user']) && $_POST['guest_upload'] == 1) {
        $sql = "UPDATE `config` SET
               `config_value`='" . DB::quote($_POST['guest_upload_user']) . "' WHERE
               `config_name`='guest_upload_user'";
        DB::query($sql);
    }

    if (isset($_POST['upload_progress_bar']))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . DB::quote($_POST['upload_progress_bar']) . "' WHERE
               `config_name`='upload_progress_bar'";
        DB::query($sql);
    }

    if (is_numeric($_POST['img_max_width'])){
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['img_max_width'] . "' WHERE
               `soption`='img_max_width'";
        DB::query($sql);
        $smarty->assign('img_max_width', $_POST['img_max_width']);
    }

    if (is_numeric($_POST['img_max_height'])){
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['img_max_height'] . "' WHERE
               `soption`='img_max_height'";
        DB::query($sql);
        $smarty->assign('img_max_height', $_POST['img_max_height']);
    }

    $msg = $lang['settings_updated'];
}

$smarty->assign('video_output_format', Config::get('video_output_format'));
$smarty->assign('upload_progress_bar', Config::get('upload_progress_bar'));
$smarty->assign('process_upload', Config::get('process_upload'));
$smarty->assign('tool_video_thumb', Config::get('tool_video_thumb'));
$smarty->assign('video_flv_delete', Config::get('video_flv_delete'));
$smarty->assign('flv_metadata', Config::get('flv_metadata'));
$smarty->assign('process_notify_user', Config::get('process_notify_user'));
$smarty->assign('guest_upload', Config::get('guest_upload'));
$smarty->assign('guest_upload_user', Config::get('guest_upload_user'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings_video.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
