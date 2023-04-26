<?php include 'header.php'; ?>
<div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-body">
      <form action="admin/account" method="post" enctype="multipart/form-data">
     
          <div class="form-group">
            <label for="charge" class="control-label">Current Password</label>
            <input type="password" class="form-control" value="" name="current_password">
          </div>

          <div class="form-group">
            <label for="charge" class="control-label">New</label>
            <input type="password" class="form-control" value="" name="password">
          </div>

          <div class="form-group">
            <label for="charge" class="control-label">Password again</label>
            <input type="password" class="form-control" value="" name="confirm_password">
          </div>
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
      </div><br>
</form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="theme/assets/js/datatable/payments.js"></script>