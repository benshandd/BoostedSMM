<?php

  if( !route(2) ):
    $route[2]   = "general";
  endif;

  if( $_SESSION["client"]["data"] ):
    $data = $_SESSION["client"]["data"];
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    unset($_SESSION["client"]);
  endif;


  $menuList = ["General Settings"=>"general","Providers"=>"providers","Payments"=>"payment-methods",  "Modules"=>"modules","Bonuses"=>"payment-bonuses","Currency"=>"currency","Notification settings"=>"alert"];

  if( !array_search(route(2),$menuList) ):
    header("Location:".site_url("admin/settings"));
  elseif( route(2) == "general" ):
    $access = $admin["access"]["general_settings"];
      if( $access ):
        if( $_POST ):
         foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          if ( $_FILES["logo"] && ( $_FILES["logo"]["type"] == "image/jpeg" || $_FILES["logo"]["type"] == "image/jpg" || $_FILES["logo"]["type"] == "image/png" || $_FILES["logo"]["type"] == "image/gif"  ) ):
            $logo_name      = $_FILES["logo"]["name"];
            $uzanti         = substr($logo_name,-4,4);
            $logo_newname   = "public/images/".md5(rand(10,999)).".png";
            $upload_logo    = move_uploaded_file($_FILES["logo"]["tmp_name"],$logo_newname);
          elseif( $settings["site_logo"] != "" ):
            $logo_newname   = $settings["site_logo"];
          else:
            $logo_newname   = "";
          endif;
          if ( $_FILES["favicon"] && ( $_FILES["favicon"]["type"] == "image/jpeg" || $_FILES["favicon"]["type"] == "image/jpg" || $_FILES["favicon"]["type"] == "image/png" || $_FILES["favicon"]["type"] == "image/gif"  ) ):
            $favicon_name   = $_FILES["favicon"]["name"];
            $uzanti         = substr($logo_name,-4,4);
            $fv_newname     = "public/images/".sha1(rand(10,999)).".png";
            $upload_logo    = move_uploaded_file($_FILES["favicon"]["tmp_name"],$fv_newname);
          elseif( $settings["favicon"] != "" ):
            $fv_newname     = $settings["favicon"];
          else:
            $fv_newname     = "";
          endif;
          if( empty($name) ):
            $errorText  = "Panel Name cannot be blank";
            $error      = 1;
          else:
            $update = $conn->prepare("UPDATE settings SET 
			site_maintenance=:site_maintenance,
			resetpass_page=:resetpass_page,
skype_feilds=:skype_feilds,
name_fileds=:name_fileds,
snow_effect=:snow_effect,
			snow_colour=:snow_colour,
			resetpass_sms=:resetpass_sms,
			resetpass_email=:resetpass_email,
			site_name=:name,
			site_logo=:logo,
email_confirmation=:email_confirmation,
			resend_max=:resend_max, 
			favicon=:fv,
			dolar_charge=:dolar, 
			euro_charge=:euro, 
			ticket_system=:ticket_system, 
			register_page=:registration_page, 
			service_list=:service_list, 
			custom_header=:custom_header, 
			custom_footer=:custom_footer,
			bronz_statu=:bronz_statu,
			silver_statu=:silver_statu,
			gold_statu=:gold_statu,
			bayi_statu=:bayi_statu WHERE id=:id ");
            $update->execute(array(
                "id" => 1,
                "site_maintenance" => $site_maintenance,
                "resetpass_page" => $resetpass, 
"snow_effect" => $snow_effect,
  "snow_colour" => $snow_colour, 
                "resetpass_sms" => $resetsms,
                "resetpass_email" => $resetmail,
                "name" => $name,
                "logo" => $logo_newname,
                "fv" => $fv_newname,
"resend_max" => $resend_max,
               "email_confirmation" => $email_confirmation, 
"name_fileds" => $name_fileds,
                "skype_feilds" => $skype_feilds,
                "dolar" => $_POST['dolar'],
                "euro" => $_POST['euro'],
                "ticket_system" => $ticket_system,
                "registration_page" => $registration_page,
                "service_list" => $service_list,    
                "custom_footer" => $custom_footer,
                "custom_header" => $custom_header,
                "bronz_statu" => $bronz_statu,
                "silver_statu" => $silver_statu,
                "gold_statu" => $gold_statu,
                "bayi_statu" => $bayi_statu
               )) ;
$update = $conn->prepare("UPDATE General_options SET currency_format=:format WHERE id=:id ");
          $update->execute(array("format"=> $currency_format,"id"=>1));
                $referrer = site_url("admin/settings/general");
                $icon = "success";
                $error = 1;
                $errorText = "Success";
                
                header("Location:".site_url("admin/settings/general"));
                echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);

              if( $update ):
                header("Location:" . site_url("admin/settings/general"));
                    $_SESSION["client"]["data"]["success"] = 1;
                    $_SESSION["client"]["data"]["successText"] = "Successful";
              else:
                $errorText  = "Failed";
                $error      = 1;
				
              endif;
				
				
          endif;
        endif;
        if( route(3) == "delete-logo" ):
          $update = $conn->prepare("UPDATE settings SET site_logo=:type WHERE id=:id ");
          $update->execute(array("type"=>"","id"=>1));
          if ( $update ):
            unlink($settings["site_logo"]);
          endif;
          header("Location:".site_url("admin/settings/general"));
        elseif( route(3) == "delete-favicon" ):
          $update = $conn->prepare("UPDATE settings SET favicon=:type WHERE id=:id ");
          $update->execute(array("type"=>"","id"=>1));
          if ( $update ):
            unlink($settings["site_favicon"]);
          endif;
          header("Location:".site_url("admin/settings/general"));
        endif;
      endif;

