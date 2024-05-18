<?php include 'header.php'; ?>


   <div class="sticker-head">
      <table class="service-block__header" id="sticker">
         <thead>
  
               <th class="">ID</th>
               <th class="" >Name</th>
<th >Min</th> 
<th >Max</th>
<th >Price</th>
<th >Description</th>
            </tr>
         </thead>
      </table>
   


                           <table id="servicesTableList" >
                              <tbody class="service-sortable">
<form action="" method="post" enctype="multipart/form-data">
            
              <?php foreach($services as $service ):  ?>
          <tr>
                                            <td class=""><input type="text" class="form-control" name="service[<?php echo $service["service_id"]; ?>]"  value="<?php echo $service["service_id"]; ?>" readonly></td>
                                            <td class=""><input type="text" class="form-control" name="name-<?php echo $service["service_id"]; ?>"  value=" <?php echo $service["service_name"]; ?>"></td>
                                            

                                             
                                            <td class="">
                                               <div><input type="text" class="form-control" name="min-<?php echo $service["service_id"]; ?>" value="<?php echo $service["service_min"]; ?>"></div>
                                              
                                            </td>
                                            <td class=" ">
                                               <div><input type="text" class="form-control" name="max-<?php echo $service["service_id"]; ?>" value="<?php echo $service["service_max"]; ?>"></div>
                                            </td>
   <td class="">
                                               <div><input type="text" class="form-control" name="price-<?php echo $service["service_id"]; ?>" value="<?php echo $service["service_price"]; ?>"></div>
                                            </td>
   <td class="">
                                               <div><input type="text" class="form-control" name="desc-<?php echo $service["service_id"]; ?>"  value="<?php echo $service["service_description"]; ?>"></div>
                                            </td>
                                            
                                     </tr>
<?php endforeach; ?>
                                   </div>
                              </tbody>
                           </table>
              

                            <center><button type="submit" class="btn btn-primary">Save Changes</button></center>
      </form>
         </div>
      </div>
   </div>

</div>

<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
 <div class="modal-dialog modal-dialog-center" role="document">
   <div class="modal-content">
     <div class="modal-body text-center">
       <h4>Are you sure you want to update the status?</h4>
       <div align="center">
         <a class="btn btn-primary" href="" id="confirmYes">Yes</a>
         <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
       </div>
     </div>
   </div>
 </div>
</div>


<?php include 'footer.php'; ?>
