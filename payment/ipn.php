<?php

require '../include/config.php';

$admin_email = $config['admin_email'];

$ipn_debug = 1;

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";

if ($config['enable_test_payment'] == 'yes') {
    $paypal_url = 'ssl://www.sandbox.paypal.com';
    $header .= "Host: www.sandbox.paypal.com:443\r\n";
} else {
    $paypal_url = 'ssl://ipnpb.paypal.com';
    $header .= "Host: ipnpb.paypal.com:443\r\n";
}

$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

$fp = fsockopen($paypal_url, 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$business = $_POST['business'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$mc_gross = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$receiver_id = $_POST['receiver_id'];
$quantity = $_POST['quantity'];
$num_cart_items = $_POST['num_cart_items'];
$payment_date = $_POST['payment_date'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$payment_type = $_POST['payment_type'];
$payment_status = $_POST['payment_status'];
$payment_gross = $_POST['payment_gross'];
$payment_fee = $_POST['payment_fee'];
$settle_amount = $_POST['settle_amount'];
$memo = $_POST['memo'];
$payer_email = $_POST['payer_email'];
$txn_type = $_POST['txn_type'];
$payer_status = $_POST['payer_status'];
$address_street = $_POST['address_street'];
$address_city = $_POST['address_city'];
$address_state = $_POST['address_state'];
$address_zip = $_POST['address_zip'];
$address_country = $_POST['address_country'];
$address_status = $_POST['address_status'];
$item_number = $_POST['item_number'];
$tax = $_POST['tax'];
$option_name1 = $_POST['option_name1'];
$option_selection1 = $_POST['option_selection1'];
$option_name2 = $_POST['option_name2'];
$option_selection2 = $_POST['option_selection2'];
$for_auction = $_POST['for_auction'];
$invoice = $_POST['invoice'];
$custom = $_POST['custom'];
$notify_version = $_POST['notify_version'];
$verify_sign = $_POST['verify_sign'];
$payer_business_name = $_POST['payer_business_name'];
$payer_id = $_POST['payer_id'];
$mc_currency = $_POST['mc_currency'];
$mc_fee = $_POST['mc_fee'];
$exchange_rate = $_POST['exchange_rate'];
$settle_currency = $_POST['settle_currency'];
$parent_txn_id = $_POST['parent_txn_id'];

$custom = urldecode($_POST['custom']);

$message = <<<message
----------------------------------
PAYPAL IPN DATA
----------------------------------
item_name = $item_name
business = $business
payment_status = $payment_status
mc_gross = $mc_gross
payment_currency = $payment_currency
txn_id = $txn_id
receiver_email = $receiver_email
receiver_id = $receiver_id
quantity = $quantity
payment_date = $payment_date
first_name = $first_name
last_name = $last_name
payment_type = $payment_type
payment_status = $payment_status
payment_gross = $payment_gross
payer_email = $payer_email
txn_type = $txn_type
payer_status = $payer_status
address_street = $address_street
address_city = $address_city
address_state = $address_state
address_zip = $address_zip
address_country = $address_country
address_status = $address_status
item_number = $item_number
tax = $tax
option_name1 = $option_name1
option_selection1 = $option_selection1
option_name2 = $option_name2
option_selection2 = $option_selection2
for_auction = $for_auction
invoice = $invoice
custom = $custom
notify_version = $notify_version
verify_sign = $verify_sign
payer_business_name = $payer_business_name
payer_id = $payer_id
mc_currency = $mc_currency
mc_fee = $mc_fee
exchange_rate = $exchange_rate
settle_currency  = $settle_currency
parent_txn_id  = $parent_txn_id

message;

$name = $config['site_name'];
$from = $config['admin_email'];

if (! $fp) {
    if ($ipn_debug) {
        mail($admin_email, "[IPN] UNABLE TO CONNECT PAYPAL", $message);
    }
} else {

    fputs($fp, $header . $req);

    while (! feof($fp)) {

        $res = fgets($fp, 1024);

        if (strcmp($res, "VERIFIED") == 0) {

            # payment_currency is correct
            if ($config["paypal_currency"] != $mc_currency) {
                $error[] = "Fraud attempt was detected. (Payer uses another currency then site)";
            }

            # Check receiver email
            if (strtolower($receiver_email) != strtolower($config["paypal_receiver_email"])) {
                $error[] = "Fraud attempt was detected. (PayPal's receiver email is not equal to attempting's receiver email: $receiver_email)";
            }

            // check the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that payment_amount/payment_currency are correct
            // process payment
            // if 'VERIFIED', send an email of IPN variables and values to the specified email address


            if (count($error) == 0) {

                if ($ipn_debug) {
                    mail($admin_email, "VERIFIED IPN", $message);
                }

                $sql_log = '';

                ####################### PAYMENT SUCCESS START ############################


                $custom_array = explode('|', $custom);
                $userid = $custom_array[0];
                $pack_id = $custom_array[1];
                $period = $custom_array[2];
                $the_price = $custom_array[3];
                $vshare_payment_id = $custom_array[4];

                $expired_time = date("Y-m-d H:i:s", strtotime("+$period"));

                $sql = "UPDATE subscriber SET
                       `pack_id`='$pack_id',
                       `subscribe_time`='" . date("Y-m-d H:i:s") . "',
                       `expired_time`='" . DB::quote($expired_time) . "' WHERE
                       `UID`='" . (int) $userid . "'";
                DB::query($sql);
                $sql_log .= "<p>$sql</p>";

                $sql = "UPDATE `payments` SET
                       `payment_completed`='1' WHERE
                       `payment_id`='" . (int) $vshare_payment_id . "'";
                DB::query($sql);
                $sql_log .= "<p>$sql</p>";

                $sql = "UPDATE `users` SET
                       `user_account_status`='Active' WHERE
                       `user_id`='$userid'";
                DB::query($sql);
                $sql_log .= "<p>$sql</p>";

                $user_info = User::getById($userid);
                $to = $user_info['user_email'];
                $username = $user_info['user_name'];

                $sql = "SELECT * from `packages` WHERE
    	               `package_id`=$pack_id";
                $package_info = DB::fetch1($sql);
                $package_name = $package_info['package_name'];

                $vshare_url = VSHARE_URL;

                $body = "
	            <P>Hello  $username,</P>
	            <P>Your payment received successfully. Your payment status is:</P>
	            <table>
	            <tr><td>Package:</td><td>$pack_name</td></tr>
	            <tr><td>You have paid:</td><td>$$the_price</td></tr>
	            <tr><td>Subscribed for:</td><td>$period</td></tr>
	            <tr><td>Expire Date:</td><td>$expired_time</td></tr>
	            </table>
	            <P><a href='$vshare_url/login'>Click here</a> to login the site.</P>
	            <P>Thank You,</p>
	            <P>$config[site_name] Team</p>
	            ";

                $headers = "From: " . $from . "\n";
                $headers .= "Content-Type: text/html\n";
                $subj = "Receipt for your payment to" . $config['site_name'];

                mail("$to", "$subj", "$body", "$headers");

                ####################### PAYMENT SUCCESS ############################ END


                ####################### SEND MAIL TO ADMIN ############################


                $message_admin = <<<EOT
                <table>
                <tr><td>User: $username</td></tr>
                <tr><td>Package: $package_name</td></tr>
                <tr><td>Amount: $the_price</td></tr>
                <tr><td>Period: $period</td></tr>
                <tr><td>Expiry Date: $expired_time</td></tr>
                <tr><td>Payer Email: $payer_email</td></tr>
                <tr><td>Total: $mc_gross</td></tr>
                <tr><td>Payment Date: $payment_date</td></tr>
                <tr><td>----</td></tr>
                <tr><td>$sql_log</td></tr>
                </table>
EOT;

                $subject = $config["site_name"] . " - Got Payment";

                mail($admin_email, $subject, $message_admin, $headers);

    ####################### SEND MAIL TO ADMIN ############################  END


            } else {

                if ($ipn_debug) {

                    $error_list = implode("\n", $error);

                    $message = "
                    <p>$message</p>
                    <p>===============================</p>
                    <p>ERRORS</p>
                    <p>===============================</p>
                    <p>$error_list</p>
                    ";

                    $headers = "From: " . $from . "\n";
                    $headers .= "Content-Type: text/html\n";

                    mail($admin_email, "VERIFIED IPN WITH ERRORS", $message, $headers);
                }
            }
        } else if (strcmp($res, "INVALID") == 0) {
            if ($ipn_debug) {
                mail($admin_email, "INVALID IPN", $message);
            }
        }
    }
    fclose($fp);
}
