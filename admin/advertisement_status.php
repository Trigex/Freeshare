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

$advertisement_id = isset($_GET['adv_id']) ? $_GET['adv_id'] : 0;

$sql = "SELECT * FROM `adv` WHERE
       `adv_id`='" . (int) $advertisement_id . "'";
$advertisement_info = DB::fetch1($sql);

if (! $advertisement_info) {
    $redirect_url = VSHARE_URL . '/admin/advertisements.php';
} else {
    if ($advertisement_info['adv_status'] == 'Active') {
        $new_adv_status = 'Inactive';
    } else {
        $new_adv_status = 'Active';
    }

    $sql = "UPDATE `adv` SET
           `adv_status`='" . $new_adv_status . "' WHERE
           `adv_id`='" . (int) $advertisement_id . "'";
    DB::query($sql);
    set_message('Advertisement status changed', 'success');
    $redirect_url = VSHARE_URL . '/admin/advertisements.php';
}

DB::close();
Http::redirect($redirect_url);
