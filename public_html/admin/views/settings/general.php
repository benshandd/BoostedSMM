  <div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-body">
    
      <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
        
          <div class="row">
            <div class="col-md-10">
              <label for="preferenceLogo" class="control-label">Site Logo</label>
              <input type="file" name="logo" id="preferenceLogo">
            </div>
            <div class="col-md-2">
              <?php if( $settings["site_logo"] ):  ?>
                <div class="setting-block__image">
                      <img class="img-thumbnail" src="<?=$settings["site_logo"]?>">
                    <div class="setting-block__image-remove">
                      <a href="" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-logo")?>"><span class="fa fa-remove"></span></a>
                    </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-11">
              <label for="preferenceFavicon" class="control-label">Site Favicon</label>
              <input type="file" name="favicon" id="preferenceFavicon">
            </div>
            <div class="col-md-1">
              <?php if( $settings["favicon"] ):  ?>
                <div class="setting-block__image">
                    <img class="img-thumbnail" src="<?=$settings["favicon"]?>">
                    <div class="setting-block__image-remove">
                      <a href="" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-favicon")?>"><span class="fa fa-remove"></span></a>
                    </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
          <hr>
      
        <div class="form-group">
          <label class="control-label">Maintenance mode  
            </label>
          <select class="form-control" name="site_maintenance">
            <option value="2" <?= $settings["site_maintenance"] == 2 ? "selected" : null; ?> >Passive</option>
            <option value="1" <?= $settings["site_maintenance"] == 1 ? "selected" : null; ?>>Active</option>
          </select>
          <hr>
          
      
       <div class="form-group">
          <label class="control-label">Rates Rounding   <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">When Sync and import</span></div> 
            </label>
          <select class="form-control" name="currency_format">
            <option value="0" <?= $general["currency_format"] == 0 ? "selected" : null; ?> >Ones (1)</option>
            <option value="2" <?= $general["currency_format"] == 2 ? "selected" : null; ?>>Hundreds (1.12)</option>
<option value="3" <?= $general["currency_format"] == 3 ? "selected" : null; ?> >Thousands (1.111)</option>
            <option value="4" <?= $general["currency_format"] == 4 ? "selected" : null; ?>>Ten Thousands (1.1111)</option>

          </select> 
          
<hr>
<div class="form-group">
          <label class="control-label">Snow Falling Effect</label>
          <select class="form-control" name="snow_effect">
            <option value="2" <?= $settings["snow_effect"] == 2 ? "selected" : null; ?> >Disabled</option>
            <option value="1" <?= $settings["snow_effect"] == 1 ? "selected" : null; ?>>Enabled</option>
          </select>
        </div>
        <div class="form-group">
          <label for="" class="control-label">Snow Colour</label>
          <input type="text" class="form-control" name="snow_colour" value="<?=$settings["snow_colour"]?>">
        </div>
