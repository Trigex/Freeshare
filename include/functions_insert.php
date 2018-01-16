<?php

function insert_tags()
{
    $sql = "SELECT * FROM `tags` WHERE
           `active`='1' AND
           `tag_count` > 0
            ORDER BY `used_on` DESC
            LIMIT " . Config::get('home_num_tags');
    $tags_all = DB::fetch($sql);

    if (! $tags_all) {
        return '';
    }

    require 'HTML/TagCloud.php';
    $tags = new HTML_TagCloud();

    foreach ($tags_all as $tag) {
        $tag_url = VSHARE_URL . '/tag/' . mb_strtolower($tag['tag']) . '/';
        $tags->addElement($tag['tag'], $tag_url, $tag['tag_count'], $tag['used_on']);
    }

    return $tags->buildHTML();
}

/*
function insert_show_videos($a)
{
    if ($a['type'] == "top") {
        $query = "ORDER BY `video_view_number` DESC";
    } else if ($a['type'] == 'new') {
        $query = "ORDER BY `video_add_time` DESC";
    } else if ($a['type'] == 'recently_viewed') {
        $query = "ORDER BY `video_view_time` DESC";
    } else if ($a['type'] == 'featured') {
        $query = "AND `video_featured`='yes' ORDER BY `video_add_time` DESC";
    }

    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`=1 AND
           `video_approve`=1 " . $query . "
            LIMIT " . (int) $a['num_videos'];
    $result = mysql_query($sql) or mysql_die($sql);

    if ($a['type'] == 'featured' && mysql_num_rows($result) < 1) {
        $sql = "SELECT * FROM videos WHERE
               `video_type`='public' AND
               `video_active`='1' AND
               `video_approve`='1'
                LIMIT " . (int) $a['num_videos'];
        $result = mysql_query($sql) or mysql_die($sql);
    }

    while ($video_info = mysql_fetch_assoc($result)) {
        $videos[] = $video_info;
    }

    return $videos;
}
*/

function insert_id_to_name($id)
{
    $sql = "SELECT `user_name` FROM `users` WHERE
           `user_id`='" . (int) $id['un'] . "'";
    $tmp = DB::fetch1($sql);
    return $tmp['user_name'];
}

function insert_time_range($info)
{
    global $config , $conn;
    $range = '';
    $present = $_SERVER['REQUEST_TIME'];
    $addtime = $info['time'];
    $interval = $present - $addtime;

    if ($interval > 0) {
        $day = $interval / (60 * 60 * 24);

        if ($day >= 1) {
            $range = floor($day) . ' days ';
            $interval = $interval - (60 * 60 * 24 * floor($day));
        }

        if ($interval > 0 && $range == '') {
            $hour = $interval / (60 * 60);
            if ($hour >= 1) {
                $range = floor($hour) . ' hours ';
                $interval = $interval - (60 * 60 * floor($hour));
            }
        }

        if ($interval > 0 && $range == '') {
            $min = $interval / (60);
            if ($min >= 1) {
                $range = floor($min) . ' minutes ';
                $interval = $interval - (60 * floor($min));
            }
        }

        if ($interval > 0 && $range == '') {
            $scn = $interval;
            if ($scn >= 1) {
                $range = $scn . ' seconds ';
            }
        }

        if ($range != '') {
            $range = $range . ' ago';
        } else {
            $range = 'just now';
        }

        return $range;
    } else {
        return '1 seconds ago';
    }
}

function insert_time_to_date($a)
{
    global $conn;
    $date = date('F j, Y, g:i a', $a['tm']);
    return $date;
}