elseif( route(2) == "modules" ):
        $access = 1;
        if( $access ):
          if( $_POST ):
            foreach ($_POST as $key => $value) {
              $$key = $value;
            }
            $conn->beginTransaction();
            $update = $conn->prepare("UPDATE settings SET referral_commision=:referral_commision,
childpanel_selling=:selling,
childpanel_price=:price,
promotion=:promotion,
freebalance=:freebalance,
freeamount=:freeamount,
        	referral_payout=:referral_payout,
          referral_status=:referral_status WHERE id=:id ");
            $update = $update->execute(array("id"=>1,"referral_commision" => $commision,
                  "referral_payout" => $minimum,
"promotion" => $promotion,
"selling" => $selling,
"freeamount" => $freeamount,
"freebalance" => $freebalance,
"price" => $price,
                  "referral_status" => $affiliates_status,  ));

$update = $conn->prepare("UPDATE General_options SET updates_show=:updates_show,coupon_status=:coupon_status,massorder=:massorder WHERE id=:id ");
            $update = $update->execute(array("id"=>1,"updates_show"=>$updates_show,"coupon_status"=>$coupon_status,"massorder"=>$massorder));

//update menu updates
$update = $conn->prepare("UPDATE menus SET type=:updates_show WHERE slug=:id ");
            $update = $update->execute(array("id"=> "/updates" ,"updates_show"=>$updates_show ));


//update menu Affiliates
$update = $conn->prepare("UPDATE menus SET type=:updates_show WHERE slug=:id ");
            $update = $update->execute(array("id"=> "/refer" ,"updates_show"=>$affiliates_status ));


//update menu Child
$update = $conn->prepare("UPDATE menus SET type=:updates_show WHERE slug=:id ");
            $update = $update->execute(array("id"=> "/child-panels" ,"updates_show"=>$selling ));

//update menu Promotion
$update = $conn->prepare("UPDATE menus SET type=:updates_show WHERE slug=:id ");
            $update = $update->execute(array("id"=> "/earn" ,"updates_show"=>$promotion ));

//update menu Mass order
$update = $conn->prepare("UPDATE menus SET type=:updates_show WHERE slug=:id ");
            $update = $update->execute(array("id"=> "/massorder" ,"updates_show"=>$massorder ));


            if( $update ):
              $conn->commit();
              header("Location:".site_url("admin/settings/modules"));
              $_SESSION["client"]["data"]["success"]    = 1;
              $_SESSION["client"]["data"]["successText"]= "Success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
            endif;
          endif;
        endif;
  elseif( route(2) == "payment-methods" ):
    $access = $admin["access"]["payments_settings"];
      if( $access ):
        if( route(3) == "edit" && $_POST  ):
          $id = route(4);
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          if( !countRow(["table"=>"payment_methods","where"=>["method_get"=>$id]]) ):
            $error    = 1;
            $icon     = "error";
            $errorText= "Lütfen geçerli ödeme methodu seçin";
          else:
            $update = $conn->prepare("UPDATE payment_methods SET method_min=:min, method_max=:max, method_type=:type, method_extras=:extras WHERE method_get=:id ");
            $update->execute(array("id"=>$id,"min"=>$min,"max"=>$max,"type"=>$method_type,"extras"=>json_encode($_POST) ));
              if( $update ):
                $error    = 1;
                $icon     = "success";
                $errorText= "Success";
              else:
                $error    = 1;
                $icon     = "error";
                $errorText= "Failed";
              endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon]);
          exit();
        elseif( route(3) == "type" ):
          $id     = $_GET["id"];
          $type   = $_GET["type"]; if( $type == "off" ): $type = 1; elseif( $type == "on" ): $type = 2; endif;
          $update = $conn->prepare("UPDATE payment_methods SET method_type=:type WHERE id=:id ");
          $update->execute(array("id"=>$id,"type"=>$type));
            if( $update ):
              echo "1";
            else:
              echo "0";
            endif;
          exit();
        endif;
        $methodList = $conn->prepare("SELECT * FROM payment_methods WHERE nouse=:use ORDER BY method_line ");
        $methodList->execute(array("use"=>"2" ));
        $methodList = $methodList->fetchAll(PDO::FETCH_ASSOC);
      endif;
    if( route(3) ): header("Location:".site_url("admin/settings/payment-methods")); endif;






