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

$package_id = isset($_GET['package_id']) ? (int) $_GET['package_id'] : 0;

$sql = "SELECT * FROM `packages` WHERE
       `package_id`='$package_id'";
$package_info = DB::fetch1($sql);

if (! $package_info) {
    Http::redirect('packages.php');
}

$sql = "SELECT `UID` FROM `subscriber` WHERE
       `pack_id`='" . $package_info['package_id'] . "'";
$subscribers = DB::fetch($sql);
$user_ids = array();

foreach ($subscribers as $subscriber) {
    $user_ids[] = $subscriber['UID'];
}

array_unique($user_ids);
$subscriber_count = count($user_ids);

if (isset($_POST['submit'])) {
    if ($subscriber_count > 0) {
        foreach ($user_ids as $user_id) {
            $sql = "UPDATE `subscriber` SET
                   `pack_id`='" . (int) $_POST['package_id'] . "' WHERE
                   `UID`='" . $user_id . "'";
            DB::query($sql);
        }
    }

    $sql = "DELETE FROM `packages` WHERE
           `package_id`='" . $package_id . "'";
    DB::query($sql);

    set_message('Package has been deleted', 'success');
    Http::redirect('packages.php');
}

$sql = "SELECT * FROM `packages` WHERE
       `package_id`!='" . $package_info['package_id'] . "'
        ORDER BY `package_name` ASC";
$packages = DB::fetch($sql);

$smarty->assign('package_info', $package_info);
$smarty->assign('packages', $packages);
$smarty->assign('subscriber_count', $subscriber_count);
$smarty->display('admin/header.tpl');
$smarty->display('admin/package_delete.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
