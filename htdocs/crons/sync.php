
<?php

require '../vendor/autoload.php';
require '../app/init.php';


//Auto Sync


//logs
$logs = $conn->prepare("SELECT * FROM serviceapi_alert ORDER BY id DESC ");
$logs->execute(array());
$logs = $logs->fetchAll(PDO::FETCH_ASSOC);


//services_fetch
// $services       = $conn->prepare("SELECT * FROM services WHERE services.service_id = $service_id ");
// $services       -> execute(array());
// $services       = $services->fetchAll(PDO::FETCH_ASSOC);
// $serviceList    = array_group_by($services, 'category_name');
// require admin_view('services');

$currency     = $conn->prepare("SELECT * FROM settings WHERE id=:id");
$currency     ->execute(array("id"=>"1"));
$currency     = $currency->fetch(PDO::FETCH_ASSOC);
$conv_rate = $currency["dolar_charge"];


if( $logs ): 

    foreach($logs as $log):
        $extra = json_decode($log["servicealert_extra"],true);

       
        $service_id =  $log["service_id"];
        $change_desc1 = $log["serviceapi_alert"];
        
        $api_old_value = $extra["old"];
        $api_new_value = $extra["new"];
   
       
        $services       = $conn->prepare("SELECT * FROM services WHERE service_id=:service_id ");
        $services       -> execute(array("service_id"=>$service_id));
        $services       = $services->fetchAll(PDO::FETCH_ASSOC);
        $services_extra = json_decode($services[0]["api_detail"] , true);
$provider_currency = $services_extra["currency"];
         foreach($services as $service):
         
         
         if( strpos(  $change_desc1 , "price has been changed") ):
         //profit percentage 
     $new_profit = $service["service_price"]-$api_old_value;
         $new_profit = $new_profit*100;
$new_profit = $new_profit/$api_old_value;
$service_price = $api_new_value;

    
             $format = $general["currency_format"];
if ($provider_currency == "INR"):
           $finalprice = $service_price +($service_price * ($new_profit/100));
 $final_price​ = $finalprice/$conv_rate;
 else:
$final_price = $service_price +($service_price * ($new_profit/100));   
           endif;
$insert2= $conn->prepare("INSERT INTO sync_logs SET service_id=:s_id, api_id=:api_id, action=:action,  description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"api_id"=>$service["service_api"],"action"=>"Price Changed on
provider from $api_old_value to $api_new_value","description"=>"Price changed from ". $service["service_price"]. " to $final_price","date"=>date("Y-m-d H:i:s") ));
//Create Updates
if($service["service_price"] > $api_new_value ):
$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Price Decreased","description"=>"Price Changed changed from ". $service["service_price"] ." to $final_price","date"=>date("Y-m-d H:i:s") ));
endif;
if($service["service_price"] < $api_new_value ):
$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Price Increased","description"=>"Price Changed changed from ". $service["service_price"] ." to $final_price","date"=>date("Y-m-d H:i:s") ));
endif;

//update
$update = $conn->prepare("UPDATE services SET  service_price=:price WHERE service_id=:service ");
            $update->execute(array("service"=>$service_id , "price"=> number_format($final_price, $format, '.', '') ));

  
        elseif(strpos(  $change_desc1 , "minimum amount changed" ) ):

            
            $update = $conn->prepare("UPDATE services SET  service_min=:min WHERE service_id=:service ");
            $update->execute(array("service"=>$service_id , "min"=>$api_new_value ));

//Create a synced log
            $insert2= $conn->prepare("INSERT INTO sync_logs SET service_id=:s_id, api_id=:api_id, action=:action,  description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"api_id"=>$service["service_api"],"action"=>"Minimum Changed on
provider from $api_old_value to $api_new_value","description"=>"Minimum Amount changed from ". $service["service_min"]. " to $api_new_value","date"=>date("Y-m-d H:i:s") ));
//Create Updates
if($service["service_min"] < $api_new_value ):

  

$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Minimum Increased","description"=>"Minimum amount changed from $api_old_value to $api_new_value","date"=>date("Y-m-d H:i:s") ));
endif;
if($service["service_min"] > $api_new_value ):

  

$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Minimum Decreased","description"=>"Minimum amount changed from ". $service["service_min"] ." to $api_new_value","date"=>date("Y-m-d H:i:s") ));
endif;

        
        
        
        elseif(strpos(  $log["serviceapi_alert"] , "service maximum amount has been changed." ) ):

            
            $update = $conn->prepare("UPDATE services SET  service_max=:max WHERE service_id=:service ");
            $update->execute(array("service"=>$service_id , "max"=>$api_new_value ));
       

//Create a synced log
            $insert2= $conn->prepare("INSERT INTO sync_logs SET service_id=:s_id, api_id=:api_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"api_id"=>$service["service_api"],"action"=>"Maximum Changed on provider from $api_old_value to $api_new_value","description"=>"Maximum Amount changed from ". $service["service_max"]. " to $api_new_value","date"=>date("Y-m-d H:i:s") ));

//Create Updates
if($service["service_max"] < $api_new_value ):

  

$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Maximum Increased","description"=>"Maximum amount changed from ". $service["service_max"] ." to $api_new_value","date"=>date("Y-m-d H:i:s") ));
endif;
if($service["service_max"] > $api_new_value ):

  

$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Maximum Decreased","description"=>"Maximum amount changed from ". $service["service_max"] ." to $api_new_value","date"=>date("Y-m-d H:i:s") ));
endif;
     
            
        
        
      

        elseif(strpos($change_desc1 , "Re-activated by number service provider"  ) ):

            // 1 - inactive , 2 - active

 //Create a synced log
            $insert2= $conn->prepare("INSERT INTO sync_logs SET service_id=:s_id, api_id=:api_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"api_id"=>$service["service_api"],"action"=>"Service Reactivated on provider","description"=>"Activated Service","date"=>date("Y-m-d H:i:s") ));
     
//Create Updates

$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Activated","description"=>"","date"=>date("Y-m-d H:i:s") )); 
            
             

        $update = $conn->prepare("UPDATE services SET  service_type=:type WHERE service_id=:service ");
        $update->execute(array("service"=>$service_id , "type"=> 2 ));

        elseif(strpos( $change_desc1 , "removed by the number service provider" ) ):

                // 1 - inactive , 2 - active
    
   
            $active = 1;
            $update = $conn->prepare("UPDATE services SET  service_type=:type WHERE service_id=:service ");
        $update->execute(array("service"=>$service_id , "type"=>$active ));
                 
        //Create a synced log
            $insert2= $conn->prepare("INSERT INTO sync_logs SET service_id=:s_id, api_id=:api_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"api_id"=>$service["service_api"],"action"=>"Service Removed on provider","description"=>"Deactivated Service","date"=>date("Y-m-d H:i:s") ));
        //Create Updates 
$insert2= $conn->prepare("INSERT INTO updates SET service_id=:s_id, action=:action, description=:description, date=:date ");
          $insert2= $insert2->execute(array("s_id"=>$service_id,"action"=>"Disabled","description"=>"","date"=>date("Y-m-d H:i:s") ));
        else :  
            
       
       
        endif;


            
   

        //push this to services table
        
        // $update = $conn->prepare("UPDATE services SET api_detail=:detail, api_servicetype=:type WHERE service_id=:service ");
        // $update->execute(array("service"=>$service["service_id"],"detail"=>$detail,"type"=>2 ));
       
        
        //push this to services table
    endforeach; 
endforeach; 
    
    
     $delete = $conn->prepare("DELETE FROM serviceapi_alert");
        $delete->execute();
    
    

    else :
        
        
    endif;
