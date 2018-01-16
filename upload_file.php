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
require 'include/settings/upload.php';
require 'include/language/' . LANG . '/lang_upload.php';

if (Config::get('guest_upload') != 1) {
    User::is_logged_in();

    if ($config['enable_package'] == 'yes') {
        check_subscriber_space($_SESSION['UID']);
        check_subscriber_videos($_SESSION['UID']);
    }
}

header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

$upload_progress_bar = Config::get('upload_progress_bar');
$smarty->assign('upload_progress_bar', $upload_progress_bar);

if (isset($_GET['id'])) {
    $smarty->assign('upload_id', $_GET['id']);
}

if ($upload_progress_bar == 'uber') {

    $THIS_VERSION = '2.5';

    require VSHARE_DIR . '/ubr/ubr_ini.php';
    require VSHARE_DIR . '/ubr/ubr_lib.php';
    require VSHARE_DIR . '/ubr/ubr_default_config.php';

    $smarty->assign('path_to_link_script', $PATH_TO_LINK_SCRIPT);
    $smarty->assign('path_to_set_progress_script', $PATH_TO_SET_PROGRESS_SCRIPT);
    $smarty->assign('path_to_get_progress_script', $PATH_TO_GET_PROGRESS_SCRIPT);
    $smarty->assign('path_to_upload_script', $PATH_TO_UPLOAD_SCRIPT);
    $smarty->assign('multi_configs_enabled', $MULTI_CONFIGS_ENABLED);
    $smarty->assign('check_allow_extensions_on_client', $_CONFIG['check_allow_extensions_on_client']);
    $smarty->assign('check_disallow_extensions_on_client', $_CONFIG['check_disallow_extensions_on_client']);
    $smarty->assign('allow_extensions', '/' . $_CONFIG['allow_extensions'] . '$/i');
    $smarty->assign('disallow_extensions', '/' . $_CONFIG['disallow_extensions'] . '$/i');
    $smarty->assign('check_file_name_format', $_CONFIG['check_file_name_format']);
    $smarty->assign('check_file_name_regex', '/' . $_CONFIG['check_file_name_regex'] . '$/i');
    $smarty->assign('check_file_name_error_message', "Error, legal file name characters are 1-9, a-z, A-Z, _, -");
    $smarty->assign('max_file_name_chars', 48);
    $smarty->assign('min_file_name_chars', 5);
    $smarty->assign('check_null_file_count', $_CONFIG['check_null_file_count']);
    $smarty->assign('check_duplicate_file_count', $_CONFIG['check_duplicate_file_count']);
    $smarty->assign('max_upload_slots', $_CONFIG['max_upload_slots']);
    $smarty->assign('cedric_progress_bar', $_CONFIG['cedric_progress_bar']);
    $smarty->assign('cedric_hold_to_sync', $_CONFIG['cedric_hold_to_sync']);
    $smarty->assign('bucket_progress_bar', $_CONFIG['bucket_progress_bar']);
    $smarty->assign('progress_bar_width', $_CONFIG['progress_bar_width']);
    $smarty->assign('show_percent_complete', $_CONFIG['show_percent_complete']);
    $smarty->assign('show_files_uploaded', $_CONFIG['show_files_uploaded']);
    $smarty->assign('show_current_position', $_CONFIG['show_current_position']);

    if ($CGI_UPLOAD_HOOK && $_CONFIG['show_current_file']) {
        $smarty->assign('show_current_file', 1);
    } else {
        $smarty->assign('show_current_file', 0);
    }

    $smarty->assign('show_elapsed_time', $_CONFIG['show_elapsed_time']);
    $smarty->assign('show_est_time_left', $_CONFIG['show_est_time_left']);
    $smarty->assign('show_est_speed', $_CONFIG['show_est_speed']);

    $upload_iframe = '';

    if ($_CONFIG['embedded_upload_results'] || $_CONFIG['opera_browser'] || $_CONFIG['safari_browser']) {
        $upload_iframe = "target=\"upload_iframe\"";
    }

    $smarty->assign('upload_iframe', $upload_iframe);
}

