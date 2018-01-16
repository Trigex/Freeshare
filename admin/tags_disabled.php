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

$sql = "SELECT * FROM `tags` WHERE
       `active`='0'";
$tags = DB::fetch($sql);
$smarty->assign('tags', $tags);

if (isset($_POST['action'])) {
    $active = 1;
    $tag_id = $_POST['action_tag'];
    $sql = "UPDATE `tags` SET
           `active`='$active' WHERE
           `id`='" . (int) $tag_id . "'";
    DB::query($sql);

    $msg = 'Tag has been ' . $_POST['action'] . 'd.';
    set_message($msg, 'success');
    $redirect_url = VSHARE_URL . '/admin/tags_disabled.php';
    Http::redirect($redirect_url);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/tags_disabled.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
