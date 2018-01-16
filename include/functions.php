<?php

require VSHARE_DIR . '/include/functions_insert.php';

function write_admin_log()
{
    $file_name_array = explode('/', $_SERVER['SCRIPT_FILENAME']);
    $admin_log_script = $file_name_array[count($file_name_array)-1];
    if ($admin_log_script == 'admin_log.php') {
        return;
    }

    $user = new User();
    $admin_log_ip = $user->get_ip();
    $admin_log_user_id = isset($_SESSION['MUID']) ? (int) $_SESSION['MUID'] : 0;
    $admin_log_time = time();
    $admin_log_extra = '';

    if (isset($_SERVER['QUERY_STRING'])) {
        $admin_log_extra = $_SERVER['QUERY_STRING'];
    }

    $sql = "INSERT INTO `admin_log` SET
           `admin_log_user_id`='$admin_log_user_id',
           `admin_log_script`='$admin_log_script',
           `admin_log_time`='$admin_log_time',
           `admin_log_action`='',
           `admin_log_extra`='$admin_log_extra',
           `admin_log_ip`='$admin_log_ip'";
    DB::query($sql);
}

function years($sel = '')
{
    $year = '';
    $init = date('Y');

    for ($i = 1900; $i <= $init; $i ++) {
        if ($i == $sel) {
            $year .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        } else {
            $year .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    return $year;
}

function months($sel = '')
{
    $months = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );
    $month = '';

    for ($i = 1; $i <= 12; $i ++) {
        if ($i == $sel) {
            $month .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        } else {
            $month .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    return $month;
}

function days($sel = '')
{
    $day = '';
    for ($i = 1; $i <= 31; $i ++) {
        if ($i == $sel) {
            $day .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        } else {
            $day .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    return $day;
}

function check_field_exists($fvalue, $field, $table)
{
    $sql = "SELECT count(*) AS `total` FROM `$table` WHERE
           `$field`='" . DB::quote($fvalue) . "'";
    $total = DB::getTotal($sql);
    if ($total > 0) {
        return 1;
    } else {
        return 0;
    }
}

function format_size($size)
{
    if ($size['type'] == 'byte') {

    } else {
        if ($size < 1024) {
            $output = round($size, 2) . ' MB';
        } else {
            $output = round($size / 1024, 2) . ' GB';
        }
    }
    return $output;
}

function upload_jpg($FILE, $var_name, $file_name, $img_width = 128, $dir = "upload/", $rename = '')
{

    if ($FILE[$var_name]['name']) {
        $file_url = $dir . uniqid("") . 'tmp';
        $ext = strrchr($FILE[$var_name]['name'], '.');
        move_uploaded_file($FILE[$var_name]['tmp_name'], $file_url);

        if ($FILE[$var_name]['error'] > 0) {
            $err = 'Error occurs while uploading file';
        } else if (strtolower($ext) == '.jpg') {
            $img = @imagecreatefromjpeg($file_url);
            $size = @getimagesize($file_url);
            $width = $size[0];
            $height = $size[1];

            if ($width > $img_width) {
                $percentage = $img_width / $width;
                $width *= $percentage;
                $height *= $percentage;
                $img_r = @imagecreatetruecolor($width, $height);
                @imagecopyresampled($img_r, $img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            } else {
                $img_r = $img;
            }
            $pic_name = $dir . $file_name;
            @ImageJpeg($img_r, $pic_name, 100);
            //                       rename("$pic_name", "$dir"."$rename");
            @unlink($file_url);
        } else {
            @unlink($file_url);
            $err = 'File must be as .jpg format';
        }
    }

    return $err;
}

function cc_month($sel = '')
{
    $month = '';

    for ($i = 1; $i <= 12; $i ++) {
        if ($i <= 9) {
            $j = '0' . $i;
        } else {
            $j = $i;
        }

        if ($i == $sel) {
            $month .= "<option value='$i' selected>$j</option>";
        } else {
            $month .= "<option value='$i'>$j</option>";
        }
    }
    return $month;
}

function cc_year($sel = '')
{
    $year = '';

    for ($i = 2004; $i <= 2020; $i ++) {
        if ($i == $sel) {
            $year .= "<option value='$i' selected>$i</option>";
        } else {
            $year .= "<option value='$i'>$i</option>";
        }
    }
    return $year;
}

function check_subscriber($space = 0)
{
    global $config;
    $err = '';
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $_SESSION['UID'] . "'";
    $subs = DB::fetch1($sql);
    $sql = "SELECT * FROM `packages` WHERE
           `package_id`=" . $subs['pack_id'];
    $pack = DB::fetch1($sql);

    if ($pack['package_videos'] != 0 && ($subs['total_video'] >= $pack['package_videos'])) {
        $err = 'You cannot upload more than ' . $pack['package_videos'] . ' videos';
        $type = 'limit';
    } else if ($subs['used_space'] + $space >= $pack['package_space']) {
        $err = 'You cannot upload more than ' . format_size($pack['package_space']) . ' space';
        $type = 'space';
    }

    if ($err != '') {
        $uid = $_SESSION['UID'];
        header('Location: ' . VSHARE_URL . '/renew_account.php?uid=' . $uid . '&err=' . $err);
        exit();
    }
}

function write_log($txt, $logfile = 1, $echo = 0, $extension = 'txt')
{
    global $config;

    if ($logfile == 1) {
        $log_file = VSHARE_DIR . '/templates_c/debug.txt';
    } else {
        $log_file = VSHARE_DIR . '/templates_c/' . $logfile . '.' . $extension;
    }

    $now = date("Y-m-d G:i:s");
    error_log("$now $txt\n\r", 3, $log_file);

    if ($echo == 1) {
        echo $txt;
    }

}

function check_subscriber_duration($uid)
{
    global $config , $lang;
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $uid . "'";
    $duration = DB::fetch1($sql);
    $expired_time = $duration['expired_time'];
    $subscribe_time = $duration['subscribe_time'];

    if ($expired_time == '0000-00-00 00:00:00') {
        $expired_time = date("Y-m-d h:i:s");
        $sql = "UPDATE `subscriber` SET
               `expired_time`='$expired_time' WHERE
               `UID`='" . (int) $uid . "'";
        DB::query($sql);
    }

    if ($subscribe_time == '0000-00-00 00:00:00') {
        $subscribe_time = date("Y-m-d h:i:s");
        $sql = "UPDATE `subscriber` SET
               `subscribe_time`='$subscribe_time' WHERE
               `UID`='" . (int) $uid . "'";
        DB::query($sql);
    }

    $expired_time_in_sec = strtotime($expired_time);
    $current_time = $_SERVER['REQUEST_TIME'];

    if ($expired_time_in_sec < $current_time) {
        $expired_time = date("j F Y", strtotime($expired_time));
        $msg = str_replace('[EXPIRED_TIME]', $expired_time, $lang['subscriber_expired']);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/renew_account.php?uid=' . $uid;
        Http::redirect($redirect_url);
    }
}

function check_subscriber_space($user_id)
{
    global $config , $lang;
    $err = '';

    if (empty($user_id)) {
        $user_id = 0;
    }

    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $user_id . "'";
    $subscribe_info = DB::fetch1($sql);

    $sql = "SELECT * FROM `packages` WHERE
           `package_id`='" . (int) $subscribe_info['pack_id'] . "'";
    $pack = DB::fetch1($sql);

    if ($subscribe_info['used_space'] >= $pack['package_space']) {
        $msg = $lang['subscriber_space'];
        $space_used = format_size($subscribe_info['used_space']);
        $msg = str_replace('[SPACE_USED]', $space_used, $msg);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/renew_account.php?uid=' . $user_id;
        Http::redirect($redirect_url);
    }
}

function check_subscriber_videos($uid)
{
    global $config , $lang;
    $err = '';
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $uid . "'";
    $subscribe_info = DB::fetch1($sql);

    $sql = "SELECT * FROM `packages` WHERE
           `package_id`='" . (int) $subscribe_info['pack_id'] . "'";
    $pack = DB::fetch1($sql);

    if ($pack['package_videos'] != 0 && $subscribe_info['total_video'] >= $pack['package_videos']) {
        $msg = $lang['subscriber_video'];
        $total_videos = $subscribe_info['total_video'];
        $msg = str_replace('[TOTAL_VIDEOS]', $total_videos, $msg);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/renew_account.php?uid=' . $uid;
        Http::redirect($redirect_url);
    }
}

function password_generator($lenght = 8)
{

    $password = array();

    for ($i = 0; $i <= $lenght; $i ++) {
        $password[$i] = chr(rand(97, 122));

        switch ($password[$i]) {
            case 'a':
                $password[$i] = 4;
                break;
            case 'b':
                $password[$i] = 8;
                break;
            case 'e':
                $password[$i] = 3;
                break;
            case 'i':
                $password[$i] = 1;
                break;
            case 'o':
                $password[$i] = 0;
                break;
            case 's':
                $password[$i] = 5;
                break;
        }

        $third = $i / 3;

        if (is_int($third)) {
            $password[$i] = strtoupper($password[$i]);
        }
    }
    return implode('', $password);
}

function sec2hms($sec, $useColon = true)
{
    $hms = '';
    $hours = intval(intval($sec) / 3600);

    if ($hours > 0) {
        $hms .= str_pad($hours, 2, '0', STR_PAD_LEFT) . ':';
    }

    $minutes = intval(($sec / 60) % 60);

    if ($minutes > 0) {
        $hms .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':';
    } else {
        $hms .= '00:';
    }

    if ($sec > 59) {
        $seconds = intval($sec % 60);
    } else {
        $sec_tmp = round($sec, 2);
        $seconds = $sec_tmp;
    }

    $hms .= str_pad($seconds, 2, '0', STR_PAD_LEFT);
    return $hms;
}

function set_message($message, $message_type)
{
    $_SESSION['vshare_message'] = $message;
    $_SESSION['vshare_message_type'] = $message_type;
}

function strlen_uni($string)
{
    return mb_strlen($string, 'UTF-8');
}

function htmlspecialchars_uni($text, $entities = true)
{
    return str_replace(array(
        '<',
        '>',
        '"'
    ), array(
        '&lt;',
        '&gt;',
        '&quot;'
    ), preg_replace('/&(?!' . ($entities ? '#[0-9]+|shy' : '(#[0-9]+|[a-z]+)') . ';)/si', '&amp;', $text));
}

function array_remove_duplicate($source_array)
{
    $source_array = array_unique($source_array);
    $array_new = array();

    foreach ($source_array as $key) {
        $array_new[] = $key;
    }
    return $array_new;
}

function getFamilyFilter()
{
	global $config;

	if ($config['family_filter'] == 1) {
		if (!isset($_SESSION['FAMILY_FILTER'])) {
			if (isset($_SESSION['UID'])) {
				$sql = "SELECT `user_adult` FROM `users` WHERE
				       `user_id`='" . (int) $_SESSION['UID'] . "'";
				$tmp = DB::fetch1($sql);
				$user_adult = $tmp['user_adult'];
			} else {
				$user_adult = 1;
			}

			$_SESSION['FAMILY_FILTER'] = $user_adult;
		}
		return $_SESSION['FAMILY_FILTER'];
	}
	return 0;
}

function size_in_bytes($size)
{
    $size = trim($size);
    $size = strtolower($size);
    $last = $size[strlen($size)-1];
    $size = (int) trim($size, $last);

    if ($last == 'g') {
        $size = $size * 1024 * 1024 * 1024;
    } else if ($last == 'm') {
        $size = $size * 1024 * 1024;
    } else if ($last == 'k') {
        $size = $size * 1024;
    }
    return $size;
}
