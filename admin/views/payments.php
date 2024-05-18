<?php include 'header.php'; ?>
<div class="container-fluid ">
    <ul class="nav nav-tabs">
        <li>
            <button class="btn btn-primary dp-10" data-toggle="modal" data-target="#modalDiv" data-action="payment_new">New Payment</button>

        </li>

        <li class="mln-10">
          
<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <?php echo $units["unit"] ?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><a href="admin/<?php echo $pageunits ?>?units=50">50 Per Page</a></li>
    <li><a href="admin/<?php echo $pageunits ?>?units=100">100 Per Page</a></li>
    <li><a href="admin/<?php echo $pageunits ?>?units=250">250 Per Page</a></li>
    <li><a href="admin/<?php echo $pageunits ?>?units=500">500 Per Page</a></li>
    </ul>
    </div>
        </li>
<li class="pull-right custom-search">
            <form class="form-inline" action="https://mastersofindiasmm.com/admin/payments" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="" placeholder="Search Payment">
                    <span class="input-group-btn search-select-wrap">
                        <select class="form-control search-select" name="search_type">
                        <option value="username" >Username</option>
                           <option value="txn_id" >Transaction ID</option>
                            <option value="pay_method" >Payment Method</option>
                            <option value="pay_amt" >Payment Amount</option>
                            <option value="pay_note" >Payment Note</option>
                           
                        </select>
                        <button type="submit" class="btn btn-default"><span class="fa fa-search" aria-hidden="true"></span></button>
                    </span>
                </div>
            </form>
        </li>
    </ul>
    <table class="table mytable">

        <thead>

                                    <tr>
                                        <th class="p-l">ID</th>
                                        <th>User</th>
                                        <th>Balance</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Mode</th>
                                        <th>Note</th>
                                        <th>Creation Date</th>
                                        <th>Last Update</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <form id="changebulkForm" action="<?php echo site_url("admin/payments/online/multi-action") ?>" method="post">
                                    <tbody>
                                        <?php foreach($payments as $payment ): ?>
                                        <tr>
                                            <td class="p-l"><?php echo $payment["payment_id"] ?></td>
                                            <td><?php echo $payment["username"] ?></td>
                                            <td>$<?php echo $payment["client_balance"] ?></td>
                                            
<td><?php echo $payment["payment_amount"] ?>$</td>
                                            <td><?php echo $payment["method_name"] ?></td>
                                            <td>
                                                <?php if( $payment["payment_status"] = 3 ){ ?>
                                                Completed
                                                <?php } ?>
                                            </td>
                                            <td><?php if( $payment["payment_mode"] == "Auto" ): ?>Automatic
<?php else: ?>
Manual<?php endif; ?></td>
                                            <td><?php echo $payment["payment_note"] ?></td>
                                            <td nowrap=""><?php echo $payment["payment_create_date"] ?></td>
                                            <td nowrap=""><?php echo $payment["payment_update_date"] ?></td>
                                            <td class="service-block__action">
                                                <div class="dropdown pull-right">
                                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Action</button>
                                                    <ul class="dropdown-menu">
                                                        <?php if( $payment["payment_mode"] == "Auto" ): ?>
                                                        <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="payment_detail" data-id="<?php echo $payment["payment_id"] ?>">Payment Detail</a></li>
                                                        <?php endif; ?>
                                                        <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="payment_edit" data-id="<?php echo $payment["payment_id"] ?>">Edit Payment</a></li>
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


<?php if( $paginationArr["count"] > 1 ): ?>
     <div class="row">
        <div class="col-sm-8">
           <nav>
              <ul class="pagination">
                <?php if( $paginationArr["current"] != 1 ): ?>
                 <li class="prev"><a href="<?php echo site_url("admin/payments/1".$search_link) ?>">&laquo;</a></li>
                 <li class="prev"><a href="<?php echo site_url("admin/payments/".$paginationArr["previous"].$search_link) ?>">&lsaquo;</a></li>
                 <?php
                     endif;
                     for ($page=1; $page<=$pageCount; $page++):
                       if( $page >= ($paginationArr['current']-9) and $page <= ($paginationArr['current']+9) ):
                 ?>
                 <li class="<?php if( $page == $paginationArr["current"] ): echo "active"; endif; ?> "><a href="<?php echo site_url("admin/payments/".$page.$search_link) ?>"><?=$page?></a></li>
                 <?php endif; endfor;
                       if( $paginationArr["current"] != $paginationArr["count"] ):
                 ?>
                 <li class="next"><a href="<?php echo site_url("admin/payments/".$paginationArr["next"].$search_link) ?>" data-page="1">&rsaquo;</a></li>
                 <li class="next"><a href="<?php echo site_url("admin/payments/".$paginationArr["count"].$search_link) ?>" data-page="1">&raquo;</a></li>
                 <?php endif; ?>
              </ul>
           </nav>
        </div>
     </div>
   <?php endif; ?>

<?php include 'footer.php'; ?>

