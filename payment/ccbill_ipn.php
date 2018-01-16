<?php

require '../include/config.php';

$accountingAmount = $_POST['accountingAmount'];
$address1 = $_POST['address1'];
$allowedTypes = $_POST['allowedTypes'];
$baseCurrency = $_POST['baseCurrency'];
$cardType = $_POST['cardType'];
$ccbill_referer = $_POST['ccbill_referer'];
$city = $_POST['city'];
$clientAccnum = $_POST['clientAccnum'];
$clientDrivenSettlement = $_POST['clientDrivenSettlement'];
$clientSubacc = $_POST['clientSubacc'];
$consumerUniqueId = $_POST['consumerUniqueId'];
$country = $_POST['country'];
$currencyCode = $_POST['currencyCode'];
$customer_fname = $_POST['customer_fname'];
$customer_lname = $_POST['customer_lname'];
$email = $_POST['email'];
$formName = $_POST['formName'];
$initialFormattedPrice = $_POST['initialFormattedPrice'];
$initialPeriod = $_POST['initialPeriod'];
$initialPrice = $_POST['initialPrice'];
$ip_address = $_POST['ip_address'];
$password = $_POST['password'];
$paymentAccount = $_POST['paymentAccount'];
$phone_number = $_POST['phone_number'];
$price = $_POST['price'];
$productDesc = $_POST['productDesc'];
$reasonForDecline = $_POST['reasonForDecline'];
$reasonForDeclineCode = $_POST['reasonForDeclineCode'];
$rebills = $_POST['rebills'];
$recurringFormattedPrice = $_POST['recurringFormattedPrice'];
$recurringPeriod = $_POST['recurringPeriod'];
$recurringPrice = $_POST['recurringPrice'];
$referer = $_POST['referer'];
$referringUrl = $_POST['referringUrl'];
$reservationId = $_POST['reservationId'];
$responseDigest = $_POST['responseDigest'];
$start_date = $_POST['start_date'];
$state = $_POST['state'];
$subscription_id = $_POST['subscription_id'];
$typeId = $_POST['typeId'];
$username = $_POST['username'];
$zipcode = $_POST['zipcode'];

$log_txt = <<<EOT
------------------------------
CCBill IPN DATA
------------------------------
accountingAmount = $accountingAmount
address1 = $address1
allowedTypes = $allowedTypes
baseCurrency = $baseCurrency
cardType = $cardType
ccbill_referer = $ccbill_referer
city = $city
clientAccnum = $clientAccnum
clientDrivenSettlement = $clientDrivenSettlement
clientSubacc = $clientSubacc
consumerUniqueId = $consumerUniqueId
country = $country
currencyCode = $currencyCode
customer_fname = $customer_fname
customer_lname = $customer_lname
email = $email
formName = $formName
initialFormattedPrice = $initialFormattedPrice
initialPeriod = $initialPeriod
initialPrice = $initialPrice
ip_address = $ip_address
password = $password
paymentAccount = $paymentAccount
phone_number = $phone_number
price = $price
productDesc = $productDesc
reasonForDecline = $reasonForDecline
reasonForDeclineCode = $reasonForDeclineCode
rebills = $rebills
recurringFormattedPrice = $recurringFormattedPrice
recurringPeriod = $recurringPeriod
recurringPrice = $recurringPrice
referer = $referer
referringUrl = $referringUrl
reservationId = $reservationId
responseDigest = $responseDigest
start_date = $start_date
state = $state
subscription_id = $subscription_id
typeId = $typeId
username = $username
zipcode = $zipcode
REMOTE_ADDR = {$_SERVER['REMOTE_ADDR']}
vshare_payment_id = {$_POST['vshare_payment_id']}


EOT;