<hr>
  <div class="form-group">
          <label class="control-label">Panel name</label>
          <input type="text" class="form-control" name="name" value="<?=$settings["site_name"]?>">
        </div>

        <hr>

        
        <div class="row">
              <div class="col-md-12 form-group">
            <div class="alert alert-info"><strong>ATTENTION! </strong>Exchange rates are should updated Daily</div>
            </div>
            <?php   ?>
          <div class="col-md-6 form-group">
            <label for="" class="control-label">Dollar Exchange Rate</label>
            <input type="text" class="form-control" name="dolar" value="<?=$settings["dolar_charge"]?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="" class="control-label">Euro Exchange Rate</label>
            <input type="text" class="form-control" name="euro" value="<?=$settings["euro_charge"]?>">
          </div>
          <p class="col-md-12 help-block">
                <small>Exchange rates to be used when calculating earnings from orders, Etc</small>
          </p>
        </div>
        <hr>
        		
		<div class="form-group">
          <label for="" class="control-label">Bronze Member</label>
          <input type="text" class="form-control" name="bronz_statu" value="<?=$settings["bronz_statu"]?>">
        </div>
		
		<div class="form-group">
          <label for="" class="control-label">Silver Member</label>
          <input type="text" class="form-control" name="silver_statu" value="<?=$settings["silver_statu"]?>">
        </div>
		
		<div class="form-group">
          <label for="" class="control-label">Gold Member</label>
          <input type="text" class="form-control" name="gold_statu" value="<?=$settings["gold_statu"]?>">
        </div>
		
		<div class="form-group">
          <label for="" class="control-label">Dealer</label>
          <input type="text" class="form-control" name="bayi_statu" value="<?=$settings["bayi_statu"]?>">
        </div>
		 <p class="help block">
                <small>	Just enter the number to determine the amount that the member should spend on the rank. Example: 350</small>
          </p>
	
	<hr />
        <div class="row">	
          <div class="form-group col-md-4">
            <?php 
            if($settings["resetpass_page"] == "2"){
                $respass_active = "selected";
            }else{
                $respass_passive = "selected";
            } ?>  
            <label class="control-label">Reset Password</label>
            <select class="form-control" name="resetpass">
              <option value="2" <?= $respass_active ?> >Enabled</option>
              <option value="1" <?= $respass_passive ?>>Disabled</option>
            </select>
          </div>

          <div class="form-group col-md-4">
            <?php 
            if($settings["resetpass_sms"] == "2"){
                $ressms_active = "selected";
            }else{
                $ressms_passive = "selected";
            } ?>  
            <label class="control-label">Send My Password To My Phone</label>
            <select class="form-control" name="resetsms">
              <option value="2" <?= $ressms_active ?> >Enabled</option>
              <option value="1" <?= $ressms_passive ?>>Disabled</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <?php 
            if($settings["resetpass_email"] == "2"){
                $resemail_active = "selected";
            }else{
                $resemail_passive = "selected";
            } ?>
            <label class="control-label">Send My Password To My Mail</label>
            <select class="form-control" name="resetmail">
              <option value="2" <?= $resemail_active ?> >Enabled</option>
              <option value="1" <?= $resemail_passive ?>>Disabled</option>
            </select>
          </div>
        </div>
        <hr>
        <div class="form-group">
            <?php 
            if($settings["ticket_system"] == "1"){
                $ticket_active = "selected";
            }else{
                $ticket_passive = "selected";
            } ?>
          <label class="control-label">Ticket system</label>
          <select class="form-control" name="ticket_system">
            <option value="1" <?= $ticket_active ?> >Enabled</option>
            <option value="2" <?= $ticket_passive ?>>Disabled</option>
          </select>
        </div>
<div class="form-group">
          <label class="control-label">Max Pending Tickets per user</label>
          <select class="form-control" name="tickets_per_user">
            <option value="1" <?= $settings["tickets_per_user"] == 1 ? "selected" : null; ?> >1</option>
            <option value="2" <?= $settings["tickets_per_user"] == 2 ? "selected" : null; ?>>2</option>
<option value="3" <?= $settings["tickets_per_user"] == 3 ? "selected" : null; ?>>3</option>
<option value="4" <?= $settings["tickets_per_user"] == 4 ? "selected" : null; ?> >4</option>
            <option value="5" <?= $settings["tickets_per_user"] == 5 ? "selected" : null; ?>>5</option>
<option value="6" <?= $settings["tickets_per_user"] == 6 ? "selected" : null; ?>>6</option>
<option value="7" <?= $settings["tickets_per_user"] == 7 ? "selected" : null; ?> >7</option>
            <option value="8" <?= $settings["tickets_per_user"] == 8 ? "selected" : null; ?>>8</option>
