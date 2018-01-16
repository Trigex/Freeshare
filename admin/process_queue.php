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
require '../include/language/' . LANG . '/admin/process_queue.php';

Admin::auth();

$admin_listing_per_page = Config::get('admin_listing_per_page');

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `process_queue` WHERE
           `id`='" . (int) $id . "'";
    $tmp = DB::fetch1($sql);
    $sql = "DELETE FROM `process_queue` WHERE
           `id`='" . (int) $id . "'";
    DB::query($sql);

    $video_path = VSHARE_DIR . '/video/' . $tmp['file'];

    if (file_exists($video_path) && is_file($video_path)) {
        $vid = $tmp['vid'];
        if ($vid == 0) {
            unlink($video_path);
        }
    }
    $msg = $lang['process_q_deleted'];
}

if ((isset($_GET['action'])) && ($_GET['action'] == 'delete_all')) {
    $sql = "SELECT * FROM `process_queue`";
    $process_queue_all = DB::fetch($sql);

    foreach ($process_queue_all as $process_queue) {
        $video_path = VSHARE_DIR . '/video/' . $process_queue['file'];
        if (file_exists($video_path) && is_file($video_path)) {
            $vid = $process_queue['vid'];
            if ($vid == 0) {
                if (! unlink($video_path)) {
                    echo str_replace('[VIDEO_PATH]', $video_path, $lang['unable_to_delete']);
                    exit(0);
                }
            }
        }
    }

    $sql = "DELETE FROM  `process_queue`";
    DB::query($sql);
    $msg = $lang['process_q_deleted'];
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM
       `process_queue` AS p,
       `users` AS u WHERE
        p.user=u.user_name ORDER BY
       `status` ASC";
$total = DB::getTotal($sql);

$start = ($page - 1) * $admin_listing_per_page;

$links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

$sql = "SELECT * FROM
       `process_queue` AS p,
       `users` AS u WHERE
        p.user=u.user_name
        ORDER BY `id` DESC
        LIMIT $start, $admin_listing_per_page";
$process_queue_info = DB::fetch($sql);

$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('links', $links);
$smarty->assign('process_queue', $process_queue_info);
$smarty->display('admin/header.tpl');
$smarty->display('admin/process_queue.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
