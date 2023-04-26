<?php include 'header.php'; ?>

<div class="container">
    <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
    <div class="modal-header">
         
         <h4 class="modal-title" id="modalTitle">Create Notification</h4>
       </div>

          
        <form class="form" action="<?php echo site_url("admin/broadcasts/new"); ?> " method="POST" >
              <div class="form-group">
               <label class="form-group__service-name">Title</label>
                <input type="text" class="form-control" name="title" value="" required>
              </div>
              <div class="form-group">
                        <label class="form-group__service-name">Button Link (Optional)</label>
                        <input type="text" class="form-control" name="action_link" value="">
                </div>
               <div class="form-group">
                        <label class="form-group__service-name">Button Text (Optional)</label>
                        <input type="text" class="form-control" name="action_text" value="">
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Description</label>
         <textarea class="form-control" id="summernoteExample" rows="5" name="description" placeholder=""></textarea>
                        
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Display On All Pages</label>
                        <input type="checkbox" id="isAllPage" name="isAllPage" value="1">
                </div>
                <div class="form-group" id="allPages">
                        <label class="form-group__service-name">Select Pages</label>
                        <select multiple class="form-control" name="allPages[]" >
                            <?php foreach($pages as $page){ 
                         
                             echo '<option value="'.$page['page_get'].'">'.$page['page_name'].'</option>';
                             } ?>
                        </select>
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Select Users</label>
                        <input type="radio" class="" name="isAllUser" value="0"> All Users</br>
                        <input type="radio" class="" name="isAllUser" value="1"> Logged-In User
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Expiry Date</label>
                        <input type="date" class="form-control" name="expiry_date" value="">
                </div>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
  </div>
</div>

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