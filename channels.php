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
require 'include/language/' . LANG . '/lang_channels.php';

$sql_adult_filter = '';

if (getFamilyFilter()) {
    $sql_adult_filter = "AND `video_adult`='0'";
}

$channels = Channel::get();

if (! $channels) {
    $msg = $lang['channel_not_found'];
}

$smarty->assign('html_title', 'Channels');
$smarty->assign('html_keywords', 'Channels');
$smarty->assign('html_description', 'Channels');
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('channels', $channels);
$smarty->display('header.tpl');
$smarty->display('channels.tpl');
$smarty->display('footer.tpl');
DB::close();
