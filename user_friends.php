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

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$user_info = User::getByName($_GET['user_name']);

if (! $user_info) {
    $redirect_url = VSHARE_URL . '/';
    Http::redirect($redirect_url);
}

$sql = "SELECT count(*) AS `total` FROM `friends` WHERE
       `friend_user_id`='" . (int) $user_info['user_id'] . "' AND
       `friend_status`='Confirmed'";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $user_info['user_id'] . "' AND
       `friend_status`='Confirmed'
        ORDER BY `friend_invite_date` DESC
        LIMIT $start_from, $config[items_per_page]";
$friends = DB::fetch($sql);
$friends_count = count($friends);

$start_num = $start_from + 1;
$end_num = $start_from + $friends_count;

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
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('user_info', $user_info);
$smarty->assign('friends', $friends);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_friends.tpl');
$smarty->display('footer.tpl');
DB::close();
