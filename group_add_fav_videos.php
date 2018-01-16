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
require 'include/language/' . LANG . '/lang_add_favour.php';

User::is_logged_in();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$group_url = isset($_GET['group_url']) ? trim($_GET['group_url']) : '';

if ($group_url == '')
{
    Http::redirect(VSHARE_URL);
}

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($group_url) . "'";
$group_info = DB::fetch1($sql);

if (! $group_info)
{
    Http::redirect(VSHARE_URL);
}

$smarty->assign('group_name', $group_info['group_name']);
$smarty->assign('group_info', $group_info);

if (isset($_POST['add_video']))
{
    $sql = "SELECT * FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
    $group_member = DB::fetch1($sql);

    if ($group_member)
    {
        $approved = 'no';

        if ($group_info['group_owner_id'] == $_SESSION['UID'])
        {
            $approved = 'yes';
        }

        if ($group_info['group_upload'] == 'immediate')
        {
            $approved = 'yes';
        }

        $sql = "INSERT INTO `group_videos` SET
               `group_video_group_id`='" . (int) $group_info['group_id'] . "',
               `group_video_video_id`='" . (int) $_POST['video_id'] . "',
               `group_video_member_id`='" . (int) $_SESSION['UID'] . "',
               `group_video_approved`='" . DB::quote($approved) . "'";
        DB::query($sql);

        if ($approved == 'no')
        {
            $msg = $lang['group_video_approve'];
        }
        else
        {
            $msg = $lang['group_video_added'];
        }

        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/group/' . $group_url . '/fav/' . $page;
        Http::redirect($redirect_url);
    }
    else
    {
        set_message($lang['group_not_member'], 'error');
        $redirect_url = VSHARE_URL . '/group/' . $group_url . '/fav/' . $page;
        Http::redirect($redirect_url);
    }
}

$sql = "SELECT count(*) AS `total` FROM
       `videos` AS v, `favourite` AS f WHERE
        f.favourite_user_id='" . (int) $_SESSION['UID'] . "' AND
        f.favourite_video_id=v.video_id";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM
       `videos` AS v,
       `favourite` AS f WHERE
        f.favourite_user_id='" . (int) $_SESSION['UID'] . "' AND
        f.favourite_video_id=v.video_id
        ORDER BY v.video_add_time DESC
        LIMIT $start_from, $config[items_per_page]";
$fav_videos = DB::fetch($sql);
$fav_videos_count = count($fav_videos);
$favorite_video_keywords = '';

if ($fav_videos_count > 0)
{
    foreach ($fav_videos as $row)
    {
        $sql = "SELECT * FROM `group_videos` WHERE
               `group_video_group_id`='" . (int) $group_info['group_id'] . "' AND
               `group_video_video_id`='" . (int) $row['video_id'] . "'";
        $tmp = DB::fetch1($sql);

        if ($tmp)
        {
            $row['in_group'] = 1;
        }
        else
        {
            $row['in_group'] = 0;
        }

        $row['video_keywords_array'] = explode(' ', $row['video_keywords']);
        $row['video_thumb_url'] = $servers[$row['video_thumb_server_id']];
        $favorite_videos[] = $row;
        $favorite_video_keywords .= $row['video_keywords'] . ' ';
    }

    $smarty->assign('favorite_videos', $favorite_videos);
}
else
{
    $msg = $lang['no_favorites'];
}

$video_keywords_array = explode(' ', $favorite_video_keywords);
$video_keywords_array = array_remove_duplicate($video_keywords_array);

$start_num = $start_from + 1;
$end_num = $start_from + $fav_videos_count;

$page_links = Paginate::getLinks($total, $config['items_per_page'], '.', '', $page);

$smarty->assign('favorite_video_keywords_array', $video_keywords_array);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('sub_menu', 'menu_add_video.tpl');
$smarty->display('header.tpl');
$smarty->display('group_add_fav_videos.tpl');
$smarty->display('footer.tpl');
DB::close();
