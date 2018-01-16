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
require 'include/language/' . LANG . '/lang_user_groups.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$user_info = User::getByName($_GET['user_name']);

if (! $user_info) {
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$sql = "SELECT count(gm.group_member_group_id) AS `total` FROM
       `groups` AS g,
       `group_members` AS gm WHERE
        gm.group_member_group_id=g.group_id AND
        gm.group_member_user_id='" . (int) $user_info['user_id'] . "'";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT g.*, gm.group_member_group_id FROM
       `groups` AS g,`group_members` AS gm WHERE
        gm.group_member_group_id=g.group_id AND
        gm.group_member_user_id='" . (int) $user_info['user_id'] . "'
        ORDER BY g.group_create_time DESC
        LIMIT $start_from, $config[items_per_page]";
$groups_all = DB::fetch($sql);
$num_result = count($groups_all);

$user_group_keywords_all = '';

$groups = array();

foreach ($groups_all as $group) {
    $groups[] = $group;
    $user_group_keywords_all .= $group['group_keyword'] . ' ';
}

$user_group_keywords_array = explode(' ', $user_group_keywords_all);

$view = array();
$view['user_group_keywords_array'] = array_remove_duplicate($user_group_keywords_array);
$smarty->assign('view', $view);

$start_num = $start_from + 1;
$end_num = $start_from + $num_result;
$page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

$allow_playlist = $user_info['user_playlist_public'];
$allow_favorite = $user_info['user_favourite_public'];

if (isset($_SESSION['UID'])) {
    if ($_SESSION['UID'] == $user_info['user_id']) {
        $allow_playlist = $allow_favorite = 1;
    }
}

$smarty->assign('allow_playlist', $allow_playlist);
$smarty->assign('allow_favorite', $allow_favorite);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('groups', $groups);
$smarty->assign('user_info', $user_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_groups.tpl');
$smarty->display('footer.tpl');
DB::close();
