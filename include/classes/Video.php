<?php



class Video
{
    public $video_id;
    public $video_title;
    public $video_description;
    public $video_keywords;
    public $video_channels;
    public $video_type;
    public $video_allow_comment;
    public $video_allow_rated;
    public $video_allow_embed;
    public $video_featured;
    public $video_active;
    public $video_duration;
    public $video_embeded_code;
    public $video_adult;
    public $is_admin = 0;
    public $video_info;

    public function Video()
    {

    }

    public function video_update()
    {
        global $lang;
        require_once VSHARE_DIR . '/include/language/' . LANG . '/lang_class_video.php';

        $tags_delete = 0;
        $tags_add = 0;
        $sql_extra = '';

        $valid = $this->validate_video_info();

        if ($valid != 1) {
            return $valid;
        }

        $channel_list_formatted = implode('|', $this->video_channels);
        $channel_list_formatted = '0|' . $channel_list_formatted . '|0';

        $this->video_info = Video::getById($this->video_id);

        if ($this->is_admin == 0) {
            if ($_SESSION['UID'] != $this->video_info['video_user_id']) {
                $error = $lang['not_video_owner'];
                return $error;
            }
        }

        if ($this->video_info['video_title'] != $this->video_title) {
            $seo_name = Url::seoName($this->video_title);
            $seo_name_org = $seo_name;
            $i = 1;

            while (check_field_exists($seo_name, 'video_seo_name', 'videos')) {
                $seo_name = $seo_name_org . '-' . $i;
                $i ++;
            }

            $sql_extra .= ",`video_seo_name`='" . DB::quote($seo_name) . "' ";
            $this->video_info['video_seo_name'] = $seo_name;
        }

        $tags_add = 0;
        $tags_delete = 0;

        /*
        Add Tags
        1. when a private video changed to public
        2. when keywords edited

        Delete Tags
        1. A video changed to private from public
        2. when keyword edited
        */

        // conditon 1


        if ($this->video_info['video_type'] != $this->video_type) {

            if ($this->video_type == 'public') {
                $tags_add = 1;
            } else {
                $tags_delete = 1;
            }
        }

        // condition 2


        if ($this->video_info['video_keywords'] != $this->video_keywords && $this->video_type == 'public') {
            $tags_delete = 1;
            $tags_add = 1;
        }

        if ($tags_delete == 1) {
            $tags = new Tag($this->video_info['video_keywords'], $this->video_id, $this->video_info['video_user_id'], $channel_list_formatted);
            $tags->delete();
            unset($tags);
        }

        if ($tags_add == 1) {
            $tags = new Tag($this->video_keywords, $this->video_id, $this->video_info['video_user_id'], $channel_list_formatted);
            $tags->add();
            $video_tags = $tags->get_tags();
            $this->video_keywords = implode(' ', $video_tags);
            unset($tags);
        }

        if ($this->is_admin == 1) {
            $sql_extra .= ",`video_featured`='$this->video_featured',
                            `video_active`='$this->video_active',
                            `video_duration`='$this->video_duration',
                            `video_length`='" . sec2hms($this->video_duration) . "',
                            `video_adult`='$this->video_adult'";

            if ($this->video_info['video_vtype'] == 2 || $this->video_info['video_vtype'] == 6) {
                $sql_extra .= ",`video_embed_code`='$this->video_embeded_code'";
            }

            if ($this->video_info['video_active'] != $this->video_active) {
                User::updateVideoCount($this->video_info['video_user_id'], $this->video_active);
            }
        }

        $sql = "UPDATE `videos` SET
               `video_title`='" . DB::quote($this->video_title) . "',
               `video_description`='" . DB::quote($this->video_description, 1) . "',
               `video_keywords`='" . DB::quote($this->video_keywords) . "',
               `video_channels`='$channel_list_formatted',
               `video_type`='" . DB::quote($this->video_type) . "',
               `video_allow_comment`='" . DB::quote($this->video_allow_comment) . "',
               `video_allow_rated`='" . DB::quote($this->video_allow_rated) . "',
               `video_allow_embed`='" . DB::quote($this->video_allow_embed) . "'
                $sql_extra WHERE
               `video_id`='" . (int) $this->video_id . "' AND
               `video_user_id`='" . $this->video_info['video_user_id'] . "'";

        DB::query($sql);

        return 1;
    }