elseif( route(2) == "integrations" ):
    $access = $admin["access"]["payments_settings"];
      if( $access ):
        if( route(3) == "edit" && $_POST  ):
          $id = route(4);
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          if( !countRow(["table"=>"integrations","where"=>["method_get"=>$id]]) ):
            $error    = 1;
            $icon     = "error";
            $errorText= "Lütfen geçerli ödeme methodu seçin";
          else:
            $update = $conn->prepare("UPDATE integrations SET method_type=:type, method_extras=:extras WHERE method_get=:id ");
            $update->execute(array("id"=>$id,"type"=>$method_type,"extras"=>json_encode($_POST) ));
              if( $update ):
                $error    = 1;
                $icon     = "success";
                $errorText= "Success";
              else:
                $error    = 1;
                $icon     = "error";
                $errorText= "Failed";
              endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon]);
          exit();
        elseif( route(3) == "type" ):
          $id     = $_GET["id"];
          $type   = $_GET["type"]; if( $type == "off" ): $type = 1; elseif( $type == "on" ): $type = 2; endif;
          $update = $conn->prepare("UPDATE integrations SET method_type=:type WHERE id=:id ");
          $update->execute(array("id"=>$id,"type"=>$type));
            if( $update ):
              echo "1";
            else:
              echo "0";
            endif;
          exit();
        endif;
        $methodList = $conn->prepare("SELECT * FROM integrations ORDER BY method_line ");
        $methodList->execute(array());
        $methodList = $methodList->fetchAll(PDO::FETCH_ASSOC);
      endif;
    if( route(3) ): header("Location:".site_url("admin/settings/integrations")); endif;





  

  elseif( route(2) == "payment-bonuses" ):
    $access = $admin["access"]["payments_bonus"];
      if( $access ):
        if( route(3) == "new" && $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          if( empty($method_type) ):
            $error    = 1;
            $errorText= "Method boş olamaz";
            $icon     = "error";
          elseif( empty($amount) ):
            $error    = 1;
            $errorText= "Bonus tutarı boş olamaz";
            $icon     = "error";
          elseif( empty($from) ):
            $error    = 1;
            $errorText= "İtibaren olamaz";
            $icon     = "error";
          else:
            $conn->beginTransaction();
            $insert = $conn->prepare("INSERT INTO payments_bonus SET bonus_method=:method, bonus_from=:from, bonus_amount=:amount, bonus_type=:type ");
            $insert = $insert->execute(array("method"=>$method_type,"from"=>$from,"amount"=>$amount,"type"=>2 ));
            if( $insert ):
              $conn->commit();
              $referrer = site_url("admin/settings/payment-bonuses");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
        elseif( route(3) == "edit" && $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          $id = route(4);
          if( empty($method_type) ):
            $error    = 1;
            $errorText= "Method boş olamaz";
            $icon     = "error";
          elseif( empty($amount) ):
            $error    = 1;
            $errorText= "Bonus tutarı boş olamaz";
            $icon     = "error";
          elseif( empty($from) ):
            $error    = 1;
            $errorText= "İtibaren olamaz";
            $icon     = "error";
          else:
            $conn->beginTransaction();
            $update = $conn->prepare("UPDATE payments_bonus SET bonus_method=:method, bonus_from=:from, bonus_amount=:amount WHERE bonus_id=:id ");
            $update = $update->execute(array("method"=>$method_type,"from"=>$from,"amount"=>$amount,"id"=>$id ));
            if( $update ):
              $conn->commit();
              $referrer = site_url("admin/settings/payment-bonuses");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
        elseif( route(3) == "delete" ):
          $id = route(4);
            if( !countRow(["table"=>"payments_bonus","where"=>["bonus_id"=>$id]]) ):
              $error    = 1;
              $icon     = "error";
              $errorText= "Lütfen geçerli ödeme bonusu seçin";
            else:
              $delete = $conn->prepare("DELETE FROM payments_bonus WHERE bonus_id=:id ");
              $delete->execute(array("id"=>$id));
                if( $delete ):
                  $error    = 1;
                  $icon     = "success";
                  $errorText= "Success";
                  $referrer = site_url("admin/settings/payment-bonuses");
                else:
                  $error    = 1;
                  $icon     = "error";
                  $errorText= "Failed";
                endif;
            endif;
            echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>0]);
            exit();
        elseif( !route(3) ):
          $bonusList = $conn->prepare("SELECT * FROM payments_bonus INNER JOIN payment_methods WHERE payment_methods.id = payments_bonus.bonus_method ORDER BY payment_methods.id DESC ");
          $bonusList->execute(array());
          $bonusList = $bonusList->fetchAll(PDO::FETCH_ASSOC);
        else:
          header("Location:".site_url("admin/settings/payment-bonuses"));
        endif;
      endif;

  elseif( route(2) == "providers" ):
    $access = $admin["access"]["providers"];
      if( $access ):
        if( route(3) == "new" && $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }

