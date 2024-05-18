<?php include 'header.php'; ?>
<link rel="stylesheet" href="panel/vendors/simple-datatables/style.css">
<div class="container">
  <div class="row">
              <div class="col-md-2 col-md-offset-1">
            <ul class="nav nav-pills nav-stacked p-b">
                               <li class="settings_menus "><a href="admin/referrals">Referrals</a></li>
<li class="settings_menus active"><a href="admin/payouts">Payouts</a></li>
 </div>                           
<div class="content-body">
    <div class="pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        </div>

        <div class="row row-xs">

            <div class="col">
                <div class="card dwd-100">
                    <div class="card-body pd-20 table-responsive dof-inherit">

                        <div class="container-fluid pd-t-20 pd-b-20">

                            <br> <br> <br>
                            <table class="table" id="table1" style="overflow:auto;">
                                <thead>
                                    <tr>
                                        <th class="p-l">#</th>
                                        <th> Code</th>
                                        <th> Username </th>
                                        <th>Amount Requested</th>
                                        <th>Payout Status</th>
                                        <th>Payout Created At</th>
                                        <th>Payout Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <form id="changebulkForm" action="<?php echo site_url("admin/payouts") ?>" method="post">
                                    <tbody>
                                        <?php foreach ($referral_payouts as $referral_payout) : ?>
                                            <tr>
                                                <td><?php echo $referral_payout["r_p_id"] ?></td>
                                                <td><?php echo $referral_payout["r_p_code"] ?></td>
                                                <td><?php echo $referral_payout["username"] ?></td>
                                                <td><?php echo $referral_payout["r_p_amount_requested"] ?></td>
                                                <td><?php if ($referral_payout["r_p_status"] == 0) {
                                                        echo "Pending";
                                                    } elseif (
                                                        $referral_payout["r_p_status"] == 1
                                                    ) {
                                                        echo "Disapproved ";
                                                    }elseif (
                                                        $referral_payout["r_p_status"] == 2
                                                    ){
                                                        echo "Approved ";
                                                    } else {
                                                        echo "Rejected ";
                                                    }
                                                       
                                                      ?></td>
                                                <td><?php echo $referral_payout["r_p_requested_at"] ?></td>
                                                <td><?php echo $referral_payout["r_p_updated_at"] ?></td>


                                                <td class="service-block__action">
                                                    <div class="dropdown pull-right">
                                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Action</button>
                                                        <ul class="dropdown-menu">

                                                            <?php if ($referral_payout["r_p_status"] == 0) : ?>
                                                              
                                                                    <li><a href="<?= site_url("admin/payouts?approve=" . $referral_payout["r_p_id"]) ?>">Approve</a></li>
                                                                    <li><a href="<?= site_url("admin/payouts?disapprove=" . $referral_payout["r_p_id"]) ?>">Disapprove</a></li>
                                                                    <li><a href="<?= site_url("admin/payouts?reject=" . $referral_payout["r_p_id"]) ?>">Reject</a></li>

                                                             
                                                            <?php else : ?>

                                                                <li><a href="javascript:void(0)">No options to use</a></li>
                                                            <?php endif; ?>

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