    public function validate_video_info()
    {
        global $lang , $num_max_channels;

        $error = array();

        $this->video_title = strip_tags($this->video_title);
        $this->video_title = trim($this->video_title);

        $this->video_keywords = strip_tags($this->video_keywords);
        $this->video_keywords = trim($this->video_keywords);

        $this->video_description = trim($this->video_description);

        if (get_magic_quotes_gpc()) {
            $this->video_description = stripslashes($this->video_description);
        }

        if ($this->is_admin == 0) {
            $this->video_description = Xss::clean($this->video_description);
        }

        if ($this->video_type != 'private') {
            $this->video_type = 'public';
        }

        if ($this->video_allow_comment != 'no') {
            $this->video_allow_comment = 'yes';
        }

        if ($this->video_allow_rated != 'no') {
            $this->video_allow_rated = 'yes';
        }

        if ($this->video_featured != 'no') {
            $this->video_featured = 'yes';
        }

        if ($this->video_allow_embed == 'enabled') {
            $this->video_allow_embed = 'enabled';
        } else {
            $this->video_allow_embed = 'disabled';
        }

        if ($this->video_active != 0) {
            $this->video_active = 1;
        }

        if ($this->is_admin == 1) {

            if (! is_numeric($this->video_duration)) {
                $error[] = $lang['video_duration_empty'];
            }
        }

        if (strlen_uni($this->video_title) < 8) {
            $error[] = $lang['video_title_empty'];
        }

        if (strlen_uni($this->video_description) < 8) {
            $error[] = $lang['video_description_empty'];
        }

        if (strlen_uni($this->video_keywords) < 8) {
            $error[] = $lang['video_keyword_empty'];
        }

        $channels_valid = array();

        foreach ($this->video_channels as $channel) {
            $channel = (int) $channel;

            if (! in_array($channel, $channels_valid) && check_field_exists($channel, 'channel_id', 'channels')) {
                $channels_valid[] = $channel;
            }
        }

        $this->video_channels = $channels_valid;

        if ((count($this->video_channels) < 1) || (count($this->video_channels) > $num_max_channels)) {
            $error[] = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
        }

        if ($this->video_adult != 1) {
            $this->video_adult = 0;
        }

        if (count($error)) {
            $error_msg = '<ul>';

            for ($i = 0; $i < count($error); $i ++) {
                $error_msg .= '<li>' . $error[$i] . '</li>';
            }

            $error_msg .= '</ul>';

            return $error_msg;
        } else {
            return 1;
        }
    }

    public static function getRelatedVideos($video_id, $search_string)
    {
        global $config , $servers;

        $search_string = strip_tags($search_string);
        $search_string = DB::quote($search_string);

        $sql_select_fields = "`video_id`,`video_user_id`,`video_title`,`video_seo_name`,`video_length`,`video_view_number`,`video_com_num`,`video_thumb_server_id`, `video_folder`";

        $sql = "SELECT $sql_select_fields, MATCH (`video_title`) AGAINST ('$search_string' IN BOOLEAN MODE) AS `relevance`
                FROM `videos` WHERE
                MATCH (`video_title`) AGAINST ('$search_string' IN BOOLEAN MODE) AND
               `video_type`='public' AND
               `video_active`='1' AND
               `video_approve`='1'
                ORDER BY `relevance` DESC
                LIMIT " . $config['rel_video_per_page'];
        $result = DB::query($sql);
        $total = mysqli_num_rows($result);
        $related_videos = array();

        while ($tmp = mysqli_fetch_assoc($result)) {
            if ($total > 1 && $tmp['video_id'] == $video_id) {
                continue;
            }
            $tmp['video_thumb_url'] = $servers[$tmp['video_thumb_server_id']];
            $related_videos[] = $tmp;
        }

        return $related_videos;
    }