<option value="9" <?= $settings["tickets_per_user"] == 9 ? "selected" : null; ?>>9</option>
<option value="10" <?= $settings["tickets_per_user"] == 10 ? "selected" : null; ?> >10</option>
            <option value="9999999999" <?= $settings["tickets_per_user"] == 9999999999 ? "selected" : null; ?>>Unlimited</option>

          </select>
        </div>
<hr>
        <div class="form-group">
            <?php 
            if($settings["register_page"] == "2"){
                $reg_active = "selected";
            }else{
                $reg_passive = "selected";
            } ?>
<div class="form-group field-editgeneralform-skype_field required" >
          <label class="control-label" for="editgeneralform-registration_page">Signup page <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Allows Users to register</span></div></label>

          <select class="form-control"  name="registration_page">
            <option value="2" <?= $reg_active ?> >Enabled</option>
            <option value="1" <?= $reg_passive ?>>Disabled</option>
          </select>
        </div>
<div class="form-group field-editgeneralform-skype_field required">
<label class="control-label" for="editgeneralform-skype_field">Name fields <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Name field on the Signup page</span></div></label>
          <select class="form-control" name="name_fileds">
            <option value="1" <?= $settings["name_fileds"] == 1 ? "selected" : null; ?> >Enabled</option>
            <option value="2" <?= $settings["name_fileds"] == 2 ? "selected" : null; ?>>Disabled</option>
          </select>
          </div>
<div class="form-group field-editgeneralform-skype_field required">
<label class="control-label" for="editgeneralform-skype_field">Skype fields <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Skype field on the Signup page</span></div></label>
          <select class="form-control" name="skype_feilds">
            <option value="1" <?= $settings["skype_feilds"] == 1 ? "selected" : null; ?> >Enabled</option>
            <option value="2" <?= $settings["skype_feilds"] == 2 ? "selected" : null; ?>>Disabled</option>
          </select>
          </div>
<div class="form-group field-editgeneralform-skype_field required">
<label class="control-label" for="editgeneralform-skype_field">Email Confirmation <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">(Enables mandatory email confirmation for the user after signing up)</span></div> </label>
          <select class="form-control" name="email_confirmation">
            <option value="1" <?= $settings["email_confirmation"] == 1 ? "selected" : null; ?> >Enabled</option>
            <option value="2" <?= $settings["email_confirmation"] == 2 ? "selected" : null; ?>>Disabled</option>
          </select>
          </div>
<div class="form-group">
          <label for="" class="control-label">Resend link max<h6>(Recommended 2)</h6></label>
          <input type="text" class="form-control" name="resend_max" value="<?=$settings["resend_max"]?>">
        </div>
        <div class="form-group">
            <?php 
            if($settings["service_list"] == "2"){
                $servlist_active = "selected";
            }else{
                $servlist_passive = "selected";
            } ?>
          <label class="control-label">Service List</label>
          <select class="form-control" name="service_list">
            <option value="2" <?= $servlist_active ?> >Active for everyone</option>
            <option value="1" <?= $servlist_passive ?>>Active for only users</option>
          </select>
        </div>

                  <hr>
      
        <div class="form-group">
          <label class="control-label">Header codes</label>
          <textarea class="form-control" rows="7" name="custom_header" placeholder='<style type="text/css">...</style>'><?=$settings["custom_header"]?></textarea>
        </div>
        <div class="form-group">
          <label>Footer codes</label>
          <textarea class="form-control" rows="7" name="custom_footer" placeholder='<script>...</script>'><?=$settings["custom_footer"]?></textarea>
        </div>
		<hr>
                    
        <button type="submit" class="btn btn-primary">Update Settings</button>
      </form>
    </div>
  </div>
</div>

<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
 <div class="modal-dialog modal-dialog-center" role="document">
   <div class="modal-content">
     <div class="modal-body text-center">
       <h4>Are you sure?</h4>
       <div align="center">
         <a class="btn btn-primary" href="" id="confirmYes">Yes</a>
         <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
       </div>
     </div>
   </div>
 </div>
