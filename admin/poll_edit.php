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

require 'admin_config.php';
require '../include/config.php';
require '../include/language/' . LANG . '/admin/poll_edit.php';

Admin::auth();

$poll_id = isset($_GET['poll_id']) ? $_GET['poll_id'] : 0;

if (isset($_POST['submit'])) {
    $poll_id = isset($_POST['poll_id']) ? $_POST['poll_id'] : 0;

    $poll_question = $_POST['poll_question'];
    $poll_answer_array = $_POST['edit_poll_answers'];

    for ($i = 0; $i < count($poll_answer_array); $i ++) {
        if ($poll_answer_array[$i] == '') {
            $err = $lang['poll_answer_empty'];
        }
    }

    if ($err == '') {
        $poll_answers = implode('|', $poll_answer_array);
        $end_day = $_POST['end_date_year'] . '-' . $_POST['end_date_month'] . '-' . $_POST['end_date_day'];
        $start_day = $_POST['start_date_year'] . '-' . $_POST['start_date_month'] . '-' . $_POST['start_date_day'];

        if (strtotime($start_day) > strtotime($end_day)) {
            $err = $lang['poll_date_invalid'];
        } else {
            $sql = "UPDATE `poll_question` SET
             `poll_qty`='" . DB::quote($poll_question) . "',
             `poll_answer`='" . DB::quote($poll_answers) . "',
             `start_date`='$start_day',
             `end_date`='$end_day' WHERE
             `poll_id`='" . (int) $poll_id . "'";
            DB::query($sql);
            set_message($lang['poll_updated'], 'success');
            $redirect_url = VSHARE_URL . '/admin/poll_list.php';
            Http::redirect($redirect_url);
        }
    }
}

$sql = "SELECT * FROM `poll_question` WHERE
       `poll_id`='" . (int) $poll_id . "'";
$poll_info = DB::fetch1($sql);

$list = array(
    $poll_info['poll_answer']
);

$start_date = array(
    $poll_info['start_date']
);

$end_date = array(
    $poll_info['end_date']
);

$start_date = explode('-', $poll_info['start_date']);
$end_date = explode('-', $poll_info['end_date']);
$list = explode('|', $poll_info['poll_answer']);
$smarty->assign('poll_id', $poll_info['poll_id']);
$smarty->assign('poll_qty', $poll_info['poll_qty']);
$smarty->assign('list', $list);

$start_year = $start_date[0];
$start_month = $start_date[1];
$start_day = $start_date[2];

$end_year = $end_date[0];
$end_month = $end_date[1];
$end_date = $end_date[2];

$month_start = months($start_month);
$days_start = days($start_day);
$year_start = cc_year($start_year);

$month_end = months($end_month);
$days_end = days($end_date);
$year_end = cc_year($end_year);

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('days_start', $days_start);
$smarty->assign('month_start', $month_start);
$smarty->assign('year_start', $year_start);
$smarty->assign('days_end', $days_end);
$smarty->assign('month_end', $month_end);
$smarty->assign('year_end', $year_end);
$smarty->display('admin/header.tpl');
$smarty->display('admin/poll_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
