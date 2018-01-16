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
require 'include/language/' . LANG . '/lang_add_video.php';

User::is_logged_in();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$group_url = isset($_GET['group_url']) ? trim($_GET['group_url']) : '';

if (empty($group_url))
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

        if ($_SESSION['UID'] == $group_info['group_owner_id'])
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
        $redirect_url = VSHARE_URL . '/group/' . $group_url . '/add/' . $page;
        Http::redirect($redirect_url);
    }
    else
    {
        set_message($lang['group_not_member'], 'error');
        $redirect_url = VSHARE_URL . '/group/' . $group_url . '/add/' . $page;
        Http::redirect($redirect_url);
    }
}

$sql = "SELECT COUNT(*) AS `total` FROM `videos` WHERE
       `video_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `video_approve`='1' AND
       `video_active`='1'";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM `videos` WHERE
       `video_user_id`=" . (int) $_SESSION['UID'] . " AND
       `video_approve`='1' AND
       `video_active`='1'
        ORDER BY `video_add_time` DESC
        LIMIT $start_from, $config[items_per_page]";
$user_videos = DB::fetch($sql);
$num_result = count($user_videos);

if ($num_result > 0)
{
    $group_add_video_keywords_all = '';

    foreach ($user_videos as $video_row)
    {
        $sql = "SELECT * FROM `group_videos` WHERE
               `group_video_group_id`='" . (int) $group_info['group_id'] . "' AND
               `group_video_video_id`='" . (int) $video_row['video_id'] . "'";
        $tmp = DB::fetch1($sql);

        if (! $tmp)
        {
            $video_row['in_group'] = 0;
        }
        else
        {
            $video_row['in_group'] = 1;
        }

        $video_row['video_thumb_url'] = $servers[$video_row['video_thumb_server_id']];
        $video_row['video_keywords_array'] = explode(' ', $video_row['video_keywords']);
        $group_add_video_keywords_all .= $video_row['video_keywords'] . ' ';
        $videos[] = $video_row;
    }

    $group_video_keywords_array = explode(' ', $group_add_video_keywords_all);
    $group_video_keywords_array_new = array_remove_duplicate($group_video_keywords_array);

    $view = array();
    $view['group_add_video_keywords_array'] = $group_video_keywords_array_new;
    $smarty->assign('view', $view);
}
else
{
    $msg = $lang['no_videos'];
}

$start_num = $start_from + 1;
$end_num = $start_from + $num_result;

$page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);

if (isset($videos))
{
    $smarty->assign('videos', $videos);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_add_video.tpl');
$smarty->display('header.tpl');
$smarty->display('group_add_videos.tpl');
$smarty->display('footer.tpl');
DB::close();
