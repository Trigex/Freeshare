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
require 'include/language/' . LANG . '/lang_search_group.php';

$t1 = $_SERVER['REQUEST_TIME'];

if (isset($_GET['search'])) {
    $_GET['search'] = htmlspecialchars_uni($_GET['search']);
    $_GET['search'] = str_replace("<", ' ', $_GET['search']);
    $_GET['search'] = str_replace(">", ' ', $_GET['search']);
    $_GET['search'] = str_replace("(", ' ', $_GET['search']);
    $_GET['search'] = str_replace(")", ' ', $_GET['search']);
    $_GET['search'] = str_replace('"', ' ', $_GET['search']);
} else {
    $err = $lang['search_empty'];
}

if ($_GET['search'] == '') {
    $err = $lang['search_empty'];
}

if ($err == '') {

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    if ($page < 1) {
        $page = 1;
    }

    $search_string = DB::quote($_GET['search']);

    $sql = "SELECT count(*) AS `total` FROM `groups` WHERE (
           `group_name` LIKE '%$search_string%' OR
           `group_keyword` LIKE '%$search_string%' OR
           `group_description` LIKE '%$search_string%')";
    $total = DB::getTotal($sql);

    if ($total > 0) {
        $start_from = ($page - 1) * $config['items_per_page'];

        $sql = "SELECT * FROM `groups` WHERE (
               `group_name` LIKE '%$search_string%' OR
               `group_keyword` LIKE '%$search_string%' OR
               `group_description` LIKE '%$search_string%')
                LIMIT $start_from, $config[items_per_page]";
        $groups = DB::fetch($sql);
        $group_keywords_all = '';

        foreach ($groups as $group) {
            $group['group_keywords_array'] = explode(' ', $group['group_keyword']);
            $group_keywords_all .= $group['group_keyword'] . ' ';
            $group_info[] = $group;
        }

        $view = array();
        $group_keywords_array_all = explode(' ', $group_keywords_all);
        $view['group_keywords_array_all'] = array_remove_duplicate($group_keywords_array_all);

        $start_num = $start_from + 1;
        $end_num = $start_from + count($groups);

        $page_link = '';
        $total_page = $total / $config['items_per_page'];

        for ($k = 1; $k <= $total_page; $k ++) {
            $page_link .= "<a href=\"search_group.php?page=$k&search=$_GET[search]\">$k</a>&nbsp;&nbsp;";
        }

        $view['groups'] = $group_info;

        $smarty->assign('view', $view);
        $smarty->assign('page', $page);
        $smarty->assign('total', $total);
        $smarty->assign('start_num', $start_num);
        $smarty->assign('end_num', $end_num);
        $smarty->assign('page_link', $page_link);
    } else {
        $err = $lang['group_not_found'];
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', "menu_groups.tpl");
$smarty->display('header.tpl');
$t2 = time();
$smarty->assign('ttime', ($t2 - $t1));
if ($err == '') $smarty->display('search_group.tpl');
$smarty->display('footer.tpl');
DB::close();
