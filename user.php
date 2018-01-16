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
require 'include/language/' . LANG . '/lang_user.php';

$user_name = $_GET['user_name'];

$user_info = User::getByName($user_name);

if (! $user_info || in_array($user_info['user_account_status'], array('Inactive', 'Suspended'))) {
    require '404.php';
    exit();
}

$smarty->assign('user_info', $user_info);

if ($user_info['user_birth_date'] != '0000-00-00') {
    $age = User::findAge($user_info['user_birth_date']);
    $smarty->assign('age', $age);
}

# increase view count
$sql = "UPDATE `users` SET
       `user_profile_viewed`=`user_profile_viewed`+1 WHERE
       `user_name`='" . DB::quote($user_name) . "'";
DB::query($sql);

# show latest user video
$sql = "SELECT * FROM `videos` WHERE
       `video_user_id`='" . (int) $user_info['user_id'] . "' AND
       `video_type`='public' AND
       `video_approve`='1' AND
       `video_active`='1'
        ORDER BY `video_id` DESC
        LIMIT 8";
$new_views_array = DB::fetch($sql);
$new_videos = array();

foreach ($new_views_array AS $new_video) {
    $new_video['video_thumb_url'] = $servers[$new_video['video_thumb_server_id']];
    $new_videos[] = $new_video;
}

# show popular user video

$sql = "SELECT * FROM `videos` WHERE
       `video_user_id`='" . (int) $user_info['user_id'] . "' AND
       `video_type`='public' AND
       `video_approve`='1' AND
       `video_active`='1'
        ORDER BY `video_view_number` DESC
        LIMIT 8";
$popular_video_array = DB::fetch($sql);
$popular_videos = array();

foreach ($popular_video_array AS $popular_video) {
    $popular_video['video_thumb_url'] = $servers[$popular_video['video_thumb_server_id']];
    $popular_videos[] = $popular_video;
}

# show user friends

$sql = "SELECT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $user_info['user_id'] . "' AND
       `friend_status`='Confirmed'
        ORDER BY `friend_invite_date` DESC
        LIMIT 8";
$user_friends = DB::fetch($sql);
$smarty->assign('user_friends', $user_friends);

$chkuserflag = '';

if (isset($_SESSION['UID'])) {
    if ($_SESSION['UID'] == $user_info['user_id']) {
        $chkuserflag = 'self';
    } else {
        $chkuserflag = 'guest';
    }
}

if ($config['enable_package'] == 'yes' and isset($_SESSION['UID'])) {
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $user_info['user_id'] . "'";
    $u_info = DB::fetch1($sql);
    $smarty->assign('u_info', $u_info);

    $pack = Package::find($u_info['pack_id']);
    $smarty->assign('pack', $pack);
}

$photo_url = User::get_photo($user_info['user_photo'], $user_info['user_id']);

$is_friend = 'no';

if (isset($_SESSION['UID']))
{
    $sql = "SELECT * FROM `friends` WHERE
           `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `friend_name`='" . DB::quote($user_name) . "' AND
           `friend_status`='Confirmed'";

    if (DB::fetch1($sql)) {
        $is_friend = 'yes';
    }
}

$smarty->assign('is_friend', $is_friend);

$sql = "SELECT g.*, gm.group_member_group_id FROM
       `groups` AS g,`group_members` AS gm WHERE
        gm.group_member_group_id=g.group_id AND
        gm.group_member_user_id='" . (int) $user_info['user_id'] . "'
        ORDER BY g.group_create_time DESC
        LIMIT 8";
$groups = DB::fetch($sql);
$num_result = count($groups);
$smarty->assign('groups', $groups);

if (isset($_SESSION['UID']) && $_SESSION['UID'] == $user_info['user_id']) {
    $allow_playlist = $allow_favorite = $allow_friend = $allow_comment = $allow_private_message = 1;
} else {
    $allow_playlist = $user_info['user_playlist_public'];
    $allow_favorite = $user_info['user_favourite_public'];
    $allow_friend = $user_info['user_friend_invition'];
    $allow_comment = $user_info['user_profile_comment'];
    $allow_private_message = $user_info['user_private_message'];
}

$smarty->assign('allow_playlist', $allow_playlist);
$smarty->assign('allow_favorite', $allow_favorite);
$smarty->assign('allow_friend', $allow_friend);
$smarty->assign('allow_comment', $allow_comment);
$smarty->assign('allow_private_message', $allow_private_message);

if ($user_info['user_style'] == '')
{
    $user_css = '/css/profile/default.css';
}
else
{
    $user_css = '/css/profile/' . $user_info['user_style'] . '.css';
}

$html_extra = '
<script type="text/javascript">
    var user_id = ' . $user_info['user_id'] . ';
    $(function(){
        display_user_comments(1);
    });
</script>

<script type="text/javascript" src="' . VSHARE_URL . '/js/user_comment.js"></script>
<script type="text/javascript" src="' . VSHARE_URL . '/js/user_comment_display.js"></script>
<script type="text/javascript" src="' . VSHARE_URL . '/js/user_rate.js"></script>';

$smarty->assign('html_extra', $html_extra);
$smarty->assign('photo_url', $photo_url);
$smarty->assign('chkuserflag', $chkuserflag);
$smarty->assign('html_title', $user_name);
$smarty->assign('html_keywords', $user_name);
$smarty->assign('html_description', $user_name);
$smarty->assign('new_video', $new_videos);
$smarty->assign('new_video_total', count($new_videos));
$smarty->assign('videos', $new_videos);
$smarty->assign('popular', $popular_videos);
$smarty->assign('popular_total', count($popular_videos));
$smarty->assign('cover_photo_url', User::getCoverPhotoURL($user_info['user_id']));

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);

if ($err == '') {
    $smarty->assign('sub_menu', 'menu_user.tpl');
}

$smarty->display('header.tpl');

if ($err == '') {
    $smarty->display('user.tpl');
}

$smarty->display('footer.tpl');

DB::close();

