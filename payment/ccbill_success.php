<?php

require '../include/config.php';

$smarty->assign('period', $period);
$exp_date = date('Y-m-d', strtotime("+$period"));
$smarty->assign('exp_date', $exp_date);
$smarty->display('header.tpl');
echo '<h2>Your payment is received successfully. Payment information has been sent to your email address.</h2>';
$smarty->display('footer.tpl');
DB::close();
