<?php

require '../include/config.php';

$group_id = isset($_GET['group_id']) ? (int) $_GET['group_id'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$ajax_debug = 0;

if ($page == 0 || !is_numeric($page)) {
	$page = 1;
}

if ($group_id == '') {
	$err = 'There is no groups';
	if ($ajax_debug) error_log("$err \n",3, VSHARE_DIR . '/ajax/log.txt');
	Ajax::returnJson($err,'error');
	exit;
}

$group_info = Group::getById($group_id);

if ($group_info) {

	if (isset($_SESSION['UID']) && $_SESSION['UID'] == $group_info['group_owner_id']) {
		$approved = '';
	} else  {
		$approved = " AND gt.group_topic_approved='yes'";
	}

	$sql = "SELECT count(*) as `total` FROM `group_topics` AS gt WHERE
		    gt.group_topic_group_id=" . (int) $group_info['group_id'] . "
		    $approved";
	$group_total_posts = DB::getTotal($sql);

	if ($group_total_posts > 0) {
			$start_from = ($page-1) * $config['items_per_page'];

			$sql = "SELECT * FROM
                   `group_topics` AS gt,
                   `users` AS u WHERE
	       			gt.group_topic_group_id=" . $group_info['group_id'] . " AND
					u.user_id=gt.group_topic_user_id
	       			$approved
	       			ORDER BY `group_topic_id` DESC
	       			LIMIT $start_from, $config[items_per_page]";
			$group_topics_all = DB::fetch($sql);

            $group_topics = array();

			foreach ($group_topics_all as $topics) {
				$topics['addtime'] = date('F j,Y H:i a',strtotime($topics['group_topic_add_time']));
				$group_topics[] = $topics;
			}

			$smarty->assign('group_info', $group_info);
			$smarty->assign('group_topics', $group_topics);

			$start_num = $start_from + 1;
			$end_num = $start_from + count($group_topics);

			require_once 'Pager/Pager.php';
			require_once 'Pager/Sliding.php';

			$params = array(
			    'mode'       => 'Sliding',
			    'perPage'    => $config['items_per_page'],
				'delta'      => 2,
				'totalItems' => $group_total_posts,
				'nextImg' => 'Next',
				'prevImg' => 'Previous',
				'urlVar'    => 'page',
				'path'      => '',
				'append' => false,
				'fileName' => 'javascript:display_topics(%d)'
			);

			$pager = new Pager_Sliding($params);
			$data = $pager->getPageData();
			$links = $pager->getLinks();

			$topics_links = $links['all'];
			$smarty->assign('topics_links',$topics_links);
			$smarty->assign('group_id',$group_id);

			$fetch_group_topics = $smarty->fetch('group_topics.tpl');
			Ajax::returnJson($fetch_group_topics,'success');
	}
} else  {
	$err = 'There is no groups';
	if ($ajax_debug) error_log("$err \n",3, VSHARE_DIR . '/ajax/log.txt');
	Ajax::returnJson($err,'error');
	exit;
}