if (isset($_GET['upload_id'])) {

    if ($upload_progress_bar == 'uber') {

    require VSHARE_DIR . '/ubr/ubr_finished_lib.php';

    if (isset($_GET['upload_id']) && preg_match("/^[a-zA-Z0-9]{32}$/", $_GET['upload_id'])) {
        $UPLOAD_ID = $_GET['upload_id'];
    } else {
        kak("<span class='ubrError'>ERROR</span'>: Invalid parameters passed<br>", 1, __LINE__, $PATH_TO_CSS_FILE);
    }

    //Declare local values
    $_XML_DATA = array(); // Array of xml data read from the upload_id.redirect file
    $_CONFIG_DATA = array(); // Array of config data read from the $_XML_DATA array
    $_POST_DATA = array(); // Array of posted data read from the $_XML_DATA array
    $_FILE_DATA = array(); // Array of 'FileInfo' objects read from the $_XML_DATA array
    $_FILE_DATA_TABLE = ''; // String used to store file info results nested between <tr> tags
    $_FILE_DATA_EMAIL = ''; // String used to store file info results


    $xml_parser = new XML_Parser(); // XML parser
    $xml_parser->setXMLFile($TEMP_DIR, $_REQUEST['upload_id']); // Set upload_id.redirect file
    $xml_parser->setXMLFileDelete($DELETE_REDIRECT_FILE); // Delete upload_id.redirect file when finished parsing
    $xml_parser->parseFeed(); // Parse upload_id.redirect file


    // Display message if the XML parser encountered an error
    if ($xml_parser->getError()) {
        kak($xml_parser->getErrorMsg(), 1, __LINE__, $PATH_TO_CSS_FILE);
    }

    $_XML_DATA = $xml_parser->getXMLData(); // Get xml data from the xml parser
    $_CONFIG_DATA = getConfigData($_XML_DATA); // Get config data from the xml data
    $_POST_DATA = getPostData($_XML_DATA); // Get post data from the xml data
    $_FILE_DATA = getFileData($_XML_DATA); // Get file data from the xml data


    $upload_dir = $_CONFIG_DATA['upload_dir'];
    $upload_file_name = $_FILE_DATA['upfile_0']->name;
    $upload_file_path = $upload_dir . $upload_file_name;
    $pos = strrpos($upload_file_name, ".");
    $upload_file_extn = strtolower(substr($upload_file_name, $pos + 1, strlen($upload_file_name) - $pos));

    if (! in_array($upload_file_extn, $file_types)) {
        unlink($upload_file_path);
        $err = "Invalid File format - $upload_file_extn";
        write_log($err);
    }

    if ($err == '') {
        $upfile_details = "UPLOAD WITH PROGRESS BAR";
        $process_video = 1;
    }

    $upload_id = $_POST_DATA['upload_id'];

    } elseif ($upload_progress_bar == 'html5') {

        switch ($_FILES['upfile_0']['error']) {
            case 1:
                $err = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case 2:
                $err = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                break;
            case 3:
                $err = "The uploaded file was only partially uploaded.";
                break;
            case 4:
                $err = "No file was uploaded.";
                break;
            case 6:
                $err = "Missing a temporary folder.";
                break;
            case 7:
                $err = "Failed to write file to disk.";
                break;
            default:
                break;
        }

        if ($err != '') {
            exit($err);
        }

        $upload_dir = VSHARE_DIR . '/video';
        $upload_file_name = $_FILES['upfile_0']['name'];

        $pos = mb_strrpos($upload_file_name, ".", 'UTF-8');
        $upload_file_arr = explode('.', $upload_file_name);
        $upload_file_extn = $upload_file_arr[count($upload_file_arr) - 1];
        $upload_file_extn = mb_strtolower($upload_file_extn);
        $upfile_no_extn = basename($upload_file_name, ".$upload_file_extn");
        $upfile_no_extn = mb_ereg_replace("[&$#]+", " ", $upfile_no_extn);
        $upfile_no_extn = mb_ereg_replace("\s+", "-", $upfile_no_extn);

        $upload_file_name = $upfile_no_extn . '.' . $upload_file_extn;
        $upload_file_path = $upload_dir . '/' . $upload_file_name;
        $i = 0;

        while (file_exists($upload_file_path))
        {
            $i ++;
            $upload_file_name = $upfile_no_extn . '_' . $i . '.' . $upload_file_extn;
            $upload_file_path = $upload_dir . '/' . $upload_file_name;
        }

        if (move_uploaded_file($_FILES['upfile_0']['tmp_name'], $upload_file_path))
        {
            if (! in_array($upload_file_extn, $file_types))
            {
                unlink($upload_file_path);
                $err = "Invalid File format - $upload_file_extn";
                write_log($err);
                exit($err);
            }
        }

        if ($err == '')
        {
            $upfile_details = "UPLOAD WITH PROGRESS BAR";
            $process_video = 1;
        }

        $upload_id = $_GET['upload_id'];
    }
}

