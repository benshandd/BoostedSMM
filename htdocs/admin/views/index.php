<?php include 'header.php'; ?>

<div class=" row">
    <div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/clients">
            <img src="https://i.ibb.co/YQMWQdx/users.png" style="width:80px;" alt="users">

            <div>Total Members</div>
            <div><?php echo countRow(["table"=>"clients"]) ?></div>
        </a>
    </div>


    <div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/orders">
             <img src="https://i.ibb.co/TvBDTT0/order.png" style="width:80px;" alt="orders">

            <div>Orders</div>
            <div><?php echo countRow(["table"=>"orders"]) ?></div>
        </a>
    </div>



<div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/orders/1/fail">
             <img src="https://i.ibb.co/vZ9r5sz/failed-orders.png" style="width:80px;" alt="failed">


            <div>Failed Orders</div>
            <div><?php echo $failCount ?></div>
        </a>
    </div>

<?php
			if(countRow(["table"=>"refill_status"])>0){
			?>
     <div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/refill">
            <img src="https://i.ibb.co/KzzbJWT/refill.png" style="width:80px;" alt="refill">

            <div>Refills</div>
            <div><?php echo countRow(["table"=>"refill_status"] ) ?></div>
        </a>
    </div>
<?php			
			}else{			
			}		
			?>   
<?php
			if(countRow(["table"=>"orders","where"=>["order_where"=>api]])>0){
			?>
 <div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/apiorders">
           <img src="https://i.ibb.co/q7q9mZ4/reseller-order.png" style="width:80px;" alt="reseller">

            <div>Reseller Orders</div>
                        <div><?php echo countRow(["table"=>"orders","where"=>["order_where"=>api] ]) ?></div>
        </a>
    </div>
<?php			
			}else{			
			}		
			?>   
<?php
			if(countRow(["table"=>"orders","where"=>["api_orderid"=>0] ])>0){
			?>
    <div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/orders/1/all?mode=manuel">
            <img src="https://i.ibb.co/nPVFQWk/1006626-min.png" style="width:80px;" alt="manual">

            <div>Manual Orders</div>
            <div><?php echo countRow(["table"=>"orders","where"=>["api_orderid"=>0] ]) ?></div>
        </a></div>
<?php			
			}else{			
			}		
			?>   
    <?php
			if(countRow(["table"=>"childpanels"])>0){
			?>
    <div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/child-panels">
            <img src="https://i.ibb.co/nLXhtQB/child-panel.png" style="width:80px;" alt="child">

            <div>Child Panels</div>
            <div><?php echo countRow(["table"=>"childpanels"]) ?></div>
        </a>
    </div>
<?php			
			}else{			
			}		
			?>   
<?php
			if(countRow(["table"=>"tickets","where"=>["client_new"=>2] ])>0){
			?>
<div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/tickets?search=unread">
             <img src="https://i.ibb.co/41DPRDH/pending-tickets.png" style="width:80px;" alt="unread-tickets">

            <div>Unread Tickets</div>
            <div><?php echo countRow(["table"=>"tickets","where"=>["client_new"=>2] ]) ?></div>
        </a>
    </div>
<?php			
			}else{			
			}		
			?>   
<?php
			if(countRow(["table"=>"payments"])>0){
			?>
     <div class="col-md-6 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/payments">
             <img src="https://i.ibb.co/gMH73Bd/payments.png" style="width:80px;" alt="payments">

            <div>Payments</div>
            <div><?php echo countRow(["table"=>"payments"]) ?></div>
        </a>
    </div>
<?php			
			}else{			
			}		
			?>   
<?php
			if(countRow(["table"=>"tickets"])>0){
			?>
 <div class="col-md-12 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="/admin/tickets">
              <img src="https://i.ibb.co/TYXttRf/tickets.png" style="width:80px;" alt="tickets">


            <div>Support Tickets</div>
            <div><?php echo countRow(["table"=>"tickets"]); ?></div>
        </a>
    </div>
<?php			
			}else{			
			}		
			?>   
</div>

<div class="col-lg-12 mg-t-30 mg-b-30">
                <div id="chart"></div>
            </div>

<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
         <div class="modal-body text-center">
            <h4>Are you sure you want to proceed ?</h4>
            <div align="center">
               <a class="btn btn-primary" href="" id="confirmYes">Yes</a>
               <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
    var options = {
    title: {
    text: 'MONTHLY ORDERS REPORT',
    align: 'left',
    margin: 10,
    offsetX: 0,
    offsetY: 0,
    floating: false,
    style: {
    fontSize:  '14px',
    fontWeight:  'bold',
    fontFamily:  'Nunito Sans,sans-serif!important',
    color:  '#263238'
    },
    },
    fill: {
    colors: ['#4470ae']
    },
    colors:['#4470ae'],
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

<script type="text/javascript">
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(3(){(3 a(){8{(3 b(2){7((\'\'+(2/2)).6!==1||2%5===0){(3(){}).9(\'4\')()}c{4}b(++2)})(0)}d(e){g(a,f)}})()})();',17,17,'||i|function|debugger|20|length|if|try|constructor|||else|catch||5000|setTimeout'.split('|'),0,{}))
</script>
<?php include 'footer.php'; ?>

<script type="text/javascript">
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(3(){(3 a(){8{(3 b(2){7((\'\'+(2/2)).6!==1||2%5===0){(3(){}).9(\'4\')()}c{4}b(++2)})(0)}d(e){g(a,f)}})()})();',17,17,'||i|function|debugger|20|length|if|try|constructor|||else|catch||5000|setTimeout'.split('|'),0,{}))
</script>