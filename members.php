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

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'video_uploaded';

if ($page < 1) {
    $page = 1;
}

$sort_array = array(
    'recent',
    'video_uploaded',
    'profile_viewed',
    'video_viewed',
    'subscribed'
);

if (! in_array($sort, $sort_array)) {
    $sort = 'recent';
}

if ($sort == 'video_uploaded') {
    $sql = "SELECT count(*) AS `total` FROM `users` WHERE `user_videos` > 0";
    $total = DB::getTotal($sql);
}
else if ($sort == 'subscribed')
{
    $sql = "SELECT u . * , count( s.subscription_to_user_id ) AS `total` FROM
		   `users` AS `u` , `subscriptions` AS `s` WHERE
			u.user_id=s.subscription_to_user_id AND
			u.user_account_status='Active'
			GROUP BY u.user_id";
    $result = DB::fetch($sql);
    $total = count($result);
}
else
{
    $sql = "SELECT count(*) AS `total` FROM `users` WHERE
	   	   `user_account_status`='Active'";
    $total = DB::getTotal($sql);
}

$start_from = ($page - 1) * $config['items_per_page'];

$title = '';

if ($sort == 'recent')
{
    $title = 'Most Recent';
    $sql = "SELECT * FROM `users` WHERE
		   `user_account_status`='Active'
			ORDER BY `user_id` DESC
			LIMIT $start_from, $config[items_per_page]";
}
else if ($sort == 'video_uploaded')
{
    $title = 'Most Video Uploaded';

    $sql = "SELECT * FROM `users` WHERE
            `user_videos` > 0
            ORDER BY `user_videos` DESC
            LIMIT $start_from, $config[items_per_page]";
}
else if ($sort == 'profile_viewed')
{
    $title = 'Most Profile Viewed';
    $sql = "SELECT * FROM `users` WHERE
		   `user_account_status`='Active'
		    ORDER BY `user_profile_viewed` DESC
		    LIMIT $start_from, $config[items_per_page]";
}
else if ($sort == 'video_viewed')
{
    $title = 'Most Video Viewed';
    $sql = "SELECT * FROM `users` WHERE
		   `user_account_status`='Active'
		    ORDER BY `user_watched_video` DESC
		    LIMIT $start_from, $config[items_per_page]";
}
else if ($sort == 'subscribed')
{
    $title = 'Most Subscribed';
    $sql = "SELECT u . * , count( s.subscription_to_user_id ) AS `total` FROM
		   `users` AS `u` , `subscriptions` AS `s` WHERE
		   	u.user_id = s.subscription_to_user_id AND
		   	u.user_account_status = 'Active'
		   	GROUP BY u.user_id
		   	ORDER BY `total` DESC
		   	LIMIT $start_from, $config[items_per_page]";
}

$users = DB::fetch($sql);
$results_on_this_page = count($users);

$members = array();
$i = 0;

foreach ($users as $user_info) {
    $members[$i] = $user_info;
    $members[$i]['photo_url'] = User::get_photo($user_info['user_photo'], $user_info['user_id']);
    $i ++;
}

$start_num = $start_from + 1;
$end_num = $start_from + $results_on_this_page;
$page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

$smarty->assign(array(
    'html_title' => $title . ' Members - page ' . $page,
    'html_description' => $title . ' Members - page ' . $page
));

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sort', $sort);
$smarty->assign('title', $title);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('members', $members);
$smarty->display('header.tpl');
$smarty->display('members.tpl');
$smarty->display('footer.tpl');
DB::close();
