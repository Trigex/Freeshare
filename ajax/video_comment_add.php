<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_video_comment_add.php';

$comments_value = isset($_POST['comments_value']) ? $_POST['comments_value'] : '';
$video_id = isset($_POST['video_id']) ? (int) $_POST['video_id'] : '';

if (get_magic_quotes_gpc()) {
	$comments_value = stripslashes($comments_value);
}

$comments_value = Xss::clean($comments_value);
$comments_value = nl2br($comments_value);

if (! is_numeric($video_id)) {
    $err = $lang['vid_invalid'];
} else if (! isset($_SESSION['UID'])) {
    $err = $lang['guest'];
} else if (empty($comments_value)) {
    $err = $lang['comment_value_empty'];
}

if (! empty($err)) {
    echo $err;
    exit();
}

$sql = "SELECT * FROM `words`";
$words_all = DB::fetch($sql);

foreach ($words_all as $row) {
    $word = $row['word'];
    $replacement = $row['replacement'];
    if (preg_match("/$word/i", $comments_value)) {
        if ($replacement == '') {
            $word_length = mb_strlen($word, 'UTF-8');
            $replacement = str_repeat('*', $word_length);
        }
        $comments_value = str_replace($word, $replacement, $comments_value);
    }
}

$sql = "INSERT INTO `comments` SET
	   `comment_video_id`='" . (int) $video_id . "',
	   `comment_user_id`='" . (int) $_SESSION['UID'] . "',
	   `comment_text`='" . DB::quote($comments_value,1) . "',
	   `comment_add_time`='" . DB::quote($_SERVER['REQUEST_TIME']) . "'";
DB::query($sql);

if (DB::affectedRows() == 1) {

    $sql = "UPDATE `videos` SET
           `video_com_num`=`video_com_num`+1 WHERE
           `video_id`='" . (int) $video_id . "'";
    DB::query($sql);

    if (Config::get('video_comment_notify') == 1) {

        $sql = "SELECT * FROM `email_templates` WHERE
               `email_id`='video_comment_notify'";
        $mail_template = DB::fetch1($sql);

        $email_subject = $mail_template['email_subject'];
        $email_body = $mail_template["email_body"];
        $email_subject = str_replace("[SITE_NAME]", $config['site_name'], $email_subject);

        $sql = "SELECT v.video_title,v.video_seo_name,u.user_name,u.user_email FROM
               `videos` AS `v`, `users` AS `u` WHERE
                v.video_id='" . (int) $video_id . "' AND
                v.video_user_id=u.user_id";
        $video_user_info = DB::fetch1($sql);

        $video_url = VSHARE_URL . '/view/' . $video_id . '/' . $video_user_info['video_seo_name'] . '/';

        $email_body = str_replace('[VIDEO_OWNER_NAME]', $video_user_info['user_name'], $email_body);
        $email_body = str_replace('[COMMENT_USER_NAME]', $_SESSION['USERNAME'], $email_body);
        $email_body = str_replace('[SITE_NAME]', $config['site_name'], $email_body);
        $email_body = str_replace('[SITE_URL]', VSHARE_URL, $email_body);
        $email_body = str_replace('[VIDEO_URL]', $video_url, $email_body);
        $email_body = str_replace('[VIDEO_TITLE]', $video_user_info['video_title'], $email_body);

        $mail_details = array();
        $mail_details['from_email'] = $config['admin_email'];
        $mail_details['from_name'] = $config['site_name'];
        $mail_details['to_email'] = $video_user_info['user_email'];
        $mail_details['to_name'] = $video_user_info['user_name'];
        $mail_details['subject'] = $email_subject;
        $mail_details['body'] = $email_body;
        $mail = new Mail();
        $mail->send($mail_details);
    }
}

echo $lang['comment_posted'];
DB::close();
