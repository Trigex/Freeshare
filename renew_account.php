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
require 'include/language/' . LANG . '/lang_renew_account.php';

if ($config['enable_package'] == 'yes') {
    if (isset($_POST['submit'])) {
        $package_id = isset($_POST['package_id']) ? (int) $_POST['package_id'] : 0;

        $sql = "SELECT * FROM `packages` WHERE
               `package_id`='$package_id' AND
               `package_trial`='no'";
        $package_info = DB::fetch1($sql);

        if (! $package_info) {
            $err = $lang['select_package'];
        } else {

            if ($package_info['package_price'] == 0) {
                $subscribe_date = date('Y-m-d H:i:s', time());
                if ($package_info['package_trial'] == 'no') {
                    $expire_time = strtotime("+1 $package_info[package_period]");
                } else {
                    $expire_time = strtotime("+$package_info[package_trial_period] days");
                }
                $expire_date = date('Y-m-d H:i:s', $expire_time);
                $pack_id = $package_info['package_id'];

                $sql = "UPDATE `subscriber` SET `pack_id`='" . $package_info['package_id'] . "',
                       `subscribe_time`='$subscribe_date',
                       `expired_time`='$expire_date',
                       `used_space`='0',
                       `total_video`='0' WHERE
                       `UID`='" . (int) $_GET['uid'] . "'";
                DB::query($sql);

                set_message('Subscription has been upgraded.', 'success');
                Http::redirect(VSHARE_URL);
            }

            $redirect_url = VSHARE_URL . '/package_options.php?package_id=' . (int) $package_id . '&user_id=' . $_GET['uid'];
            Http::redirect($redirect_url);
        }
    }

    $sql = "SELECT * FROM `packages` WHERE
           `package_status`='Active' AND
           `package_trial`='no'
            ORDER BY `package_price` DESC";
    $package = DB::fetch($sql);
    $smarty->assign('package', $package);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('renew_account.tpl');
$smarty->display('footer.tpl');
DB::close();
