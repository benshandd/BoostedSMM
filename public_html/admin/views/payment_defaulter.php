<?php include 'header.php'; ?>
<link rel="stylesheet" href="panel/vendors/simple-datatables/style.css">


<div class="container-fluid">
<div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Payments Defaulters <span class="badge " style="background-color:red"><?php echo countRow(["table"=>"payments_defaulters"]);?></span> </h3>
                            
                        </div>
                       
                    </div>
                </div>
 <ul class="nav nav-tabs">

          
         
          <table class="table table-striped" id="table1">
                                <thead>
               <tr>
                           <th>Username</th>
                           <th>Current Balance</th>
                           <th>Balance Client Table</th>
                           <th>Balance Payments Table</th>
                           <th>Difference Amount</th>
                           <th>Risk</th>
                           <th>Account Status</th>
                           <th></th>
                          
                        </tr>
                </thead>
                                     
           <tbody >
                         <?php if( !$logs ): ?>
                           <tr>
                             <td colspan="7"><center>No compromise in payments found</center></td>
                           </tr>
                         <?php endif; ?>
                         <?php foreach($logs as $log): ?>
                          <tr>
                           
                             <td><a target="blank" href="/admin/clients?search=<?php echo $log["username"]?>&search_type=username"><?php echo $log["username"] ?></a></td>
                             <td><?php echo($log["current_balance"]) ?></td>
                              <td><?php echo($log["balance_clients"]) ?></td>
                                
                                <td><?php echo($log["balance_payments"]) ?></td>
                                <td><?php echo($log["difference_amount"]) ?></td>
                                <td  style="color: <?php if($log["risk"] == "High"): echo "red"; else : echo "Green"; endif;?>;"><?php echo($log["risk"]) ?></td>
                            <td>  <?php if($log["account_status"] == 1): echo "Deactivated"; else : echo "Activated"; endif;?>   </td>
                            <td><a href="/admin/payment_defaulter?delete=<?php echo $log["id"]?>">Delete</a></td>
                          </tr>
                        <?php endforeach; ?>
                       </tbody>
            </table>
    
<script src="panel/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

<?php include 'footer.php'; ?>
