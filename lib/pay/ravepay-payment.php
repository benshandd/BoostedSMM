<?php
include 'header.php';
include 'db.php';
//config data
$configData = configItem();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../assets/js/jquery-3.3.1.min.js"></script>
</head>

<body>
    <div class="d-flex justify-content-center">
        <div class="lw-page-loader lw-show-till-loading">
            <div class="spinner-border"  role="status"></div>
        </div>
    </div>

    <div class="pt-4 mb-5 container" id="lwCheckoutForm">
        <div class="row">
            <div class="col-lg-8">
                <form method="post" id="lwPaymentForm">
                    <div class="card bg-light">
                        <div class="card-body">
                            <!-- show validation message block -->
                            <div id="lwValidationMessage" class="lw-validation-message"></div>
                            <!-- / show validation message block -->                            

                            <?php
                            $hash = htmlspecialchars($_GET['hash']);
                            $paymentList = $conn->prepare("SELECT * FROM payments WHERE payment_extra=:extra");
                            $paymentList->execute(array('extra' => $hash));
                            $paymentList = $paymentList->fetch(PDO::FETCH_ASSOC);
                            $getdata = json_decode($paymentList['data'], true);

                            // Get config data
                            $configData = configItem();
                            $userDetails = [
                                    'amounts' => [ // at least one currency amount is required
                                        $getdata['c']  => $getdata['a']
                                    ],
                                    'order_id'      => 'ORDS' . uniqid(), // required in instamojo, Iyzico, Paypal, Paytm gateways
                                    'customer_id'   => 'CUSTOMER' . uniqid(), // required in Iyzico, Paytm gateways
                                    'item_name'     => 'Sample Product', // required in Paypal gateways
                                    'item_id'       => 'ITEM' . uniqid(), // required in Iyzico, Paytm gateways
                                    'item_qty'      => 1,
                                    'payer_email'   => 'sample@domain.com', // required in instamojo, Iyzico, Stripe gateways
                                    'payer_name'    => 'John Doe', // required in instamojo, Iyzico gateways
                                    'description'   => 'Lorem ipsum dolor sit amet, constetur adipisicing', // Required for stripe
                                    'payer_mobile'  => '9999999999',
                                    'ip_address'    => getUserIpAddr(), // required only for iyzico 
                                    'address'       => '3234 Godfrey Street Tigard, OR 97223', // required in Iyzico gateways
                                    'city'          => 'Tigard',  // required in Iyzico gateways
                                    'country'       => 'United States' // required in Iyzico gateways
                                ];

                            if (!$configData) {
                                echo '<div class="alert alert-warning text-center">Unable to load configuration.</div>';
                            } else {
                                $configItem = $configData['payments']['gateway_configuration'];

                                //show payment gateway radio button
                                foreach ($configItem as $key => $value) { 
                                    if ($value['enable'] and $key == 'ravepay') { ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="paymentOption-<?= $key ?>">
                                                <fieldset class="lw-fieldset mr-3 mb-3" style="border:0">
                                                    <legend class="lw-fieldset-legend-font">
                                                        <input class="form-check-input" checked hidden type="radio" required="true" id="paymentOption-<?= $key ?>" name="paymentOption" value="<?= $key ?>">
                                                    </legend>
                                                </fieldset>
                                            </label>
                                        </div>                                        
                                    <?php  }
                                } ?>
                                Your payment was initiated successfully, you are being redirected..
                                <h3 id="lwPaymentAmount"></h3>
                                <!--  checkout form submit button -->
                                <button type="submit" value="Proceed to Pay" id="btn" hidden class="btn btn-lg btn-block btn-success">Proceed to Pay</button>
                                <!-- / checkout form submit button -->
                    <?php   } ?>
                        </div>
                    </div>
                    <script>
                        setTimeout(function() {
                            var link = document.querySelector('#btn');
                            if(link) { link.click(); }
                        }, 1000);
                    </script>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!-- get configuration data -->
<?php 
    $paymentPagePath    = getAppUrl('', 'individual-payment-gateways/');
    $ravepayConfigData = configItemData('payments.gateway_configuration.ravepay');
    $ravepayCallbackUrl= getAppUrl($ravepayConfigData['callbackUrl']);    
    $currency = $ravepayConfigData['currency'];
    $currencySymbol = $ravepayConfigData['currencySymbol'];
    $ravepayTestingPublicKey = $ravepayConfigData['testPublicApiKey'];
    $ravepayLivePublicKey = $ravepayConfigData['livePublicApiKey'];
    $txnReferenceId = $ravepayConfigData['txn_reference_id'];
    $testMode = $ravepayConfigData['testMode'];
