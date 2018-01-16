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
require '../include/language/' . LANG . '/admin/settings_home.php';

Admin::auth();

if (isset($_POST['submit']))
{
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['user_poll']) . "' WHERE
           `soption`='user_poll'";
    DB::query($sql);
    $smarty->assign('user_poll', $_POST['user_poll']);

    if (is_numeric($_POST['home_num_tags']))
    {
        $sql = "UPDATE `config` SET
               `config_value` ='" . (int) $_POST['home_num_tags'] . "' WHERE
               `config_name`='home_num_tags'";
        DB::query($sql);
    }

    if (is_numeric($_POST['num_last_users_online']))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['num_last_users_online'] . "' WHERE
               `config_name`='num_last_users_online'";
        DB::query($sql);
    }

    if (is_numeric($_POST['num_new_videos']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['num_new_videos'] . "' WHERE
               `soption`='num_new_videos'";
        DB::query($sql);
        $smarty->assign('num_new_videos', $_POST['num_new_videos']);
    }

    if (is_numeric($_POST['recently_viewed_video']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['recently_viewed_video'] . "' WHERE
               `soption`='recently_viewed_video'";
        DB::query($sql);
        $smarty->assign('recently_viewed_video', $_POST['recently_viewed_video']);
    }

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['show_stats'] . "' WHERE
           `soption`='show_stats'";
    DB::query($sql);
    $smarty->assign('show_stats', $_POST['show_stats']);

    $msg = $lang['settings_updated'];
}

$smarty->assign('home_num_tags', Config::get('home_num_tags'));
$smarty->assign('num_last_users_online', Config::get('num_last_users_online'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings_home.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