    public static function delete($video_id, $video_uid, $delete = 1)
    {
        global $config;
        $log_file_name = 'delete_' . $video_id;

        $sql = "SELECT * FROM `videos` WHERE
               `video_id`='" . (int) $video_id . "' AND
               `video_user_id`='" . (int) $video_uid . "'";
        $video_info = DB::fetch1($sql);

        if ($video_info) {
            $vdoname = $video_info['video_name'];
            $video_flv_name = $video_info['video_flv_name'];
            $video_space = $video_info['video_space'];
            $vtype = $video_info['video_vtype'];
            $current_keyword = $video_info['video_keywords'];
            $server_id = $video_info['video_server_id'];
            $video_folder = $video_info['video_folder'];

            if ($server_id != 0 && $delete == 1) {
                $ftp_config = array();
                $ftp_config['video_id'] = $video_id;
                $ftp_config['debug'] = $config['debug'];
                $ftp_config['log_file_name'] = $log_file_name;
                $ftp = new Ftp();

                if (! $ftp->delete_video($ftp_config)) {
                    echo 'Delete failed';
                    exit();
                }
                $ftp->close();
            } else if ($delete == 1) {

                if ($vtype == 0 && $server_id == 0) {
                    # DELETE FLV IF LOCAL VIDEO
                    $flv = VSHARE_DIR . '/flvideo/' . $video_folder . $video_flv_name;

                    if (file_exists($flv)) {
                        if (is_file($flv)) {
                            if (! unlink($flv)) {
                                $err = 'File delete failed. Check file permission :' . $flv;
                                return $err;
                            }
                        }
                    }
                }

            }

            if ($video_info['video_thumb_server_id'] > 0) {
                unset($ftp_config);
                unset($ftp);
                $ftp_config['video_id'] = $video_id;
                $ftp_config['debug'] = $config['debug'];
                $ftp_config['log_file_name'] = $log_file_name;
                $ftp = new Ftp();
                $ftp->delete_thumb($ftp_config);
                $ftp->close();
            }

            $tags = new Tag($current_keyword, $video_id, '', '');
            $tags->delete($delete);
            unset($tags);

            if ($delete == 1) {
                $sql = "DELETE FROM `comments` WHERE
                       `comment_video_id`=$video_id";
                DB::query($sql);
                $sql = "DELETE FROM `process_queue` WHERE
                       `vid`=$video_id";
                DB::query($sql);
                $sql = "DELETE FROM `videos` WHERE
                       `video_id`=$video_id";
                DB::query($sql);
                $sql = "DELETE FROM `import_track` WHERE
                       `import_track_video_id`=$video_id";
                DB::query($sql);
            } else {
                $sql = "UPDATE `videos` SET
                       `video_user_id`='0',
                       `video_active`='0' WHERE
                       `video_id`='" . (int) $video_id . "'";
                DB::query($sql);

                User::updateVideoCount($video_uid, 0);
            }

            $sql = "UPDATE `groups` SET
                   `group_image_video`='0' WHERE
                   `group_image_video`=$video_id";
            DB::query($sql);
            $sql = "DELETE FROM `group_videos` WHERE
                   `group_video_video_id`=$video_id";
            DB::query($sql);
            $sql = "DELETE FROM `favourite` WHERE
                   `favourite_video_id`=$video_id";
            DB::query($sql);
            $sql = "DELETE FROM `inappropriate_requests` WHERE
                   `inappropriate_request_video_id`=$video_id";
            DB::query($sql);
            $sql = "DELETE FROM `feature_requests` WHERE
                   `feature_request_video_id`=$video_id";
            DB::query($sql);
            $sql = "UPDATE `subscriber` SET
                   `total_video`=total_video-1,
                   `used_space`=used_space-$video_space WHERE
                   `UID`=$video_uid";
            DB::query($sql);
            $sql = "DELETE FROM `playlists_videos` WHERE
                   `playlists_videos_video_id`='" . (int) $video_id . "'";
            DB::query($sql);
            $sql = "UPDATE `group_topics` SET
                   `group_topic_video_id`='0' WHERE
                   `group_topic_video_id`='" . (int) $video_id . "'";
            DB::query($sql);
            $sql = "UPDATE `group_topic_posts` SET
                   `group_topic_post_video_id`='0' WHERE
                   `group_topic_post_video_id`='" . (int) $video_id . "'";
            DB::query($sql);

            if ($delete == 1) {
                $ff = VSHARE_DIR . '/thumb/' . $video_folder . $video_id . '.jpg';
                $ff1 = VSHARE_DIR . '/thumb/' . $video_folder . '1_' . $video_id . '.jpg';
                $ff2 = VSHARE_DIR . '/thumb/' . $video_folder . '2_' . $video_id . '.jpg';
                $ff3 = VSHARE_DIR . '/thumb/' . $video_folder . '3_' . $video_id . '.jpg';

                if (file_exists($ff)) @unlink($ff);
                if (file_exists($ff1)) @unlink($ff1);
                if (file_exists($ff2)) @unlink($ff2);
                if (file_exists($ff3)) @unlink($ff3);

                if ($vtype == 0) {
                    $ff4 = VSHARE_DIR . '/video/' . $vdoname;
                    if (strlen($vdoname) > 3) {
                        if (file_exists($ff4)) @unlink($ff4);
                    }
                }
            }

            return 1;
        } else {
            return 0;
        }
    }

    public static function getVideoResponse($video_id, $limit = 5)
    {
        global $servers;

        if (! empty($limit)) {
            $limit = 'LIMIT ' . (int) $limit;
        }

        $sql = "SELECT v.* FROM `videos` AS `v`,`video_responses` AS `vr` WHERE
                vr.video_response_to_video_id='" . (int) $video_id . "' AND
                vr.video_response_active='1' AND
                vr.video_response_video_id=v.video_id
                ORDER BY vr.video_response_add_time DESC
                $limit";
        $result = DB::query($sql);

        $video_info = array();

        if (mysqli_num_rows($result) > 0) {
            while ($video = mysqli_fetch_assoc($result)) {
                $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
                $video_info[] = $video;
            }
        }

        return $video_info;
    }

    public static function getById($video_id) {
        $sql = "SELECT * FROM `videos` WHERE
                `video_id`=" . (int) $video_id;
        return DB::fetch1($sql);
    }
}
