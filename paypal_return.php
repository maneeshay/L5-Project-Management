<?php
session_start();
$order_no = $_SESSION["ss_last_order_no"];

$pp_acc = "sb-wnyyl6565753@business.example.com";
$at = "9DLGioaBLHIkCqd4tUDVDc-B_SOaIwrULG8sfSEftRFSz0hKfT9G22o9iYG"; //PDT Identity Token

// Alternate ID and tokens, also change $pp_acc in paypal.php if this is used
 //$pp_acc = "sb-wwm7v6631628@business.example.com";
//$at = "lYsSRxjmnhlQdnUZ-A37omP9AhMKV1X4c0TPCCzyEos07pxkH7HilgSpVoC"; //PDT Identity Token

$url = "https://www.sandbox.paypal.com/cgi-bin/webscr"; //Test
//$url = "https://www.paypal.com/cgi-bin/webscr"; //Live

$tx = $_REQUEST["tx"]; //this value is return by PayPal
$cmd = "_notify-synch";
$post_vars = "cmd=_notify-synch&tx=" . $tx . "&at=" . $at;

// send request to PayPal server using CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'cURL/PHP');


// the response is key-value pair string
$result = curl_exec($ch);
$error = curl_error($ch);

if (curl_errno($ch) != 0) {
    // CURL error
    echo ("ERROR: Failed updating order. PayPal PDT service failed.");
    exit();
}

$lines = explode("\n", $result);

if (strcmp($lines[0], "SUCCESS") == 0) {
    // if the payment is completed successfully
    $paypal_info = array();

    foreach ($lines as $line) {
        list($key, $val) = array_pad(explode('=', $line), 2, null);
        $paypal_info[urldecode($key)] = urldecode($val);
    }
    // check the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your Primary PayPal email
    // check that payment_amount/payment_currency are correct
    // process payment

    // capture the PayPal returned information
    $cur_time = gmdate("d/m/Y");
    // print_r($paypal_info);
    $first_name = $paypal_info['first_name'];
    $last_name = $paypal_info['last_name'];
    $item_name = $paypal_info['item_name'];
    $amount = $paypal_info['mc_gross'];
    $txn_id = $paypal_info["txn_id"];
    $txn_type = $paypal_info["txn_type"];
    $item_number = $paypal_info["item_number"];
    $payment_date = $paypal_info["payment_date"];
    $payment_type = $paypal_info["payment_type"];
    $payment_status = $paypal_info["payment_status"];
    $currency = $paypal_info["mc_currency"];
    $payment_gross = $paypal_info["payment_gross"];
    $payment_fee = $paypal_info["payment_fee"];
    $payer_email = $paypal_info["payer_email"];
    $payer_id = $paypal_info["payer_id"];
    $payer_name = $paypal_info["first_name"]
        . " " . $paypal_info["last_name"];
    $payer_status = $paypal_info["payer_status"];
    $country = $paypal_info["residence_country"];
    $business = $paypal_info["business"];
    $receiver_email = $paypal_info["receiver_email"];
    $receiver_id = $paypal_info["receiver_id"];
    echo (" <h2>Thank you for
    your purchase!</h2><br/><hr/><br/>");

    $oremarks =
        "##   $cur_time   ##<br/>" .
        "PayPal Transaction Information...<br/><hr/><hr/><br/>" .
        "Txn Id: " . $txn_id . "<br/>" .
        "Txn Type: " . $txn_type . "<br/>" .
        "Item Number: " . $item_number . "<br/>" .
        "Payment Date: " . $payment_date . "<br/>" .
        "Payment Type: " . $payment_type . "<br/>" .
        "Payment Status: " . $payment_status . "<br/>" .
        "Currency: " . $currency . "<br/>" .
        "Payment Gross: " . $payment_gross . "<br/>" .
        "Payment Fee: " . $payment_fee . "<br/>" .
        "Payer Email: " . $payer_email . "<br/>" .
        "Payer Id: " . $payer_id . "<br/>" .
        "Payer Name: " . $payer_name . "<br/>" .
        "Payer Status: " . $payer_status . "<br/>" .
        "Country: " . $country . "<br/>" .
        "Business: " . $business . "<br/>" .
        "Receiver Email: " . $receiver_email . "<br/>" .
        "Receiver Id: " . $receiver_id . "<br/>";

    echo ($oremarks);
} else if (strcmp($lines[0], "FAIL") == 0) {
    // if the payment process fails
    echo ("<h2>Sorry, something went wrong</h2>");
}