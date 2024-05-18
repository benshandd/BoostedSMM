  <?php

require __DIR__.'/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$mail = new PHPMailer;
require __DIR__.'/app/init.php';

$first_route  = explode('?',$_SERVER["REQUEST_URI"]);
$gets         = explode('&',$first_route[1]);
  foreach ($gets as $get) {
    $get = explode('=',$get);
    $_GET[$get[0]]  = $get[1];
  }
$routes       = array_filter( explode('/',$first_route[0]) );

  if( SUBFOLDER === true ){
    array_shift($routes);
    $route = $routes;
  }else {
    foreach ($routes as $index => $value):
      $route[$index-1] = $value;
    endforeach;
  }
$panel_orders = countRow(["table"=>"orders"]);

  if( $_GET["lang"] && $user['auth'] != 1 ):
    include 'app/language/list.php';
    if( countRow(["table"=>"languages","where"=>["language_type"=>2,"language_code"=>$_GET["lang"]]]) ):
      unset($_SESSION["lang"]);
      $_SESSION["lang"] = $_GET["lang"];
      include 'app/language/'.$_GET["lang"].'.php';
    else:
           $_SESSION["lang"] = $_GET["lang"];
      include 'app/language/'.$_GET["lang"].'.php';
    endif;
    $selectedLang = $_SESSION["lang"];
    header("Location:".site_url());
  else:
    if( $_SESSION["lang"] && $user['auth'] != 1 ):
      $language = $_SESSION["lang"];
    elseif( $user['auth'] != 1 ):
      $language = $conn->prepare("SELECT * FROM languages WHERE default_language=:default ");
      $language->execute(array("default"=>1));
      $language = $language->fetch(PDO::FETCH_ASSOC);
      $language = $language["language_code"];
    else:
      if( getRow(["table"=>"languages","where"=>["language_code"=>$user["lang"]]]) ):
        $language = $user["lang"];
      else:
        $language = $conn->prepare("SELECT * FROM languages WHERE default_language=:default ");
        $language->execute(array("default"=>1));
        $language = $language->fetch(PDO::FETCH_ASSOC);
        $language = $language["language_code"];
      endif;
    endif;
    include 'app/language/'.$language.'.php';
    $selectedLang = $language;
  endif;

  if( !isset($route[0]) && $_SESSION["msmbilisim_userlogin"] == true ){
    $route[0] = "neworder";
    $routeType= 0;
  }elseif( !isset($route[0]) && $_SESSION["msmbilisim_userlogin"] == false ){
    $route[0] = "auth";
    $routeType= 1;
  }elseif( $route[0] == "auth" && $_SESSION["msmbilisim_userlogin"] == false ){
    $routeType= 1;
  }else{
    $routeType= 0;
  }




$pageshh = $_SERVER["REQUEST_URI"];
$pageshh2 = $_SERVER['HTTP_HOST'];

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 

                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  

                $_SERVER['REQUEST_URI']; 

  

$pageurl = $link;
 



  if( !file_exists( controller($route[0]) ) ){
    $route[0] = "404";
  }
  if( route(0) != "frozen" && route(0) != "dreampanelworkall" && $panel["panel_status"] == "Suspended" ): header("Location:".site_url('frozen')); endif;
  if( route(0) == "frozen"  && $panel["panel_status"] == "Active" ): header("Location:".site_url('')); endif;
  if( route(0) != "frozen" && route(0) != "dreampanelworkall" && $panel["panel_status"] == "Frozen" ): header("Location:".site_url('frozen')); endif;
  if( route(0) != "admin" && $settings["site_maintenance"] == 1 ): include 'app/views/maintenance.php';exit(); endif;
  if( $settings["service_list"] == 2 ): $serviceList = 1; endif;

  require controller($route[0]);
if( $settings["snow_effect"] == 1 ){
    $snow_effect = true;
  }
  if( $settings["recaptcha"] == 1 ){
    $captcha = false;
  }elseif( ( $settings["recaptcha"] == 2 && ( route(0) == "signup" || route(0) == "resetpassword" ) ) || $_SESSION["recaptcha"] ){
    $captcha = true;
  }


  if( $settings["resetpass_page"] == 2 ){
    $resetPage = true;
  }
  
