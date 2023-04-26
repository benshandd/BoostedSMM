<?php
include 'header.php';
require 'db.php';
$configData = configItem();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="assets/js/jquery-3.3.1.min.js"></script>
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
                                        $getdata['c']  => intval($getdata['a'])
                                    ],
                                    'order_id'      => 'ORDS' . uniqid(), // required in instamojo, Iyzico, Paypal, Paytm gateways
                                    'customer_id'   => 'CUSTOMER' . uniqid(), // required in Iyzico, Paytm gateways
                                    'item_name'     => 'Sample Product', // required in Paypal gateways
                                    'item_id'       => 'ITEM' . uniqid(), // required in Iyzico, Paytm gateways
                                    'item_qty'      => 1,
                                    'payer_email'   => $hash.'@m.com', // required in instamojo, Iyzico, Stripe gateways
                                    'payer_name'    => 'John Doe', // required in instamojo, Iyzico gateways
                                    'description'   => 'Lorem ipsum dolor sit amet, constetur adipisicing', // Required for stripe
                                    'payer_mobile'  => '9999999999',
                                    'ip_address'    => getUserIpAddr(), // required only for iyzico 
                                    'address'       => '3234 Godfrey Street Tigard, OR 97223', // required in Iyzico gateways
                                    'city'          => 'Tigard',  // required in Iyzico gateways
                                    'country'       => 'United States' // required in Iyzico gateways
                                ];
                            ?>
                            <?php
                            if (!$configData) {
                                echo '<div class="alert alert-warning text-center">Unable to load configuration.</div>';
                            } else {
                                $configItem = $configData['payments']['gateway_configuration'];

                                //show payment gateway radio button
                                foreach ($configItem as $key => $value) { 
                                    if ($value['enable'] and $key == 'razorpay') { ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="paymentOption-<?= $key ?>">
                                                <fieldset class="lw-fieldset mr-3 mb-3" style="border:0">
                                                    <legend class="lw-fieldset-legend-font">
                                                        <input class="form-check-input" hidden type="radio" required="true" id="paymentOption-<?= $key ?>" name="paymentOption" value="<?= $key ?>" checked>
                                                    </legend>
                                                </fieldset>
                                            </label>
                                        </div>  
                                    <?php  }
                                } ?>
                                <div style="background: #f01747;color: white;padding: 5px;text-align: center;border-radius: 5px;">Do not make any changes on the email field to add your balance automatically.</div>
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
    $paymentPagePath    = getAppUrl(null, 'individual-payment-gateways/');
    $razorpayConfigData = configItemData('payments.gateway_configuration.razorpay');
    $razorpayCallbackUrl= getAppUrl($razorpayConfigData['callbackUrl']);
    $currency = $razorpayConfigData['currency'];
    $currencySymbol = $razorpayConfigData['currencySymbol'];
    $testMode = $razorpayConfigData['testMode'];
    $razorpayTestingkeyId = $razorpayConfigData['razorpayTestingkeyId'];
    $razorpayLivekeyId = $razorpayConfigData['razorpayLivekeyId'];
    $merchantname = $razorpayConfigData['merchantname'];
    $themeColor = $razorpayConfigData['themeColor'];
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
           
            if (paymentOption == 'razorpay') {

                var razorpayCallbackUrl = <?php echo json_encode($razorpayCallbackUrl); ?>,
                    paymentPagePath = <?php echo json_encode($paymentPagePath); ?>,
                    userDetails = <?php echo json_encode($userDetails); ?>,
                    currency = "<?= $currency ?>",
                    razorpayKeyId = '',
                    testMode = "<?= $testMode ?>";
                const amount =  userDetails['amounts'][currency];

                if (testMode) {
                    razorpayKeyId = "<?= $razorpayTestingkeyId ?>";
                } else {
                    razorpayKeyId = "<?= $razorpayLivekeyId ?>";
                }

                var razorpayAmount = amount.toFixed(2) * 100,
                    razorpayPaymentId = null,
                    options = {
                    "key": razorpayKeyId, // add razorpay Api Key Id
                    "amount": razorpayAmount, // 2000 paise = INR 20
                    "currency": currency, // add currency
                    "name": "<?= $merchantname ?>", // add merchant user name
                    "handler": function (response){
                        // after successful paid amount return razorpay payment Id
                        razorpayPaymentId = response.razorpay_payment_id;
                        var encodeRazorpayAmount =  window.btoa(razorpayAmount);
                        //show loader before ajax request
                        $(".lw-show-till-loading").show();

                        var razorpayData = {
                            'razorpayPaymentId': razorpayPaymentId,
                            'razorpayAmount': encodeRazorpayAmount
                        };
                        var razorpayData = $('#lwPaymentForm').serialize() + '&' + $.param(userDetails) + '&' + $.param(razorpayData);

                        $.ajax({
                            type: 'post', //form method
                            context: this,
                            url: 'payment-process.php', // post data url
                            dataType: "JSON",
                            data: razorpayData, // form serialize data
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
                                if (response.status == "captured") {
                                    razorpayCallbackUrl = razorpayCallbackUrl+'?orderId='+userDetails['order_id'];
                                    $('body').html("<form action='"+razorpayCallbackUrl+"' method='post'><input type='hidden' name='response' value='"+JSON.stringify(response)+"'><input type='hidden' name='paymentOption' value='razorpay'></form>");
                                    $('body form').submit();
                                }
                            }
                        });

                        //after successful payment go to response page
                        /* window.location.href = razorpayCallbackUrl+'?paymentOption='+paymentOption+'&razorpayPaymentId='+razorpayPaymentId+'&amount='+encodeRazorpayAmount; */
                    },
                    "prefill": {
                        "name": userDetails['payer_name'], // add user name
                        "email": userDetails['payer_email'], // add user email
                    },
                    "theme": {
                        "color": "<?= $themeColor ?>", // add widget theme color
                    },
                    "modal": {
                        "ondismiss": function(e){
                            // if razorpay payment Id is not received on onDismiss razorpay inline widget then load Url back to checkoutform page
                            if (razorpayPaymentId == null) {
                                //window.location.href = paymentPagePath+'<?= basename($_SERVER['PHP_SELF']); ?>';
                            }
                        }
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }
            // Razorpay script for send ajax request to server side
        });
    });
</script>
<!-- /  Jquery Form submit in script tag -->

<?php 
if ($razorpayConfigData['enable']) { ?>
    <!-- load razorpay inline widget script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <!-- load razorpay inline widget script -->
<?php } ?>