if (isset($_POST['upload_final'])) {

    $upfile_details = "\nTemporary File Name :" . $_FILES['field_uploadfile']['tmp_name'];
    $upfile_details .= "\nFile Size :" . $_FILES['field_uploadfile']['size'];
    $upfile_details .= "\nFile Type :" . $_FILES['field_uploadfile']['type'];
    $upfile_details .= "\nFile Name :" . $_FILES['field_uploadfile']['name'];

    if (! is_uploaded_file($_FILES['field_uploadfile']['tmp_name'])) {

        $err .= nl2br($upfile_details);
        $upload_error = $_FILES['field_uploadfile']['error'];

        switch ($_FILES['field_uploadfile']['error']) {
            case 0:
                $err = $err . "<br />" . "[ERROR: $upload_error] There is no error, the file uploaded with success.";
                break;
            case 1:
                $err = $err . "<br />" . "[ERROR: $upload_error] The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case 2:
                $err = $err . "<br />" . "[ERROR: $upload_error] The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                break;
            case 3:
                $err = $err . "<br />" . "[ERROR: $upload_error] The uploaded file was only partially uploaded.";
                break;
            case 4:
                $err = $err . "<br />" . "[ERROR: $upload_error] No file was uploaded.";
                break;
            case 6:
                $err = $err . "<br />" . "[ERROR: $upload_error] Missing a temporary folder.";
                break;
            case 7:
                $err = $err . "<br />" . "[ERROR: $upload_error] Failed to write file to disk.";
                break;
            default:
                $err = $err . "<br />" . "[ERROR: $upload_error] There was a problem with your upload.";
                break;
        }
    }

    if ($err == '') {

        $upload_source_file_name = $_FILES['field_uploadfile']['name'];
        $pos = mb_strrpos($upload_source_file_name, ".", 'UTF-8');
        $upload_file_extn = mb_strtolower(mb_substr($upload_source_file_name, $pos + 1, mb_strlen($upload_source_file_name, 'UTF-8') - $pos, 'UTF-8'), 'UTF-8');
        $upfile_no_extn = basename($upload_source_file_name, ".$upload_file_extn");
        $upfile_no_extn = mb_ereg_replace("[&$#]+", " ", $upfile_no_extn);
        $upfile_no_extn = mb_ereg_replace("[ ]+", "-", $upfile_no_extn);

        $upload_file_name = $upfile_no_extn . '.' . $upload_file_extn;
        $upload_file_path = VSHARE_DIR . '/video/' . $upload_file_name;
        $i = 0;

        while (file_exists($upload_file_path)) {
            $i ++;
            $upload_file_name = $upfile_no_extn . '_' . $i . '.' . $upload_file_extn;
            $upload_file_path = VSHARE_DIR . '/video/' . $upload_file_name;
        }

        if (move_uploaded_file($_FILES['field_uploadfile']['tmp_name'], $upload_file_path)) {
            if (! in_array($upload_file_extn, $file_types)) {
                unlink($upload_file_path);
                $err = "Invalid File format - $upload_file_extn";
                write_log($err);
            }
        } else {
            $err = 'Error in moving file, check permission of video folder';
            write_log($err);
        }
    } else {
        write_log($err);
    }

    if ($err == '') {
        $process_video = 1;
    }

    $upload_id = $_POST['upload_id'];
}

