<?php
require '../vendor/autoload.php';
require '../app/init.php';
$smmapi = new SMMApi();
       



    
    
//Enable refill button after 24 hours of an order 



       $orders = $conn->prepare("SELECT * FROM orders WHERE show_refill=:show_refill and order_status=:order_status
         ORDER BY order_id DESC LIMIT 200");
        $orders->execute(array("order_status" => "completed" , "show_refill" => 0 ));
        $orders = $orders->fetchAll(PDO::FETCH_ASSOC);
        $orders = json_decode(json_encode($orders),true);
        
        
        
          
        
        foreach($orders as $order):
        
        
        
        $order_id = $order['order_id'];
        
      
        $current_time = strtotime(date("Y-m-d H:i:s"));
      
        $order_last_check = $order['last_check'];
        $order_create24_time = strtotime($order_last_check) + 86400;  
        $order_create2410_time = strtotime($order_last_check) + 87000;
     
        if ($current_time > $order_create24_time && $current_time < $order_create2410_time ):
            
          
            //show_refill = 1;
            $show_refill = 1;
            
            $update = $conn->prepare("UPDATE orders SET show_refill=:show_refill WHERE order_id=:id");
             $update = $update-> execute(array("id"=>$order_id , "show_refill" => $show_refill));
           

        endif;
        

        
        
        
        // echo $order_create2415_time;
        // echo "<br>";
        
        
        endforeach;
        
        //Enable refill button after 24 hours of an order 


       
//Enable refill status  
        
$refills = $conn->prepare("SELECT * FROM refill_status ");
$refills->execute(array());
$refills = $refills->fetchAll(PDO::FETCH_ASSOC);




foreach ($refills as $refill):
    
    //Status of refill//
    
    
    $order_id_refill = $refill['order_id'];
    $refill_apiid = "$refill[refill_apiid]";
    
    
    // echo  $order_id_refill;
    
    // echo "<br>";
    // echo $refill_apiid;
    
    
    //  $order  = $conn->prepare("SELECT * FROM orders WHERE order_id=:id ");
     $order  = $conn->prepare("SELECT * FROM orders INNER JOIN services ON services.service_id = orders.service_id INNER JOIN service_api ON services.service_api = service_api.id WHERE orders.order_id=:id ");
    $order ->execute(array("id"=>$order_id_refill));
    $order  = $order->fetch(PDO::FETCH_ASSOC);
    $order = json_decode(json_encode($order),true);
    
      
    //   print_r($order[order_id]);
    //   print_r($order["api_key"]);
    //       echo "<br>";
    
    
    // $refill_apiid = $refill[refill_apiid];
    
     $get_refill_status    = $smmapi->action(array('key' =>$order["api_key"],'action' =>'monthorders','id'=>"1"),"https://old.smmpanel.click");
     
     
    $get_refill_status = json_decode(json_encode($get_refill_status),true);
    
    // print_r($get_refill_status[error]);
    
    if(!empty($get_refill_status['status'])) :
        
        
        
      $new_refill_status = $get_refill_status['status'];
       
    
       
       
       
    //   echo $new_refill_status;
      $update  = $conn->prepare("UPDATE refill_status SET refill_status=:refill_status WHERE order_id=:id ");
        $update ->execute(array("id"=>$refill['order_id'] , "refill_status"=>$new_refill_status));
         

    endif;
    
    //  print_r($get_refill_status[status]);
        //Status of refill//
  
    
    
    //Refill button on/off after click
    
      
    $refill_placed_time = strtotime($refill['creation_date']);
    
     $current_time = strtotime(date("Y-m-d H:i:s"));
    
    $refill_end_time = $refill_placed_time + 86400;
    
    // $refill_end_time = date("Y-m-d H:i:s" ,$refill_end_time );
  
  $refill_end_time_6 = $refill_placed_time + 87100;
    
    // $refill_end_time_6 = date("Y-m-d H:i:s" , $refill_end_time_6);

    if ($current_time >= $refill_end_time && $current_time < $refill_end_time_6):
        // echo "Done " . $refill[order_id];
        //  echo "<br>";
        
     
        $show_refill = 1;
    
        $update = $conn->prepare("UPDATE orders SET show_refill=:show_refill WHERE order_id=:id");
         $update = $update-> execute(array("id"=>$refill['order_id'] , "show_refill" => $show_refill));
         
    
       
     
    
    endif;
  
    //Refill button on/off after click
    
    
endforeach;   
 //Enable refill status 
    
 

    
        

    