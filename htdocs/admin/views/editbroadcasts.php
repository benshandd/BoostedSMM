<?php include 'header.php'; ?>

            <div class="container">
    <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
    <div class="modal-header">  

         
         <h4 class="modal-title" id="modalTitle">Edit Notification </h4>

          
     <left>   <a href="<?=site_url("admin/broadcasts")?>" class="export">
         <span class="export-title">Go Back</span>
         </a></left>
      
       </div>

         <?php  //echo "<pre>"; print_r($notifData); echo "</pre>"; ?> 
        <form class="form" action="<?php echo site_url("admin/broadcasts/edit"); ?> " method="POST" >
              <div class="form-group">
               <label class="form-group__service-name">Title</label>
               <input type="hidden" name="id" value="<?= $notifData['id']; ?>">
                <input type="text" class="form-control" name="title" value="<?= $notifData['title']; ?>" required>
              </div>
      
               <div class="form-group">
                        <label class="form-group__service-name">Action Link</label>
                        <input type="text" class="form-control" name="action_link" value="<?= $notifData['action_link']; ?>">
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Button Text (Optional)</label>
                        <input type="text" class="form-control" name="action_text" value="<?= $notifData['action_text']; ?>">
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Description</label>
         <textarea class="form-control" id="summernoteExample" rows="5" name="description" placeholder="" required> <?= $notifData['description']; ?> </textarea>

                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Display On All Pages</label>
                        <input type="checkbox" id="isAllPage" name="isAllPage" value="1" <?php if ($notifData['isAllPage']==1) { echo 'checked'; } ?>>
                </div>
                <div class="form-group" id="allPages" <?php if ($notifData['isAllPage']==1) { ?> style="display:none"<?php } ?>>
                        <label class="form-group__service-name">Select Pages</label>
                        <select multiple class="form-control" name="allPages[]" >
                            <?php foreach($pages as $page){ ?> 
                                <option value="<?php echo $page['page_get']; ?>" <?php if (strpos($notifData['allPages'], $page['page_get'])) { echo 'selected'; } ?>><?php echo $page['page_name']; ?></option>
                            <?php } ?>
                        </select>
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Select Users</label>
                        <input type="radio" class="" name="isAllUser" value="0" <?php if ($notifData['isAllUser']==0) { echo 'checked'; } ?>> All Users</br>
                        <input type="radio" class="" name="isAllUser" value="1" <?php if ($notifData['isAllUser']==1) { echo 'checked'; } ?>> Logged-In User
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Expiry Date</label>
                        <input type="date" class="form-control" name="expiry_date" value="<?= $notifData['expiry_date']; ?>">
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Status</label>
                        <select class="form-control" name="status">
                                <option value="0" >Selected : <?php if($notifData['status']==0){echo "Inactive";}else{echo "Active";}  ?></option>
                            <option value="0" <? if($notifData['status']==0){ echo 'selected'; } ?>Inactive</option>
                            <option value="1" <? if($notifData['status']==1){ echo 'selected'; } ?>Active</option>
                        </select>    
                </div>
              <button type="submit" class="btn btn-primary">Update</button>
        </form>
    
  


<?php include 'footer.php'; ?>
<script>
$('input#isAllPage').change(function() {
if ($('input#isAllPage').prop('checked')) {    
   $('div#allPages').hide();
}else{
    $('div#allPages').show();
}

});
</script>