if (empty($_POST['reasonForDeclineCode'])) {
    $sql = "SELECT * FROM `payments` WHERE
    	   `payment_id`='" . (int) $_POST['vshare_payment_id'] . "'";
    $payments = DB::fetch1($sql);

    $log_txt .= "$sql\n";

    if (! $payments) {
        $log_txt .= "PAYMENT INFO NOT FOUND\n";
    }

    $user_id = $payments['payment_user_id'];
    $package_id = $payments['payment_package_id'];
    $period = $payments['payment_period'];
    $price = $payments['payment_amount'];

    $sql = "SELECT * FROM `packages` WHERE
    	   `package_id`='" . (int) $package_id . "'";
    $package_info = DB::fetch1($sql);

    $log_txt .= "$sql\n";

    if ($package_info['package_period'] != 'Month' && $package_info['package_period'] != 'Year') {
        $package_info['package_period'] = 'Day';
    }

    $log_txt .= "package_period : {$package_info['package_period']}\n";

    $period = $period . ' ' . $package_info['package_period'];

    $log_txt .= "\$period : $period\n";

    $expired_time = date("Y-m-d H:i:s", strtotime("+$period"));

    $sql = "UPDATE `subscriber` SET
           `pack_id`='" . (int) $package_id . "',
           `subscribe_time`='" . date("Y-m-d H:i:s") . "',
           `expired_time`='" . DB::quote($expired_time) . "' WHERE
           `UID`='" . (int) $user_id . "'";
    DB::query($sql);

    $log_txt .= "$sql\n";

    $sql = "UPDATE `payments` SET
           `payment_completed`='1' WHERE
           `payment_id`='" . (int) $_POST['vshare_payment_id'] . "'";
    DB::query($sql);

    $log_txt .= "$sql\n";

    $sql = "UPDATE `users` SET
           `user_account_status`='Active' WHERE
           `user_id`='" . (int) $user_id . "'";
    DB::query($sql);

    $log_txt .= "$sql\n";

    $user_info = User::getById($user_id);
    $user_email = $user_info['user_email'];
    $username = $user_info['user_name'];

    $sql = "SELECT * FROM `packages` WHERE
    	   `package_id`='" . (int) $package_id . "'";
    $package_info = DB::fetch1($sql);
    $package_name = $package_info['package_name'];

    $log_txt .= "$sql\n";

    $vshare_url = VSHARE_URL;

    $body = "
	<P>Hello  $username,</P>

	<P>Your payment received successfully. Your payment status is:</P>

	<table>
	<tr><td>Package:</td><td>$package_name</td></tr>
	<tr><td>You have paid:</td><td>$$price</td></tr>
	<tr><td>Subscribed for:</td><td>$period</td></tr>
	<tr><td>Expire Date:</td><td>$expired_time</td></tr>
	</table>

	<P><a href='$vshare_url/login'>Click here</a> to login the site.</P>

	<P>Thank You,</p>

	<P>$config[site_name] Team</p>
    ";

    $headers = "From: " . $config['admin_email'] . "\n";
    $headers .= "Content-Type: text/html\n";
    $subj = "Receipt for your payment to" . $config['site_name'];

    mail("$user_email", "$subj", "$body", "$headers");

    $log_txt .= "$user_email\n$body\n";

    ####################### PAYMENT SUCCESS ########################### END


    ####################### SEND MAIL TO ADMIN ############################


    $message_admin = <<<EOT
User: $username
Package: $package_name
Amount: $price
Period: $period
Expiry Date: $expired_time
Payer Email: $email
Total: $accountingAmount
Payment Date: $start_date
----
$sql_log
EOT;

    $subject = $config['site_name'] . " - Got Payment";

    mail($config['admin_email'], $subject, $message_admin);

    $log_txt .= "$message_admin\n";

    ####################### SEND MAIL TO ADMIN ######################## END


} else {
    $log_txt .= "===============================\n";
    $log_txt .= "PAYMENT FAILED\n";
    $log_txt .= "===============================\n";
}

mail($config['admin_email'], 'CCBill PAYMENT LOG', $log_txt);
