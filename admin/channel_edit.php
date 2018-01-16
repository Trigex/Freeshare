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
require '../include/language/' . LANG . '/admin/channel_edit.php';

Admin::auth();

$result_per_page = Config::get('admin_listing_per_page');

if (isset($_POST['edit_channel'])) {

    if ($_POST['name'] == '') {
        $err = $lang['channel_name_null'];
    } else if ($_POST['descrip'] == '') {
        $err = $lang['channel_description_null'];
    }

    $_POST['name'] = trim($_POST['name']);
    $seo_name = Url::seoName($_POST['name']);

    $sql = "SELECT * FROM `channels` WHERE
            `channel_seo_name`='" . $seo_name . "' AND
            `channel_id`!='" . (int) $_POST['id'] . "'";
    $channel_exisists = DB::fetch1($sql);

    if ($channel_exisists) {
        $err = 'Channel with the name already exists';
    }

    $sql = "SELECT * FROM `channels` WHERE
            `channel_name`='" . DB::quote($_POST['name']) . "' AND
            `channel_id`!='" . (int) $_POST['id'] . "'";
    $channel_exisists = DB::fetch($sql);

    if ($channel_exisists) {
        $err = 'Channel with the name already exists';
    }

    if ($err == '') {

        $sql = "UPDATE `channels` SET
                `channel_name` = '" . DB::quote($_POST['name']) . "',
                `channel_seo_name` = '" . DB::quote($seo_name) . "',
                `channel_description` = '" . DB::quote($_POST['descrip']) . "'
                WHERE `channel_id`='" . (int) $_POST['id'] . "'";
        DB::query($sql);

        if ($_FILES['picture'] != '') {
            Image::createThumb($_FILES['picture']['tmp_name'], VSHARE_DIR . '/chimg/' . $_POST['id'] . '.jpg', $config['img_max_width'], $config['img_max_height']);
        }

        if ($err == '') {
            set_message($lang['channel_updated'], 'success');
            $redirect_url = VSHARE_URL . '/admin/channel_search.php?id=' . $_POST['id'] . '&action=search';
            Http::redirect($redirect_url);
        }
    } else {
        $_GET['chid'] = $_POST['id'];
    }
}

if (isset($_GET['chid']) && $_GET['chid'] != '') {
    $channel_info = Channel::getById($_GET['chid']);
    $smarty->assign('channel', $channel_info);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
