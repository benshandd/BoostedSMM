<?php
// Include Header file
require 'db.php';
include 'header.php';

/*
 * Use PaytmResponse Class
 * Use PaystackResponse Class
 * Use StripeResponse Class
 * Use RazorpayResponse Class
 * Use InstamojoResponse Class
 * Use IyzicoResponse Class
 * Use PaypalIpnResponse Class
 * Use BitPayResponse Class
 * Use MercadopagoResponse Class
 * Use PayUmoneyResponse Class
 * Use MollieResponse Class
 * Use RavepayResponse Class
 * Use PagseguroResponse Class
 */

use App\Components\Payment\PaytmResponse;
use App\Components\Payment\PaystackResponse;
use App\Components\Payment\StripeResponse;
use App\Components\Payment\RazorpayResponse;
use App\Components\Payment\InstamojoResponse;
use App\Components\Payment\IyzicoResponse;
use App\Components\Payment\PaypalIpnResponse;
use App\Components\Payment\BitPayResponse;
use App\Components\Payment\MercadopagoResponse;
use App\Components\Payment\PayUmoneyResponse;
use App\Components\Payment\MollieResponse;
use App\Components\Payment\RavepayResponse;
use App\Components\Payment\PagseguroResponse;

function countRow($data)
{
    global $conn;
    $where = '';
    if ($data['where']) {
        $where = 'WHERE ';
        foreach ($data['where'] as $key => $value) {
            $where .= ' ' . $key . '=:' . $key . ' && ';
            $execute[$key] = $value;
        }
        $where = substr($where, 0, -3);
    } else {
        $execute[] = '';
    }
    $row = $conn->prepare('SELECT * FROM ' . $data['table'] . ' ' . $where . ' ');
    $row->execute($execute);
    $validate = $row->rowCount();
    return $validate;
}

function GetIP()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) $ip = $_SERVER['REMOTE_ADDR'];
    else $ip = "unknown";
    return ($ip);
}

// Get Config Data 
$configData = configItem();
// Get Request Data when payment success or failed
$requestData = $_REQUEST;

$settings = $conn->prepare('SELECT * FROM settings  WHERE id=:id');
$settings->execute(array('id' => 1));
$settings = $settings->fetch(PDO::FETCH_ASSOC);