function insert_video_channel($a)
{
    $a['tbl'] = isset($a['tbl']) ? $a['tbl'] : '';

    if ($a['tbl'] == '') {
        $sqlx = "`video_channels` AS `channel` FROM `videos` WHERE `video_id`='" . (int) $a['vid'] . "'";
    } else {
        $sqlx = "`group_channels` FROM `groups` WHERE `group_id`='" . (int) $a['gid'] . "'";
    }

    $sql = "SELECT $sqlx";
    $tmp = DB::fetch1($sql);

    if ($a['tbl'] == '') {
        $ch_id = explode('|', $tmp['channel']);
    } else {
        $ch_id = explode('|', $tmp['group_channels']);
    }

    for ($i = 0; $i < count($ch_id); $i ++) {
        if (! empty($ch_id[$i])) {
            $sql = "SELECT `channel_id`,`channel_name`,`channel_seo_name` FROM `channels` WHERE
                   `channel_id`='" . (int) $ch_id[$i] . "'";
            $ch_info[] = DB::fetch1($sql);
        }
    }

    return $ch_info;
}

function insert_show_rate($a)
{
    global $conn , $config;
    $list = '';
    $rate = $a['rte'];
    $rating = $a['rated'];

    if ($rate != 0) {
        $rate = $rate / $rating;
        $num_full_star = floor($rate);

        for ($i = 0; $i < $num_full_star; $i ++) {
            $list .= '<img src="' . IMG_CSS_URL . '/images/star.gif" alt="star">&nbsp;';
        }

        if ($rate == $num_full_star) {
            $num_falf_star = 0;
        } else {
            $num_falf_star = 1;
            $list .= '<img src="' . IMG_CSS_URL . '/images/half_star.gif" alt="half star">';
        }

        $num_blank_star = 5 - $num_full_star - $num_falf_star;

        for ($i = 0; $i < $num_blank_star; $i ++) {
            $list .= '<img src="' . IMG_CSS_URL . '/images/blank_star.gif" alt="blank star">';
        }
    } else {
        $rate = 0;
    }

    if ($rate > 0) {
        return $list;
    } else {
        return 'Not yet rated';
    }
}

function insert_row_count($a)
{
    global $conn;
    $execute_query = 1;

    $table_arr = array(
        'group_members',
        'group_videos',
        'group_topics'
    );

    if (! in_array($a['table'], $table_arr)) {
        $execute_query = 0;
    }

    $field_arr1 = array(
        'group_member_group_id',
        'group_video_group_id',
        'group_topic_group_id'
    );

    if (! in_array($a['field1'], $field_arr1)) {
        $execute_query = 0;
    }

    $field_arr2 = array(
        'group_member_approved',
        'group_video_approved',
        'group_topic_approved'
    );

    if (! in_array($a['field2'], $field_arr2)) {
        $execute_query = 0;
    }

    if ($execute_query == 1) {
        $sql = "SELECT count(*) AS `total` FROM `$a[table]` WHERE
	           `$a[field1]`='" . (int) $a['group_id'] . "' AND
               `$a[field2]`='yes'";
        return DB::getTotal($sql);
    } else {
        return 'error';
    }
}

function insert_channel_count($a)
{
    global $sql_adult_filter;

    $dt = date('Y-m-d');

    $sql_extra = ' AND `video_active`=1 AND `video_approve`=1';
    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_channels` LIKE '%|$a[cid]|%' AND
           `video_add_date`='$dt'
            $sql_extra
            $sql_adult_filter";
    $list[0] = DB::getTotal($sql);

    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_channels` LIKE '%|$a[cid]|%'
            $sql_extra
            $sql_adult_filter";
    $list[1] = DB::getTotal($sql);

    $sql = "SELECT count(*) AS `total` FROM `groups` WHERE
           `group_channels` LIKE '%|$a[cid]|%'";
    $list[2] = DB::getTotal($sql);
    return $list;
}

