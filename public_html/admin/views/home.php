<?php include 'header.php'; ?>

<div class="content-body">
    <div class="container-fluid pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#"><?php echo constant("HOME") ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">New Support Tickets</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"tickets","where"=>["client_new"=>2]])>0?countRow(["table"=>"tickets","where"=>["client_new"=>2]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Open Support Tickets</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"tickets","where"=>["status"=>"pending"]])>0?countRow(["table"=>"tickets","where"=>["status"=>"pending"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">New Payment Notifications</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"payments","where"=>["payment_method"=>6,"payment_status"=>1]])>0?countRow(["table"=>"payments","where"=>["payment_method"=>6,"payment_status"=>1]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">New Manual Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo countRow(["table"=>"orders","where"=>["api_orderid"=>0] ]) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <hr class="mg-t-20 mg-b-10">
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Clients</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo countRow(["table"=>"clients"]) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders"])>0?countRow(["table"=>"orders"]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Earning</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Tickets</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"tickets"])>0?countRow(["table"=>"tickets"]):0) ?></h1>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 mg-t-30 mg-b-30">
                <div id="chart"></div>
            </div>

            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Cron Pending Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"cronpending"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"cronpending"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Pending Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"pending"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"pending"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Inprogress Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"inprogress"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"inprogress"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Completed Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"completed"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"completed"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Partial Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"partial"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"partial"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Canceled Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"canceled"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"canceled"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Processing Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"processing"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"processing"]]):0) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mg-t-10">
                <div class="card card-body">
                    <h4 class="tx-uppercase tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Fail Orders</h4>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo (countRow(["table"=>"orders","where"=>["order_status"=>"fail"]])>0?countRow(["table"=>"orders","where"=>["order_status"=>"fail"]]):0) ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var options = {
    title: {
    text: 'MONTHLY ORDER REPORT',
    align: 'left',
    margin: 10,
    offsetX: 0,
    offsetY: 0,
    floating: false,
    style: {
    fontSize:  '14px',
    fontWeight:  'bold',
    fontFamily:  'Nunito Sans,sans-serif!important',
    color:  '#208b9f'
    },
    },
    fill: {
    colors: ['#208b9f']
    },
    colors:['#208b9f'],
    series: [{
    name: 'Daily Orders',
    data: [<?php for ($day=1; $day <=31; $day++): ?>
                <?php echo dayOrders($day,date('m'),date("Y")).','; ?>
            <?php endfor; ?>]
    }],
    chart: {
    height: 350,
    type: 'area'
    },
    dataLabels: {
    enabled: false
    },
    stroke: {
    curve: 'smooth'
    },
    xaxis: {
    type: 'datetime',
    categories: ["<?=date('m')?>-01","<?=date('m')?>-02","<?=date('m')?>-03","<?=date('m')?>-04","<?=date('m')?>-05","<?=date('m')?>-06","<?=date('m')?>-07","<?=date('m')?>-08","<?=date('m')?>-09","<?=date('m')?>-10","<?=date('m')?>-11","<?=date('m')?>-12","<?=date('m')?>-13","<?=date('m')?>-14","<?=date('m')?>-15","<?=date('m')?>-16","<?=date('m')?>-17","<?=date('m')?>-18","<?=date('m')?>-19","<?=date('m')?>-20","<?=date('m')?>-21","<?=date('m')?>-22","<?=date('m')?>-23","<?=date('m')?>-24","<?=date('m')?>-25","<?=date('m')?>-26","<?=date('m')?>-27","<?=date('m')?>-28","<?=date('m')?>-29","<?=date('m')?>-30","<?=date('m')?>-31"]
    },
    tooltip: {
    x: {
        format: 'MM/dd'
    },
    },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<?php include 'footer.php'; ?>