// Check payment Method is paytm
if ($requestData['paymentOption'] == 'paytm') {
    // Get Payment Response instance
    $paytmResponse  = new PaytmResponse();

    // Fetch payment data using payment response instance
    $paytmData = $paytmResponse->getPaytmPaymentData($requestData);

    // Check if payment status is success
    if ($paytmData['STATUS'] == 'TXN_SUCCESS') {

        // Create payment success response data.
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData($paytmData['ORDERID'], $paytmData['TXNAMOUNT'], $paytmData['TXNID'], 'paytm')
        ];
        // Send data to payment response.
        paymentResponse($paymentResponseData);
    } else {
        // Create payment failed response data.
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData($paytmData['ORDERID'], $paytmData['TXNAMOUNT'], $paytmData['TXNID'], 'paytm')
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }
    // Check payment method is instamojo
} else if ($requestData['paymentOption'] == 'instamojo') {

    // Check if payment successfully procced
    if ($requestData['payment_status'] == "Credit") {

        // Get Instance of instamojo response service
        $instamojoResponse  = new InstamojoResponse();

        // fetch payment data from instamojo response instance
        $instamojoData = $instamojoResponse->getInstamojoPaymentData($requestData);

        // Prepare data for payment response
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $instamojoData,
            'data'     => preparePaymentData($requestData['orderId'], $instamojoData['amount'], $instamojoData['payment_id'], 'instamojo')
        ];

        $hash = htmlspecialchars($requestData['orderId']);
        $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra');
        $payment->execute(array('extra' => $hash));
        $payment = $payment->fetch(PDO::FETCH_ASSOC);

        if (countRow(['table' => 'payments', 'where' => ['client_id' => $payment['client_id'], 'payment_method' => 13, 'payment_status' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]])) {
            if ($requestData['payment_status'] == 'Credit') {
                $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra ');
                $payment->execute(['extra' => $hash]);
                $payment = $payment->fetch(PDO::FETCH_ASSOC);


                if ($settings["site_currency"] == "USD") {
                    $payment['payment_amount'] = $payment['payment_amount'] / $settings["dolar_charge"];
                }


                $payment_bonus = $conn->prepare('SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1');
                $payment_bonus->execute(['method' => 13, 'from' => $payment['payment_amount']]);
                $payment_bonus = $payment_bonus->fetch(PDO::FETCH_ASSOC);
                if ($payment_bonus) {
                    $amount = $payment['payment_amount'] + (($payment['payment_amount'] * $payment_bonus['bonus_amount']) / 100);
                } else {
                    $amount = $payment['payment_amount'];
                }
                $conn->beginTransaction();

                $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                $update = $update->execute(['balance' => $payment['balance'], 'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);

                $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                $balance = $balance->execute(['id' => $payment['client_id'], 'balance' => $payment['balance'] + $amount]);

                $insert = $conn->prepare('INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ');
                if ($payment_bonus) {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with Instamojo and included %' . $payment_bonus['bonus_amount'] . ' bonus.', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                } else {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with Instamojo', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                }
                if ($update && $balance) {
                    $conn->commit();
                    echo 'OK';
                } else {
                    $conn->rollBack();
                    echo 'NO';
                }
            } else {
                $update = $conn->prepare('UPDATE payments SET payment_status=:payment_status WHERE client_id=:client_id, payment_method=:payment_method, payment_delivery=:payment_delivery, payment_extra=:payment_extra');
                $update = $update->execute(['payment_status' => 2, 'client_id' => $payment['client_id'], 'payment_method' => 13, 'payment_delivery' => 1, 'payment_extra' => $hash]);
            }
        }

        // Send data to payment response
        paymentResponse($paymentResponseData);
        // Check if payment failed then send failed response
    } else {
        // Prepare data for failed response data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $requestData,
            'data'     => preparePaymentData($requestData['orderId'], $instamojoData['amount'], null, 'instamojo')
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }

    // Check if payment method is iyzico.
} else if ($requestData['paymentOption'] == 'iyzico') {

    // Check if payment status is success for iyzico.
    if ($_REQUEST['status'] == 'success') {
        // Get iyzico response.
        $iyzicoResponse  = new IyzicoResponse();

        // fetch payment data using iyzico response instance.
        $iyzicoData = $iyzicoResponse->getIyzicoPaymentData($requestData);
        $rawResult = json_decode($iyzicoData->getRawResult(), true);

        // Check if iyzico payment data is success
        // Then create a array for success data
        if ($iyzicoData->getStatus() == 'success') {
            $paymentResponseData = [
                'status'   => true,
                'rawData'  => (array) $iyzicoData,
                'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], $rawResult['conversationId'], 'iyzico')
            ];

            $hash = htmlspecialchars($requestData['orderId']);
            $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra');
            $payment->execute(array('extra' => $hash));
            $payment = $payment->fetch(PDO::FETCH_ASSOC);

            if (countRow(['table' => 'payments', 'where' => ['client_id' => $payment['client_id'], 'payment_method' => 16, 'payment_status' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]])) {
                if ($iyzicoData->getStatus() == 'success') {
                    $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra ');
                    $payment->execute(['extra' => $hash]);
                    $payment = $payment->fetch(PDO::FETCH_ASSOC);
                    $payment_bonus = $conn->prepare('SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1');
                    $payment_bonus->execute(['method' => 16, 'from' => $payment['payment_amount']]);
                    $payment_bonus = $payment_bonus->fetch(PDO::FETCH_ASSOC);
                    if ($payment_bonus) {
                        $amount = $payment['payment_amount'] + (($payment['payment_amount'] * $payment_bonus['bonus_amount']) / 100);
                    } else {
                        $amount = $payment['payment_amount'];
                    }
                    $conn->beginTransaction();

                    $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                    $update = $update->execute(['balance' => $payment['balance'], 'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);

                    $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                    $balance = $balance->execute(['id' => $payment['client_id'], 'balance' => $payment['balance'] + $amount]);

                    $insert = $conn->prepare('INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ');
                    if ($payment_bonus) {
                        $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with Iyzico and included %' . $payment_bonus['bonus_amount'] . ' bonus.', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                    } else {
                        $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with Iyzico', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                    }
                    if ($update && $balance) {
                        $conn->commit();
                        echo 'OK';
                    } else {
                        $conn->rollBack();
                        echo 'NO';
                    }
                } else {
                    $update = $conn->prepare('UPDATE payments SET payment_status=:payment_status WHERE client_id=:client_id, payment_method=:payment_method, payment_delivery=:payment_delivery, payment_extra=:payment_extra');
                    $update = $update->execute(['payment_status' => 2, 'client_id' => $payment['client_id'], 'payment_method' => 16, 'payment_delivery' => 1, 'payment_extra' => $hash]);
                }
            }

            // Send data to payment response
            paymentResponse($paymentResponseData);
            // If payment failed then create data for failed
        } else {
            // Prepare failed payment data
            $paymentResponseData = [
                'status'   => false,
                'rawData'  => (array) $iyzicoData,
                'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], $rawResult['conversationId'], 'iyzico')
            ];
            // Send data to payment response
            paymentResponse($paymentResponseData);
        }
        // Check before 3d payment process payment failed
    } else {
        // Prepare failed payment data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $requestData,
            'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], null, 'iyzico')
        ];
        // Send data to process response
        paymentResponse($paymentResponseData);
    }

    // Check Paypal payment process
} else if ($requestData['paymentOption'] == 'paypal') {
    // Get instance of paypal
    $paypalIpnResponse  = new PaypalIpnResponse();

    // fetch paypal payment data
    $paypalIpnData = $paypalIpnResponse->getPaypalPaymentData();
    $rawData = json_decode($paypalIpnData, true);

    // Note : IPN and redirects will come here
    // Check if payment status exist and it is success
    if (isset($requestData['payment_status']) and $requestData['payment_status'] == "Completed") {

        // Then create a data for success paypal data
        $paymentResponseData = [
            'status'    => true,
            'rawData'   => (array) $paypalIpnData,
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], $rawData['txn_id'], 'paypal')
        ];

        $hash = htmlspecialchars($requestData['invoice']);
        $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra');
        $payment->execute(array('extra' => $hash));
        $payment = $payment->fetch(PDO::FETCH_ASSOC);

        if (countRow(['table' => 'payments', 'where' => ['client_id' => $payment['client_id'], 'payment_method' => 1, 'payment_status' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]])) {
            if ($requestData['payment_status'] == 'Completed') {
                $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra ');
                $payment->execute(['extra' => $hash]);
                $payment = $payment->fetch(PDO::FETCH_ASSOC);
                $payment_bonus = $conn->prepare('SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1');
                $payment_bonus->execute(['method' => 1, 'from' => $payment['payment_amount']]);
                $payment_bonus = $payment_bonus->fetch(PDO::FETCH_ASSOC);
                if ($payment_bonus) {
                    $amount = $payment['payment_amount'] + (($payment['payment_amount'] * $payment_bonus['bonus_amount']) / 100);
                } else {
                    $amount = $payment['payment_amount'];
                }
                $conn->beginTransaction();

                $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                $update = $update->execute(['balance' => $payment['balance'], 'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);

                $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                $balance = $balance->execute(['id' => $payment['client_id'], 'balance' => $payment['balance'] + $amount]);

                $insert = $conn->prepare('INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ');
                if ($payment_bonus) {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' ' . $requestData['mc_currency'] . ' payment has been made with Paypal and included %' . $payment_bonus['bonus_amount'] . ' bonus.', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                } else {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' ' . $requestData['mc_currency'] . ' payment has been made with Paypal', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                }
                if ($update && $balance) {
                    $conn->commit();
                    echo 'OK';
                } else {
                    $conn->rollBack();
                    echo 'NO';
                }
            } else {
                $update = $conn->prepare('UPDATE payments SET payment_status=:payment_status WHERE client_id=:client_id, payment_method=:payment_method, payment_delivery=:payment_delivery, payment_extra=:payment_extra');
                $update = $update->execute(['payment_status' => 2, 'client_id' => $payment['client_id'], 'payment_method' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]);
            }
        }

        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
        // Check if payment not successful    
    } else {
        // Prepare payment failed data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => [],
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], null, 'paypal')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    }

    // Check Paystack payment process
} else if ($requestData['paymentOption'] == 'paystack') {

    $requestData = json_decode($requestData['response'], true);

    // Check if status key exists and payment is successfully completed
    if (isset($requestData['status']) and $requestData['status'] == "success") {
        // Create data for payment success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['data']['reference'], $requestData['data']['amount'], $requestData['data']['reference'], 'paystack')
        ];

        $hash = htmlspecialchars($requestData['data']['customer']['email']);
        $hash = explode('@', $hash);
        $hash = $hash[0];
        $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra');
        $payment->execute(array('extra' => $hash));
        $payment = $payment->fetch(PDO::FETCH_ASSOC);

        // file_put_contents('C:\xampp\htdocs\smm\a.txt', json_encode($requestData));

        if (countRow(['table' => 'payments', 'where' => ['client_id' => $payment['client_id'], 'payment_method' => 14, 'payment_status' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]])) {
            if ($requestData['status'] == 'success') {
                $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra ');
                $payment->execute(['extra' => $hash]);
                $payment = $payment->fetch(PDO::FETCH_ASSOC);
                $payment_bonus = $conn->prepare('SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1');
                $payment_bonus->execute(['method' => 14, 'from' => $payment['payment_amount']]);
                $payment_bonus = $payment_bonus->fetch(PDO::FETCH_ASSOC);
                if ($payment_bonus) {
                    $amount = $payment['payment_amount'] + (($payment['payment_amount'] * $payment_bonus['bonus_amount']) / 100);
                } else {
                    $amount = $payment['payment_amount'];
                }
                $conn->beginTransaction();

                $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                $update = $update->execute(['balance' => $payment['balance'], 'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);

                $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                $balance = $balance->execute(['id' => $payment['client_id'], 'balance' => $payment['balance'] + $amount]);

                $insert = $conn->prepare('INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ');
                if ($payment_bonus) {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . $requestData['data']['currency'] . ' payment has been made with Razorpay and included %' . $payment_bonus['bonus_amount'] . ' bonus.', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                } else {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . $requestData['data']['currency'] . ' payment has been made with Razorpay', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                }
                if ($update && $balance) {
                    $conn->commit();
                    echo 'OK';
                } else {
                    $conn->rollBack();
                    echo 'NO';
                }
            } else {
                $update = $conn->prepare('UPDATE payments SET payment_status=:payment_status WHERE client_id=:client_id, payment_method=:payment_method, payment_delivery=:payment_delivery, payment_extra=:payment_extra');
                $update = $update->execute(['payment_status' => 2, 'client_id' => $payment['client_id'], 'payment_method' => 14, 'payment_delivery' => 1, 'payment_extra' => $hash]);
            }
        }

        // Send data to payment response for further process
        paymentResponse($paymentResponseData);
        // If paystack payment is failed    
    } else {
        // Prepare data for failed payment 
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['data']['reference'], $requestData['data']['amount'], $requestData['data']['reference'], 'paystack')
        ];
        // Send data to payment response to further process
        paymentResponse($paymentResponseData);
    }

    // Check Stripe payment process
} else if ($requestData['paymentOption'] == 'stripe') {

    $stripeResponse = new StripeResponse();

    $stripeData = $stripeResponse->retrieveStripePaymentData($requestData['stripe_session_id']);

    // Check if payment charge status key exist in stripe data and it success
    if (isset($stripeData['status']) and $stripeData['status'] == "succeeded") {
        // Prepare data for success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $stripeData,
            'data'     => preparePaymentData($stripeData->charges->data[0]['balance_transaction'], $stripeData->amount, $stripeData->charges->data[0]['balance_transaction'], 'stripe')
        ];

        // Check if stripe data is failed    
    } else {
        // Prepare failed payment data
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $stripeData,
            'data'     => preparePaymentData($requestData['orderId'], $stripeData->amount, null, 'stripe')
        ];
    }

    // Send data to payment response for further process
    paymentResponse($paymentResponseData);

    // Check Razorpay payment process
} else if ($requestData['paymentOption'] == 'razorpay') {
    $orderId = $requestData['orderId'];

    $requestData = json_decode($requestData['response'], true);

    // Check if razorpay status exist and status is success
    if (isset($requestData['status']) and $requestData['status'] == 'captured') {
        // prepare payment data
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['id'], 'razorpay')
        ];

        $hash = htmlspecialchars($requestData['email']);
        $hash = explode('@', $hash);
        $hash = $hash[0];
        $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra');
        $payment->execute(array('extra' => $hash));
        $payment = $payment->fetch(PDO::FETCH_ASSOC);

        if (countRow(['table' => 'payments', 'where' => ['client_id' => $payment['client_id'], 'payment_method' => 15, 'payment_status' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]])) {
            if ($requestData['status'] == 'captured') {
                $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra ');
                $payment->execute(['extra' => $hash]);
                $payment = $payment->fetch(PDO::FETCH_ASSOC);
                $payment_bonus = $conn->prepare('SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1');
                $payment_bonus->execute(['method' => 15, 'from' => $payment['payment_amount']]);
                $payment_bonus = $payment_bonus->fetch(PDO::FETCH_ASSOC);
                if ($payment_bonus) {
                    $amount = $payment['payment_amount'] + (($payment['payment_amount'] * $payment_bonus['bonus_amount']) / 100);
                } else {
                    $amount = $payment['payment_amount'];
                }
                $conn->beginTransaction();

                $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                $update = $update->execute(['balance' => $payment['balance'], 'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);

                $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                $balance = $balance->execute(['id' => $payment['client_id'], 'balance' => $payment['balance'] + $amount]);

                $insert = $conn->prepare('INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ');
                if ($payment_bonus) {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . $requestData['currency'] . ' payment has been made with Razorpay and included %' . $payment_bonus['bonus_amount'] . ' bonus.', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                } else {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . $requestData['currency'] . ' payment has been made with Razorpay', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                }
                if ($update && $balance) {
                    $conn->commit();
                    echo 'OK';
                } else {
                    $conn->rollBack();
                    echo 'NO';
                }
            } else {
                $update = $conn->prepare('UPDATE payments SET payment_status=:payment_status WHERE client_id=:client_id, payment_method=:payment_method, payment_delivery=:payment_delivery, payment_extra=:payment_extra');
                $update = $update->execute(['payment_status' => 2, 'client_id' => $payment['client_id'], 'payment_method' => 15, 'payment_delivery' => 1, 'payment_extra' => $hash]);
            }
        }

        // send data to payment response
        paymentResponse($paymentResponseData);
        // razorpay status is failed
    } else {
        // prepare payment data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['id'], 'razorpay')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    }
} else if ($requestData['paymentOption'] == 'authorize-net') {
    $orderId = $requestData['order_id'];

    $requestData = json_decode($requestData['response'], true);

    // Check if razorpay status exist and status is success
    if (isset($requestData['status']) and $requestData['status'] == 'success') {
        // prepare payment data
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['transaction_id'], 'authorize-net')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
        // razorpay status is failed
    } else {
        // prepare payment data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['transaction_id'], 'authorize-net')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    }
} else if ($requestData['paymentOption'] == 'bitpay') {
    // prepare payment data
    $paymentResponseData = [
        'status'   => true,
        'rawData'  => $requestData,
        'data'     => preparePaymentData($requestData['orderId'], $requestData['amount'], $requestData['orderId'], 'bitpay')
    ];
    // send data to payment response
    paymentResponse($paymentResponseData);
} else if ($requestData['paymentOption'] == 'bitpay-ipn') {
    $bitpayResponse = new BitPayResponse;
    $rawPostData = file_get_contents('php://input');
    $ipnData = $bitpayResponse->getBitPayPaymentData($rawPostData);
    if ($ipnData['status'] == 'success') {
        // code here
    } else {
        // code here
    }
} else if ($requestData['paymentOption'] == 'mercadopago') {
    if ($requestData['collection_status'] == 'approved') {
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['order_id'], $requestData['amount'], $requestData['collection_id'], 'mercadopago')
        ];

        $hash = htmlspecialchars($requestData['order_id']);
        $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra');
        $payment->execute(array('extra' => $hash));
        $payment = $payment->fetch(PDO::FETCH_ASSOC);

        if (countRow(['table' => 'payments', 'where' => ['client_id' => $payment['client_id'], 'payment_method' => 18, 'payment_status' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]])) {
            if ($requestData['collection_status'] == 'approved') {
                $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra ');
                $payment->execute(['extra' => $hash]);
                $payment = $payment->fetch(PDO::FETCH_ASSOC);
                $payment_bonus = $conn->prepare('SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1');
                $payment_bonus->execute(['method' => 18, 'from' => $payment['payment_amount']]);
                $payment_bonus = $payment_bonus->fetch(PDO::FETCH_ASSOC);
                if ($payment_bonus) {
                    $amount = $payment['payment_amount'] + (($payment['payment_amount'] * $payment_bonus['bonus_amount']) / 100);
                } else {
                    $amount = $payment['payment_amount'];
                }
                $conn->beginTransaction();

                $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                $update = $update->execute(['balance' => $payment['balance'], 'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);

                $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                $balance = $balance->execute(['id' => $payment['client_id'], 'balance' => $payment['balance'] + $amount]);

                $insert = $conn->prepare('INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ');
                if ($payment_bonus) {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with MercadoPago and included %' . $payment_bonus['bonus_amount'] . ' bonus.', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                } else {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with MercadoPago', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                }
                if ($update && $balance) {
                    $conn->commit();
                    echo 'OK';
                } else {
                    $conn->rollBack();
                    echo 'NO';
                }
            } else {
                $update = $conn->prepare('UPDATE payments SET payment_status=:payment_status WHERE client_id=:client_id, payment_method=:payment_method, payment_delivery=:payment_delivery, payment_extra=:payment_extra');
                $update = $update->execute(['payment_status' => 2, 'client_id' => $payment['client_id'], 'payment_method' => 18, 'payment_delivery' => 1, 'payment_extra' => $hash]);
            }
        }
    } elseif ($requestData['collection_status'] == 'pending') {
        $paymentResponseData = [
            'status'   => 'pending',
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['order_id'], $requestData['amount'], $requestData['collection_id'], 'mercadopago')
        ];
    } else {
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['order_id'], $requestData['amount'], $requestData['collection_id'], 'mercadopago')
        ];
    }
    paymentResponse($paymentResponseData);
} else if ($requestData['paymentOption'] == 'mercadopago-ipn') {
    $mercadopagoResponse = new MercadopagoResponse;
    $mercadopagoIpnData = $mercadopagoResponse->getMercadopagoPaymentData($requestData);

    // Ipn data recieved here are as following
    //$mercadopagoIpnData['status'] = 'total_paid or not_paid';
    //$mercadopagoIpnData['message'] = 'Message';    
    //$mercadopagoIpnData['raw_data'] = 'Raw Ipn Data';   
} else if ($requestData['paymentOption'] == 'payumoney') {
    $payUmoneyResponse = new PayUmoneyResponse;
    $payUmoneyResponseData = $payUmoneyResponse->getPayUmoneyPaymentResponse($requestData);
    if ($payUmoneyResponseData['status'] == 'success') {
        $paymentResponseData = [
            'status'    => true,
            'order_id'  => $payUmoneyResponseData['raw_Data'],
            'rawData'   => $payUmoneyResponseData['raw_Data'],
            'data'      => preparePaymentData($payUmoneyResponseData['order_id'], $payUmoneyResponseData['amount'], $payUmoneyResponseData['txn_id'], 'payumoney')
        ];

        $hash = htmlspecialchars($requestData['order_id']);
        $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra');
        $payment->execute(array('extra' => $hash));
        $payment = $payment->fetch(PDO::FETCH_ASSOC);



        $user = $conn->prepare("SELECT * FROM clients WHERE client_id=:client_id");
        $user->execute(array("client_id" => $payment['client_id']));
        $user = $user->fetch(PDO::FETCH_ASSOC);


        if (countRow(['table' => 'payments', 'where' => ['client_id' => $payment['client_id'], 'payment_method' => 19, 'payment_status' => 1, 'payment_delivery' => 1, 'payment_extra' => $hash]])) {
            if ($payUmoneyResponseData['status'] == 'success') {
                $payment = $conn->prepare('SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.payment_extra=:extra ');
                $payment->execute(['extra' => $hash]);
                $payment = $payment->fetch(PDO::FETCH_ASSOC);


                // if ($settings["site_currency"] == "USD") {
                //     $payment['payment_amount'] = $payment['payment_amount'] / $settings["dolar_charge"];
                // }
                //referral

                if ($user["ref_by"]) {
                    $reff = $conn->prepare("SELECT * FROM referral WHERE referral_code=:referral_code ");
                    $reff->execute(array("referral_code" => $user["ref_by"]));
                    $reff  = $reff->fetch(PDO::FETCH_ASSOC);




                    $newAmount = $payment['payment_amount'];

                    $update3 = $conn->prepare("UPDATE referral SET referral_totalFunds_byReffered=:referral_totalFunds_byReffered,
    referral_total_commision=:referral_total_commision WHERE referral_code=:referral_code ");
                    $update3 = $update3->execute(array(
                        "referral_code" => $user["ref_by"],
                        "referral_totalFunds_byReffered" => round($reff["referral_totalFunds_byReffered"] + $newAmount, 2),
                        "referral_total_commision" => round($reff["referral_total_commision"] + (($settings["referral_commision"] / 100) * $newAmount), 2)
                    ));
                }
                //referral



                $payment_bonus = $conn->prepare('SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1');
                $payment_bonus->execute(['method' => 19, 'from' => $payment['payment_amount']]);
                $payment_bonus = $payment_bonus->fetch(PDO::FETCH_ASSOC);
                if ($payment_bonus) {
                    $amount = $payment['payment_amount'] + (($payment['payment_amount'] * $payment_bonus['bonus_amount']) / 100);
                } else {
                    $amount = $payment['payment_amount'];
                }
                $conn->beginTransaction();

                $amount = round( $amount , 2);

                if ($settings["site_currency"] == "USD") {
                    $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_amount=:payment_amount , payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                    $update = $update->execute(['balance' => $payment['balance'], "payment_amount" => round($payment['payment_amount'],2),  'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);
                } else {
                    $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ');
                    $update = $update->execute(['balance' => $payment['balance'], 'status' => 3, 'delivery' => 2, 'id' => $payment['payment_id']]);
                }
                $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                $balance = $balance->execute(['id' => $payment['client_id'], 'balance' => $payment['balance'] + $amount]);

                $insert = $conn->prepare('INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ');
                if ($payment_bonus) {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with PayUmoney and included %' . $payment_bonus['bonus_amount'] . ' bonus.', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                } else {
                    $insert = $insert->execute(['c_id' => $payment['client_id'], 'action' => 'New ' . $amount . ' payment has been made with PayUmoney', 'ip' => GetIP(), 'date' => date('Y-m-d H:i:s')]);
                }
                if ($update && $balance) {
                    $conn->commit();
                    echo 'OK';
                } else {
                    $conn->rollBack();
                    echo 'NO';
                }
            } else {
                $update = $conn->prepare('UPDATE payments SET payment_status=:payment_status WHERE client_id=:client_id, payment_method=:payment_method, payment_delivery=:payment_delivery, payment_extra=:payment_extra');
                $update = $update->execute(['payment_status' => 2, 'client_id' => $payment['client_id'], 'payment_method' => 19, 'payment_delivery' => 1, 'payment_extra' => $hash]);
            }
        }
    } else if ($payUmoneyResponseData['status'] == 'failed') {
        $paymentResponseData = [
            'status'    => false,
            'order_id'  => '',
            'rawData'   => $payUmoneyResponseData['raw_Data'],
            'data'      => preparePaymentData($payUmoneyResponseData['order_id'], $payUmoneyResponseData['amount'], $payUmoneyResponseData['txn_id'], 'payumoney')
        ];
    }

    paymentResponse($paymentResponseData);
} else if ($requestData['paymentOption'] == 'mollie') {

    $paymentResponseData = [
        'status'    => true,
        'order_id'  => $requestData['order_id'],
        'rawData'   => $requestData,
        'data'      => preparePaymentData($requestData['order_id'], $requestData['amount'], null, 'mollie')
    ];

    paymentResponse($paymentResponseData);
} else if ($requestData['paymentOption'] == 'mollie-webhook') {
    $mollieResponse = new MollieResponse;
    $webhookData = $mollieResponse->retrieveMollieWebhookData($requestData);

    // mollie webhook data received here with following option
    // $webhookData['status']; - payment status (paid|open|pending|failed|expired|canceled|refund|chargeback)
    // $webhookData['raw_data']; - webhook all raw data
    // $webhookData['message']; - if payment failed then message

    // Check Ravepay payment process
} else if ($requestData['paymentOption'] == 'ravepay') {
    $requestData = json_decode($requestData['response'], true);

    //Check if status key exists and payment is successfully completed
    if (isset($requestData['body']['status']) and $requestData['body']['status'] == "success") {
        // Create data for payment success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['body']['data']['txref'], $requestData['body']['data']['amount'], $requestData['body']['data']['txid'], 'ravepay')
        ];
        // Send data to payment response for further process
        paymentResponse($paymentResponseData);
        // If ravepay payment is failed    
    } else {
        // Prepare data for failed payment 
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['body']['data']['txref'], $requestData['body']['data']['amount'], $requestData['body']['data']['txid'], 'ravepay')
        ];
        // Send data to payment response to further process
        paymentResponse($paymentResponseData);
    }

    // Check Pagseguro payment process
} else if ($requestData['paymentOption'] == 'pagseguro') {

    // Get Payment Response instance
    $pagseguroResponse  = new PagseguroResponse();

    // Fetch payment data using payment response instance
    $pagseguroData = $pagseguroResponse->fetchTransactionByRefrenceId($requestData['reference_id']);

    //handling errors
    if (isset($pagseguroData['status']) and $pagseguroData['status'] == 'error') {
        //throw exception when generate errors
        throw new Exception($pagseguroData['message']);
    }

    //transaction status
    //1 - Awaiting payment, 2 - In analysis, 3 - Pay, 4 - Available, 5 - In dispute,
    //6 - Returned, 7 - Canceled
    $txnStatus = $pagseguroData['responseData']->getTransactions()[0]->getStatus();

    //collect transaction code
    $transactionCode = $pagseguroData['responseData']->getTransactions()[0]->getCode();

    // Fetch transaction data by transaction code
    $transactionData = $pagseguroResponse->fetchTransactionByTxnCode($transactionCode);

    // Check if payment status is success
    if ($transactionData['status'] == 'success' and $txnStatus == 3 and $transactionData['responseData']->getReference() == $requestData['reference_id']) {
        // Create payment success response data.
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $transactionData['responseData'],
            'data'     => preparePaymentData(
                $transactionData['responseData']->getReference(),
                $transactionData['responseData']->getGrossAmount(),
                $transactionData['responseData']->getCode(),
                'pagseguro'
            )
        ];
        // Send data to payment response.
        paymentResponse($paymentResponseData);
    } else {
        // Create payment failed response data.
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData(
                $transactionData['responseData']->getReference(),
                $transactionData['responseData']->getGrossAmount(),
                $transactionData['responseData']->getCode(),
                'pagseguro'
            )
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }
}

/*
 * This payment used for get Success / Failed data for any payment method.
 *
 * @param array $paymentResponseData - contains : status and rawData
 *
 */
function paymentResponse($paymentResponseData)
{
    // payment status success
    if ($paymentResponseData['status'] === true) {

        // Show payment success page or do whatever you want, like send email, notify to user etc
        header('Location: ' . getAppUrl('../../'));
    } elseif ($paymentResponseData['status'] === 'pending') {

        // Show payment success page or do whatever you want, like send email, notify to user etc
        header('Location: ' . getAppUrl('../../'));
    } else {
        // Show payment error page or do whatever you want, like send email, notify to user etc
        header('Location: ' . getAppUrl('../../'));
    }
}

/*
* Prepare Payment Data.
*
* @param array $paymentData
*
*/
function preparePaymentData($orderId, $amount, $txnId, $paymentGateway)
{
    return [
        'order_id'              => $orderId,
        'amount'                => $amount,
        'payment_reference_id'  => $txnId,
        'payment_gateway'        => $paymentGateway
    ];
}