/*
function insert_get_photo($a)
{
    global $conn;
    $sql = "SELECT max(video_id) AS `vid` FROM `videos` WHERE
           `video_user_id`='" . (int) $a['uid'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    return $tmp['vid'];
}

function insert_video_info($a)
{
    global $conn;
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $a['vid'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $x[] = $tmp;
    return $x;
}

function insert_comment_info($a)
{
    global $conn;
    $sql = "SELECT * FROM `comments` WHERE
           `comment_video_id`='" . (int) $a['vid'] . "'
            ORDER BY `comment_id` ASC";
    $result = mysql_query($sql) or mysql_die($sql);
    while ($comment_info = mysql_fetch_assoc($result)) {
        $comment_info['comment_text'] = nl2br($comment_info['comment_text']);
        $comments[] = $comment_info;
    }
    return $comments;
}
*/

function insert_comment_count($a)
{
    $sql = "SELECT count(*) AS `total` FROM `comments` WHERE
           `comment_video_id`='" . (int) $a['vid'] . "'";
    return DB::getTotal($sql);
}

function insert_video_count($a)
{
    $add = '';
    $a['type'] = isset($a['type']) ? $a['type'] : 'public';

    if ($a['type'] == 'public') {
        $add = " AND `video_type`='public'";
    } else if ($a['type'] == 'private') {
        $add = " AND `video_type`='private'";
    }

    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_user_id`='" . (int) $a['uid'] . "'
            $add AND
           `video_approve`='1' AND
           `video_active`='1'";
    return DB::getTotal($sql);
}

function insert_favour_count($a)
{
    $sql = "SELECT count(*) AS `total` FROM
           `videos` AS `v`,
           `favourite` AS `f` WHERE
            f.favourite_user_id='" . (int) $a['uid'] . "' AND
            f.favourite_video_id=v.video_id";
    return DB::getTotal($sql);
}

function insert_playlist_count($a)
{
    $sql = "SELECT count(*) AS `total` FROM `playlists` WHERE
           `playlist_user_id`='" . (int) $a['uid'] . "'";
    return DB::getTotal($sql);
}

function insert_msg_count()
{
    $sql = "SELECT count(*) AS `total` FROM `mails` WHERE
           `mail_receiver`='" . DB::quote($_SESSION['USERNAME']) . "' AND
           `mail_read`='0' AND
           `mail_inbox_track`='2'";
    return DB::getTotal($sql);
}

function insert_friends_count($a)
{
    $sql = "SELECT count(*) AS `total` FROM `friends` WHERE
           `friend_user_id`='" . (int) $a['uid'] . "' AND
           `friend_status`='Confirmed'";
    return DB::getTotal($sql);
}

function insert_recently_active_users($a)
{
    $sql = "SELECT DISTINCT `user_login_user_id` FROM `user_logins`
            ORDER BY `user_login_id` DESC
            LIMIT " . Config::get('num_last_users_online');
    return DB::fetch($sql);
}

function insert_group_count($a)
{
    $a['chid'] = isset($a['chid']) ? $a['chid'] : '';
    $a['uid'] = isset($a['uid']) ? $a['uid'] : '';
    $a['type'] = isset($a['type']) ? $a['type'] : 'public';

    if ($a['chid'] != '') {
        $from = 'groups';
        $add1 = "WHERE `group_channels` LIKE '%|$a[chid]|%' ";
    }

    if ($a['uid'] != '') {
        $add1 = "WHERE m.group_member_group_id=o.group_id AND m.group_member_user_id='" . (int) $a['uid'] . "'";
        $from = "`groups` AS o,`group_members` AS m";
    }

    if ($a['type'] == 'public') {
        $add2 = "AND `group_type`='public'";
    }

    if ($a['type'] == 'private') {
        $add2 = "AND `group_type`='private'";
    }

    $sql = "SELECT count(*) AS `total` FROM $from
            $add1 $add2";
    return DB::getTotal($sql);
}

function insert_group_info_count($a)
{
    $sql_extra = '';
    $execute_query = 1;

    if (isset($a['query'])) {
        if ($a['query'] == 1) {
            $sql_extra = "AND `$a[field1]`='yes'";
        }
    }

    if ($a['tbl'] == 'groups') {
        $sql = "SELECT count(*) AS `total` FROM `groups` WHERE
               `group_id`='" . (int) $a['gid'] . "' " . $sql_extra;
        return DB::getTotal($sql);
    } else {
        $table_arr = array(
            'group_members',
            'group_videos',
            'group_topics'
        );

        if (! in_array($a['tbl'], $table_arr)) {
            $execute_query = 0;
        }

        $field_arr1 = array(
            'group_member_approved',
            'group_video_approved',
            'group_topic_approved'
        );

        if (! in_array($a['field1'], $field_arr1)) {
            $execute_query = 0;
        }

        $field_arr2 = array(
            'group_member_group_id',
            'group_video_group_id',
            'group_topic_group_id'
        );

        if (! in_array($a['field2'], $field_arr2)) {
            $execute_query = 0;
        }

        if ($execute_query == 1) {
            $sql = "SELECT count(*) AS `total` FROM `$a[tbl]` WHERE
    				`$a[field2]`='" . (int) $a['gid'] . "' " . $sql_extra;
            return DB::getTotal($sql);
        } else {
            return "error";
        }
    }
}

function insert_topic_count($a)
{
    $sql = "SELECT count(*) AS `total` FROM `group_topics` WHERE
           `group_topic_group_id`='" . (int) $a['GID'] . "' AND
           `group_topic_approved`='yes'";
    return DB::getTotal($sql);
}

function insert__count($a)
{
    $sql = "SELECT count(*) AS `total` FROM `group_topics` WHERE
           `group_topic_group_id`='" . (int) $a['GID'] . "' AND
           `group_topic_approved`='yes'";
    return DB::getTotal($sql);
}

function insert_post_count($a)
{
    $sql = "SELECT count(*) AS `total` FROM `group_topic_posts` WHERE
           `group_topic_post_topic_id`='" . (int) $a['TID'] . "'";
    return DB::getTotal($sql);
}

function insert_group_image($a)
{
    global $servers;
    $group_image_video_id = 0;

    $sql = "SELECT * FROM `groups` WHERE
           `group_id`='" . (int) $a['gid'] . "'";
    $tmp = DB::fetch1($sql);

    if ($tmp['group_image'] == 'owner_only') {
        $group_image_video_id = $tmp['group_image_video'];
    } else {
        $sql = "SELECT `group_video_video_id` FROM " . DB::quote($a['tbl']) . " WHERE
               `group_video_group_id`='" . (int) $a['gid'] . "'
                ORDER BY `AID` DESC
                LIMIT 1";
        $tmp = DB::fetch1($sql);

        if ($tmp) {
            $group_image_video_id = $tmp['group_video_video_id'];
        }
    }

    if ($group_image_video_id != 0) {
        $sql = "SELECT video_id,video_folder,video_thumb_server_id FROM `videos` WHERE
    			`video_id`=$group_image_video_id";
        $tmp = DB::fetch1($sql);

        $tmp['video_thumb_url'] = $servers[$tmp['video_thumb_server_id']];
        return $tmp;
    } else {
        return 0;
    }

}

function insert_member_img($a)
{
    global $config , $servers;

    $user_id = $a['UID'];
    $photo_type = isset($a['type']) ? $a['type'] : 0;
    $img_size = 'width=80 height=60';

    if ($photo_type == 1) {
        $img_size = 'width="50"';
    }

    $sql = "SELECT `user_photo` FROM `users` WHERE
    	   `user_id`='" . (int) $user_id . "'";
    $user_info = DB::fetch1($sql);

    if ($user_info['user_photo'] == 1) {
        if ($photo_type == 1) {
            echo '<img class="preview" src="' . VSHARE_URL . '/photo/1_' . $user_id . '.jpg" alt="user image" />';
        } else {
            echo '<img class="preview" src="' . VSHARE_URL . '/photo/' . $user_id . '.jpg" alt="user image" />';
        }
    } else {
        $sql = "SELECT `video_id`, `video_folder`, `video_thumb_server_id` FROM `videos` WHERE
               `video_user_id`='" . (int) $user_id . "' AND
               `video_active`=1 AND
               `video_approve`=1
                ORDER BY `video_id` DESC
                LIMIT 1";
        $user_recent_video = DB::fetch1($sql);

        if ($user_recent_video) {
            echo '<img class="preview" src="' . $servers[$user_recent_video['video_thumb_server_id']] . '/thumb/' . $user_recent_video['video_folder'] . '1_' . $user_recent_video['video_id'] . '.jpg"' . $img_size . ' alt="" />';
        } else {
            echo '<img class="preview" src="' . IMG_CSS_URL . '/images/no_pic.gif"' . $img_size . ' alt="" />';
        }
    }
}

function insert_member_img_url($a)
{
    global $config , $servers;

    $user_id = $a['UID'];
    $photo_type = isset($a['type']) ? $a['type'] : 0;
    $sql = "SELECT `user_photo` FROM `users` WHERE
           `user_id`='" . (int) $user_id . "'";
    $user_info = DB::fetch1($sql);

    $src_url = IMG_CSS_URL . '/images/no_pic.gif';

    if ($user_info['user_photo'] == 1) {
        if ($photo_type == 1) {
            $src_url = VSHARE_URL . '/photo/1_' . $user_id . '.jpg';
        } else {
            $src_url = VSHARE_URL . '/photo/' . $user_id . '.jpg';
        }
    } else {
        $sql = "SELECT `video_id`, `video_folder`, `video_thumb_server_id` FROM `videos` WHERE
               `video_user_id`='" . (int) $user_id . "' AND
               `video_active`=1 AND
               `video_approve`=1
                ORDER BY `video_id` DESC
                LIMIT 1";
        $user_recent_video = DB::fetch1($sql);

        if ($user_recent_video) {
            $src_url = $servers[$user_recent_video['video_thumb_server_id']] . '/thumb/' . $user_recent_video['video_folder'] . '1_' . $user_recent_video['video_id'] . '.jpg';
        }
    }

    echo $src_url;
}

function insert_check_group_mem($a)
{
    global $conn;

    if ($_SESSION['UID'] != '') {
        $sql = "SELECT count(*) AS `total` FROM `group_members` WHERE
               `group_member_group_id`='" . (int) $a['gid'] . "' AND
               `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
        return DB::getTotal($sql);
    } else {
        return 0;
    }
}

