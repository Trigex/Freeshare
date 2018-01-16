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
require 'include/settings/upload.php';
require 'include/language/' . LANG . '/lang_video_response.php';

User::is_logged_in();

$video_response_added = 0;

$video_info = Video::getById($_GET['vid']);

if (! $video_info || $video_info['video_active'] != 1 || $video_info['video_approve'] != 1) {
    Http::redirect(VSHARE_URL . '/');
}

$video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];

$smarty->assign('video_info', $video_info);

if (isset($_POST['submit'])) {

    $sql = "DELETE FROM `video_responses` WHERE
           `video_response_video_id`='" . (int) $_POST['video_response_video_id'] . "'";
    DB::query($sql);

    $sql = "INSERT INTO `video_responses` SET
           `video_response_video_id`='" . (int) $_POST['video_response_video_id'] . "',
           `video_response_to_video_id`='" . (int) $_POST['video_response_to_video_id'] . "',
           `video_response_add_time`='" . (int) $_SERVER['REQUEST_TIME'] . "'";
    DB::query($sql);

    $response_video_info = Video::getById($_POST['video_response_video_id']);

    $data1 = 'VIDEO_RESPONSE' . $response_video_info['video_id'];
    $data2 = $video_info['video_id'];

    $vkey = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
    $vkey = md5($vkey);

    $sql = "INSERT INTO `verify_code` SET
           `vkey`='" . DB::quote($vkey) . "',
           `data1`='" . DB::quote($data1) . "',
           `data2`='" . (int) $data2 . "'";
    $verify_id = DB::insertGetId($sql);

    $sql = "SELECT * FROM `email_templates` WHERE
           `email_id`='video_response_notify'";
    $tmp = DB::fetch1($sql);

    $email_subject = $tmp['email_subject'];
    $email_body_tmp = $tmp['email_body'];

    $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);
    $email_subject = str_replace('[VIDEO_TITLE]', $video_info['video_title'], $email_subject);

    $video_url = VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/';
    $response_video_url = VSHARE_URL . '/view/' . $response_video_info['video_id'] . '/' . $response_video_info['video_seo_name'] . '/';
    $verify_link = VSHARE_URL . '/verify/response/' . $response_video_info['video_id'] . '/' . $verify_id . '/' . $vkey . '/';

    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
    $email_body_tmp = str_replace('[USERNAME]', $_SESSION['USERNAME'], $email_body_tmp);
    $email_body_tmp = str_replace('[VIDEO_URL]', $video_url, $email_body_tmp);
    $email_body_tmp = str_replace('[VIDEO_TITLE]', $video_info['video_title'], $email_body_tmp);
    $email_body_tmp = str_replace('[RESPONSE_VIDEO_URL]', $response_video_url, $email_body_tmp);
    $email_body_tmp = str_replace('[RESPONSE_VIDEO_TITLE]', $response_video_info['video_title'], $email_body_tmp);
    $email_body_tmp = str_replace('[VERIFY_LINK]', $verify_link, $email_body_tmp);

    $video_owner_info = User::getById($video_info['video_user_id']);

    $headers = "From: $config[site_name] <$config[admin_email]> \n";
    $headers .= "Content-Type: text/html\n";

    $email = array();
    $email['from_email'] = $config['admin_email'];
    $email['from_name'] = $config['site_name'];
    $email['to_email'] = $video_owner_info['user_email'];
    $email['to_name'] = $video_owner_info['user_name'];
    $email['subject'] = $email_subject;
    $email['body'] = $email_body_tmp;
    $mail = new Mail();
    $mail->send($email);

    $video_response_added = 1;
}

if ($video_response_added == 0) {

    $sql = "SELECT * FROM `videos` WHERE
           `video_id`!='" . (int) $_GET['vid'] . "' AND
           `video_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `video_active`='1' AND
           `video_approve`='1'
            ORDER BY `video_id` DESC";
    $user_videos_all = DB::fetch($sql);

    if ($user_videos_all) {

        foreach ($user_videos_all as $video) {

            $video['video_already_response'] = 0;

            $sql = "SELECT * FROM `video_responses` WHERE
                  `video_response_video_id`='" . (int) $video['video_id'] . "'";
            $video_responses_all = DB::fetch($sql);

            $duplicate_video = 0;

            if ($video_responses_all) {
                foreach ($video_responses_all as $tmp_info) {
                    if ($tmp_info['video_response_video_id'] == $video['video_id']) {
                        $video['video_already_response'] = 1;
                    }

                    if ($tmp_info['video_response_to_video_id'] == $_GET['vid']) {
                        $duplicate_video = 1;
                    }
                }
            }

            if ($duplicate_video == 0) {
                $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
                $user_videos[] = $video;
            }
        }

        $smarty->assign('user_videos', $user_videos);
    }
}

$smarty->assign('video_response_added', $video_response_added);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('upload_video_response.tpl');
$smarty->display('footer.tpl');
DB::close();
