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
require 'include/language/' . LANG . '/lang_invite_friends.php';

User::is_logged_in();

if (isset($_GET['UID']) && ($_GET['UID'] == $_SESSION['UID'])) {
    set_message($lang['invite_self'], 'success');
    $redirect_url = VSHARE_URL . '/friends.php';
    Http::redirect($redirect_url);
}

if (isset($_POST['submit'])) {

    $first_name = htmlspecialchars_uni($_POST['first_name']);
    $recipients = htmlspecialchars_uni($_POST['recipients']);
    $message = htmlspecialchars_uni($_POST['message']);
    $smarty->assign('recipients', $recipients);

    if (isset($first_name) && (strlen($first_name) < 2)) {
        $err = $lang['invite_friends_name'];
    } else if (($recipients == '') && ($_POST['UID'] == '')) {
        $err = $lang['invite_friends_email'];
    } else {
        $user_daily_mail_limit = Config::get('user_daily_mail_limit');

        $sql = "SELECT count(*) AS `total` FROM `mail_logs` WHERE
               `mail_log_user_id`='" . (int) $_SESSION['UID'] . "'";
        $user_mail_today = DB::getTotal($sql);

        $sql = "UPDATE `users` SET
               `user_first_name`='" . DB::quote($first_name) . "' WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        DB::query($sql);

        $user_info = User::getById($_SESSION['UID']);

        $sender_name = $user_info['user_name'];
        $sender_fname = $user_info['user_first_name'];
        $sender_email = $user_info['user_email'];

        $sender_url = VSHARE_URL . '/' . $user_info['user_name'];

        $sql = "SELECT * FROM `email_templates` WHERE
               `email_id`='invite_friends'";
        $email_info = DB::fetch1($sql);

        $email_subject = $email_info['email_subject'];
        $email_body = $email_info['email_body'];
        $email_subject = str_replace('[SENDER_NAME]', $sender_name, $email_subject);

        $user_id = $_POST['UID'];
        $smarty->assign('user_id', $user_id);

        if ($user_id == '') {
            $recipients = str_replace(' ', ',', $recipients);
            $emails = explode(',', $recipients);

            for ($i = 0; $i < count($emails); $i ++) {
                $friend_email = trim($emails[$i]);

                if ($friend_email == '') {
                    continue;
                }

                if (! Validate::email($friend_email)) {
                    $msg .= $friend_email . ' - Invalid<br />';
                    continue;
                }

                $sql = "SELECT * FROM `friends` WHERE
                       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
                       `friend_name`='" . DB::quote($friend_email) . "'";
                $friend_already = DB::fetch1($sql);

                if ($friend_already) {
                    $msg .= $friend_email . ' - ' . $lang['invite_friends_duplicate'] . '<br />';
                } else {
                    $user_mail_today ++;

                    if ($user_mail_today > $user_daily_mail_limit) {
                        $msg .= $lang['email_limit_exceeded'];
                        break;
                    }

                    $sql = "INSERT INTO `mail_logs` SET
                           `mail_log_user_id`='" . (int) $_SESSION['UID'] . "',
                           `mail_log_time`='" . time() . "'";
                    DB::query($sql);

                    $sql = "INSERT INTO `friends` SET
                           `friend_user_id`='" . (int) $_SESSION['UID'] . "',
                           `friend_name`='" . DB::quote($friend_email) . "',
                           `friend_type`='All|Friends',
                           `friend_invite_date`='" . date("Y-m-d") . "'";
                    $id = DB::insertGetId($sql);
                    $key = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                    $sql = "INSERT INTO `verify_code` SET
                           `vkey`='" . DB::quote($key) . "',
                           `data1`='" . (int) $id . "'";
                    $id = DB::insertGetId($sql);
                    $verify_url = VSHARE_URL . '/confirm/friend/' . base64_encode($id) . '/' . $key;
                    $email_body_tmp = $email_body;
                    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
                    $email_body_tmp = str_replace('[RECEIVER_NAME]', $friend_email, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
                    $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
                    $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_FNAME]', $sender_fname, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);

                    $email = array();
                    $email['from_email'] = $sender_email;
                    $email['from_name'] = $sender_fname;
                    $email['to_email'] = $friend_email;
                    $email['to_name'] = '';
                    $email['subject'] = $email_subject;
                    $email['body'] = $email_body_tmp;
                    $mail = new Mail();
                    $mail->send($email);

                    $msg .= $friend_email . ' - ' . $lang['invite_friends_send'] . '<br />';
                }
            }
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/friends/invite/';
            Http::redirect($redirect_url);
        } else {
            $user_info = User::getById($user_id);
            $reciever_email = $user_info['user_email'];
            $reciever_name = $user_info['user_first_name'];
            if ($reciever_name == '') {
                $reciever_name = $user_info['user_name'];
            }

            $sql = "SELECT count(*) as `total` FROM `friends` WHERE
                   `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
                   `friend_friend_id`='" . (int) $user_id . "'";
            $already_friend = DB::getTotal($sql);

            if ($already_friend) {
                set_message($lang['invite_friends_duplicate'], 'success');
                $redirect_url = VSHARE_URL . '/friends/';
                Http::redirect($redirect_url);
            }

            $sql = "INSERT INTO `friends` SET
                   `friend_user_id`=" . (int) $_SESSION['UID'] . ",
                   `friend_friend_id`='" . (int) $user_id . "',
                   `friend_name`='" . DB::quote($user_info['user_name']) . "',
                   `friend_type`='All|Friends',
                   `friend_invite_date`='" . date("Y-m-d") . "'";
            $id = DB::insertGetId($sql);

            $key = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);

            $sql = "INSERT INTO `verify_code` SET
                   `vkey`='" . DB::quote($key) . "',
                   `data1`='" . (int) $id . "'";
            $id = DB::insertGetId($sql);

            $verify_url = VSHARE_URL . '/confirm/friend/' . base64_encode($id) . '/' . $key;

            $email_body_tmp = $email_body;
            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[RECEIVER_NAME]', $reciever_name, $email_body_tmp);
            $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
            $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
            $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
            $email_body_tmp = str_replace('[SENDER_FNAME]', $sender_fname, $email_body_tmp);
            $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);

            $sql = "INSERT INTO `mails` SET
                   `mail_subject`='" . DB::quote($email_subject) . "',
                   `mail_body`='" . DB::quote($email_body_tmp) . "',
                   `mail_sender`='" . DB::quote($_SESSION['USERNAME']) . "',
                   `mail_receiver`='" . DB::quote($user_info['user_name']) . "',
                   `mail_date`='" . date("Y-m-d H:i:s") . "'";
            DB::query($sql);

            $email = array();
            $email['from_email'] = $sender_email;
            $email['from_name'] = $sender_fname;
            $email['to_email'] = $reciever_email;
            $email['to_name'] = $reciever_name;
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);
            $msg = $lang['invite_friends_send'];
        }
    }
}

$sql = "DELETE FROM `mail_logs` WHERE
       `mail_log_time`<'" . strtotime("last day") . "'";
DB::query($sql);

$my_info = User::getById($_SESSION['UID']);

$smarty->assign('first_name', $my_info['user_first_name']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_friends.tpl');
$smarty->display('header.tpl');
$smarty->display('invite_friends.tpl');
$smarty->display('footer.tpl');
DB::close();
