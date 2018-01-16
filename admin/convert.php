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
require '../include/language/' . LANG . '/admin/convert.php';

Admin::auth();

$qid = $_GET['id'];

if (! is_numeric($qid)) {
    echo $lang['id_not_numeric'];
    exit();
}

$re_convert = isset($_GET['reconvert']) ? $_GET['reconvert'] : 0;

if ($re_convert == 1) {
    $sql = "UPDATE `process_queue` SET
           `status`='2' WHERE
           `id`='" . (int) $qid . "'";
    DB::query($sql);
}

ob_start();
$video_id = Upload::processVideo($qid, 1);
$debug_log = ob_get_contents();
ob_end_clean();

DB::close();

$smarty->display('admin/header.tpl');
echo $debug_log;
echo "<p><a href=\"javascript:history.go(-1)\">Back</a></p>";
