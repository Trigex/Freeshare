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

$guest_upload = Config::get('guest_upload');

if ($guest_upload == 0) {
    User::is_logged_in();
    $user_id = $_SESSION['UID'];
} else {
    $user_name = Config::get('guest_upload_user');
    $user_info = User::getByName($user_name);
    $user_id = $user_info['user_id'];
}

if (isset($_POST['action_upload'])) {
    if (empty($_POST['url'])) {
        $err = 'You must enter Youtube/Dailymotion video url.';
    } else if (! check_field_exists($_POST['channel'], 'channel_id', 'channels')) {
        $err = 'Invalid Channel id.';
    }

    if ($err == '') {

        $url = $_POST['url'];
        $channel_id = $_POST['channel'];

        if (isset($_POST['field_privacy'])) {
            if ($_POST['field_privacy'] == 'public') {
                $type = 'public';
            } else {
                $type = 'private';
            }
        } else {
            $type = 'public';
        }

        $import_site = 'youtube';

        if (preg_match("/youtube/i", $url)) {

            $video_id = BulkImport::getYoutubeVideoId($url);

            if (BulkImport::checkImported($video_id, $import_site)) {
                $err = 'Video already exists. Enter another video url.';
            }

            if ($err == '') {
                $video_info = Youtube::getVideoInfo($video_id);
                $seo_name = Url::seoName($video_info['video_title']);

                $sql = "INSERT INTO `videos` SET
		               `video_user_id`='" . (int) $user_id . "',
		               `video_title`='" . DB::quote($video_info['video_title']) . "',
		               `video_description`='" . DB::quote(Xss::clean($video_info['video_description'])) . "',
		               `video_keywords`='" . DB::quote($video_info['video_keywords']) . "',
		               `video_seo_name`='" . DB::quote($seo_name) . "',
		               `video_channels`='0|" . DB::quote($channel_id) . "|0',
		               `video_type`='" . DB::quote($type) . "',
		               `video_duration`='" . (int) $video_info['video_duration'] . "',
		               `video_length`='" . DB::quote($video_info['video_length']) . "',
		               `video_add_time`='" . $_SERVER['REQUEST_TIME'] . "',
		               `video_add_date`='" . date('Y-m-d') . "',
		               `video_active`='1',
		               `video_approve`='$config[approve]'";
                $video_id = DB::insertGetId($sql);

                $sql = "INSERT INTO `import_track` SET
                       `import_track_unique_id`='" . DB::quote($video_id) . "' ,
                       `import_track_site`='" . DB::quote($import_site) . "'";
                DB::query($sql);

                $upload_remote = new UploadRemote();
                $upload_remote->vid = $video_id;
                $upload_remote->url = $url;
                $upload_remote->debug = 1;

                if ($type == 'public' && $config['approve'] == 1) {
                    $current_keyword = DB::quote($video_info['video_keywords']);
                    $tags = new Tag($current_keyword, $video_id, $_SESSION['UID'], "0|$channel|0");
                    $tags->add();
                }

                $err = $upload_remote->youtube();

                if ($err == '') {
                    $sql = "UPDATE `subscriber` SET
		                   `total_video`=`total_video`+1 WHERE
		                   `UID`='" . (int) $user_id . "'";
                    DB::query($sql);
                    $redirect_url = VSHARE_URL . '/upload/success/' . $video_id . '/remote/';
                    Http::redirect($redirect_url);
                }
            }
        } else if (preg_match("/dailymotion.com/i", $url)) {
            if (preg_match('/video\/(.*)_/i',$url,$match)) {
                if (preg_match('/(.*)_/i',$match[1],$matches)) {
                    $dailymotionVideoId = $matches[1];

                    if (BulkImport::checkImported($dailymotionVideoId, 'dailymotion')) {
                        $err = 'Video already exists. Enter another video url.';
                    } else {
                        $dailymotionVideo = new DailymotionVideo();
                        $dailymotionVideo->videoId = $dailymotionVideoId;
                        $dailymotionVideoInfo = $dailymotionVideo->videoInfo();

                        if (isset($dailymotionVideoInfo['err'])) {
                            $err = $dailymotionVideoInfo['err'];
                        } else {
                            $seo_name = Url::seoName($dailymotionVideoInfo['title']);
                            $video_length = sec2hms($dailymotionVideoInfo['duration']);
                            $dailymotionVideoKeywords = implode(' ',$dailymotionVideoInfo['tags']);

                            $sql = "INSERT INTO `videos` SET
                                   `video_user_id`='" . (int) $user_id . "',
                                   `video_title`='" . DB::quote($dailymotionVideoInfo['title']) . "',
                                   `video_description`='" . DB::quote($dailymotionVideoInfo['description']) . "',
                                   `video_keywords`='" . DB::quote($dailymotionVideoKeywords) . "',
                                   `video_seo_name`='" . DB::quote($seo_name) . "',
                                   `video_name`='" . DB::quote($dailymotionVideoInfo['id']) . "',
                                   `video_vtype`='7',
                                   `video_channels`='0|" . DB::quote($channel_id) . "|0',
                                   `video_type`='" . DB::quote($type) . "',
                                   `video_duration`='" . (int) $dailymotionVideoInfo['duration'] . "',
                                   `video_length`='" . DB::quote($video_length) . "',
                                   `video_add_time`='" . $_SERVER['REQUEST_TIME'] . "',
                                   `video_add_date`='" . date('Y-m-d') . "',
                                   `video_active`='1',
                                   `video_approve`='$config[approve]'";
                            $video_id = DB::insertGetId($sql);

                            $sql = "INSERT INTO `import_track` SET
                                   `import_track_unique_id`='" . DB::quote($dailymotionVideoInfo['id']) . "' ,
                                   `import_track_video_id`='" . DB::quote($video_id) . "' ,
                                   `import_track_site`='dailymotion'";
                            DB::query($sql);

                            $dailymotionVideo->vshareVideoId = $video_id;
                            $dailymotionVideo->CreateThumb();

                            if ($type == 'public' && $config['approve'] == 1) {
                                $current_keyword = DB::quote($dailymotionVideoKeywords);
                                $tags = new Tag($current_keyword, $video_id, $_SESSION['UID'], "0|$channel|0");
                                $tags->add();
                            }

                            $sql = "UPDATE `subscriber` SET
                                   `total_video`=`total_video`+1 WHERE
                                   `UID`='" . (int) $user_id . "'";
                            DB::query($sql);

                            $redirect_url = VSHARE_URL . '/upload/success/' . $video_id . '/remote/';
                            Http::redirect($redirect_url);
                        }
                    }
                }
            }
        } else {
            $err = 'Link specified is not supported';
        }
    }
}

$smarty->assign('channel_info', Channel::get());
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('upload_embed.tpl');
$smarty->display('footer.tpl');
DB::close();
