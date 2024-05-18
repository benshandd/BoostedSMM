<?php include 'header.php'; ?>


<div class="container-fluid">
  <div class="row">    
   <div class=" col-md-12">
   <ul class="nav nav-tabs">
   
          <a href="<?php echo site_url("admin/broadcasts/create") ?>" <button type="button" class="btn btn-primary" data-toggle="modal" data-target="" data-action="">Create Notifications </button> </a>
   
     
   </ul>
<br>
   <div class="row row-xs">

            <div class="col">
                <div class="card dwd-100">
                    <div class="card-body pd-20 table-responsive dof-inherit">
                        <div class="container-fluid pd-t-20 pd-b-20">
                            
                                    
   
   <table class="table report-table" style="border:1px solid #ddd">
      <thead>
         <tr>
            <th width="5%"> Id</th>
            <th width="20%">Title</th>
            <th width="30%">Action Link</th>
            <th width="5%">All Pages</th>
            <th width="5%">All Users</th>
            <th width="10%">Date Expiry</th>
            <th width="10%">Status</th>
            <th width="10%">Action</th>
         </tr>
      </thead>
      
        <tbody>
          <?php foreach($notifications as $notification ): ?>
              <tr>
                
                 <td><?php echo $notification["id"] ?></td>
                 <td><?php echo $notification["title"] ?></td>
                 <td><?php echo $notification["action_link"] ?></td>
                 <td><?php if($notification["isAllPage"]){ echo 'Yes';}else{ echo 'No';}   ?></td>
                 <td><?php if($notification["isAllUser"]){ echo 'No';}else{ echo 'Yes';}   ?></td>
                 <td><?php echo $notification["expiry_date"] ?></td>
                 <td><?php if($notification["status"]==1){ echo 'Active';}else{ echo 'Inactive';}   ?></td>
                 <td>
                     <form id="changebulkForm" action="<?php echo site_url("admin/broadcasts/delete") ?>" method="post" onsubmit="return confirm('Do you want to delete it?');">
                     <input type="hidden" name="notification_id" value="<?php echo $notification["id"] ?>"><button type="submit" class="btn btn-danger btn-xs dropdown-toggle btn-xs-caret">Delete</button>
                     <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
                     </form>
                     <a href="<?php echo site_url("admin/broadcasts/edit/".$notification["id"]) ?>" class="btn btn-info btn-xs dropdown-toggle btn-xs-caret" style="min-width: 46%;">Edit</a>
                 </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
        
   </table>
   <!--<hr>
   <h4>Notification Used</h4>
   <br>
 
   
   <table class="table report-table" style="border:1px solid #ddd">
      <thead>
         <tr>
           
           
            <th width="13%">Member Number</th>
            <th width="13%">Notification Popup Id</th>
            <th width="33%">Title</th>
            <th width="33%">Descriptiont</th>
            <th width="33%">All Pages</th>
            <th></th>
         </tr>
      </thead>
      <form id="changebulkForm" action="<?php echo site_url("admin/broadcasts/delete") ?>" method="post" onsubmit="return confirm('Silmek istiyor musunuz ?');">
        <tbody>
          <?php foreach($kupon_kullananlar as $kupons ): ?>
              <tr>
                
                 <td><?php echo $kupons["uye_id"] ?></td>
                 <td><?php echo $kupons["kuponadi"] ?></td>
                 <td><?php echo $kupons["tutar"] ?></td>
                 <td><?php echo $kupons["tutar"] ?></td>
            
                 
              </tr>
            <?php endforeach; ?>
        </tbody>
        <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
      </form>
   </table>-->
</div>
</div>
</div>

<?php

include 'footer.php'; ?>