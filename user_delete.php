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

$mail_send = 0;

if (isset($_SESSION['UID'])) {

    if (isset($_POST['submit'])) {

        $data1 = 'DELETE_USER';
        $data2 = $_SESSION['UID'];
        $sql = "SELECT * FROM `verify_code` WHERE
               `data1`='" . DB::quote($data1) . "' AND
               `data2`='" . (int) $data2 . "'";
        $verify_info = DB::fetch1($sql);

        if ($verify_info) {
            $verify_id = $verify_info['id'];
            $verify_key = $verify_info['vkey'];
        } else {
            $verify_key = time();
            $verify_key = md5($verify_key);
            $sql = "INSERT INTO `verify_code` SET
                   `vkey`='" . DB::quote($verify_key) . "',
                   `data1`='" . DB::quote($data1) . "',
                   `data2`='" . (int) $data2 . "'";
            $verify_id = DB::insertGetId($sql);
        }

        $sql = "SELECT * FROM `email_templates` WHERE
               `email_id`='delete_user'";
        $email_templates = DB::fetch1($sql);

        $email_subject = $email_templates['email_subject'];
        $email_subject = str_replace('[USERNAME]', $_SESSION['USERNAME'], $email_subject);
        $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);

        $verify_url = VSHARE_URL . '/user_delete_done.php?k=' . $verify_key . '&i=' . $verify_id;

        $email_body = $email_templates['email_body'];
        $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body);
        $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
        $email_body_tmp = str_replace('[USERNAME]', $_SESSION['USERNAME'], $email_body_tmp);
        $email_body_tmp = str_replace('[USER_IP]', $_SERVER['REMOTE_ADDR'], $email_body_tmp);
        $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);

        $mail_detailes = array();
        $mail_detailes['from_email'] = $config['admin_email'];
        $mail_detailes['from_name'] = $config['site_name'];
        $mail_detailes['to_email'] = $_SESSION['EMAIL'];
        $mail_detailes['to_name'] = $_SESSION['USERNAME'];
        $mail_detailes['subject'] = $email_subject;
        $mail_detailes['body'] = $email_body_tmp;
        $mail = new Mail();
        $mail->send($mail_detailes);
        $mail_send = 1;
    }
}

$smarty->assign('mail_send', $mail_send);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->assign('user', $tmp);
$smarty->display('user_delete.tpl');
$smarty->display('footer.tpl');
DB::close();
