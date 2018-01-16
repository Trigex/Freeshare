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

$server_id = isset($_GET['server_id']) ? $_GET['server_id'] : '';

$sql = "SELECT * FROM `servers` WHERE
       `id`='" . (int) $server_id . "'";
$server_info = DB::fetch1($sql);

if ($server_info) {
    if ($server_info['status'] == 1) {
        $new_status = 0;
        $enabled_or_disabled = 'Disabled';
    } else {
        $new_status = 1;
        $enabled_or_disabled = 'Enabled';
    }

    $sql = "UPDATE `servers` SET
           `status`='" . (int) $new_status . "' WHERE
           `id`='" . (int) $server_id . "'";
    DB::query($sql);

    $msg = 'Server ' . $server_info['url'] . ' ' . $enabled_or_disabled;
    set_message($msg, 'success');
} else {
    set_message('Invalid server id', 'error');
}

DB::close();
$redirect_url = VSHARE_URL . '/admin/server_manage.php';
Http::redirect($redirect_url);