if (isset($process_video) && $process_video == 1) {
    $video_title = $_SESSION["$upload_id"]['title'];
    $video_descr = $_SESSION["$upload_id"]['description'];
    $video_keywords = $_SESSION["$upload_id"]['keywords'];
    $video_channels = $_SESSION["$upload_id"]['channels'];
    $video_privacy = $_SESSION["$upload_id"]['field_privacy'];
    $video_adult = $_SESSION["$upload_id"]['adult'];

    $upload_file_size = filesize($upload_file_path);
    $upload_file_size = round($upload_file_size / (1024 * 1024));

    if ((Config::get('guest_upload') == 1) && (! isset($_SESSION['USERNAME']))) {
        $user_name = Config::get('guest_upload_user');
    } else {
        $user_name = $_SESSION['USERNAME'];
    }

    $qid = ProcessQueue::create(array(
        'file' => $upload_file_name,
        'title' => $video_title,
        'description' => $video_descr,
        'keywords' => $video_keywords,
        'channels' => $video_channels,
        'type' => $video_privacy,
        'user' => $user_name,
        'status' => 2,
        'adult' => (int) $video_adult
    ));

    $process_upload = Config::get('process_upload');

    write_log("Upload Finished");

    if ($process_upload == 0) {
        write_log("Batch Processing");
    } else if ($process_upload == 1) {
        write_log("Realtime Processing - process_video[$qid ,0]");
        $video_id = Upload::processVideo($qid, 0);
    } else {
        write_log("Background Processing");
        $php_path = Config::get('php_path');
        $cmd_bkgnd = "$php_path -q " . VSHARE_DIR . "/convert.php $qid > /dev/null &";
        write_log("Running: $cmd_bkgnd");
        exec($cmd_bkgnd);
    }

    if ($upload_progress_bar == 'html5') {
        echo $qid;
        exit();
    }

    $redirect_url = VSHARE_URL . '/upload/success/' . $qid . '/' . $upload_id . '/';
    Http::redirect($redirect_url);
}

$html_extra = $html_head_extra = '';

if ($upload_progress_bar == 'uber') {
    $html_extra = '
    <script language="javascript" type="text/javascript">
    var JQ = jQuery.noConflict();
        JQ(document).ready(function(){
            iniFilePage();
            JQ("#upfile_0").bind("keypress", function(e){ if(e == 13){ return false; } });
            JQ("#upfile_0").bind("change", function(e){ addUploadSlot(1); });
            JQ("#upload_button").bind("click", function(e){ linkUpload(); });
            JQ("#reset_button").bind("click", function(e){ resetForm(); });
        });
    </script>
    ';
    $html_head_extra = '<link rel="stylesheet" type="text/css"  href="' . VSHARE_URL . '/ubr/ubr.css">';
} elseif ($upload_progress_bar == 'html5') {
    $html_extra = '
    <script src="' . VSHARE_URL . '/js/jquery.form.js"></script>
    <script src="' . VSHARE_URL . '/js/upload_progress.js"></script>
    <script>var upload_max_filesize = ' . size_in_bytes(ini_get('upload_max_filesize')) . ';</script>
    ';
}

$smarty->assign('html_extra', $html_extra);
$smarty->assign('html_head_extra', $html_head_extra);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('upload_file.tpl');
$smarty->display('footer.tpl');
DB::close();
