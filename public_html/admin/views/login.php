<div id="displayDivId" style="display: none;">
    <?php include 'header.php'; ?>
</div>
<br><br><br><br>

<div class="container">
    <div class="container container-fluid" role="main">
        <div class="col-sm-offset-4 col-sm-4 m-t">
<?php if (!$_SESSION["username"]) : ?>

            <form id="yw0" action="" method="post">
<input name="check" value="1" type="hidden" />

           <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input class="form-control" name="username" id="AdminUsers_login"  type="text" maxlength="300" /> </div>


                



                <?php if ($_SESSION["recaptcha"]) : ?>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo $settings["recaptcha_key"] ?>"></div>
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-default">Login</button>
            </form>
        </div>
    </div>

</form>
<?php endif; ?>

<?php if ($_SESSION["username"]) : ?>
           

     


<form id="yw0" action="" method="post">


     
           <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input class="form-control" name="username" id="AdminUsers_login" type="text" value="<?php echo $_COOKIE['username'] ?>" maxlength="300" /> </div>


                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input class="form-control" name="password" id="AdminUsers_passwd" type="password" maxlength="300" /> </div>




                <?php if ($_SESSION["recaptcha"]) : ?>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo $settings["recaptcha_key"] ?>"></div>
                    </div>
                <?php endif; ?>
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="remember" value="1">

                         <input type="checkbox" name="AdminUsers[remember]" id="remember" value="1"> Remember me 
                    </label>
                </div>
                <button type="submit" class="btn btn-default">Login</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>


<script src="//www.google.com/recaptcha/api.js?hl=en"></script>

<?php include 'footer.php'; ?>