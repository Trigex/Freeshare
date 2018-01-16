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

if (isset($_GET['editor'])) {
    $editor = $_GET['editor'];
    $editor_value = Config::get($editor);
    $editor_value = ($editor_value == 1) ? 0 : 1;
    $sql = "UPDATE `config` SET `config_value`='$editor_value' WHERE
           `config_name`='$editor'";
    DB::query($sql);
}

DB::close();

$referrer  = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$redirect_url = ($referrer == '') ? VSHARE_URL . '/admin' : $referrer;

Http::redirect($redirect_url);
