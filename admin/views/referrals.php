<?php include 'header.php'; ?>
<link rel="stylesheet" href="panel/vendors/simple-datatables/style.css">
<div class="container">
  <div class="row">
              <div class="col-md-2 col-md-offset-1">
            <ul class="nav nav-pills nav-stacked p-b">
                              <li class="settings_menus active"><a href="admin/referrals">Referrals</a></li>
                              <li class="settings_menus "><a href="admin/payouts">Payouts</a></li>

</div>
<div class="content-body">
    <div class="pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-40 mg-lg-b-35 mg-xl-b-40">
        <nav aria-label="breadcrumb">
                    
                </nav>
        </div>

        <div class="row row-xs">

            <div class="col">
                <div class="card dwd-100">
                    <div class="card-body pd-30 table-responsive dof-inherit">

                        <div class="container-fluid pd-t-30 pd-b-30">
                            
                            <br> <br> <br>
                            <table class="table" id="table1" style="overflow:auto;">
                                <thead>
                                    <tr>
                                        <th class="p-l">#</th>
                                        <th>R. Code</th>
                                        <th>R. Owner</th>
                                        <th>R. Clicks</th>
                                        <th>R. Sign Up</th>
                                        <th>R. Conversion Rate</th>
                                        <th>R. Total Funds</th>
                                        <th>R. Earned Commision</th>
                                        
                                        <th>R. Requested Commision</th>
                                        <th>R. Total Commision</th>
                                        <th>R. Status</th>
                                        <!-- <th>Reffered Accounts Username</th> -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <form id="changebulkForm" action="<?php echo site_url("admin/payments/online/multi-action") ?>" method="post">
                                    <tbody>
                                        <?php foreach ($referrals as $referral) : ?>
                                            <tr>
                                               <td><?php echo $referral["referral_id"] ?></td>   
                                               <td><?php echo $referral["referral_code"] ?></td>
                                               <td><?php echo $referral["username"] ?></td>
                                               <td><?php echo $referral["referral_clicks"] ?></td>
                                               <td><?php echo $referral["referral_sign_up"] ?></td>
                                               <td><?php echo ($referral["referral_sign_up"]/$referral["referral_clicks"])*100 ?>%</td>
                                               <td><?php echo $referral["referral_totalFunds_byReffered"] ?></td>
                                               <td><?php echo $referral["referral_earned_commision"] ?></td>   
                                         
                                               <td><?php echo $referral["referral_requested_commision"] ?></td>
                                               <td><?php echo $referral["referral_total_commision"] ?></td>
                                               <td><?php if($referral["referral_status"]==2){echo "Active";}else{echo "Inactive";}  ?></td>
                                               <td class="service-block__action">
                                                <div class="dropdown pull-right">
                                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Action</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="reffered_users" data-id="<?php echo $referral["referral_code"] ?>">Views Reffered Users</a></li>
                                                        <!-- <li><a >Disable Refferal</a></li> -->
                                                  </ul>
                                                </div>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="panel/vendors/simple-datatables/simple-datatables.js"></script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>


<?php include 'footer.php'; ?>

<script src="theme/assets/js/datatable/payments.js"></script>