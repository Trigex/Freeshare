<?php

require '../include/config.php';

$video_id = isset($_GET['video_id']) ? $_GET['video_id'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (! is_numeric($video_id)) {
    echo "Hacking attempt";
    exit();
}

$sql = "SELECT count(*) `total` FROM `comments` WHERE
       `comment_video_id`='" . (int) $video_id . "'";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $config['video_comments_per_page'];

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array();
$params['mode'] = 'Sliding';
$params['perPage'] = $config['video_comments_per_page'];
$params['linkClass'] = 'btn btn-default';
$params['curPageLinkClassName'] = 'btn btn-default disabled';
$params['delta'] = 2;
$params['totalItems'] = $total;
$params['nextImg'] = '&raquo;';
$params['prevImg'] = '&laquo;';
$params['urlVar'] = 'page';
$params['path'] = '';
$params['append'] = false;
$params['fileName'] = 'javascript:show_comments(' . $video_id . ',%d)';

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$comment_links = $links['all'];
$comment_link_next = $links['next'];

$sql = "SELECT * FROM
       `comments` AS c,
       `users` AS u,
       `videos` AS v WHERE
        c.comment_video_id=" . (int) $video_id . " AND
        c.comment_user_id=u.user_id AND
        v.video_id=c.comment_video_id
        ORDER BY c.comment_id DESC
        LIMIT $start_from, $config[video_comments_per_page]";
$comments = DB::fetch($sql);

$smarty->assign('comment_link_next', $comment_link_next);
$smarty->assign('links', $comment_links);
$smarty->assign('comments', $comments);
$smarty->assign('video_id', $video_id);
$smarty->display('video_comments.tpl');
DB::close();
