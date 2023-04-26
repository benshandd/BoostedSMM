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
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/custom.css" type="text/css">
</head>

<body>
    <div class="d-flex justify-content-center">
        <div class="lw-page-loader lw-show-till-loading">
            <div class="spinner-border"  role="status"></div>
        </div>
    </div>

    <div class="pt-4 mb-5 container" id="lwCheckoutForm">
        <div class="row">
            <div class="col">
                <form method="post" id="lwPaymentForm">
                    <div class="card" style="border:0">
                    <!-- Payment Page header -->
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
                                    'order_id'      => $hash, // required in instamojo, Iyzico, Paypal, Paytm gateways
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
                            ?>
                            <?php
                            
                            if (!$configData) {
                                echo '<div class="alert alert-warning text-center">Unable to load configuration.</div>';
                            } else {
                                $configItem = $configData['payments']['gateway_configuration'];

                                //show payment gateway radio button
                                foreach ($configItem as $key => $value) { 
                                    if ($value['enable'] and $key == 'iyzico') { ?>
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

                                <!-- Iyzico Merchant Form  -->
                                <div class="lw-iyzico-form card mb-3" id="iyzicoForm">
                                    <div class="card-header">
                                        <h6 class="card-title display-td" >Iyzico Card <small>All fields are required.</small></h6>
                                    </div>
                                  <!--   <h3> Iyzico Payment</h3>
                                    <label for="fname"> All fields are required.</label> -->
                                    <div class="card-body mb-3">
                                        
                                        <!-- name of card -->
                                        <div class="form-group">
                                            <label for="cname">Name on Card</label>
                                            <input type="text" class="form-control" id="cname" name="cardname" placeholder="John More Doe">
                                        </div>
                                        <!-- / name of card -->

                                        <!-- Card number -->
                                        <div class="form-group">
                                            <label for="cardNumber">Card Number</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="cardNumber" name="cardnumber">
                                                <div class="input-group-append" id="basic-addon1">
                                                    <span class="input-group-text"><i class="fa fa-credit-card"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / Card number -->                                        

                                        <div class="form-row">
                                            <div class="col">
                                                <!-- Set card expiry month -->
                                                <label for="expmonth">Exp Month</label>
                                                <input type="number" class="form-control" id="expmonth" name="expmonth">
                                                <!-- / Set card expiry month -->
                                            </div>
                                            <div class="col">
                                                <!-- Set card expiry year -->
                                                <label for="expyear">Exp Year</label>
                                                <input type="number" class="form-control" id="expyear" name="expyear">
                                                <!-- / Set card expiry year -->
                                            </div>
                                            <div class="col">
                                                <!-- Set card cvv number -->
                                                <label for="cvv">CVV</label>
                                                <input type="number" class="form-control" id="cvv" name="cvv">
                                                <!-- Set card cvv number -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / Iyzico Merchant Form  -->
                                <h3 id="lwPaymentAmount"></h3>
                                <!--  checkout form submit button -->
                                <button type="submit" value="Proceed to Pay" class="btn btn-lg btn-block btn-success">Proceed to Pay</button>
                                <!-- / checkout form submit button -->
                    <?php   } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$config = configItem();
$gatewayConfiguration = $config['payments']['gateway_configuration'];

$currency = configItemData('payments.gateway_configuration.iyzico.currency');
$currencySymbol = configItemData('payments.gateway_configuration.iyzico.currencySymbol');
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
<!-- apply validation for iyzico form data -->
<script type="text/javascript">
    $("#iyzicoForm").show();
</script>
<!-- / apply validation for iyzico form data -->

<!-- Jquery Form submit in script tag -->
<script type="text/javascript">
   
    $(document).ready(function(){
        //submit checkout form
        $('#lwPaymentForm').on('submit', function(e){ 
     
            e.preventDefault();
            var paymentOption = $( 'input[name=paymentOption]:checked' ).val();
           
            // Paypal, Paytm, Instamojo or iyzico script for send ajax request to server side start
            if (paymentOption == 'iyzico') {
                
                //show loader before ajax request
                $(".lw-show-till-loading").show();

                //send ajax request with form data to server side processing
                $.ajax({
                    type: 'post', //form method
                    context: this,
                    url: 'payment-process.php', // post data url
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
                       
                        //response data
                        if(response.paymentOption == "iyzico") {
                            //on success load html content page on iyzico else show error message
                            if (response.status == 'success') {
                                $('body').html(response.htmlContent);
                            } else if (response.message == 'failed') {
                                string += '<div class="alert alert-danger" role="alert">'+response.errorMessage+'</div>';
                            } else {
                                $.each(response.validationMessage, function(index, value) {
                                    messageData = value;
                                    string += '<div class="alert alert-danger" role="alert">'+messageData+'</div>';
                                });
                            }
                            $('#lwValidationMessage').html(string);
                        }
                    }
                });
            } 
            // iyzico script for send ajax request to server side end
        });
    });
</script>
<!-- /  Jquery Form submit in script tag -->
