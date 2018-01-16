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

if (isset($_POST['user_ids'])) {
    foreach ($_POST['user_ids'] as $user_id) {
        activate_user($user_id);
    }
    set_message('Selected users have been activated.', 'success');
}

function activate_user($user_id) {
    global $config;

    $user_info = User::getById($user_id);

    if ($user_info) {
        $sql = "UPDATE `users` SET
               `user_account_status`='Active',
               `user_email_verified`='yes' WHERE
               `user_id`='$user_id'";
        DB::query($sql);

        if (DB::affectedRows()) {
            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='user_signup_verify_admin_active'";
            $email_template = DB::fetch1($sql);
            $email_subject = $email_template['email_subject'];
            $email_body_tmp = $email_template['email_body'];

            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);

            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[USERNAME]', $user_info['user_name'], $email_body_tmp);

            $headers = "From: $config[site_name] <$config[admin_email]> \n";
            $headers .= "Content-Type: text/html\n";

            $email = array();
            $email['from_email'] = $config['admin_email'];
            $email['from_name'] = $config['site_name'];
            $email['to_email'] = $user_info['user_email'];
            $email['to_name'] = $user_info['user_name'];
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);
        }
    }
}

DB::close();

if (isset($_SERVER['HTTP_REFERER'])) {
    $redirect_url = $_SERVER['HTTP_REFERER'];
} else {
    $redirect_url = VSHARE_URL . '/admin/users.php?a=Inactive';
}

Http::redirect($redirect_url);