if( $settings["register_page"] == 2 ){
    $Signup = true;
  }

  if( $settings["childpanel_selling"] == 2 ){
    $ChildPanel = true;
  }

  if( $settings["referral_status"] == 2 ){
    $affiliatessystem = true;
  }
  if( $settings["promotion"] == 2 ){
    $Promotion = true;
  }
  if( $general["updates_show"] == 2 ){
    $updates = true;
  }
  if( route(0) == "auth" ): $active_menu = route(1); else: $active_menu = route(0); endif;
  if( route(0) != "admin" && route(0) != "ajax_data" ){
    $languages  = $conn->prepare("SELECT * FROM languages WHERE language_type=:type");
    $languages->execute(array("type"=>2));
    $languages  = $languages->fetchAll(PDO::FETCH_ASSOC);
    $languagesL = [];
      foreach ($languages as $language) {
        $l["name"] = $language["language_name"];
        $l["code"] = $language["language_code"];
          if( $_SESSION["lang"] && $language["language_code"] == $_SESSION["lang"] ){
            $l["active"] = 1;
          }elseif( !$_SESSION["lang"] ){
            $l["active"] = $language["default_language"];
          }else{
            $l["active"] = 0;
          }
        array_push($languagesL,$l);
      }

    if( !$templateDir ){
      $templateDir = route($routeType);
    }
      if( $templateDir == "login" || $templateDir == "register" ):
        $contentGet = "auth";
      else:
        $contentGet = $templateDir;
      endif;
    $content  = $conn->prepare("SELECT * FROM pages WHERE page_get=:get ");
    $content->execute(array("get"=>$contentGet));
    $content  = $content->fetch(PDO::FETCH_ASSOC);
$pageactive  = $content["page_status"];
$seo_description  = $content["seo_description"];
	$seo_title  = $content["seo_title"];
	$seo_keywords  = $content["seo_keywords"];
    $content  = $content["page_content"];
	
	if( $pageactive == 1 ){
    $PageText = true;
  }


$blogGet = $route[1]; 

$blog  = $conn->prepare("SELECT * FROM blogs WHERE blog_get=:get ");
    $blog->execute(array("get"=>$blogGet));
    $blog  = $blog->fetch(PDO::FETCH_ASSOC);
    $blogcontent  = $blog["content"];
$blogtitle  = $blog["title"];
	$blogimage  = $blog["image_file"];
	 $getblog = $blog['blog_get'];
 	//popup  notifications
   $sth1 = $conn->prepare("SELECT * FROM notifications_popup WHERE expiry_date >= DATE(now()) AND status=:status ORDER BY id DESC");
   $sth1->execute(array("status"=>1));
   $popupNotif1 = $sth1->fetchAll();
   /*echo count($popupNotif1).'///'.$_SESSION["popCount"].'</br>'; // exit;
   $link = $_SERVER['HTTP_REFERER'].'</br>';
   $link_array = explode('/',$link);
   echo $page = end($link_array);*/
  if(count($popupNotif1)>$_SESSION["popCount"] || $_SESSION["popCount"]==''){
       unset($_SESSION["popSeen"]);
   }



   
 $popupNotif = array();
 if(!$_SESSION["popSeen"]){
   $sth = $conn->prepare("SELECT * FROM notifications_popup WHERE expiry_date >= DATE(now()) AND status=:status ORDER BY id DESC");
   $sth->execute(array("status"=>1));
   $popupNotif = $sth->fetchAll();
   $link = $_SERVER['REQUEST_URI'];
   $link_array = explode('/',$link);
   $page = end($link_array);
   $i = 0;
   
   foreach($popupNotif as $val){
       
       if( in_array($val['id'] ,explode(",",$_SESSION["seen_popup"])) ){
            unset($popupNotif[$i]);
       }elseif(!$val['isAllPage']==1){ 
         if (strpos($val['allPages'], $page)) {
              $val['display'] = true; 
              $_SESSION["popCount"] = count($popupNotif);
         }else{
            $val['display'] = false; 
            unset($popupNotif[$i]);
         }
       }else{
            $val['display'] = true;  
            $_SESSION["popCount"] = count($popupNotif);
       }
       if($val['isAllUser']==1){
           if(!$_SESSION["msmbilisim_userlogin"]){
               unset($popupNotif[$i]);
           }
       }
       //$popupNotif[] = $val;
       
       $i++;
       $comma_string[] = $val['id'];
   }
   $popupNotif['notifIds'] = implode(",", $comma_string);
   $_SESSION["popSeen"] = true; 
   }
 //echo "<pre>"; print_r($popupNotif); echo "</pre>"; exit();
 
 $ref_content  = $conn->prepare("SELECT * FROM referral WHERE referral_code=:referral_code ");
 $ref_content->execute(array("referral_code" => $user['ref_code']));
 $ref_content  = $ref_content->fetchAll();
$blogs  = $conn->prepare("SELECT * FROM blogs WHERE status=:status ");
 $blogs->execute(array("status" => 1 ));
 $blogs  = $blogs->fetchAll();
  
$panel_info = $conn->prepare("SELECT * FROM panel_info WHERE id=:id ");
 $panel_info->execute(array("id" => 1));
 $panel_info  = $panel_info->fetchAll();

$currencies = $conn->prepare("SELECT * FROM currency WHERE status=:status ");
 $currencies->execute(array("status" => 1));
 $currencies  = $currencies->fetchAll();

 $ref_payouts  = $conn->prepare("SELECT * FROM referral WHERE r_p_code=:r_p_code ");
 $ref_payouts->execute(array("r_p_code" => $user['ref_code']));
 $ref_payouts  = $ref_payouts->fetchAll();


if( $user["auth"]) :

$menus  = $conn->prepare("SELECT * FROM menus WHERE visible=:Internal ORDER BY menu_line ASC ");
 $menus->execute(array("Internal" => "Internal" ));
 $menus  = $menus->fetchAll();
$menuslug = $menus["slug"];

else:


$menus  = $conn->prepare("SELECT * FROM menus WHERE visible=:visible ORDER BY menu_line ASC ");
 $menus->execute(array("visible" => "External"));
 $menus  = $menus->fetchAll();
$menuslug = $menus["slug"];
endif;

 $panels = $conn->prepare("SELECT * FROM panels INNER JOIN clients ON clients.client_id=panels.client_id WHERE panels.client_id=:client_id ORDER BY panels.panel_id DESC");
 $panels->execute(array("client_id" => $user["client_id"]));
 $panels = $panels->fetchAll();
 


 $invoices = $conn->prepare("SELECT * FROM invoices INNER JOIN clients ON clients.client_id=invoices.client_id WHERE invoices.client_id=:client_id ORDER BY invoices.invoice_id DESC");
 $invoices->execute(array("client_id" => $user["client_id"]));
 $invoices = $invoices->fetchAll();

 $unpaidCount =  countRow(["table"=>"invoices","where"=>["invoice_status"=>"Unpaid" , "client_id" => $user["client_id"]]]);

	
	if( $_SESSION["msmbilisim_userlogin"] != 1  || $user["client_type"] == 1  ){
	  
	  
	  echo $twig->render( $templateDir.'.twig',
      array(
            'site'=>[
                      'url'=>URL,'favicon'=>$settings['favicon'],"logo"=>$settings["site_logo"],"site_name"=>$settings["site_name"],
                      'service_speed'=>$settings["service_speed"],"keywords"=>$settings["site_keywords"],
                      "description"=>$settings["site_description"],'languages'=>$languagesL,"childpanel_price"=>$settings["childpanel_price"],"inr_symbol"=>$settings["inr_symbol"],"inr_value"=>$settings["inr_value"],"ns1"=>$settings["ns1"],"ns2"=>$settings["ns2"],"snow_colour"=>$settings["snow_colour"],"snow_effect"=>$settings["snow_effect"],"popup"=>$settings["popup"] ],
            'styleList'=>$stylesheet["stylesheets"],'scriptList'=>$stylesheet["scripts"],'captchaKey'=>$settings["recaptcha_key"],'captcha'=>$captcha,'resetPage'=>$resetPage,'serviceCategory'=>$categories,'categories'=>$categories,
            'error'=>$error,'errorText'=>$errorText,'success'=>$success,"servicesPage"=>$serviceList,"resetType"=>$resetType,'successText'=>$successText,'title'=>$title,"Signup"=>$Signup,"ChildPanel"=>$ChildPanel,'affiliatessystem'=>$affiliatessystem,'Promotion'=>$Promotion,
            'user'=>$user,'data'=>$_SESSION["data"],'settings'=>$settings,'total_orders'=>$totalRows,'search'=>urldecode($_GET["search"]),"active_menu"=>$active_menu,'ticketList'=>$ticketList,'messageList'=>$messageList,
            'ticketCount'=>new_ticket($user['client_id']),'paymentsList'=>$methodList,'integrationsList'=>$methoList,'transactions'=>$transaction_logs,'chilpanel_logs'=>$panel_logs,'PaytmQR'=>$PaytmQR["method_type"],'PaytmQRimage'=>$PaytmQRimage,'WhatsApp'=>$WhatsApp["method_type"],'whatsappnumber'=>$whatsappnumber,'whatsappposition'=>$whatsappposition,'whatsappstatus'=>$whatsappstatus,'whatsappvisibility'=>$whatsappvisibility,'bankPayment'=>$bankPayment["method_type"],'bankList'=>$bankList,
            'status'=>$route[1],'earn'=>$earnList,'orders'=>$ordersList,'pagination'=>$paginationArr,'contentText'=>$content,'headerCode'=>$settings["custom_header"],
            'footerCode'=>$settings["custom_footer"],'lang'=>$languageArray,'timezones'=>$timezones,'AllOrders'=>$panel_orders, 'panel'=>$panel, 'general'=>$general, 'updates'=>$updates , 'blogs'=>$blogs, 'blogtitle'=>$blogtitle, 'blogcontent'=>$blogcontent, 'blogimage'=>$blogimage, 'currency'=>$currency, 'currencies'=>$currencies, 'menus'=>$menus, 'MenuSlug'=>$menuslug, 'pageurl'=>$pageurl , 'pagekeywords'=>$seo_keywords, 'pagetitle'=>$seo_title, 'pagedescription'=>$seo_description, 'PageText'=>$PageText
      )
    );
	
	
	}else{
		

	$uye_id = $user["client_id"];
	$dripfeedvarmi = $conn->query("SELECT * FROM orders WHERE client_id=$uye_id and dripfeed=2");
	if ( $dripfeedvarmi->rowCount() ){
		$dripfeedcount=1;
	}else{
		$dripfeedcount=0;
	}

	
		$uye_id = $user["client_id"];
	$refillvarmi = $conn->query("SELECT * FROM refill_status WHERE client_id=$uye_id ");
	if ( $refillvarmi->rowCount() ){
		$refillavailable=1;
	}else{
		$refillavailable=0;
	}
	$subscriptionsvarmi = $conn->query("SELECT * FROM orders WHERE client_id=$uye_id and subscriptions_type=2");
	if ( $subscriptionsvarmi->rowCount() ){
		$subscriptionscount=1;
	}else{
		$subscriptionscount=0;
	}
	

		  $statubul = $conn->prepare("SELECT SUM(payment_amount) as toplam FROM payments WHERE client_id=:client_id ");
          $statubul->execute(array("client_id"=>$uye_id));
          $statubul = $statubul->fetch(PDO::FETCH_ASSOC);
		  
		  
		  if($statubul["toplam"]<=$bronz_statu):
			$statusu = "VIP";
		  endif;
		  
		  if($statubul["toplam"]>$bronz_statu and $statubul["toplam"]<=$silver_statu):
			$statusu = "JUNIOR";
		  endif;
		  
		  if($statubul["toplam"]>$silver_statu and $statubul["toplam"]<=$gold_statu):
			$statusu = "REGULAR";
		  endif;
		  
		  if($statubul["toplam"]>$gold_statu and $statubul["toplam"]<=$bayi_statu):
			$statusu = "NEW";
		  endif;
		  
		  if($statubul["toplam"]>$bayi_statu):
			$statusu = "NEW";
		  endif;
	
	 $ref_content  = $conn->prepare("SELECT * FROM referral WHERE referral_code=:referral_code ");
 $ref_content->execute(array("referral_code" => $user['ref_code']));
 $ref_content  = $ref_content->fetchAll();

 $ref_payouts  = $conn->prepare("SELECT * FROM referral_payouts WHERE r_p_code=:r_p_code ORDER BY r_p_id DESC");
 $ref_payouts->execute(array("r_p_code" => $user['ref_code']));
 $ref_payouts  = $ref_payouts->fetchAll();

$panel_info = $conn->prepare("SELECT * FROM panel_info WHERE id=:id ");
 $panel_info->execute(array("id" => 1));
 $panel_info  = $panel_info->fetchAll();

 $panels = $conn->prepare("SELECT * FROM panels INNER JOIN clients ON clients.client_id=panels.client_id WHERE panels.client_id=:client_id ORDER BY panels.panel_id DESC");
 $panels->execute(array("client_id" => $user["client_id"]));
 $panels = $panels->fetchAll();


$currencies = $conn->prepare("SELECT * FROM currency WHERE status=:status ");
 $currencies->execute(array("status" => 1));
 $currencies  = $currencies->fetchAll();


if( $user["auth"]) :

$menus  = $conn->prepare("SELECT * FROM menus WHERE visible=:Internal ORDER BY menu_line ASC ");
 $menus->execute(array("Internal" => "Internal" ));
 $menus  = $menus->fetchAll();
$menuslug = $menus["slug"];

else:


$menus  = $conn->prepare("SELECT * FROM menus WHERE visible=:visible ORDER BY menu_line ASC ");
 $menus->execute(array("visible" => "External"));
 $menus  = $menus->fetchAll();
$menuslug = $menus["slug"];
endif;



 $invoices = $conn->prepare("SELECT * FROM invoices INNER JOIN clients ON clients.client_id=invoices.client_id WHERE invoices.client_id=:client_id ORDER BY invoices.invoice_id DESC");
 $invoices->execute(array("client_id" => $user["client_id"]));
 $invoices = $invoices->fetchAll();

 $unpaidCount =  countRow(["table"=>"invoices","where"=>["invoice_status"=>"Unpaid" , "client_id" => $user["client_id"]]]);
	 echo $twig->render( $templateDir.'.twig',
      array(
            'site'=>[
                      'url'=>URL,'favicon'=>$settings['favicon'],"logo"=>$settings["site_logo"],"site_name"=>$settings["site_name"],'service_speed'=>$settings["service_speed"],"keywords"=>$settings["site_keywords"],
                      "description"=>$settings["site_description"],'languages'=>$languagesL,"refillavailable"=>$refillavailable,"dripfeedcount"=>$dripfeedcount,"subscriptionscount"=>$subscriptionscount,"childpanel_price"=>$settings["childpanel_price"],"inr_symbol"=>$settings["inr_symbol"],"inr_value"=>$settings["inr_value"],"ns1"=>$settings["ns1"],"ns2"=>$settings["ns2"],"snow_colour"=>$settings["snow_colour"],"snow_effect"=>$settings["snow_effect"],"popup"=>$settings["popup"]  ],
            'styleList'=>$stylesheet["stylesheets"],'scriptList'=>$stylesheet["scripts"],'captchaKey'=>$settings["recaptcha_key"],'captcha'=>$captcha,'resetPage'=>$resetPage,'serviceCategory'=>$categories,'categories'=>$categories,
            'error'=>$error,'errorText'=>$errorText,'success'=>$success,"servicesPage"=>$serviceList,"resetType"=>$resetType,'successText'=>$successText,'title'=>$title,"Signup"=>$Signup,"ChildPanel"=>$ChildPanel,'affiliatessystem'=>$affiliatessystem,'Promotion'=>$Promotion,
            'user'=>$user,'data'=>$_SESSION["data"],'statu'=>$statusu,'settings'=>$settings,'total_orders'=>$totalRows,'search'=>urldecode($_GET["search"]),"active_menu"=>$active_menu,'ticketList'=>$ticketList,'messageList'=>$messageList,
            'ticketCount'=>new_ticket($user['client_id']),'paymentsList'=>$methodList,'integrationsList'=>$methoList,'transactions'=>$transaction_logs,'chilpanel_logs'=>$panel_logs,'PaytmQRimage'=>$PaytmQRimage,'PaytmQR'=>$PaytmQR["method_type"],'WhatsApp'=>$WhatsApp["method_type"],'whatsappnumber'=>$whatsappnumber,'whatsappposition'=>$whatsappposition,'whatsappstatus'=>$whatsappstatus,'whatsappvisibility'=>$whatsappvisibility,'bankPayment'=>$bankPayment["method_type"],'bankList'=>$bankList,
            'status'=>$route[1],'earn'=>$earnList,'orders'=>$ordersList,'pagination'=>$paginationArr,'contentText'=>$content,'headerCode'=>$settings["custom_header"],
            'footerCode'=>$settings["custom_footer"],'lang'=>$languageArray,'timezones'=>$timezones,
        'popupNotif' => $popupNotif , 'ref_content' => $ref_content , 'ref_payouts' => $ref_payouts , 'panels' => $panels , 'invoices' => $invoices , "route" => $routes , "unpaidCount" => $unpaidCount , 'AllOrders'=>$panel_orders, 'panel'=>$panel, 'general'=>$general, 'updates'=>$updates , 'blogs'=>$blogs, 'blogtitle'=>$blogtitle, 'blogcontent'=>$blogcontent, 'blogimage'=>$blogimage, 'currency'=>$currency, 'currencies'=>$currencies, 'menus'=>$menus, 'MenuSlug'=>$menuslug, 'pageurl'=>$pageurl  , 'pagekeywords'=>$seo_keywords, 'pagetitle'=>$seo_title, 'pagedescription'=>$seo_description , 'PageText'=>$PageText 
      ) 
      
    );
	
	}


   
  }

  if( route(0) != "neworder" && route(0) != "child-panels" && route(0) != "ajax_data" && ( route(0) != "admin" && route(1) != "services" ) ):
    unset($_SESSION["data"]);
  endif;