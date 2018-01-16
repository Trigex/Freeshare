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
require 'include/language/' . LANG . '/lang_friends.php';

User::is_logged_in();

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_GET['add_list'])) {
    $add_list = trim($_GET['add_list']);

    if (! empty($add_list)) {
        Friend::addList($add_list);
        set_message($lang['list_created'], 'success');
    }

    Http::redirect(VSHARE_URL . '/friends/');
}

if (isset($_GET['del_list'])) {
    $del_list = trim($_GET['del_list']);

    if (! empty($del_list)) {
        Friend::removeList($del_list);
        set_message($lang['list_deleted'], 'success');
    }

    Http::redirect(VSHARE_URL . '/friends/');
}

if (isset($_POST['action_name'])) {
    if ($_POST['action_name'] == 'delete') {
        if (! empty($_POST['AID'])) {
            foreach ($_POST['AID'] as $key => $friend_id) {
                Friend::delete($friend_id);
            }

            set_message($lang['friends_deleted'], 'success');
        }
    } else {
        $sql = "SELECT `user_friends_type` FROM `users` WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        $user_info = DB::fetch1($sql);
        $user_friends_types = explode('|', $user_info['user_friends_type']);

        $action = explode('_', $_POST['action_name']);

        if (is_numeric($action[1])) {
            if ($action[0] == 'add' && is_numeric($action[1])) {
                if (! empty($_POST['AID'])) {
                    foreach ($_POST['AID'] as $key => $friend_id) {
                        Friend::addToList($friend_id, $user_friends_types[$action[1]]);
                    }

                    set_message($lang['friends_added'], 'success');
                }
            } elseif ($action[0] == 'delete' && is_numeric($action[1])) {
                if (! empty($_POST['AID'])) {
                    foreach ($_POST['AID'] as $key => $friend_id) {
                        Friend::removeFromList($friend_id, $user_friends_types[$action[1]]);
                    }

                    set_message($lang['friends_removed'], 'success');
                }
            }

            Http::redirect(VSHARE_URL . '/friends/?view=' . $user_friends_types[$action[1]]);
        }
    }

    Http::redirect(VSHARE_URL . '/friends/');
}

$view = isset($_GET['view']) ? $_GET['view'] : 'All';
$smarty->assign('view', $view);

if ($view != 'All') {
    $query = "AND `friend_type` LIKE '%" . DB::quote($_GET['view']) . "%'";
} else {
    $query = '';
}

if (isset($_GET['sort']) && $_GET['sort'] == 'name') {
    $sort = "ORDER BY `friend_name`";
} else {
    $sort = "ORDER BY `friend_invite_date` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "'
        $query";
$total = DB::getTotal($sql);

$page_links = Paginate::getLinks2($total, $config['items_per_page'], './', $page);

$start_from = ($page - 1) * $config['items_per_page'];
$start = $start_from + 1;
$last = ($start_from + $config['items_per_page'] > $total) ? $total : $start_from + $config['items_per_page'];
$link = "<b>$start - $last of $total</b>&nbsp;&nbsp;";

$sql = "SELECT DISTINCT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "' $query $sort
        LIMIT $start_from, $config[items_per_page]";
$friends = DB::fetch($sql);
$total = count($friends);

$smarty->assign('friends', $friends);
$smarty->assign('total', $total);

$sql = "SELECT DISTINCT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "'";
$result = DB::fetch($sql);
$total_friends = count($result);

$smarty->assign('total_friends', $total_friends);

$sql = "SELECT `user_friends_type` FROM `users` WHERE
       `user_id`='" . (int) $_SESSION['UID'] . "'";
$friends_type = DB::fetch1($sql);

$ftype = explode('|', $friends_type['user_friends_type']);
sort($ftype);

$ftype_ops = '';

for ($i = 0; $i < count($ftype); $i ++) {
    if ($ftype[$i] != '') {
        if ($view == $ftype[$i]) {
            $sel = 'selected';
        } else {
            $sel = '';
        }
        $ftype_ops .= "<option value='" . $ftype[$i] . "' $sel>" . $ftype[$i] . "</option>";
    }
}

$smarty->assign('ftype_ops', $ftype_ops);

$type = explode('|', $friends_type['user_friends_type']);
$type = array_splice($type, 1 - count($type));
$action_ops = '<option value="" selected="selected">--- Select Action ---</option>' . '<option disabled="disabled">Add to list:</option>';

for ($i = 0; $i < count($type); $i ++) {
    if (trim($type[$i]) != '') {
        $action_ops .= '<option value="add_' . ($i + 1) . '">&nbsp;&nbsp;&nbsp;&nbsp;' . $type[$i] . '</option>';
    }
}

$action_ops .= '<option disabled="disabled">delete from list:</option>';

for ($i = 0; $i < count($type); $i ++) {
    if (trim($type[$i]) != '') {
        $action_ops .= "<option value='delete_" . ($i + 1) . "'>&nbsp;&nbsp;&nbsp;&nbsp;$type[$i]</option>";
    }
}

$action_ops .= '<option value="delete">Delete Selected</option>';

$smarty->assign('action_ops', $action_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page_links', $page_links);
$smarty->assign('sub_menu', 'menu_friends.tpl');
$smarty->display('header.tpl');
$smarty->display('friends.tpl');
$smarty->display('footer.tpl');
DB::close();
