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
require '../include/language/' . LANG . '/admin/tags_search.php';

Admin::auth();

if (isset($_POST['submit'])) {
    $search_tag = DB::quote($_POST['search_tag']);
    $sql = "SELECT * FROM `tags` WHERE
           `tag` like '%$search_tag%'";
    $tags_all = DB::fetch($sql);

    if ($tags_all) {
        $smarty->assign('tag', $tags_all);
    } else {
        $err = str_replace('[SEARCH_TAG]', $search_tag, $lang['tag_not_found']);
    }
}

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'Disable') {
        $active = 0;
    } else if ($_POST['action'] == 'Activate') {
        $active = 1;
    }

    $tag_id = $_POST['action_tag'];

    $sql = "UPDATE `tags` SET
           `active`=$active WHERE
           `id`=" . (int) $tag_id;
    DB::query($sql);

    $msg = 'Tag has been ' . $_POST['action'] . 'd.';

    $sql = "SELECT * FROM `tags` WHERE
           `id`='" . (int) $tag_id . "'";
    $tag = DB::fetch($sql);
    $smarty->assign('tag', $tag);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/tags_search.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