function insert_timediff($var)
{
    $mytime = $var['time'];
    $now = $_SERVER['REQUEST_TIME'];
    $diff = $now - $mytime;
    $second = $diff % 60;
    $minutes = ($diff / 60) % 60;
    $hours = ($diff / 3600) % 24;
    $days = ($diff / (3600 * 24)) % 30;
    $months = ($diff / (3600 * 24 * 30)) % 12;
    $years = ($diff / (3600 * 24 * 30 * 12)) % 10000;

    $x = array();
    $x['days'] = $days;
    $x['hours'] = $hours;
    $x['minutes'] = $minutes;
    $x['seconds'] = $second;

    if ($years == 1) {
        echo "$years year ago";
    } else if ($years > 1) {
        echo "$years years ago";
    } else if ($months == 1) {
        echo "$months month ago";
    } else if ($months > 1) {
        echo "$months months ago";
    } else if ($days == 1) {
        echo "$days day ago";
    } else if ($days > 1) {
        echo "$days days ago";
    } else if ($hours == 1) {
        echo "$hours hour ago";
    } else if ($hours > 1) {
        echo "$hours hours ago";
    } else if ($minutes == 1) {
        echo "$minutes minute ago";
    } else if ($minutes > 1) {
        echo "$minutes minutes ago";
    } else if ($second == 1) {
        echo "$second second ago";
    } else if ($second > 1) {
        echo "$second seconds ago";
    }
}

