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

require './include/config.php';

$sql = "SELECT * FROM `pages` WHERE
       `page_name`='" . DB::quote($_GET['name']) . "'";
$page_info = DB::fetch1($sql);

if (! $page_info) {
    require '404.php';
    exit;
}

if ($page_info['page_members_only'] == 1) {
    User::is_logged_in();
}

$smarty->assign('err', $err);
$smarty->assign('html_title', $page_info['page_title']);
$smarty->assign('content', $page_info['page_content']);
$smarty->assign('html_description', $page_info['page_description']);
$smarty->assign('html_keywords', $page_info['page_keywords']);
$smarty->display('header.tpl');
$smarty->display('show_page.tpl');
$smarty->display('footer.tpl');
DB::close();
