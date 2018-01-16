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
require 'include/language/' . LANG . '/lang_signup.php';

$user_ip = User::get_ip();
$spam_filter = Config::get('spam_filter');

if ($spam_filter == 1) {
    if (Spam::isIPBanned($user_ip)) {
        require '404.php';
        exit();
    }
}

$signup_dob = Config::get('signup_dob');
$signup_enable = Config::get('signup_enable');

$captcha = new Captcha;
$captcha_enabled = $captcha->isEnabled();
$smarty->assign('captcha_html', $captcha->get());
$smarty->assign('captcha_enabled', $captcha_enabled);

$signup = array();

if ($signup_enable == 0) {
    $msg = $lang['signup_disable'];
}

$signup_verification_msg = '';

if (isset($_POST['submit'])) {

    if (get_magic_quotes_gpc()) {
        $_POST['password'] = stripslashes($_POST['password']);
        $_POST['password_confirm'] = stripslashes($_POST['password_confirm']);
    }

    $_POST['user_name'] = trim($_POST['user_name']);
    $signup['user_name'] = $_POST['user_name'] = htmlspecialchars_uni($_POST['user_name']);

    $signup['email'] = $_POST['email'] = htmlspecialchars_uni($_POST['email']);

    $_POST['security_code'] = isset($_POST['security_code']) ? $_POST['security_code'] : '';
    $_POST['security_code'] = htmlspecialchars_uni($_POST['security_code']);

    if ($_POST['email'] == '') {
        $err = $lang['email_null'];
    } else if (! Validate::email($_POST['email'])) {
        $err = $lang['email_invalid'];
    } else if (check_field_exists($_POST['email'], "user_email", "users") == 1) {
        $err = $lang['email_exist'];
    } else if ($_POST['user_name'] == '') {
        $err = $lang['user_name_null'];
    } else if (strlen($_POST['user_name']) < 4) {
        $err = $lang['user_name_short'];
    } else if ($_POST['password'] == '') {
        $err = $lang['password_null'];
    } else if (strlen($_POST['password']) < 4) {
        $err = $lang['password_short'];
    } else if ($_POST['password'] != $_POST['password_confirm']) {
        $err = $lang['password_not_match'];
    } else if (($config['enable_package'] == 'yes') and (! isset($_POST['pack_id']))) {
        $err = $lang['select_package'];
    } else if (! preg_match("/^[^\s\t]+$/", $_POST['user_name'])) {
        $err = $lang['user_name_invalid'];
    } else if (check_field_exists($_POST['user_name'], 'user_name', 'users') == 1) {
        $err = $lang['user_name_exist'];
    } else if (User::isReserved($_POST['user_name'])) {
        $err = $lang['user_name_reserved'];
    } else {
        if ($_POST['user_name'] != htmlspecialchars_uni($_POST['user_name'])) {
            $err = $lang['user_name_invalid'];
            $_POST['user_name'] = htmlspecialchars_uni($_POST['user_name']);
        } else {
            $invalid_user_name_chars = array();
            $invalid_user_name_chars[] = '/';
            $invalid_user_name_chars[] = '\\';
            $invalid_user_name_chars[] = '?';
            $invalid_user_name_chars[] = '@';
            $invalid_user_name_chars[] = '*';
            $invalid_user_name_chars[] = '[';
            $invalid_user_name_chars[] = ']';
            $invalid_user_name_chars[] = '(';
            $invalid_user_name_chars[] = ')';
            $invalid_user_name_chars[] = '{';
            $invalid_user_name_chars[] = '}';
            $invalid_user_name_chars[] = '<';
            $invalid_user_name_chars[] = '>';
            $invalid_user_name_chars[] = '-';
            $invalid_user_name_chars[] = '+';
            $invalid_user_name_chars[] = '=';
            $invalid_user_name_chars[] = '.';

            for ($i = 0; $i < count($invalid_user_name_chars); $i ++) {
                if (stristr($_POST['user_name'], "$invalid_user_name_chars[$i]")) {
                    $err = $lang['user_name_invalid'] . ' ( <span class="signup-invalid-char">' . $invalid_user_name_chars[$i] . '</span> )';
                    break;
                }
            }
        }
    }

    if ($captcha_enabled && $err == '') {
        $captcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
        if (! $captcha->validate($captcha_response)) {
            $err = $lang['captcha_invalid'];
        }
    }

    if ($signup_dob == 1 and $err == '') {
        $signup['year'] = $_POST['year'];
        $signup['month'] = $_POST['month'];
        $signup['day'] = $_POST['day'];

        $bdate = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
        if ($bdate == 'yyyy-mm-dd') {
            $err = $lang['signup_dob_null'];
        }

        $validate_date = Validate::date($_POST['month'], $_POST['day'], $_POST['year']);

        if ($validate_date != 1) {
            $err = $validate_date;
        } else {
            $signup_age_min_enforce = Config::get('signup_age_min_enforce');
            if ($signup_age_min_enforce == 1) {
                $age = User::findAge($bdate);
                $age_minimum = Config::get('signup_age_min');

                if ($age < $age_minimum) {
                    $err = str_replace('[AGE_MINIMUM]',$age_minimum,$lang['signup_enforce']);
    			}
    		}
        }
    }

    if ($err == '') {
        $request_password = $_POST['password'];
        $request_password = md5($request_password);

        $user_data = array(
            'user_email' => $_POST['email'],
            'user_name' => $_POST['user_name'],
            'user_password' => $request_password,
        );

        if ($signup_dob == 1) {
            $user_data['user_birth_date'] = $bdate;
        }

        $userid = User::create($user_data);

        if (! $userid) {
            echo 'Unable to get last insert ID';
            exit(0);
        }

        $auto_friend = Config::get('signup_auto_friend');

        if ((strlen($auto_friend) > 1) && (check_field_exists($auto_friend, 'user_name', 'users'))) {
            Friend::makeFriends($auto_friend, $_POST['user_name']);
        }

        $sql = "INSERT INTO `subscriber` SET `UID`='" . (int) $userid . "'";
        DB::query($sql);

        $paid_member = 0;

        if ($config['enable_package'] == 'yes') {
            $sql = "SELECT * FROM `packages` WHERE
                   `package_id`='" . (int) $_POST['pack_id'] . "'";
            $package_info = DB::fetch1($sql);

            if ($package_info['package_trial'] == 'yes') {
                $paid_member = 1;
            } else {
                $paid_member = 2;
            }
        }

        # send welcome mail

        if ($config['signup_verify'] == 0) {
            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='user_signup'";
            $email_template = DB::fetch1($sql);
            $email_subject = $email_template['email_subject'];
            $email_body_tmp = $email_template['email_body'];

            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);

            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[USERNAME]', $_POST['user_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[PASSWORD]', $_POST['password'], $email_body_tmp);

            $headers = "From: $config[site_name] <$config[admin_email]> \n";
            $headers .= "Content-Type: text/html\n";

            $email = array();
            $email['from_email'] = $config['admin_email'];
            $email['from_name'] = $config['site_name'];
            $email['to_email'] = $_POST["email"];
            $email['to_name'] = $_POST['user_name'];
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);

            $signup_verification_msg = $lang['signup_welcome'];

        } else if ($config['signup_verify'] == 1) {
            $sql = "UPDATE `users` SET
                   `user_account_status`='Inactive',
                   `user_email_verified`='no' WHERE
                   `user_id`='" . (int) $userid . "'";
            DB::query($sql);

            $password = $_POST['password'];
            $user_name = $_POST['user_name'];

            if ($paid_member == 2) {
                $email_template_name = 'user_signup';
                $verify_id = 0;
            } else {
                $email_template_name = 'user_signup_verify';

                $data1 = 'SIGNUP' . $userid;
                $vkey = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                $vkey = md5($vkey);

                $verify_code_data = array(
                    'vkey' => $vkey,
                    'data1' => $data1
                );

                $verify_id = VerifyCode::create($verify_code_data);
            }

            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='$email_template_name'";
            $email_template = DB::fetch1($sql);
            $email_subject = $email_template['email_subject'];
            $email_body_tmp = $email_template['email_body'];

            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);
            $email_subject = str_replace('[SITE_URL]', VSHARE_URL, $email_subject);

            if ($verify_id > 0) {
                $verify_link = VSHARE_URL . '/verify/user/' . $userid . '/' . $verify_id . '/' . $vkey . '/';
                $email_body_tmp = str_replace('[VERIFY_LINK]', $verify_link, $email_body_tmp);
            }

            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[USERNAME]', $user_name, $email_body_tmp);
            $email_body_tmp = str_replace('[PASSWORD]', $password, $email_body_tmp);

            $headers = "From: $config[site_name] <$config[admin_email]> \n";
            $headers .= "Content-Type: text/html\n";

            $email = array();
            $email['from_email'] = $config['admin_email'];
            $email['from_name'] = $config['site_name'];
            $email['to_email'] = $_POST["email"];
            $email['to_name'] = $user_name;
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);

            $signup_verification_msg = $lang['signup_verify_email'];

        } else if ($config['signup_verify'] == 2) {
            $sql = "UPDATE `users` SET
                   `user_account_status`='Inactive' WHERE
                   `user_id`='" . (int) $userid . "'";
            DB::query($sql);

            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='user_signup_verify_admin'";
            $email_template = DB::fetch1($sql);
            $email_subject = $email_template['email_subject'];
            $email_body_tmp = $email_template['email_body'];

            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);

            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[USERNAME]', $_POST['user_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[PASSWORD]', $_POST['password'], $email_body_tmp);

            $headers = "From: $config[site_name] <$config[admin_email]> \n";
            $headers .= "Content-Type: text/html\n";

            $email = array();
            $email['from_email'] = $config['admin_email'];
            $email['from_name'] = $config['site_name'];
            $email['to_email'] = $_POST["email"];
            $email['to_name'] = $_POST['user_name'];
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);

            $signup_verification_msg = $lang['signup_verify_admin'];
        }
        # send activation mail end

        $spam_notify_info = '';

        if ($spam_filter == 1) {
            $spam_score = Spam::foundOnSFS($user_ip, $_POST['user_name'], $_POST['email']);
            if ($spam_score > 1) {
                Spam::banIP($user_ip);
                $config['notify_signup'] = 1;
                $spam_notify_info .= "\n";
                $spam_notify_info .= 'FOUND ON SFS (score: ' . $spam_score . '): http://www.stopforumspam.com/api?f=serial&ip=' . $user_ip . '&username=' . $_POST['user_name'] . '&email=' . $_POST['email'];
            }
        }

        # admin signup notify

        if ($config['notify_signup'] == 1) {

            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='admin_signup_notify'";
            $tmp = DB::fetch1($sql);
            $email_body = $tmp['email_body'];
            $email_subject = $tmp['email_subject'];

            $email_subject = str_replace('[USERNAME]', $_POST['user_name'], $email_subject);
            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);

            $email_body_tmp = $email_body;
            $email_body_tmp = str_replace('[USERNAME]', $_POST['user_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[USER_EMAIL]', $_POST['email'], $email_body_tmp);
            $email_body_tmp = str_replace('[REMOTE_ADDR]', $_SERVER['REMOTE_ADDR'], $email_body_tmp);
            $email_body_tmp = str_replace('[HTTP_USER_AGENT]', $_SERVER['HTTP_USER_AGENT'], $email_body_tmp);
            $email_body_tmp = str_replace('[USER_URL]', VSHARE_URL . '/' . $_POST['user_name'], $email_body_tmp);
            $email_body_tmp .= $spam_notify_info;

            $email = array();
            $email['from_email'] = $config['admin_email'];
            $email['from_name'] = $config['site_name'];
            $email['to_email'] = $config['admin_email'];
            $email['to_name'] = $config['site_name'];
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);
        }

        # admin signup notify end

        // package_enabled && package_trial == Yes
        if ($paid_member == 1) {
            $expired_time = date("Y-m-d H:i:s", strtotime("+" . $package_info['package_trial_period'] . " day"));
            $sql = "UPDATE `subscriber` SET
                   `pack_id`='" . (int) $_POST['pack_id'] . "',
                   `subscribe_time`='" . date("Y-m-d H:i:s") . "',
                   `expired_time`='$expired_time' WHERE
                   `UID`='" . (int) $userid . "'";
            DB::query($sql);
        }

        // package_enabled && package_trial == No
         else if ($paid_member == 2) {
            $subscribe_time = date("Y-m-d H:i:s");
            $expired_time = date("Y-m-d H:i:s");

            if ($package_info['package_price'] == 0) {
                $expired_time = date("Y-m-d H:i:s", strtotime("+1 $package_info[package_period]"));
            }

            $sql = "UPDATE `subscriber` SET
                   `pack_id`='" . (int) $_POST['pack_id'] . "',
                   `subscribe_time`='" . $subscribe_time . "',
                   `expired_time`='" . $expired_time . "' WHERE
                   `UID`='" . (int) $userid . "'";
            DB::query($sql);

            $sql = "UPDATE `users` SET
                   `user_account_status`='Inactive' WHERE
                   `user_id`='" . (int) $userid . "'";
            DB::query($sql);

            if ($package_info['package_price'] > 0) {
                set_message($lang['signup_success_payment'], 'success');
                $redirect_url = VSHARE_URL . '/package_options.php?package_id=' . $_POST['pack_id'] . '&user_id=' . $userid;
                Http::redirect($redirect_url);
            }
        }
    }
} else {
    $signup = array(
        'user_name' => '',
        'email' => '',
        'month' => '',
        'day' => '',
        'year' => '',
    );
}

if ($config['enable_package'] == 'yes') {
    $sql = "SELECT * FROM `packages` WHERE
           `package_status`='Active'
            ORDER BY `package_price` DESC";
    $smarty->assign('package', DB::fetch($sql));
}

if ($signup_dob == 1) {
    for ($i = 1; $i <= 12; $i ++) {
        $months[] = $i;
    }

    $smarty->assign('months', $months);

    for ($i = 1; $i <= 31; $i ++) {
        $days[] = $i;
    }

    $smarty->assign('days', $days);

    for ($i = 1930; $i <= date('Y'); $i ++) {
        $years[] = $i;
    }

    $smarty->assign('years', $years);
}

$smarty->assign('html_title', 'Sign Up');
$smarty->assign('html_description', 'Sign Up');
$smarty->assign('signup', $signup);
$smarty->assign('signup_verification_msg', $signup_verification_msg);
$smarty->assign('age_minimum', Config::get('signup_age_min'));
$smarty->assign('signup_dob', $signup_dob);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');

if ($signup_enable == 1 && $msg == '') {
    $smarty->display('signup.tpl');
}

$smarty->assign('html_extra', $smarty->fetch('signup_js.tpl'));
$smarty->display('footer.tpl');
DB::close();
