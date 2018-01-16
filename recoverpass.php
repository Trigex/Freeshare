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
require 'include/language/' . LANG . '/lang_recoverpass.php';

$mail_send = 0;

if (isset($_POST['recover'])) {

    $user_name = isset($_POST['username']) ? $_POST['username'] : '';
    $user_email = isset($_POST['email']) ? $_POST['email'] : '';
    $user_name = htmlspecialchars_uni($user_name);
    $user_email = htmlspecialchars_uni($user_email);

    if (($user_email == '') && ($user_name == '')) {
        $err = $lang['fields_null'];
    } else {
        if ($user_name != '') {
            if (check_field_exists($user_name, 'user_name', 'users') == 1) {
                $query = " WHERE `user_name`='" . DB::quote($user_name) . "'";
            } else {
                $err = $lang['user_name_not_found'];
            }
        } else if ($user_email != '') {
            if (Validate::email($user_email)) {
                if (check_field_exists($user_email, 'user_email', 'users') == 1) {
                    $query = " WHERE `user_email`='" . DB::quote($user_email) . "'";
                } else {
                    $err = $lang['email_not_found'];
                }
            } else {
                $err = $lang['email_invalid'];
            }
        }

        if ($err == '') {
            $sql = "SELECT * FROM `users`" . $query;
            $user_info = DB::fetch1($sql);

            $uid = $user_info['user_id'];
            $user_email = $user_info['user_email'];

            $data1 = 'PWD_RESET' . $uid;
            $sql = "SELECT * FROM `verify_code` WHERE
                   `data1`='" . DB::quote($data1) . "'";
            $verify_info = DB::fetch1($sql);

            if ($verify_info) {
                $verify_id = $verify_info['id'];
                $verify_vkey = $verify_info['vkey'];
                $new_password = $verify_info['data2'];
            } else {
                $new_password = password_generator(6);
                $verify_vkey = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                $verify_vkey = md5($verify_vkey);
                $sql = "INSERT INTO `verify_code` SET
                       `vkey`='" . DB::quote($verify_vkey) . "',
                       `data1`='" . DB::quote($data1) . "',
                       `data2`='" . DB::quote($new_password) . "'";
                $verify_id = DB::insertGetId($sql);
            }

            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='recover_password'";
            $email_templates = DB::fetch1($sql);

            $email_subject = $email_templates['email_subject'];
            $email_body = $email_templates['email_body'];
            $verify_url = VSHARE_URL . '/reset_password.php?k=' . $verify_vkey . '&i=' . $verify_id . '&u=' . $uid;

            $email_body_tmp = $email_body;
            $email_body_tmp = str_replace('[RECEIVER_NAME]', $user_info['user_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[PASSWORD]', $new_password, $email_body_tmp);
            $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[USER_IP]', $_SERVER['REMOTE_ADDR'], $email_body_tmp);
            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);

            $mail_detailes = array();
            $mail_detailes['from_email'] = $config['admin_email'];
            $mail_detailes['from_name'] = $config['site_name'];
            $mail_detailes['to_email'] = $user_email;
            $mail_detailes['to_name'] = '';
            $mail_detailes['subject'] = $email_subject;
            $mail_detailes['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($mail_detailes);
            $mail_send = 1;
            $msg = $lang['mail_send'];
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('html_title', 'Lost Password Recovery Form');
$smarty->display('header.tpl');
if (! $mail_send) $smarty->display('recoverpass.tpl');
$smarty->display('footer.tpl');
DB::close();
