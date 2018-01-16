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
require '../include/settings/upload.php';
require '../include/language/' . LANG . '/admin/import_video.php';

Admin::auth();

$import_folder = VSHARE_DIR . '/templates_c/import';

$videos = array();

$todo = '';

if (is_dir($import_folder)) {
    $import_video = dir($import_folder);
    while (false !== ($video = $import_video->read())) {
        if ($video != '.' && $video != '..') {
            $pos = strrpos($video, '.');
            $upload_file_extn = strtolower(substr($video, $pos + 1, strlen($video) - $pos));
            for ($i = 0; $i < count($file_types); $i ++) {
                if ($upload_file_extn == $file_types[$i]) {
                    $videos[] = $video;
                }
            }
        }
    }
}

if (isset($_POST['submit'])) {
    $err = '';
    $user = $_POST['video_user'];
    $video_title = $_POST['video_title'];
    $type = $_POST['video_privacy'];
    $video_description = $_POST['video_description'];
    $tags = $_POST['video_keywords'];
    $channel = $_POST['channel'];

    if ($user == '') {
        $err = $lang['user_name_null'];
    } else if (strlen($video_title) < 4) {
        $err = $lang['title_too_short'];
    } else if (strlen($video_description) < 4) {
        $err = $lang['description_too_short'];
    } else if ($tags == '') {
        $err = $lang['tags_too_short'];
    } else if (! is_numeric($channel)) {
        $err = $lang['channel_not_selected'];
    }

    if ($err == '') {
        $user_info = User::getByName($user);

        if (! $user_info) {
            $err = $lang['user_not_found'];

        } else {
            $user_id = $user_info['user_id'];
        }

        if ($err == '') {
            for ($j = 0; $j < count($videos); $j ++) {
                $file_name = basename($videos[$j]);
                $pos = strrpos($file_name, '.');
                $file_extn = strtolower(substr($file_name, $pos + 1, strlen($file_name) - $pos));
                $file_no_extn = basename($file_name, ".$file_extn");
                $file_no_extn = preg_replace("/[&$#]+/", ' ', $file_no_extn);
                $file_no_extn = preg_replace("/[ ]+/", '-', $file_no_extn);
                $file_name = $file_no_extn . '.' . $file_extn;
                $file_path = VSHARE_DIR . '/video/' . $file_name;
                $i = 0;

                while (file_exists($file_path)) {
                    $i ++;
                    $file_name = $file_no_extn . '_' . $i . '.' . $file_extn;
                    $file_path = VSHARE_DIR . '/video/' . $file_name;
                }

                $source = VSHARE_DIR . '/templates_c/import/' . $videos[$j];

                if (file_exists($source)) {

                    copy($source, $file_path);
                    unlink($source);

                    $qid = ProcessQueue::create(array(
                        'file' => $file_name,
                        'title' => $video_title,
                        'description' => $video_description,
                        'keywords' => $tags,
                        'channels' => $channel,
                        'type' => $type,
                        'user' => $user,
                        'status' => 2
                    ));

                    $todo = 'finished';
                }
            }

            $msg = $lang['video_process'];
        }
    }
}

if (empty($videos)) {
    $todo = 'folder_empty';
    $err = $lang['video_not_exists'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('todo', $todo);
$smarty->assign('channels', Channel::get());
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_folder_all.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
