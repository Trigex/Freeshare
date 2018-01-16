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

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$episode_info = Episode::getById($id);

if (isset($_POST['submit'])) {
    $episode_name = trim($_POST['episode_name']);

    if (empty($episode_name)) {
        $err = 'Episode name must not empty.';
    } else {
        if (Episode::exists($episode_name, $id)) {
            $err = 'An episode already exist with name ' . $episode_name . '.';
        } else {
            $sql = "UPDATE `episodes` SET
                   `episode_name`='" . DB::quote($episode_name) . "' WHERE
                   `episode_id`='" . $id . "'";
            DB::query($sql);
            DB::close();

            set_message('Episode name updated.', 'success');
            Http::redirect('episodes.php');
        }
    }
}

$smarty->assign(array(
    'episode_info' => $episode_info,
    'err' => $err,
));
$smarty->display('admin/header.tpl');
$smarty->display('admin/episode_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
