<?php
require '../vendor/autoload.php';
require '../app/init.php';
// use PHPMailer\PHPMailer\PHPMailer;
$to = "9";
$services    = $conn->prepare("SELECT * FROM services ");
  $services     -> execute(array());
$services = $services->fetchAll(PDO::FETCH_ASSOC);
foreach($services as $service ):

  $orders = $conn->prepare("SELECT * FROM orders INNER JOIN services WHERE services.service_id = orders.service_id && orders.order_status=:status && orders.order_quantity=:quantity && orders.service_id=:id ORDER BY orders.service_id DESC LIMIT $to  ");
 $orders->execute(array("quantity"=>"1000","status"=>"completed","id" => $service["service_id"] ));
 $orders = $orders->fetchAll(PDO::FETCH_ASSOC);



 foreach($orders as $order):


$service = $order["service_id"];

$failCount      = $conn->prepare("SELECT * FROM orders WHERE  service_id=:error ");
  $failCount     -> execute(array("error"=> $service ));
  $failCount      = $failCount->rowCount();
            if ( $failCount >=  10 ) :

                        
if($order["avg_many"] == 10 ) :

$hours = $order["avg_hours"];

$hours = $hours / 10;

$init = $hours;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);


print ($hours);
print ($minutes);


$average = "$hours hours and $minutes minutes";

if($hours == 0):
$average = "$minutes Minutes";
endif;
if($minutes == 0):
$average = "$hours Hours";
endif;
if($hours == 0):
if($minutes == 0):
$average = "Not enough data";
endif;
endif;
if($hours == 0) :
if($minutes == 1):
$average = "$minutes Minute";
endif;
endif;
if($hours == 1) :
if($minutes == 0):
$average = "$hours Hour";
endif;
endif;
$update   = $conn->prepare("UPDATE services SET  time=:time WHERE service_id=:id ");
     $update  -> execute(array("id"=>$order["service_id"] ,"time"=> $average ));       



endif;



if($order["avg_many"] >= "10" ) :
$update   = $conn->prepare("UPDATE services SET avg_many=:time, avg_days=:time, avg_minutes=:time, avg_hours=:time WHERE service_id=:id ");
     $update  -> execute(array("id"=>$order["service_id"] ,"time"=> 0  ));    
endif;
   
$date2 = $order["last_check"];
$date1 = $order["order_create"];


 
$origin = new DateTime($date2);
$target = new DateTime($date1);
$interval = $origin->diff($target);
$years = $interval->y; 
$months = $interval->m; 
$days = $interval->d; 
$hours = $interval->h;
$minutes = $interval->i;    



$timestamp1 = strtotime($date1);
$timestamp2 = strtotime($date2);

$hour = abs($timestamp2 - $timestamp1)/(60*60);

$hour = $hour*60*60;

$select = $conn->prepare("SELECT * FROM services WHERE service_id=:id");
            $select->execute(array("id" => $order["service_id"] ));
            $select  = $select->fetch(PDO::FETCH_ASSOC);

$update   = $conn->prepare("UPDATE services SET  avg_hours=:hours, avg_many=:many WHERE service_id=:id ");
     $update  -> execute(array("id"=>$order["service_id"],"hours"=> $select["avg_hours"] + $hour, "many"=>$select["avg_many"] + 1 ));       


if($order["avg_many"] == 10 ) :

$hours = $order["avg_hours"];

$hours = $hours / 10;

$init = $hours;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);


print ($hours);
print ($minutes);


$average = "$hours hours and $minutes minutes";

if($hours == 0):
$average = "$minutes Minutes";
endif;
if($minutes == 0):
$average = "$hours Hours";
endif;
if($hours == 0):
if($minutes == 0):
$average = "Not enough data";
endif;
endif;
if($hours == 0) :
if($minutes == 1):
$average = "$minutes Minute";
endif;
endif;
if($hours == 1) :
if($minutes == 0):
$average = "$hours Hour";
endif;
endif;
$update   = $conn->prepare("UPDATE services SET  time=:time WHERE service_id=:id ");
     $update  -> execute(array("id"=>$order["service_id"] ,"time"=> $average ));       



endif;



echo "$hour |";
print ($minutes);
endif;



endforeach;

endforeach;