?>
<!-- / get configuration data -->

<script type="text/javascript">
    var userDetails = <?= json_encode($userDetails) ?>;
    $('input[name=paymentOption]').change(function() {
        var gatewayCurrency = "<?= $currency ?>",
            currencySymbol = "<?= $currencySymbol ?>",
            formattedAmount = '<hr>' + currencySymbol + ' ' + userDetails['amounts'][gatewayCurrency] + ' ' + gatewayCurrency + '<hr>';
        $('#lwPaymentAmount').html(formattedAmount);
    });
</script>

<!-- Jquery Form submit in script tag -->
<script type="text/javascript">
   
    $(document).ready(function(){
        //submit checkout form
        $('#lwPaymentForm').on('submit', function(e){ 
            e.preventDefault();
            var paymentOption = $( 'input[name=paymentOption]:checked' ).val();
           
            if (paymentOption == 'ravepay') {

                //config data
                var txnReferenceId = <?php echo json_encode($txnReferenceId); ?>,
                    ravepayCallbackUrl = <?php echo json_encode($ravepayCallbackUrl); ?>,
                    paymentPagePath = <?php echo json_encode($paymentPagePath); ?>,
                    testMode = "<?= $testMode ?>",
                    currency = "<?= $currency ?>";
                    ravepayPublicKeyId = '';
                    
                const amount =  userDetails['amounts'][currency];
                
                //check ravepay test or production mode
                if (testMode) {
                    ravepayPublicKeyId = "<?= $ravepayTestingPublicKey ?>";
                } else {
                    ravepayPublicKeyId = "<?= $ravepayLivePublicKey ?>";
                }
                
                var ravepayAmount = amount,
                    x = getpaidSetup({
                    PBFPubKey: ravepayPublicKeyId,
                    customer_email: userDetails['payer_email'], // add customer email
                    amount: ravepayAmount, // add order amount
                    currency: currency,  // add currency
                    txref: txnReferenceId, // Pass your UNIQUE TRANSACTION REFERENCE HERE.
                    onclose: function() {
                        //on close ravepay inline widget then load back to checkout form page
                       // window.location.href = paymentPagePath;
                    },
                    callback: function(response) {
                        
                        var ravepayTxnRefId = response.tx.txRef; // collect txRef returned and pass to a 					server page to complete status check.
                        
                        if (
                            response.tx.chargeResponseCode == "00" ||
                            response.tx.chargeResponseCode == "0"
                        ) {
                            // redirect to a success page
                            //show loader before ajax request
                            $(".lw-show-till-loading").show();
                            
                            var ravepayData = {
                                'ravepayTxnRefId': ravepayTxnRefId,
                                'ravepayAmount': ravepayAmount
                            };

                            var ravepayData = $('#lwPaymentForm').serialize() + '&' + $.param(userDetails) + '&' + $.param(ravepayData);

                            $.ajax({
                                type: 'post', //form method
                                context: this,
                                url: '../payment-process.php', // post data url
                                dataType: "JSON",
                                data: ravepayData, // form serialize data
                                error: function (err) {
                                    var error = err.responseText
                                        string = '';
                                    
                                    //on error show alert message
                                    string += '<div class="alert alert-danger" role="alert">'+err.responseText+'</div>';

                                    $('#lwValidationMessage').html(string);
                                    //alert("AJAX error in request: " + JSON.stringify(err.responseText, null, 2));

                                    //hide loader after ajax request complete
                                    $(".lw-show-till-loading").hide();
                                },
                                success: function (response) {
                                    //check response code is success
                                    if (response.body.status == 'success') {
                                        $('body').html("<form action='"+ravepayCallbackUrl+"' method='post'><input type='hidden' name='response' value='"+JSON.stringify(response)+"'><input type='hidden' name='paymentOption' value='ravepay'></form>");
                                        $('body form').submit();
                                    }
                                }
                            });

                        } else {
                            // redirect to a failure page.
                        }

                        x.close(); // use this to close the modal immediately after payment.
                    }
                });
            }
            // Ravepay script for send ajax request to server side end
        });
    });
</script>
<!-- /  Jquery Form submit in script tag -->

<?php
if ($ravepayConfigData['enable']) { ?>
    <!-- load ravepay inline widget script -->
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <!-- load ravepay inline widget script -->
<?php } ?>
