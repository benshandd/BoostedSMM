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
                                'item_qty'      => 1,
                                'item_id'       => 'ITEM' . uniqid(), // required in Iyzico, Paytm gateways
                                'payer_email'   => 'sample@domain.com', // required in instamojo, Iyzico, Stripe gateways
                                'payer_name'    => 'John Doe', // required in instamojo, Iyzico gateways
                                'payer_mobile'  => '9999999999',
                                'mobile_code'     => '11', // (code) required in pagseguro gateways
                                'mobile_number'   => '56273440', // (number) required in pagseguro gateways
                                'shipping_address' => [
                                    'address'           => 'Av. Brig. Faria Lima', //address
                                    'week_number'       => '1384', //house number
                                    'name'              => 'Jardim Paulistano', //name
                                    'zip_code'          => '01452002', // zip zode
                                    'state'             => 'São Paulo', // zip zode
                                    'highway_code'      => 'SP', // highway zode
                                    'country_code'      => 'BRA', // country zode
                                    'appartment_number' => 'apto. 114', // country zode
                                ], // required in pagseguro gateways
                                'shipping_cost' => '20.00',  // required in pagseguro gateways
                                'cpf_number'    => '92354201567', // required in pagseguro gateways
                                'description'   => 'Lorem ipsum dolor sit amet, constetur adipisicing', // Required for stripe
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
                                    if ($value['enable'] and $key == 'pagseguro') { ?>
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
                            <?php } ?>
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

<?php 
$currency = configItemData('payments.gateway_configuration.pagseguro.currency');
$currencySymbol = configItemData('payments.gateway_configuration.pagseguro.currencySymbol');  
?>

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
           
            // Paypal, Pagseguro, Instamojo or iyzico script for send ajax request to server side start
            if (paymentOption == 'pagseguro') {
                
                //show loader before ajax request
                $(".lw-show-till-loading").show();

                //send ajax request with form data to server side processing
                $.ajax({
                    type: 'post', //form method
                    context: this,
                    url: '../payment-process.php', // post data url
                    dataType: "JSON",
                    data: $('#lwPaymentForm').serialize() + '&' + $.param(JSON.parse('<?php echo json_encode($userDetails) ?>')), // form serialize data
                    error: function (err) {
                        var error = err.responseText;
                        
                        //on error show alert message
                        alert("AJAX error in request: " + JSON.stringify(err.responseText, null, 2));
                        //hide loader after ajax request complete
                        $(".lw-show-till-loading").hide();
                    },
                    success: function (response) {
                      
                       //check server side validation
                        if (typeof(response.validationMessage)) {

                            var messageData = [];
                            var string = '';

                            $.each(response.validationMessage, function(index, value) {
                                messageData = value;
                                string += '<div>'+messageData+'</div>';
                            });

                            $('#lwValidationMessage').html(string);

                            //hide loader after ajax request complete
                            $(".lw-show-till-loading").hide();
                        }
                       
                        //load pagseguro merchant form
                        if (response.paymentOption == "pagseguro") {    

                            //check status is success
                            if (response.status == 'success') {
                                window.location.href = response.redirect_url;
                            } else if (response.status == 'error') {
                                $(".lw-show-till-loading").hide();
                                var string = '';                                
                                //on error show alert message
                                string += '<div class="alert alert-danger" role="alert">'+response.message+'</div>';
                                $('#lwValidationMessage').html(string);
                            }

                        }
                    }
                });
            } 
            // Paytm script for send ajax request to server side end

        });
    });
</script>
<!-- /  Jquery Form submit in script tag -->
