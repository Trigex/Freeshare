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
require 'include/language/' . LANG . '/lang_invite_members.php';

User::is_logged_in();

$_GET['group_url'] = htmlspecialchars_uni($_GET['group_url']);

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($_GET['group_url']) . "'";
$group_info = DB::fetch1($sql);

if (! $group_info)
{
    Http::redirect(VSHARE_URL . '/groups.php');
}

$smarty->assign('group_info', $group_info);

$sql = "SELECT * FROM `group_members` WHERE
       `group_member_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
       `group_member_approved`='yes'";
$group_member = DB::fetch1($sql);

if ($group_member)
{
    if ($group_info['group_type'] == 'public' || $group_info['group_type'] == 'protected' || $group_info['group_owner_id'] == $_SESSION['UID'])
    {
        $allow_invite = 1;
    }
    else
    {
        $allow_invite = 0;
    }
}
else
{
    $allow_invite = 0;
}

$smarty->assign('allow_invite', $allow_invite);

if (isset($_POST['send']) && $allow_invite == 1)
{
    $sql = "SELECT `user_name`, `user_first_name`, `user_last_name` FROM `users` WHERE
           `user_id`='" . (int) $_SESSION['UID'] . "'";
    $sender_info = DB::fetch1($sql);

    $message = htmlspecialchars_uni($_POST['message']);
    $message = nl2br($message);
    $smarty->assign('message', $message);

    if ($_POST['flist'][0] == '' && $_POST['recipients'] == '')
    {
        $err = $lang['to_email_null'];
    }
    else if ($message == '')
    {
        $err = $lang['invite_msg_null'];
    }
    else
    {
        $user_daily_mail_limit = Config::get('user_daily_mail_limit');

        $sql = "SELECT count(*) AS `total` FROM `mail_logs` WHERE
               `mail_log_user_id`='" . (int) $_SESSION['UID'] . "'";
        $user_mail_today = DB::getTotal($sql);

        if ($sender_info['user_first_name'] == '')
        {
            $sender_name = $sender_info['user_name'];
        }
        else
        {
            $sender_name = $sender_info['user_first_name'] . ' ' . $sender_info['user_last_name'];
        }

        $group_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
        $sender_url = VSHARE_URL . '/' . $sender_info['user_name'];
        $from = $_SESSION['EMAIL'];

        $sql = "SELECT * FROM `email_templates` WHERE
               `email_id`='invite_group_email'";
        $email_info = DB::fetch1($sql);
        $subj = $email_info['email_subject'];
        $email_subj = str_replace('[SENDER_NAME]', $sender_name, $subj);
        $email_subj = str_replace('[GROUP_NAME]', $group_info['group_name'], $email_subj);
        $email_body = $email_info['email_body'];

        if (count($_POST['flist']) > 0)
        {
            for ($i = 0; $i < count($_POST['flist']); $i ++)
            {
                $sql = "SELECT * FROM `users` WHERE
                        `user_name`='" . DB::quote($_POST['flist'][$i]) . "'";
                $user_info = DB::fetch1($sql);
                $count = count($user_info);

                $key = time() . rand(1, 99999999);
                $key = md5($key);
                $sql = "INSERT INTO `verify_code` SET
                       `vkey`='" . DB::quote($key) . "',
                       `data1`='" . (int) $group_info['group_id'] . "'";
                DB::query($sql);

                if ($count > 0)
                {
                    $user_mail_today ++;

                    if ($user_mail_today > $user_daily_mail_limit)
                    {
                        $msg .= $lang['email_limit_exceeded'];
                        break;
                    }

                    $sql = "INSERT INTO `mail_logs` SET
                           `mail_log_user_id`='" . (int) $_SESSION['UID'] . "',
                           `mail_log_time`='" . time() . "'";
                    DB::query($sql);

                    $email_body_tmp = $email_body;
                    $verify_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/join/' . $key . '/';

                    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
                    $email_body_tmp = str_replace('[RECEIVER_NAME]', $_POST['flist'][$i], $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
                    $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_URL]', $group_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_NAME]', $group_info['group_name'], $email_body_tmp);

                    $sql = "INSERT INTO `mails` SET
                           `mail_subject`='" . DB::quote($email_subj) . "',
                           `mail_body`='" . DB::quote($email_body_tmp) . "',
                           `mail_sender`='" . DB::quote($_SESSION['USERNAME']) . "',
                           `mail_receiver`='" . DB::quote($_POST['flist'][$i]) . "',
                           `mail_date`='" . date("Y-m-d H:i:s") . "'";
                    DB::query($sql);

                    $sql = "SELECT * FROM `buddy_list` WHERE
                           `user_name`='" . DB::quote($_SESSION['USERNAME']) . "' AND
                           `buddy_name`='" . DB::quote($_POST['flist'][$i]) . "'";
                    $buddy = DB::fetch1($sql);

                    if ($buddy)
                    {
                        $sql = "INSERT INTO `buddy_list` SET
                               `user_name`='" . DB::quote($_SESSION['USERNAME']) . "',
                               `buddy_name`='" . DB::quote($_POST['flist'][$i]) . "'";
                        DB::query($sql);
                    }
                }

                $email = array();
                $email['from_email'] = $from;
                $email['from_name'] = $_SESSION['USERNAME'];
                $email['to_email'] = $user_info['user_email'];
                $email['to_name'] = '';
                $email['subject'] = $email_subj;
                $email['body'] = $email_body_tmp;
                $mail = new Mail();
                $mail->send($email);
            }
        }

        if ($_POST['recipients'])
        {
            $emails = htmlspecialchars_uni($_POST['recipients']);
            $emails = explode(',', $emails);

            for ($i = 0; $i < count($emails); $i ++)
            {
                if (Validate::email($emails[$i]))
                {
                    $user_mail_today ++;

                    if ($user_mail_today > $user_daily_mail_limit)
                    {
                        $msg .= $lang['email_limit_exceeded'];
                        break;
                    }

                    $sql = "INSERT INTO `mail_logs` SET
                           `mail_log_user_id`='" . (int) $_SESSION['UID'] . "',
                           `mail_log_time`='" . time() . "'";
                    DB::query($sql);

                    $key = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                    $sql = "INSERT INTO `verify_code` SET
                       `vkey`='" . DB::quote($key) . "',
                       `data1`='" . (int) $group_info['group_id'] . "'";
                    DB::query($sql);

                    $email_body_tmp = $email_body;
                    $verify_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/?key=' . $key;
                    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
                    $email_body_tmp = str_replace('[RECEIVER_NAME]', $emails[$i], $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
                    $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_NAME]', $group_info['group_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_URL]', $group_url, $email_body_tmp);

                    $email = array();
                    $email['from_email'] = $from;
                    $email['from_name'] = $_SESSION['USERNAME'];
                    $email['to_email'] = $emails[$i];
                    $email['to_name'] = '';
                    $email['subject'] = $email_subj;
                    $email['body'] = $email_body_tmp;
                    $mail = new Mail();
                    $mail->send($email);

                    $msg .= $emails[$i] . ' - ' . $lang['invite_sent'] . '<br />';
                }

            }
        }

        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/invite/';
        Http::redirect($redirect_url);
    }
}

$sql = "DELETE FROM `mail_logs` WHERE
       `mail_log_time` < '" . strtotime("last day") . "'";
DB::query($sql);

$sql = "SELECT `user_first_name` FROM `users` WHERE
       `user_id`='" . (int) $_SESSION['UID'] . "'";
$fname_info = DB::fetch1($sql);
$first_name = $fname_info['user_first_name'];
$smarty->assign('first_name', $first_name);

$sql = "SELECT `friend_name`, `friend_friend_id` FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `friend_status`='Confirmed'";
$friends = DB::fetch($sql);

$fname = '';
$my_friends = '';

foreach ($friends as $friends_info)
{
    $my_friends[] = $friends_info['friend_name'];
    $fname .= "<option value=" . $friends_info['friend_name'] . ">" . $friends_info['friend_name'] . "</option>\n";
}

$smarty->assign('fname', $fname);
$smarty->assign('myfriends', $my_friends);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');
$smarty->display('invite_members.tpl');
$smarty->display('footer.tpl');
DB::close();