function insert_showlist($v)
{
    $sql = "SELECT `friend_type` FROM `friends` WHERE
           `friend_id`=" . (int) $v['id'];
    $tmp = DB::fetch1($sql);
    $type = str_replace('All|', '', $tmp['friend_type']);
    $type = str_replace('All', '', $type);
    $type = str_replace('|', ', ', $type);
    return $type;
}

function insert_getfield($v)
{
    global $conn;
    $execute_query = 1;

    $table_arr = array(
        'groups',
        'group_topic_posts',
        'videos',
        'users'
    );

    if (! in_array($v['table'], $table_arr)) {
        $execute_query = 0;
    }

    $field_arr = array(
        'group_owner_id',
        'group_topic_post_date',
        'video_title',
        'video_seo_name',
        'video_user_id',
        'user_website'
    );

    if (! in_array($v['field'], $field_arr)) {
        $execute_query = 0;
    }

    $qfield_arr = array(
        'group_id',
        'group_topic_post_topic_id',
        'video_id',
        'group_owner_id',
        'user_id'
    );

    if (! in_array($v['qfield'], $qfield_arr)) {
        $execute_query = 0;
    }

    if (isset($v['order'])) {

        $order_arr = array(
            'order by group_topic_post_id desc',
            'order by video_id desc',
            'order by user_id desc',
            'order by group_id desc'
        );

        if (! in_array(strtolower($v['order']), $order_arr)) {
            $execute_query = 0;
        }
    } else {
        $v['order'] = '';
    }

    if ($execute_query == 1) {
        $sql = "SELECT `$v[field]` FROM `$v[table]` WHERE
               `$v[qfield]`='" . DB::quote($v['qvalue']) . "' " . DB::quote($v['order']);
        $tmp = DB::fetch1($sql);
        return $tmp[$v['field']];
    }
}

