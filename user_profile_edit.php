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
require 'include/language/' . LANG . '/lang_user_profile_edit.php';

User::is_logged_in();

$user_info = User::get_user_by_id($_SESSION['UID']);

$countries = new Country();

if (isset($_POST['submit'])) {
    $user_bdate = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];

    if ($_POST['user_email'] == '') {
        $err = $lang['email_null'];
    } else if (check_field_exists($_POST['user_email'], 'user_email', 'users') == 1 && $user_info['user_email'] != $_POST['user_email']) {
        $err = $lang['email_exist'];
    } else if ($user_bdate != 'yyyy-mm-dd') {
        if (! checkdate($_POST['month'], $_POST['day'], $_POST['year'])) {
            $err = $lang['invalid_date'];
        }
    }

    if ($err == '') {
        $sql_extra = '';

        $gender = array(
            'Male',
            'Female'
        );

        $relations = array(
            'Single',
            'Taken',
            'Open'
        );

        if ($user_bdate != 'yyy-mm-dd') {
            $user_bdate;
        }

        if (in_array($_POST['user_gender'], $gender)) {
            $sql_extra .= "`user_gender`='" . DB::quote($_POST['user_gender']) . "',";
        }

        if (in_array($_POST['user_relation'], $relations)) {
            $sql_extra .= "`user_relation`='" . DB::quote($_POST['user_relation']) . "',";
        }

        if (in_array($_POST['user_country'], $countries->countries)) {
            $sql_extra .= "`user_country`='" . DB::quote($_POST['user_country']) . "',";
        }

        if ($_POST['user_website'] != '') {
            if (Validate::url($_POST['user_website'])) {
                $sql_extra .= "`user_website`='" . DB::quote($_POST['user_website']) . "',";
            }
        }

        $user_first_name = htmlspecialchars_uni($_POST['user_first_name']);
        $user_last_name = htmlspecialchars_uni($_POST['user_last_name']);
        $user_about_me = htmlspecialchars_uni($_POST['user_about_me']);
        $user_town = htmlspecialchars_uni($_POST['user_town']);
        $user_city = htmlspecialchars_uni($_POST['user_city']);
        $user_zip = htmlspecialchars_uni($_POST['user_zip']);
        $user_occupation = htmlspecialchars_uni($_POST['user_occupation']);
        $user_company = htmlspecialchars_uni($_POST['user_company']);
        $user_school = htmlspecialchars_uni($_POST['user_school']);
        $user_interest_hobby = htmlspecialchars_uni($_POST['user_interest_hobby']);
        $user_fav_movie_show = htmlspecialchars_uni($_POST['user_fav_movie_show']);
        $user_fav_music = htmlspecialchars_uni($_POST['user_fav_music']);
        $user_fav_book = htmlspecialchars_uni($_POST['user_fav_book']);
        $user_friends_name = htmlspecialchars_uni($_POST['user_friends_name']);
        $user_style = htmlspecialchars_uni($_POST['user_style']);

        $sql = "UPDATE `users` SET
               `user_first_name`='" . DB::quote($user_first_name) . "',
               `user_last_name`='" . DB::quote($user_last_name) . "',
               `user_birth_date`='" . DB::quote($user_bdate) . "',
                $sql_extra
               `user_about_me`='" . DB::quote($user_about_me) . "',
               `user_town`='" . DB::quote($user_town) . "',
               `user_city`='" . DB::quote($user_city) . "',
               `user_zip`='" . DB::quote($user_zip) . "',
               `user_occupation`='" . DB::quote($user_occupation) . "',
               `user_company`='" . DB::quote($user_company) . "',
               `user_school`='" . DB::quote($user_school) . "',
               `user_interest_hobby`='" . DB::quote($user_interest_hobby) . "',
               `user_fav_movie_show`='" . DB::quote($user_fav_movie_show) . "',
               `user_fav_music`='" . DB::quote($user_fav_music) . "',
               `user_fav_book`='" . DB::quote($user_fav_book) . "',
               `user_friends_name`='" . DB::quote($user_friends_name) . "',
               `user_style`='" . DB::quote($user_style) . "' WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";

        DB::query($sql);

        if ($user_info['user_email'] != $_POST['user_email']) {

            $data1 = 'EMAIL_CHANGE' . $_SESSION['UID'];

            $sql = "SELECT * FROM `verify_code` WHERE
                   `data1`='" . DB::quote($data1) . "' AND
                   `data2`='" . DB::quote($_POST['user_email']) . "'";
            $verify_info = DB::fetch1($sql);

            if ($verify_info) {
                $vkey = $verify_info['vkey'];
                $verify_id = $verify_info['id'];
            } else {
                $vkey = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                $vkey = md5($vkey);
                $sql = "INSERT INTO `verify_code` SET
                       `vkey`='" . DB::quote($vkey) . "',
                       `data1`='" . DB::quote($data1) . "',
                       `data2`='" . DB::quote($_POST['user_email']) . "'";
                $verify_id = DB::insertGetId($sql);
            }

            $verify_url = VSHARE_URL . '/verify/email/' . $_SESSION['UID'] . '/' . $verify_id . '/' . $vkey . '/';

            $user_name = $_SESSION['USERNAME'];

            $_SESSION['EMAIL'] = $_POST['email'];
            $name = $config['site_name'];
            $from = $config['admin_email'];

            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='user_email_change'";
            $tmp = DB::fetch1($sql);
            $email_subject = $tmp['email_subject'];
            $email_body_tmp = $tmp['email_body'];

            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);
            $email_subject = str_replace('[SITE_URL]', VSHARE_URL, $email_subject);

            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
            $email_body_tmp = str_replace('[USERNAME]', $user_name, $email_body_tmp);

            $email = array();
            $email['from_email'] = $config['admin_email'];
            $email['from_name'] = $config['site_name'];
            $email['to_email'] = $_POST['user_email'];
            $email['to_name'] = $user_first_name;
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);
            $msg = $lang['email_changed'];
        } else {
            $msg = $lang['profile_updated'];
        }

        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/' . $user_info['user_name'];
        Http::redirect($redirect_url);
    }
}

$user_info = User::get_user_by_id($_SESSION['UID']);
$date = explode('-', $user_info['user_birth_date']);

$country = $countries->country_options($user_info['user_country']);

$profile_css_folder = VSHARE_DIR . '/templates/css/profile/';

$css_options = '';

if (is_dir($profile_css_folder)) {
    if ($dh = opendir($profile_css_folder)) {
        while (($file = readdir($dh)) !== false) {
            if (filetype($profile_css_folder . $file) != 'dir') {
                $file_extn = File::get_extension($file);
                if ($file_extn == 'css') {
                    $selected = '';
                    $file_no_extn = basename($file, ".$file_extn");
                    if ($file_no_extn == $user_info['user_style']) {
                        $selected = 'selected';
                    } else if ($file_no_extn == 'default' && $user_info['user_style'] == '') {
                        $selected = 'selected';
                    }
                    $css_options .= '<option value="' . $file_no_extn . '"' . $selected . '>' . $file_no_extn . '</option>';
                }
            }
        }
        closedir($dh);
    }
}

$smarty->assign('css_options', $css_options);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('days', days($date[2]));
$smarty->assign('months', months($date[1]));
$smarty->assign('years', years($date[0]));
$smarty->assign('country', $country);
$smarty->assign('user_info', $user_info);
$smarty->display('header.tpl');
$smarty->display('user_profile_edit.tpl');
$smarty->display('footer.tpl');
DB::close();
