<?php

require '../include/config.php';

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) $page = 1;

$sql = "SELECT * FROM `users` WHERE
       `user_id`='" . (int) $user_id . "'";
$user_info = DB::fetch1($sql);

if ($user_info) {
    $sql = "SELECT count(*) AS `total` FROM `profile_comments` WHERE
           `profile_comment_user_id`='" . (int) $user_info['user_id'] . "'";
    $total = DB::getTotal($sql);
    if ($total > 0) {

        $start_from = ($page - 1) * $config['user_comments_per_page'];
        $sql = "SELECT * FROM `profile_comments` WHERE
               `profile_comment_user_id`='" . (int) $user_info['user_id'] . "'
                ORDER BY `profile_comment_id` DESC
                LIMIT $start_from, $config[user_comments_per_page]";
        $profile_comments = DB::fetch($sql);
        $smarty->assign('profile_comments', $profile_comments);

        require_once 'Pager/Pager.php';
        require_once 'Pager/Sliding.php';

        $params = array(
            'mode' => 'Sliding',
            'perPage' => $config['user_comments_per_page'],
            'delta' => 2,
            'totalItems' => $total,
            'nextImg' => 'Next &raquo;',
            'prevImg' => '&laquo; Prev',
            'urlVar' => 'page',
            'path' => '',
            'append' => false,
            'fileName' => 'javascript:display_user_comments(%d)',
            'linkClass' => 'btn btn-default',
            'curPageLinkClassName' => 'btn btn-default disabled'
        );

        $pager = new Pager_Sliding($params);
        $data = $pager->getPageData();
        $links = $pager->getLinks();

        $page_links = $links['all'];
        $smarty->assign('page_links', $page_links);

    }
    $smarty->display('user_comment.tpl');
} else {
    echo 'User not found.';
}
