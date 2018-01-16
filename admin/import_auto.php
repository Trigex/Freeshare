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

Admin::auth();

if (isset($_POST['submit'])) {
    $video_keywords = isset($_POST['video_keywords']) ? $_POST['video_keywords'] : '';
    $user_name = isset($_POST['video_user_name']) ? $_POST['video_user_name'] : '';
    $channel_id = isset($_POST['video_channel']) ? $_POST['video_channel'] : 0;
    $import_auto_download = isset($_POST['import_auto_download']) ? $_POST['import_auto_download'] : 0;

    if (! check_field_exists($user_name, 'user_name', 'users')) {
        $err = 'User not found - ' . $_POST['video_user_name'];
    }

    if (! check_field_exists($channel_id, 'channel_id', 'channels')) {
        $err = 'Select a channel';
    }

    if (strlen($_POST['video_keywords']) < 2) {
        $err = 'Please enter keyword';
    }

    if ($err == '') {
        $sql = "SELECT * FROM `import_auto` WHERE
			   `import_auto_keywords`='" . DB::quote($video_keywords) . "'";
        $is_duplicate = DB::fetch1($sql);

        if (! $is_duplicate) {
            $sql = "INSERT INTO `import_auto` SET
					`import_auto_keywords`='" . DB::quote($video_keywords) . "',
					`import_auto_user`='" . DB::quote($user_name) . "',
					`import_auto_channel`='" . (int) $channel_id . "',
					`import_auto_download`='" . (int) $import_auto_download . "'";
            DB::query($sql);
            $msg = 'Keywords successfully added';
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/import_auto.php';
            Http::redirect($redirect_url);
        } else {
            $err = 'Keywords Already Added.';
        }
    }

    $smarty->assign('video_keywords', $video_keywords);
    $smarty->assign('video_user_name', htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'));
    $smarty->assign('video_channel', (int) $channel_id);
    $smarty->assign('import_auto_download', (int) $import_auto_download);
}

$sql = "SELECT * FROM `import_auto`";
$import_auto_info = DB::fetch($sql);

$smarty->assign('import_auto_info', $import_auto_info);
$smarty->assign('channel_info', Channel::get());
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_auto.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
