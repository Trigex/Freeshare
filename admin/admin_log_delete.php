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

if (isset($_POST['submit'])) {
    for ($i = 0; $i < count($_POST['delete_log']); $i ++) {
        $sql = "DELETE FROM `admin_log` WHERE
			   `admin_log_id`='" . (int) $_POST['delete_log'][$i] . "'";
        DB::query($sql);
    }
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if (isset($_GET['delete_all'])) {
    $sql = "DELETE FROM `admin_log`";
    DB::query($sql);
    $page = 1;
}

DB::close();

if ($page < 1) {
    $page = 1;
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$redirect_url = VSHARE_URL . '/admin/admin_log.php?page=' . $page . '&sort=' . $sort;
Http::redirect($redirect_url);
