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
require '../include/language/' . LANG . '/admin/advertisement_edit.php';

Admin::auth();

if (isset($_POST['submit'])) {
    if ($_POST['advertisement_text'] == '') {
        $err = $lang['advt_code_empty'];
    } else {
        $sql = "UPDATE `adv` SET
               `adv_text`='" . DB::quote($_POST['advertisement_text']) . "' WHERE
               `adv_id`='" . (int) $_GET['adv_id'] . "'";
        DB::query($sql);
        $msg = $lang['advt_saved'];
    }
}

$advertisement_id = isset($_GET['adv_id']) ? $_GET['adv_id'] : 0;

$sql = "SELECT * FROM `adv` WHERE
       `adv_id`='" . (int) $advertisement_id . "'";
$advertisement_info = DB::fetch1($sql);

$smarty->assign('advertisement_info', $advertisement_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/advertisement_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
