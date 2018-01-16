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
require '../include/language/' . LANG . '/admin/package_add.php';

Admin::auth();

if (isset($_POST['add_package'])) {
    if ($_POST['pack_name'] == '') {
        $err = $lang['package_name_empty'];
    } else if ($_POST['pack_desc'] == '') {
        $err = $lang['package_description_empty'];
    } else if ($_POST['space'] == '') {
        $err = $lang['package_space_empty'];
    } else if ($_POST['price'] == '') {
        $err = $lang['package_price_empty'];
    }

    if ($err == '') {
        $sql = "INSERT INTO `packages` SET
               `package_name`='" . DB::quote($_POST['pack_name']) . "',
               `package_description`='" . DB::quote($_POST['pack_desc']) . "',
               `package_space`='" . DB::quote($_POST['space']) . "',
               `package_price`='" . DB::quote($_POST['price']) . "',
               `package_videos`='" . DB::quote($_POST['video_limit']) . "',
               `package_period`='" . DB::quote($_POST['period']) . "',
               `package_status`='" . DB::quote($_POST['status']) . "'";
        DB::query($sql);
    }

    if ($err == '') {
        set_message($lang['package_added'], 'success');
        $redirect_url = VSHARE_URL . '/admin/packages.php';
        Http::redirect($redirect_url);
    }
}

$period_ops = "
<option value='Month'>Month</option>
<option value='Year'>Year</option>";

$status_ops = "
<option value='Active'>Active</option>
<option value='Inactive'>Inactive</option>";

$smarty->assign('period_ops', $period_ops);
$smarty->assign('status_ops', $status_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/package_add.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