function insert_format_size($v)
{
    $size = $v['size'];
    if ($v['type'] == 'byte') {

    } else {
        if ($size < 1024) {
            $output = round($size, 2) . ' MB';
        } else if ($size < 1024 * 1024) {
            $output = round($size / 1024, 2) . ' GB';
        }
    }
    echo $output;
}

function insert_advertise($v)
{
    $sql = "SELECT `adv_text` FROM `adv` WHERE
           `adv_name`='" . DB::quote($v['adv_name']) . "' AND
           `adv_status`='Active'";
    $tmp = DB::fetch1($sql);
    echo $tmp['adv_text'];
}

/*
function insert_adv_status($v)
{
    global $conn;
    $sql = "SELECT `adv_status` FROM `adv` WHERE
           `adv_name`='" . DB::quote($v['adv_name']) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    return $tmp['adv_status'];
}
*/

function insert_subscriber_info($v)
{
    $sql = "SELECT s.pack_id, `package_name`, `used_space`, `used_bw`, `total_video`, `expired_time` FROM
           `subscriber` AS `s`,
           `packages` AS `p` WHERE
           `UID`='" . (int) $v['uid'] . "' AND
            s.pack_id=p.package_id";
    return DB::fetch1($sql);
}

/*
function insert_id_to_uploaddate($v)
{
    global $conn;
    $sql = "SELECT `video_add_date` FROM `videos` WHERE
           `video_id`='" . (int) $v['un'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $list = explode('-', $tmp['video_add_date']);

    print_r($list[2]);
    print_r('-');
    print_r($list[1]);
    print_r('-');
    print_r($list[0]);
}
*/

function insert_voter_name($voter_id)
{
    $sql = "SELECT * FROM `users` WHERE
           `user_id`='" . (int) $voter_id['id'] . "'";
    $tmp = DB::fetch1($sql);
    $name['name'] = $tmp['user_name'];
    $photo_dir = VSHARE_DIR . '/photo/' . $voter_id['id'] . '.jpg';
    if ($tmp['user_photo'] == 1) {
        $photo_url = VSHARE_URL . '/photo/' . $voter_id['id'] . '.jpg';
    } else {
        $photo_url = IMG_CSS_URL . '/images/no_pic.gif';
    }
    $name['voter_photo'] = $photo_url;
    return $name;
}

