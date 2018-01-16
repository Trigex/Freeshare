<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LICENSE: http://buyscripts.in/vshare-license
 *   WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 *   This program is a commercial software and any kind of using it must agree
 *   to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'include/language/' . LANG . '/lang_group_videos.php';

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$group_url = htmlspecialchars_uni($_GET['group_url']);

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($group_url) . "'";
$group_info = DB::fetch1($sql);

if (! $group_info)
{
    $err = $lang['group_not_found'];
}

$html_title = '';

if ($err == '')
{
    $smarty->assign('group_info', $group_info);

    $is_member = '';

    if (isset($_SESSION['UID']))
    {
        $sql = "SELECT * FROM `group_members` WHERE
               `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
               `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
        $group_members_info = DB::fetch1($sql);
        $is_member = $group_members_info['group_member_approved'];
    }

    $smarty->assign('is_mem', $is_member);

    if (isset($_SESSION['UID']) && $_SESSION['UID'] == $group_info['group_owner_id'])
    {
        if (isset($_POST['group_image']))
        {
            $sql = "UPDATE `groups` SET
                   `group_image_video`='" . (int) $_POST['video_id'] . "' WHERE
                   `group_id`='" . (int) $group_info['group_id'] . "'";
            DB::query($sql);
            set_message($lang['group_image_set'], 'success');
            $redirect_url = VSHARE_URL . '/group/' . $group_url . '/videos/' . $page;
            Http::redirect($redirect_url);
        }

        if (isset($_POST['remove_image']))
        {
            $sql = "DELETE FROM `group_videos` WHERE
                   `group_video_video_id`='" . (int) $_POST['video_id'] . "' AND
                   `group_video_group_id`='" . (int) $group_info['group_id'] . "'";
            DB::query($sql);
            $msg = str_replace('[GROUP_NAME]', $group_info['group_name'], $lang['video_removed']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/group/' . $group_url . '/videos/' . $page;
            Http::redirect($redirect_url);
        }

        if (isset($_POST['approve_it']))
        {
            $sql = "UPDATE `group_videos` SET
                   `group_video_approved`='yes' WHERE
                   `group_video_group_id`='" . (int) $group_info['group_id'] . "' AND
                   `group_video_video_id`='" . (int) $_POST['video_id'] . "'";
            DB::query($sql);
            $msg = str_replace('[GROUP_NAME]', $group_info['group_name'], $lang['video_approved']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/group/' . $group_url . '/videos/' . $page;
            Http::redirect($redirect_url);
        }
    }

    if (isset($_SESSION['UID']) && $_SESSION['UID'] == $group_info['group_owner_id'])
    {
        $sql_extra = '';
    }
    else
    {
        $sql_extra = " AND `group_video_approved`='yes' ";
    }

    $sql = "SELECT count(*) AS `total` FROM
           `group_videos` AS gv,
           `videos` AS v WHERE
            gv.group_video_group_id='" . (int) $group_info['group_id'] . "'
            $sql_extra AND
            gv.group_video_video_id=v.video_id";
    $total = DB::getTotal($sql);

    $start_from = ($page - 1) * $config['items_per_page'];

    $sql = "SELECT * FROM
           `group_videos` AS gv,
           `videos` AS v WHERE
            gv.group_video_group_id='" . (int) $group_info['group_id'] . "'
            $sql_extra AND
            gv.group_video_video_id=v.video_id
            ORDER BY `AID` DESC
            LIMIT $start_from, $config[items_per_page]";
    $grp_videos = DB::fetch($sql);
    $num_videos = count($grp_videos);
    $group_videos = array();

    $group_video_keywords_all = '';

    foreach ($grp_videos as $group_video)
    {
        $group_video['video_thumb_url'] = $servers[$group_video['video_thumb_server_id']];
        $group_video['group_video_keywords'] = explode(' ',$group_video['video_keywords']);
        $group_video_keywords_all .= $group_video['video_keywords'] . ' ';
        $group_videos[] = $group_video;
    }

    $group_video_keywords_array = explode(' ',$group_video_keywords_all);

    $start_num = $start_from + 1;
    $end_num = $start_from + $num_videos;
    $page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

    $html_title = "$group_info[group_name] - Videos page $page";
}

$group_video_keywords_array_new = array_remove_duplicate($group_video_keywords_array);

$view = array();
$view['group_video_keywords_array'] = $group_video_keywords_array_new;

$smarty->assign(array(
    'html_title' => $html_title,
    'html_description' => $html_title,
    'html_keywords' => $html_title
));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('group_videos', $group_videos);
$smarty->assign('view',$view);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');

if ($err == '')
{
    $smarty->display('group_videos.tpl');
}

$smarty->display('footer.tpl');
DB::close();
