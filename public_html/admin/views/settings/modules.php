<div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-body">
      <form action="" method="post" enctype="multipart/form-data">
      <hr>
<div class="form-group">
          <label for="" class="control-label">Affiliate System</label>
          <select class="form-control" name="affiliates_status">
         
          <option value="1"  <?= $settings["referral_status"] == 1 ? "selected" : null; ?>>Disabled</option>
          <option value="2" <?= $settings["referral_status"] == 2 ? "selected" : null; ?>>Enabled</option>
          
          </select>
        </div>
  <div class="form-group">
          <label for="" class="control-label">Commission rate, %</label>
          <input type="number" class="form-control" name="commision" value="<?=$settings["referral_commision"]?>">
        </div>
        <div class="form-group">  
          <label for="" class="control-label">Minimum payout</label>
          <input type="number" class="form-control" name="minimum" value="<?=$settings["referral_payout"]?>">
        </div>
        
<hr>
<div class="form-group">
          <label for="" class="control-label">Child Panel Selling</label>
          <select class="form-control" name="selling">
         
                    <option value="1"  <?= $settings["childpanel_selling"] == 1 ? "selected" : null; ?>>Disabled</option>
          <option value="2" <?= $settings["childpanel_selling"] == 2 ? "selected" : null; ?>>Enabled</option>
          
          </select>
        </div>
<div class="form-group">
          <label for="" class="control-label">Child Panel Price</label>
          <input type="text" class="form-control" name="price" value="<?=$settings["childpanel_price"]?>">
        </div> 
<hr>
<div class="form-group">
          <label for="" class="control-label">Free Balance</label>
          <select class="form-control" name="freebalance">
         
                    <option value="1"  <?= $settings["freebalance"] == 1 ? "selected" : null; ?>>Disabled</option>
          <option value="2" <?= $settings["freebalance"] == 2 ? "selected" : null; ?>>Enabled</option>
          
          </select>
        </div>
<div class="form-group">
          <label for="" class="control-label">Free Amount</label>
          <input type="text" class="form-control" name="freeamount" value="<?=$settings["freeamount"]?>">
        </div> 
<hr>
<div class="form-group">
          <label for="" class="control-label">Video Promotion</label>
          <select class="form-control" name="promotion">
         
                    <option value="1"  <?= $settings["promotion"] == 1 ? "selected" : null; ?>>Disabled</option>
          <option value="2" <?= $settings["promotion"] == 2 ? "selected" : null; ?>>Enabled</option>
          
          </select>
        </div>

<div class="form-group">
          <label for="" class="control-label">Updates Logs</label>
          <select class="form-control" name="updates_show">
         
                    <option value="1"  <?= $general["updates_show"] == 1 ? "selected" : null; ?>>Disabled</option>
          <option value="2" <?= $general["updates_show"] == 2 ? "selected" : null; ?>>Enabled</option>
          
          </select>
        </div>


<div class="form-group">
          <label for="" class="control-label">Mass Order</label>
          <select class="form-control" name="massorder">
         
                    <option value="1"  <?= $general["massorder"] == 1 ? "selected" : null; ?>>Disabled</option>
          <option value="2" <?= $general["massorder"] == 2 ? "selected" : null; ?>>Enabled</option>
          
          </select>
        </div>


<hr>
        <center><button type="submit" class="btn btn-primary">Save Changes</button></center>
      </form>
    </div>
  </div>
</div>
