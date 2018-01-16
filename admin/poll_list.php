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
require '../include/language/' . LANG . '/admin/poll_list.php';

Admin::auth();

if (isset($_GET['action']) && $_GET['action'] == 'delete' && is_numeric($_GET['poll_id'])) {
    Poll::$id = $_GET['poll_id'];
    Poll::delete();
    $msg = $lang['poll_deleted'];
}

$sql = "SELECT * FROM `poll_question`";
$polls = DB::fetch($sql);

$poll_list = array();
$poll_info = array();

foreach ($polls as $tmp) {
    $poll_info[] = Poll::display($tmp['poll_id']);
    $poll_list[] = $tmp;
}

$smarty->assign('pollArray', $poll_list);
$smarty->assign('poll_info', $poll_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/poll_list.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
