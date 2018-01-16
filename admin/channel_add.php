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
require '../include/language/' . LANG . '/admin/channel_add.php';

Admin::auth();

if (isset($_POST['add_channel'])) {

    if ($_POST['channel_name'] == '') {
        $err = $lang['channel_name_null'];
    } else if ($_POST['channel_description'] == '') {
        $err = $lang['channel_description_null'];
    } else if ($_FILES['channel_image']['name'] == '') {
        $err = $lang['channel_image'];
    }

    $seo_name = Url::seoName($_POST['channel_name']);

    if (check_field_exists($_POST['channel_name'], 'channel_name', 'channels')) {
        $err = $lang['channel_exists'];
    } else if (check_field_exists($seo_name, 'channel_seo_name', 'channels')) {
        $err = $lang['channel_exists'];
    }

    if ($err == '') {
        $sql = "INSERT INTO `channels` SET
               `channel_name`='" . DB::quote($_POST['channel_name']) . "',
               `channel_seo_name`='" . DB::quote($seo_name) . "',
               `channel_description`='" . DB::quote($_POST['channel_description']) . "'";
        $channel_id = DB::insertGetId($sql);
        $err = upload_jpg($_FILES, 'channel_image', $channel_id . '.jpg', 120, VSHARE_DIR . '/chimg/');
    }

    if ($err == '') {
        set_message($lang['channel_added'], 'success');
        $redirect_url = VSHARE_URL . '/admin/channels.php';
        Http::redirect($redirect_url);
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_add.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
