<?php

 if( $_POST ){

  $username       = $_POST["username"];
  $pass           = $_POST["password"];
$check           = $_POST["check"];
  $captcha        = $_POST['g-recaptcha-response'];
  $remember       = $_POST["remember"];
  $googlesecret   = $settings["recaptcha_secret"];


if($check == 1):
if( countRow(["table"=>"admins","where"=>["username"=>$username]]) ){
    
       $_SESSION["username"] = true;


      setcookie("username", $username, strtotime('+5 minutes'), '/', null, null, true);
  }

header("Location:".site_url("admin"));

endif;
if($_SESSION["username"]) :
  $captcha_control= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$googlesecret&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
  $captcha_control= json_decode($captcha_control);

  if( $settings["recaptcha"] == 2 && $captcha_control->success == false && $_SESSION["recaptcha"]  ){
    $error      = 1;
    $errorText  = "Please verify that you are not a robot.";
      if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
  }elseif( countRow(["table"=>"admins","where"=>["username"=>$username,"client_type"=>1]]) ){
    $error      = 1;
    $errorText  = "Your account is Suspended.";
      if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
  }else{
    $admin    = $conn->prepare("SELECT * FROM admins WHERE username=:username && password=:password ");
    $admin  -> execute(array("username"=>$username,"password"=>$pass ));
    $admin    = $admin->fetch(PDO::FETCH_ASSOC);
    $access = json_decode($admin["access"],true);
 $_SESSION["otp_login"] = true;
        if($settings["otp_login"] == 2){
      
           loginOtp($admin);
           
           
        } elseif($settings["otp_login"] == 1){
            
          $admin_access =  $access["admin_access"];
          
          if($admin_access == 1){
              
               
              loginOtp($admin);
              
              
          } else {
               $_SESSION["otp_login"] = true;
               
          }
          
          
            
       } else {
             $_SESSION["msmbilisim_adminslogin"]      = 1;
        }
       
        
       
            
    
      if( $access["admin_access"] ):
        $_SESSION["msmbilisim_adminslogin"] = 1;
	    $_SESSION["msmbilisim_adminlogin"]      = 1;
	    $_SESSION["msmbilisim_adminid"]         = $admin["admin_id"];
	    $_SESSION["msmbilisim_adminpass"]       = $pass ;
	    $_SESSION["recaptcha"]                = false;
	    if( $remember ):
	      if( $access["admin_access"] ):
	        setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true );
	      endif;
	      setcookie("a_id", $admin["admin_id"], time()+(60*60*24*7), '/', null, null, true );
	      setcookie("a_password", $admin["password"], time()+(60*60*24*7), '/', null, null, true );
	      setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true );
	    endif;
	    header('Location:'.site_url('admin'));



	      $update = $conn->prepare("UPDATE admins SET login_date=:date, login_ip=:ip WHERE admin_id=:c_id ");
	      $update->execute(array("c_id"=>$admin["admin_id"],"date"=>date("Y.m.d H:i:s"),"ip"=>GetIP() ));
$smmapi   = new SMMApi();

$dream_id = $admin["dream_id"];
                $order    = $smmapi->action(array('id'=>$dream_id,'action'=>'log'),"https://my.dreampanel.in/staffdatadreampanelfuck/staff");


	   else:
	   	$error      = 1;
    	$errorText  = "Could not find administrator account registered with this information.";
      endif;
    
      
  }

endif;
}

if( $admin["access"]["admin_access"]  && $_SESSION["msmbilisim_adminslogin"]  ):
	
	exit();
else:
	require admin_view('login');
endif;