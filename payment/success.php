<?php

require '../include/config.php';

$custom_array = explode("|", $_POST['custom']);
$userid = $custom_array[0];
$pack_id = $custom_array[1];
$period = $custom_array[2];
$theprice = $custom_array[3];

$smarty->assign('period', $period);
$exp_date = date('Y-m-d', strtotime("+$period"));
$smarty->assign('exp_date', $exp_date);
$smarty->display('header.tpl');
$smarty->display('payment_success.tpl');
$smarty->display('footer.tpl');
DB::close();
