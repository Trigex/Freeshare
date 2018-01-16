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

$result_per_page = 50;

if (isset($_GET['action'])) {

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    if ($page < 1) {
        $page = 1;
    }

    $items_per_page = isset($_GET['items_per_page']) ? (int) $_GET['items_per_page'] : $result_per_page;

    if ($items_per_page < 1) {
    	$items_per_page = $result_per_page;
    }

    $start = ($page - 1) * $items_per_page;
    $page ++;

    if ($_GET['action'] == 'update_video_counts') {

        $sql = "SELECT * FROM `users` WHERE
               `user_account_status`='Active' AND
               `user_email_verified`='Yes'
                ORDER BY `user_id` ASC
                LIMIT $start, $items_per_page";
        $users_all = DB::fetch($sql);

        if ($users_all) {

            echo '<strong>Video Counts Updating...</strong>';

            foreach ($users_all as $user_info) {

                $sql = "SELECT COUNT(*) AS `total` FROM `videos` WHERE
                       `video_user_id`='" . (int) $user_info['user_id'] . "' AND
                       `video_active`='1' AND
                       `video_approve`='1'";
                $num_user_videos = DB::getTotal($sql);

                $sql = "UPDATE `users` SET `user_videos`='" . (int) $num_user_videos . "' WHERE
                       `user_id`='" . (int) $user_info['user_id'] . "'";
                DB::query($sql);

                echo '<p>User ' . $user_info['user_name'] . ' have ' . $num_user_videos . ' videos.</p>';
            }

            echo '<meta http-equiv="refresh" content="3;url=' . VSHARE_URL . '/admin/update_counters.php?action=update_video_counts&items_per_page=' . $items_per_page . '&page=' . $page . '">';
        } else {
            set_message('Video Counts Updated Successfully');
            $redirect_url = VSHARE_URL . '/admin/update_counters.php';
            Http::redirect($redirect_url);
        }
    } else if ($_GET['action'] == 'update_video_comments_count') {

        $sql = "SELECT * FROM `videos` WHERE
               `video_user_id`!='0' AND
               `video_active`='1' AND
               `video_approve`='1'
                ORDER BY `video_id` ASC
                LIMIT $start, $items_per_page";
        $video_all = DB::fetch($sql);

        if (! $video_all) {
            set_message('Video Comments Count Updated Successfully');
            $redirect_url = VSHARE_URL . '/admin/update_counters.php';
            Http::redirect($redirect_url);
        }

        echo '<strong>Video Comments Count Updating...</strong>';

        foreach ($video_all as $video_info) {
            $sql = "SELECT COUNT(*) AS `total` FROM `comments` WHERE
                   `comment_video_id`='" . (int) $video_info['video_id'] . "'";
            $num_video_comments = DB::getTotal($sql);

            $sql = "UPDATE `videos` SET
                   `video_com_num`='" . (int) $num_video_comments . "' WHERE
                   `video_id`='" . (int) $video_info['video_id'] . "'";
            DB::query($sql);
            echo '<p>Video with ID ' . $video_info['video_id'] . ' have ' . $num_video_comments . ' comments.</p>';
        }

        echo '<meta http-equiv="refresh" content="3;url=' . VSHARE_URL . '/admin/update_counters.php?action=update_video_comments_count&items_per_page=' . $items_per_page . '&page=' . $page . '">';
    }
} else {
    $smarty->assign('result_per_page', $result_per_page);
    $smarty->assign('err', $err);
    $smarty->assign('msg', $msg);
    $smarty->display('admin/header.tpl');
    $smarty->display('admin/update_counters.tpl');
    $smarty->display('admin/footer.tpl');
}

DB::close();
