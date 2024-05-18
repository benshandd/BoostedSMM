<?php
require 'db.php';

$paymentsList = $conn->prepare("SELECT * FROM payment_methods");
$paymentsList->execute();
$paymentsList = $paymentsList->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i < 21; $i++) { 
    $extra[] = json_decode($paymentsList[$i]["method_extras"], true);
}


$techAppConfig = [

    /* Base Path of app
    ------------------------------------------------------------------------- */
    'base_url' => URL . '/lib/pay/',

    /* Amount - if null amount input open in form
    ------------------------------------------------------------------------- */
    'amount' => null,

    'payments' => [
        /* Gateway Configuration key
        ------------------------------------------------------------------------- */
        'gateway_configuration' => [
            'paypal' => [
                'enable'                        => true,
                'testMode'                      => false, //test mode or product mode (boolean, true or false)
                'gateway'                       => 'Paypal', //payment gateway name
                'paypalSandboxBusinessEmail'    => '', //paypal sandbox business email
                'paypalProductionBusinessEmail' => $extra[0]['business_email'], //paypal production business email
                'currency'                  => $extra[0]['currency'], //currency
                'currencySymbol'            => '',
                'paypalSandboxUrl'          => 'https://www.sandbox.paypal.com/cgi-bin/webscr', //paypal sandbox test mode Url
                'paypalProdUrl'             => 'https://www.paypal.com/cgi-bin/webscr', //paypal production mode Url
                'notifyIpnURl'              => 'payment-response.php', //paypal ipn request notify Url
                'cancelReturn'              => 'payment-response.php', //cancel payment Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => []
            ],
            // 'paytm' => [
            //     'enable'                    => true,
            //     'testMode'                  => true, //test mode or product mode (boolean, true or false)
            //     'gateway'                   => 'Paytm', //payment gateway name
            //     'currency'                  => 'INR', //currency
            //     'currencySymbol'              => '₹',
            //     'paytmMerchantTestingMidKey'       => 'Enter your Test Mid Key', //paytm testing Merchant Mid key
            //     'paytmMerchantTestingSecretKey'    => 'Enter your Test Secret Key', //paytm testing Merchant Secret key
            //     'paytmMerchantLiveMidKey'       => 'Enter your Live Mid Key', //paytm live Merchant Mid key
            //     'paytmMerchantLiveSecretKey'    => 'Enter your Live Secret Key', //paytm live Merchant Secret key
            //     'industryTypeID'            => 'Retail', //industry type
            //     'channelID'                 => 'WEB', //channel Id
            //     'website'                   => 'WEBSTAGING',
            //     'paytmTxnUrl'               => 'https://securegw-stage.paytm.in/theia/processTransaction', //paytm transaction Url
            //     'callbackUrl'               => 'payment-response.php', //callback Url after payment successful or cancel payment
            //     'privateItems'              => [
            //         'paytmMerchantTestingSecretKey',
            //         'paytmMerchantLiveSecretKey'
            //     ]
            // ],
            'instamojo' => [
                'enable'                    => true,
                'testMode'                  => false, //test mode or product mode (boolean, true or false)
                'gateway'                   => 'Instamojo', //payment gateway name
                'currency'                  => $extra[12]['currency'], //currency
                'currencySymbol'              => '',
                'sendEmail'                 => false, //send mail (true or false)
                'instamojoTestingApiKey'           => 'Enter your Test Api Key', // instamojo testing API Key
                'instamojoTestingAuthTokenKey'     => 'Enter your Test Auth Token Key', // instamojo testing Auth token Key
                'instamojoLiveApiKey'           => $extra[12]['api_key'], // instamojo live API Key
                'instamojoLiveAuthTokenKey'     => $extra[12]['live_auth_token_key'], // instamojo live Auth token Key
                'instamojoSandboxRedirectUrl'   => 'https://test.instamojo.com/api/1.1/', // instamojo Sandbox redirect Url
                'instamojoProdRedirectUrl'      => 'https://www.instamojo.com/api/1.1/', // instamojo Production mode redirect Url
                'webhook'                   => 'http://instamojo.com/webhook/', // instamojo Webhook Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                    'instamojoTestingApiKey',
                    'instamojoTestingAuthTokenKey',
                    'instamojoLiveApiKey',
                    'instamojoLiveAuthTokenKey',
                    'instamojoSandboxRedirectUrl',
                    'instamojoProdRedirectUrl'
                ]
            ],
            'paystack' => [
                'enable'                    => true,
                'testMode'                  => true, //test mode or product mode (boolean, true or false)
                'gateway'                   => 'Paystack', //payment gateway name
                'currency'                  => $extra[13]['currency'], //currency
                'currencySymbol'              => '',
                'paystackTestingSecretKey'         => 'sk_test_e72f02f53bbbd0d1e51ff795e3a509d13aabaab0', //paystack testing secret key
                'paystackTestingPublicKey'         => 'pk_test_4551e31544445f87b38b62d2064cae28b6fd72ca', //paystack testing public key
                'paystackLiveSecretKey'         => $extra[13]['api_secret_key'], //paystack live secret key
                'paystackLivePublicKey'         => $extra[13]['api_publish_key'], //paystack live public key
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                    'paystackTestingSecretKey',
                    'paystackLiveSecretKey'
                ]
            ],
            // 'stripe'    => [
            //     'enable'                    => true,
            //     'testMode'                  => true, //test mode or product mode (boolean, true or false)
            //     'gateway'                   => 'Stripe', //payment gateway name
            //     'locale'                    => 'auto', //set local as auto
            //     'allowRememberMe'           => false, //set remember me ( true or false)
            //     'currency'                  => 'USD', //currency
            //     'currencySymbol'              => '$',
            //     'paymentMethodTypes'         => [
            //         // before activating additional payment methods
            //         // make sure that these methods are enabled in your stripe account
            //         // https://dashboard.stripe.com/settings/payments
            //         'card',
            //         // 'ideal',
            //         // 'bancontact',
            //         // 'giropay',
            //         // 'p24',
            //         // 'eps'
            //     ],
            //     'stripeTestingSecretKey'    => 'Enter your Test Secret Key', //Stripe testing Secret Key
            //     'stripeTestingPublishKey'   => 'Enter your Test Publish Key', //Stripe testing Publish Key
            //     'stripeLiveSecretKey'       => 'Enter your Live Secret Key', //Stripe Secret live Key
            //     'stripeLivePublishKey'      => 'Enter your Live Publish Key', //Stripe live Publish Key
            //     'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
            //     'privateItems'              => [
            //         'stripeTestingSecretKey',
            //         'stripeLiveSecretKey'
            //     ]
            // ],
            'razorpay'    => [
                'enable'                    => true,
                'testMode'                  => false, //test mode or product mode (boolean, true or false)
                'gateway'                   => 'Razorpay', //payment gateway name
                'merchantname'              => 'Add Funds to SMM', //merchant name
                'themeColor'                => '#f01747', //set razorpay widget theme color
                'currency'                  => $extra[14]['currency'], //currency
                'currencySymbol'              => '',
                'razorpayTestingkeyId'      => '', //razorpay testing Api Key
                'razorpayTestingSecretkey'  => '', //razorpay testing Api Secret Key
                'razorpayLivekeyId'         => $extra[14]['api_key'], //razorpay live Api Key
                'razorpayLiveSecretkey'     => $extra[14]['api_secret_key'], //razorpay live Api Secret Key
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful'
                'privateItems'              => [
                    'razorpayTestingSecretkey',
                    'razorpayLiveSecretkey'
                ]
            ],
            'iyzico'    => [
                'enable'                    => true,
                'testMode'                  => false, //test mode or product mode (boolean, true or false)
                'gateway'                   => 'Iyzico', //payment gateway name
                'conversation_id'           => 'CONVERS' . uniqid(), //generate random conversation id
                'currency'                  => $extra[15]['currency'], //currency
                'currencySymbol'              => '',
                'subjectType'               => 1, // credit
                'txnType'                   => 2, // renewal
                'subscriptionPlanType'      => 1, //txn status
                'iyzicoTestingApiKey'       => '', //iyzico testing Api Key
                'iyzicoTestingSecretkey'    => '', //iyzico testing Secret Key
                'iyzicoLiveApiKey'          => $extra[15]['api_key'], //iyzico live Api Key
                'iyzicoLiveSecretkey'       => $extra[15]['api_secret_key'], //iyzico live Secret Key
                'iyzicoSandboxModeUrl'      => 'https://sandbox-api.iyzipay.com', //iyzico Sandbox test mode Url
                'iyzicoProductionModeUrl'   => 'https://api.iyzipay.com', //iyzico production mode Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                    'iyzicoTestingApiKey',
                    'iyzicoTestingSecretkey',
                    'iyzicoLiveApiKey',
                    'iyzicoLiveSecretkey'
                ]
            ],
            'authorize-net'    => [
                'enable'                         => true,
                'testMode'                       => false, //test mode or product mode (boolean, true or false)
                'gateway'                        => 'Authorize.net', //payment gateway name
                'reference_id'                   => 'REF' . uniqid(), //generate random conversation id
                'currency'                       => $extra[16]['currency'], //currency
                'currencySymbol'                 => '',
                'type'                           => 'individual',
                'txnType'                        => 'authCaptureTransaction',
                'authorizeNetTestApiLoginId'     => 'Enter your Test API Login Id', //authorize-net testing Api login id
                'authorizeNetTestTransactionKey' => 'Enter your Test Secret Transaction Key', //Authorize.net testing transaction key
                'authorizeNetLiveApiLoginId'     => $extra[16]['api_login_id'], //Authorize.net live Api login id
                'authorizeNetLiveTransactionKey' => $extra[16]['secret_transaction_key'], //Authorize.net live transaction key
                'callbackUrl'                    => 'payment-response.php', //callback Url after payment successful
                'privateItems'                  => [
                    'authorizeNetTestApiLoginId',
                    'authorizeNetTestTransactionKey',
                    'authorizeNetLiveApiLoginId',
                    'authorizeNetLiveTransactionKey'
                ]
            ],
            // 'bitpay'    => [
            //     'enable'                        => true,
            //     'testMode'                      => true, //test mode or product mode (boolean, true or false)
            //     'notificationEmail'             => 'sample@domain.com', // Merchant Email
            //     'gateway'                       => 'BitPay', //payment gateway name
            //     'currency'                      => 'USD', //currency
            //     'currencySymbol'                => '$', //currency Symbol
            //     'password'                      => 'Your Password', // Password for "EncryptedFilesystemStorage"
            //     'pairingCode'                   => 'Pairing Code', // Your pairing Code
            //     'pairinglabel'                  => 'Pairing Label', // Your Pairing Label
            //     'callbackUrl'                   => 'payment-response.php', //callback Url after payment successful
            //     'privateItems'                  => ['pairingCode', 'pairinglabel', 'password']
            // ],
            'mercadopago' => [
                'enable'                        => true,
                'testMode'                      => false, //test mode or product mode (boolean, true or false)
                'gateway'                       => 'Mercado Pago', //payment gateway name
                'currency'                      => $extra[17]['currency'], //currency
                'currencySymbol'                => '', //currency Symbol
                'testAccessToken'               => '',
                'liveAccessToken'               => $extra[17]['live_access_token'],
                'callbackUrl'                   => 'payment-response.php', //callback Url after payment successful
                'privateItems'                  => ['testAccessToken', 'liveAccessToken']
            ],
            'payumoney' => [
                'enable'                        => true,
                'testMode'                      => false, //test mode or product mode (boolean, true or false)
                'gateway'                       => 'PayUmoney', //payment gateway name
                'currency'                      => $extra[18]['currency'], //currency
                'currencySymbol'                => '', //currency Symbol
                'txnId'                         => "Txn" . rand(10000, 99999999),
                'merchantTestKey'               => '',
                'merchantTestSalt'              => '',
                'merchantLiveKey'               => $extra[18]['merchant_key'],
                'merchantLiveSalt'              => $extra[18]['salt_key'],
                'callbackUrl'                   => 'payment-response.php', //callback Url after payment successful
                'checkoutColor'                 => 'f01747',
                'checkoutLogo'                  => 'https://startuppitchindia.com/wp-content/uploads/2017/07/PayUmoney-logo.png',
                'privateItems'                  => ['merchantTestKey', 'merchantTestSalt', 'merchantLiveKey', 'merchantLiveSalt']
            ],
            // 'mollie' => [
            //     'enable'                        => true,
            //     'testMode'                      => true, //test mode or product mode (boolean, true or false)
            //     'gateway'                       => 'Mollie', //payment gateway name
            //     'currency'                      => 'EUR', //currency
            //     'currencySymbol'                => '€', //currency Symbol
            //     'testApiKey'                    => 'Your Test API Key',
            //     'liveApiKey'                    => 'Your Live API Key',
            //     'callbackUrl'                   => 'payment-response.php', //callback Url after payment successful
            //     'privateItems'                  => ['testApiKey', 'liveApiKey']
            // ],
            'ravepay' => [
                'enable'                        => true,
                'testMode'                      => false, //test mode or product mode (boolean, true or false)
                'gateway'                       => 'Ravepay', //payment gateway name
                'currency'                      => $extra[19]['currency'], //currency
                'currencySymbol'                => '', //currency Symbol
                'txn_reference_id'              => 'REF' . uniqid(), //generate random conversation id
                'testPublicApiKey'              => 'Your Test Public API Key',
                'testSecretApiKey'              => 'Your Test Secret API Key',
                'livePublicApiKey'              => $extra[19]['public_api_key'],
                'liveSecretApiKey'              => $extra[19]['secret_api_key'],
                'callbackUrl'                   => 'payment-response.php', //callback Url after payment successful
                'sandboxVerifyPaymentUrl'       => 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify', //sandbox staging server verify payment url.
                'productionVerifyPaymentUrl'    => 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify', //production staging server verify payment url.
                'privateItems'                  => ['testSecretApiKey', 'liveSecretApiKey']
            ],
            'pagseguro' => [
                'enable'                        => true,
                'testMode'                      => false, //test mode or product mode (boolean, true or false)
                'gateway'                       => 'Pagseguro', //payment gateway name
                'environment'                   => 'production', //production, sandbox
                'currency'                      => $extra[20]['currency'], //currency
                'currencySymbol'                => '', //currency Symbol
                'reference_id'                  => 'REF' . uniqid(), //generate random reference id
                'email'                         => $extra[20]['email_id'], //your pagseguro email id for create account credentials
                'testToken'                     => 'Your Test Production Token', //your sandbox pagseguro token for create account credentials
                'liveToken'                     => $extra[20]['live_production_token'], //your production pagseguro token for create account credentials
                'callbackUrl'                   => 'payment-response.php', //callback Url after payment successful
                'notificationUrl'               => 'payment-response.php', //notification url when payment successfully user collect notfication data
                'privateItems'                  => ['liveToken', 'testToken']
            ],
        ],
    ],

];

return compact("techAppConfig");