$smmapi   = new SMMApi();
$order    = $smmapi->action(array('action'=>''), $url );
$error  = $order->error;


          if( empty($url) ):
            $error    = 1;
            $errorText= "Api url cannot be blank";
            $icon     = "error";
          elseif( empty($error) ):
            $error    = 1;
            $errorText= "Wrong url or Api not supporting";
            $icon     = "error";
          else:
$order = explode("/", $url);
                                $name   = $order[2]; 
            $conn->beginTransaction();
            $insert = $conn->prepare("INSERT INTO service_api SET api_name=:name, api_alert=:api_alert, api_key=:key, api_url=:url, api_limit=:limit, currency=:currency, api_type=:type ");
            $insert = $insert->execute(array(  "name"=>$name,"key"=>"","url"=>$url,"limit"=>0,"currency"=>"USD" ,"type"=>1,"api_alert"=>1));

            if( $insert ):
              $conn->commit();
              $referrer = site_url("admin/settings/providers");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
        elseif( route(3) == "edit" && $_POST  ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          $id = route(4);


          if( empty($apikey) ):
            $error    = 1;
            $errorText= "API Key cannot be empty";
            $icon     = "error";
          else:



$theme = $conn->prepare("SELECT * FROM service_api WHERE id=:name");
          $theme->execute(array("name"=>$id));
          $theme = $theme->fetch(PDO::FETCH_ASSOC);

$status = "1"; 
if($theme["status"] == 2 ):
$status = "2";
endif;
if($theme["status"] == 2 ):
$api_url = $theme["api_url"];

$smmapi   = new SMMApi();
$order    = $smmapi->action(array('action'=>'balance','key'=>$apikey),$api_url);
$balance  = $order->error;


if(!empty($balance) ):
$status = "2";
else:
$status = "1"; 
endif;
endif;

            $conn->beginTransaction();




            $update = $conn->prepare("UPDATE service_api SET api_key=:key , status=:status WHERE id=:id ");
            $update = $update->execute(array("key"=>$apikey,"id"=>$id,"status"=>$status   ));
            if( $update ):
              $conn->commit();
              $referrer = site_url("admin/settings/providers");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
        elseif( !route(3) ):
          $providersList = $conn->prepare("SELECT * FROM service_api ");
          $providersList->execute(array());
          $providersList = $providersList->fetchAll(PDO::FETCH_ASSOC);

		elseif( route(3) == "delete" ):
if($panel["panel_type"] != "Child"):
          $id = route(4);
            if( !countRow(["table"=>"service_api","where"=>["id"=>$id]]) ):
              $error    = 1;
              $icon     = "error";
              $errorText= "Lütfen geçerli ödeme bonusu seçin";
            else:
              $delete = $conn->prepare("DELETE FROM service_api WHERE id=:id ");
              $delete->execute(array("id"=>$id));
                if( $delete ):
           $error    = 1;
                  $errorText= "Success";
              $icon     = "success";
          header("Location:".site_url("admin/settings/providers"));
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
                endif;
            endif;
else:
          header("Location:".site_url("admin/settings/providers"));
        endif;
else:
          header("Location:".site_url("admin/settings/providers"));
        endif;
      endif;
      if( route(5) ): header("Location:".site_url("admin/settings/providers")); endif;  
		 
  elseif( route(2) == "alert" ):
    $access = $admin["access"]["alert_settings"];
      if( $access ):
        if( $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          $conn->beginTransaction();
          $update = $conn->prepare("UPDATE settings SET alert_apibalance=:alert_apibalance, alert_serviceapialert=:alert_serviceapialert, admin_mail=:mail, alert_newticket=:alert_newticket, alert_newmanuelservice=:alert_newmanuelservice,alert_newmessage=:newmessage, alert_welcomemail=:welcomemail, alert_apimail=:apimail, alert_orderfail=:orderfail WHERE id=:id ");
          $update = $update->execute(array("id"=>1,"alert_apibalance"=>$alert_apibalance,"alert_serviceapialert"=>$serviceapialert,"mail"=>$admin_mail,"newmessage"=>$newmessage,"alert_newticket"=>$alert_newticket,"alert_newmanuelservice"=>$alert_newmanuelservice,"welcomemail"=>$welcomemail,"apimail"=>$apimail,"orderfail"=>$orderfail ));
          if( $update ):
            $conn->commit();
            header("Location:".site_url("admin/settings/alert"));
            $_SESSION["client"]["data"]["success"]    = 1;
            $_SESSION["client"]["data"]["successText"]= "Success";
          else:
            $conn->rollBack();
            $error    = 1;
            $errorText= "Failed";
          endif;
        endif;
      endif;
    if( route(3) ): header("Location:".site_url("admin/settings/alert")); endif;

    
elseif( route(2) == "currency" ):
    $access = $admin["access"]["child-panels"];
if( $access ):
$currencies = $conn->prepare("SELECT * FROM currency WHERE nouse=:code");
          $currencies->execute(array("code"=> "2" ));
          $currencies = $currencies->fetchAll(PDO::FETCH_ASSOC);


      
        if( route(3) == "add" && $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          if( empty($name) ):
            $error    = 1;
            $errorText= "Currency name cannot be empty";
            $icon     = "error";
          elseif( empty($symbol) ):
            $error    = 1;
            $errorText= "Currency symbol cannot be empty";
            $icon     = "error";
          elseif( empty($value) ):
            $error    = 1;
            $errorText= "Currency exchange rate cannot be empty";
            $icon     = "error";
          else:
            $conn->beginTransaction();
            $insert = $conn->prepare("INSERT INTO currency SET name=:name, value=:value, symbol=:symbol  ");
            $insert = $insert->execute(array("name"=>$name,"value"=>$value,"symbol"=>$symbol  ));
            if( $insert ):
              $conn->commit();
              $referrer = site_url("admin/settings/currency");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
        elseif( route(3) == "edit" && $_POST  ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          $id = route(4);
          if( empty($name) ):
            $error    = 1;
            $errorText= "Currency name cannot be empty";
            $icon     = "error";
          elseif( empty($symbol) ):
            $error    = 1;
            $errorText= "Currency symbol cannot be empty";
            $icon     = "error";
          elseif( empty($value) ):
            $error    = 1;
            $errorText= "Currency exchange rate cannot be empty";
            $icon     = "error";
          else:
            $conn->beginTransaction();
            $update = $conn->prepare("UPDATE currency SET name=:name, status=:status, value=:value, symbol=:symbol WHERE id=:id ");
            $update = $update->execute(array("name"=>$name,"value"=>$currencyvalue,"status"=>$status,"symbol"=>$symbol,"id"=>$id));
            if( $update ):
              $conn->commit();
              $referrer = site_url("admin/settings/currency");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
                elseif( route(3) == "delete" ):
          $id = route(4);
if( $id == 1):
            $error    = 1;
                  $icon     = "error";
                  $errorText= "Failed";
else:
              $delete = $conn->prepare("DELETE FROM currency WHERE id=:id ");
              $delete->execute(array("id"=>$id));
                if( $delete ):
                  $error    = 1;
                  $icon     = "success";
                  $errorText= "Success";
                  $referrer = site_url("admin/settings/currency");
                else:
                  $error    = 1;
                  $icon     = "error";
                  $errorText= "Failed";
              endif;  
endif;  
     endif;  
endif;  
elseif( route(2) == "integrations" ):
    $access = $admin["access"]["payments_settings"];
      if( $access ):
        if( route(3) == "edit" && $_POST  ):
          $id = route(4);
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          if( !countRow(["table"=>"integrations","where"=>["method_get"=>$id]]) ):
            $error    = 1;
            $icon     = "error";
            $errorText= "Lütfen geçerli ödeme methodu seçin";
          else:
            $update = $conn->prepare("UPDATE integrations SET method_type=:type, method_extras=:extras WHERE method_get=:id ");
            $update->execute(array("id"=>$id,"type"=>$method_type,"extras"=>json_encode($_POST) ));
              if( $update ):
                $error    = 1;
                $icon     = "success";
                $errorText= "Success";
              else:
                $error    = 1;
                $icon     = "error";
                $errorText= "Failed";
              endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon]);
          exit();
        elseif( route(3) == "type" ):
          $id     = $_GET["id"];
          $type   = $_GET["type"]; if( $type == "off" ): $type = 1; elseif( $type == "on" ): $type = 2; endif;
          $update = $conn->prepare("UPDATE integrations SET method_type=:type WHERE id=:id ");
          $update->execute(array("id"=>$id,"type"=>$type));
            if( $update ):
              echo "1";
            else:
              echo "0";
            endif;
          exit();
        endif;
        $methodList = $conn->prepare("SELECT * FROM integrations ORDER BY method_line ");
        $methodList->execute(array());
        $methodList = $methodList->fetchAll(PDO::FETCH_ASSOC);
      endif;
    if( route(3) ): header("Location:".site_url("admin/settings/integrations")); endif;



    
  endif;

  require admin_view('settings');
