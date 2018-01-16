<?php

require '../include/config.php';

User::is_logged_in();

$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (! is_numeric($page) || $page < 1) {
    $page = 1;
}

$mail_folder = isset($_GET['folder']) ? $_GET['folder'] : 'inbox';

$mail_folder_types = array(
    'inbox',
    'outbox'
);

if (! in_array($mail_folder, $mail_folder_types)) {
    $mail_folder = 'inbox';
}

if ($mail_folder == 'inbox') {
    $who = 'mail_receiver';
} else if ($mail_folder == 'outbox') {
    $who = 'mail_sender';
}

if ($mail_folder == 'inbox') {
    $show_photo = 'mail_sender';
} else if ($mail_folder == 'outbox') {
    $show_photo = 'mail_receiver';
}

$sql = "SELECT count(*) AS `total` FROM `mails` WHERE
        `$who`='" . DB::quote($_SESSION['USERNAME']) . "' AND
        `mail_" . $mail_folder . "_track`='2'";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT m.*,u.user_id FROM `mails` AS `m`, `users` AS `u` WHERE
        m.$who='" . DB::quote($_SESSION['USERNAME']) . "' AND
        m.mail_" . $mail_folder . "_track='2' AND
        m.$show_photo=u.user_name
        ORDER BY `mail_id` DESC
        LIMIT $start_from, $config[items_per_page]";
$mails_all = DB::fetch($sql);

$mails = array();

foreach ($mails_all as $mail) {
    $mail['mail_date'] = date('M d, Y', strtotime($mail['mail_date']));
    $mails[] = $mail;
}

$start_num = $start_from + 1;
$end_num = $start_from + count($mails);

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array(
    'mode' => 'Sliding',
    'perPage' => $config['items_per_page'],
    'linkClass' => 'btn btn-default',
    'curPageLinkClassName' => 'btn btn-default disabled',
    'delta' => 2,
    'totalItems' => $total,
    'urlVar' => 'page',
    'path' => '',
    'append' => false,
    'fileName' => 'javascript:mail.showbox("' . $mail_folder . '",%d)'
);

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$smarty->assign('mails', $mails);
$smarty->assign('mail_folder', $mail_folder);
$smarty->assign('mail_title', ucfirst($mail_folder));
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_link', $links['all']);
$smarty->assign('total', $total);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('error.tpl');
$smarty->display('mail_ajax.tpl');
DB::close();
