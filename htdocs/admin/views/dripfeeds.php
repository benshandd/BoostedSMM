

<?php include 'header.php'; ?>

<div class="content-body">
    <div class="pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            
        <div class="row row-xs">

            <div class="col">
                <div class="card dwd-100">
                    <div class="card-body pd-20 table-responsive dof-inherit">

                        <div class="container-fluid">
                            <ul class="nav nav-tabs mg-b-20 dborder-0">
                                <li class="<?php if( $status == "all"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds")?>" class="btn btn-outline-light mg-r-5">All</a></li>
                                <li class="<?php if( $status == "active"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds/1/active")?>" class="btn btn-outline-light mg-r-5">Active</a></li>
                                <li class="<?php if( $status == "completed"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds/1/completed")?>" class="btn btn-outline-light mg-r-5">Completed</a></li>
                                <li class="<?php if( $status == "canceled"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds/1/canceled")?>" class="btn btn-outline-light mg-r-5">Canceled</a></li>
                                 <li class="pull-right custom-search">
         <form class="form-inline" action="<?=site_url("admin/dripfeeds")?>" method="get">
            <div class="input-group">
               <input type="text" name="search" class="form-control" value="<?=$search_word?>" placeholder="Search">
               <span class="input-group-btn search-select-wrap">
                  <select class="form-control search-select" name="search_type">
                     <option value="order_id" <?php if( $search_where == "order_id" ): echo 'selected'; endif; ?> >Order ID</option>
                     <option value="order_url" <?php if( $search_where == "order_url" ): echo 'selected'; endif; ?> >Link</option>
                     <option value="username" <?php if( $search_where == "username" ): echo 'selected'; endif; ?> >Username</option>
                  </select>
                  <button type="submit" class="btn btn-default"><span class="fa fa-search" aria-hidden="true"></span></button>
               </span>
            </div>
         </form>
      </li>
   </ul>
                            </ul>

        <div class="table-responsive">
                            <table class="table" id="dt">
                                <thead>
                                    <tr>
                                        <th class="checkAll-th">
                                            <div class="checkAll-holder">
                                                <input type="checkbox" id="checkAll">
                                                <input type="hidden" id="checkAllText" value="order">
                                            </div>
                                            <div class="action-block">
                                                <ul class="action-list">
                                                    <li><span class="countOrders"></span> orders selected</li>
                                                    <li>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown"> Bulk actions</button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <?php if( $status  ==  "active" ): ?>
                                                                    <a class="bulkorder" data-type="completed">Completed All</a>
                                                                    <a class="bulkorder" data-type="canceled">Canceled All</a>
                                                                    <a class="bulkorder" data-type="canceledbalance">Refund Balance All</a>
                                                                    <?php endif; ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Link</th>
                                        <th>Quantity</th>
                                        <th class="dropdown-th">
                                            Service
                                        </th>
                                        <th>Type</th>
                                        <th>Interval</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <form id="changebulkForm" action="<?php echo site_url("admin/dripfeeds/multi-action") ?>" method="post">
                                    <tbody>
                                        <?php foreach( $orders as $order ): ?>
                                        <tr>
                                            <td><input type="checkbox" <?php if( $status == "all" || $status == "canceled" ): echo "class=\"dborder-1-solid\" disabled"; else: echo 'class="selectOrder dborder-1-solid"'; endif; ?> name="order[<?php echo $order["order_id"] ?>]" value="1"></td>
                                            <td class="p-l"><?php echo $order["order_id"] ?></td>
                                            <td><?php echo $order["username"] ?></td>
                                            <td><?php echo $order["dripfeed_totalcharges"] ?></td>
                                            <td><?php echo $order["order_url"]; ?></td>
                                            <td><?php echo $order["order_quantity"]; ?></td>
                                            <td><?php echo $order["service_name"]; ?></td>
                                            <td><?php echo "<a href='".site_url("admin/orders?dripfeed=".$order["order_id"])."'>".$order["dripfeed_delivery"]."</a>/".$order["dripfeed_runs"]; ?></td>
                                            <td><?php echo $order["dripfeed_interval"]; ?></td>
                                            <td><?php echo $order["dripfeed_totalquantity"]; ?></td>
                                            <td><?php echo date("d.m.Y H:i:s", strtotime($order["order_create"])); ?></td>
                                            <td><?php echo orderStatu($order["dripfeed_status"]); ?></td>
                                            <td class="service-block__action">
                                                <?php if( $order["dripfeed_status"] == "active" ): ?>
                                                <div class="dropdown pull-right">
                                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Action</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/dripfeeds/dripfeed_canceled/".$order["order_id"])?>">Cancel</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/dripfeeds/dripfeed_completed/".$order["order_id"])?>">Completed</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/dripfeeds/dripfeed_canceledbalance/".$order["order_id"])?>">Cancel and Refund</a></li>
                                                    </ul>
                                                </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
                                </form>
                            </table></div>
                        </div>
                        <div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-center" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <h4>Are you sure to update?</h4>
                                        <div align="center">
                                            <a class="btn btn-primary" href="" id="confirmYes">Yes</a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="/assets/js/datatable/drip.js"></script>