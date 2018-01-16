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
require '../include/language/' . LANG . '/admin/mail_users.php';

Admin::auth();

if (isset($_POST['submit'])) {

    if (get_magic_quotes_gpc()) {
        $_POST['htmlCode'] = stripslashes($_POST['htmlCode']);
        $_POST['subj'] = stripslashes($_POST['subj']);
    }

    $a = isset($_GET['a']) ? $_GET['a'] : '';

    if ($a == 'user') {
        if ($_POST['UID'] == "0" || $_POST['UID'] == '') {
            $err = $lang['select_user'];
        } else if ($_POST['subj'] == '') {
            $err = $lang['subject_null'];
        } else if ($_POST['htmlCode'] == '') {
            $err = $lang['message_null'];
        } else {

            if ($_POST['UID'] == 'All') {
                $sql = "SELECT * FROM `email_templates` WHERE
                       `email_id`='unsubscribe_admin_mail'";
                $email_template = DB::fetch1($sql);
                $mail_footer = $email_template['email_body'];

                $sql = "SELECT `user_id`, `user_name`, `user_email` FROM `users` WHERE
                       `user_account_status`='Active' AND
                       `user_subscribe_admin_mail`='1'";
                $users_all = DB::fetch($sql);

                foreach ($users_all as $user_info) {
                    $user_id = $user_info['user_id'];
                    $unsubscribe_id = md5(time() . $user_id . rand());
                    $data1 = 'UNSUBSCRIBE_' . $user_id;

                    $sql = "INSERT INTO `verify_code` SET
                           `vkey`='" . $unsubscribe_id . "',
                           `data1`='" . $data1 . "'";
                    DB::query($sql);

                    $unsubscribe_url = VSHARE_URL . '/' . $user_info['user_name'] . '/unsubscribe/' . $unsubscribe_id;

                    $mail_footer_tmp = $mail_footer;
                    $mail_footer_tmp = str_replace('[SITE_NAME]', $config['site_name'], $mail_footer_tmp);
                    $mail_footer_tmp = str_replace('[SITE_URL]', VSHARE_URL, $mail_footer_tmp);
                    $mail_footer_tmp = str_replace('[UNSUBSCRIBE_URL]', $unsubscribe_url, $mail_footer_tmp);

                    $htmlCode = $_POST['htmlCode'];
                    $htmlCode .= $mail_footer_tmp;

                    mail2user($user_info['user_email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $htmlCode, $unsubscribe_url);
                }

                set_message($lang['mail_all_ok'], 'success');
                $redirect_url = VSHARE_URL . '/admin/mail_users.php?a=user';
                Http::redirect($redirect_url);

            } else {

                $user_info = User::getById($_POST['UID']);
                mail2user($user_info['user_email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $_POST['htmlCode']);
                $msg = str_replace('[USERNAME]', $user_info['user_name'], $lang['mail_user_ok']);
                set_message($msg, 'success');
                $redirect_url = VSHARE_URL . '/admin/mail_users.php?a=user';
                Http::redirect($redirect_url);
            }
        }

    } else if ($a == 'group') {

        if (isset($_POST['GID']) && $_POST['GID'] == '0' || $_POST['GID'] == '') {
            $err = $lang['select_group'];
        } else if ($_POST['subj'] == '') {
            $err = $lang['subject_null'];
        } else if ($_POST['htmlCode'] == '') {
            $err = $lang['message_null'];
        } else {
            $sql = "SELECT `group_name` FROM `groups` WHERE
                   `group_id`='" . (int) $_POST['GID'] . "'";
            $tmp = DB::fetch1($sql);
            $group_name = $tmp['group_name'];

            $sql = "SELECT `group_member_user_id` FROM `group_members` WHERE
                   `group_member_group_id`='" . (int) $_POST['GID'] . "'";
            $result = DB::fetch($sql);

            foreach ($result as $tmp) {
                $member_ids[] = $tmp['group_member_user_id'];
            }

            $sql = "SELECT * FROM `users` WHERE
                   `user_id` in (" . implode(', ', $member_ids) . ")";
            $users_all = DB::fetch($sql);

            foreach ($users_all as $user_info) {
                mail2user($user_info['user_email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $_POST['htmlCode']);
            }

            $msg = str_replace("[GROUPNAME]", $group_name, $lang['mail_group_ok']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/mail_users.php?a=group';
            Http::redirect($redirect_url);
        }
    }
    else
    {
        if ($_POST['email'] == '') {
            $err = $lang['email_null'];
        } else if (! Validate::email($_POST['email'])) {
            $err = $lang['email_invalid'];
        } else if ($_POST['subj'] == '') {
            $err = $lang['subject_null'];
        } else if ($_POST['htmlCode'] == '') {
            $err = $lang['message_null'];
        }

        if ($err == '') {
            mail2user($_POST['email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $_POST['htmlCode']);
            $msg = str_replace("[EMAIL]", $_POST['email'], $lang['mail_ok']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/mail_users.php?email=' . $email . '&uname=' . $uname;
            Http::redirect($redirect_url);
        }
    }
}

if (isset($_GET['a']) && $_GET['a'] == 'group') {

    $sql = "SELECT `group_id`, `group_name` FROM `groups` ORDER BY `group_name`";
    $groups_all = DB::fetch($sql);

    $group_ops = "<option value='0'>-- Select a group --</option>";

    foreach ($groups_all as $group_info) {
        if (isset($_POST['GID']) && $_POST['GID'] == $group_info['group_id']) {
            $sel = "selected";
        } else {
            $sel = "";
        }

        $group_ops .= "<option value='" . $group_info['group_id'] . "' $sel>" . $group_info['group_name'] . "</option>";
    }

    $smarty->assign('group_ops', $group_ops);
}

function mail2user($email, $site_name, $admin_email, $subj, $htmlCode, $unsubscribe_url = '')
{
    $mail_detailes = array();
    $mail_detailes['from_email'] = $admin_email;
    $mail_detailes['from_name'] = $site_name;
    $mail_detailes['to_email'] = $email;
    $mail_detailes['to_name'] = "";
    $mail_detailes['subject'] = $subj;
    $mail_detailes['body'] = $htmlCode;
    $mail_detailes['unsubscribe_url'] = $unsubscribe_url;
    $mail = new Mail();
    $mail->send($mail_detailes);
}

$smarty->assign('editor_wysiwyg_email', Config::get('editor_wysiwyg_email'));
$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/mail_users.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