function insert_show_stats()
{
    $stats = array();
    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_active`='1' AND
           `video_approve`='1'";
    $stats['total_video'] = DB::getTotal($sql);

    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_active`='1' AND
           `video_approve`='1' AND
           `video_type`='public'";
    $stats['total_public_video'] = DB::getTotal($sql);

    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_active`='1' AND
           `video_approve`='1' AND
           `video_type`='private'";
    $stats['total_private_video'] = DB::getTotal($sql);

    $sql = "SELECT count(user_id) AS `total` FROM `users`";
    $stats['total_users'] = DB::getTotal($sql);

    $sql = "SELECT count(*) AS `total` FROM `channels`";
    $stats['total_channel'] = DB::getTotal($sql);

    $sql = "SELECT count(*) AS `total` FROM `groups`";
    $stats['total_groups'] = DB::getTotal($sql);
    return $stats;
}

function insert_user_rate($a)
{
    $sql = "SELECT count(*) AS `total`,sum(vote) FROM `uservote` WHERE
	       `candate_id`=" . (int) $a['user_id'] . "
	        GROUP BY `candate_id`";
    $vote_info = DB::fetch1($sql);
    $list = '<div style="cursor: pointer;">';
    $rate = $vote_info['sum(vote)'];
    $rating = $vote_info['total'];

    if ($rating) {
        $rate = $rate / $rating;
        $num_full_star = floor($rate);
    } else {
        $rate = 0;
        $num_full_star = 0;
    }

    $count = 0;

    for ($i = 0; $i < $num_full_star; $i ++) {
        $count ++;
        $list .= '<img src="' . IMG_CSS_URL . '/images/star.gif" onclick="user_rate(' . $_SESSION['UID'] . ',' . $a['user_id'] . ',' . $count . ');" alt="rate" />&nbsp;';
    }

    if ($rate == $num_full_star) {
        $num_falf_star = 0;
    } else {
        $num_falf_star = 1;
        $list .= '<img src="' . IMG_CSS_URL . '/images/half_star.gif" onclick="user_rate(' . $_SESSION['UID'] . ',' . $a['user_id'] . ',' . $count . ');" alt="rate" />';
    }

    $num_blank_star = 5 - $num_full_star - $num_falf_star;

    for ($i = 0; $i < $num_blank_star; $i ++) {
        $count ++;
        $list .= '<img src="' . IMG_CSS_URL . '/images/blank_star.gif" onclick="user_rate(' . $_SESSION['UID'] . ',' . $a['user_id'] . ',' . $count . ');" alt="rate" />';
    }

    $list .= '</div>';
    echo $list;
}

function insert_video_response_count($a)
{
    $sql = "SELECT count(*) AS `total` FROM `video_responses` WHERE
           `video_response_to_video_id`='" . (int) $a['video_id'] . "' AND
           `video_response_active`='1'";
    return DB::getTotal($sql);
}

function insert_video_rating($a)
{
    return VideoRating::showRate($a['id']);
}

function insert_video_like($a)
{
    $video_id = $a['id'];
    $video_info = Video::getById($video_id);
    $class = 'btn btn-default';

    if (isset($_SESSION['UID'])) {
        $voters = explode('|', $video_info['video_voter_id']);
        if (in_array($_SESSION['UID'], $voters)) {
            $class = 'btn btn-success disabled';
        }
    }

    $output = '
    <button class="btn-like ' . $class . '" title="I like this">
        <span class="glyphicon glyphicon-thumbs-up"></span>
        <span id="like-count">' . $video_info['video_rated_by'] . '</span>
    </button>';
    return $output;
}