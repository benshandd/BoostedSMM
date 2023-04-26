<?php
require '../vendor/autoload.php';
require '../app/init.php';
// use PHPMailer\PHPMailer\PHPMailer;
$to = "10";



  $orders = $conn->prepare("SELECT * FROM orders INNER JOIN services WHERE services.service_id = orders.service_id ORDER BY orders.order_id DESC LIMIT $to ");
 $orders->execute(array());
 $orders = $orders->fetchAll(PDO::FETCH_ASSOC);
 foreach($orders as $order):


$date2 = $order["last_check"];
$date1 = $order["order_create"];


if( $order["avg_many"]  ==  10 ) :
if( $order["order_status"]  ==  "completed") :
$origin = new DateTime($date2);
$target = new DateTime($date1);
$interval = $origin->diff($target);
$days = $order["avg_days"] / 10 ;
$minutes = $order["avg_minutes"] / 10 ;
$hours = $order["avg_hours"] / 10 ;
$average =    "$days days $hours hours $minutes minutes ";
if( $days == "0" ) :
$average =    "$hours hours $minutes minutes ";
endif;
if( $hours == "0" ) :
$average =    "$days days $minutes minutes ";
endif;


if( $minutes == "0" && $days == "0" ) :
$average =    "$hours hours ";
endif;
if( $hours == "0" && $days == "0" ) :
$average =    "$minutes minutes ";
endif;
if( $minutes == "0" && $hours == "0" ) :
$average =    "$days days ";
endif;

if( $minutes == "0" && $hours == "0" && $days == "0" ) :
$average =    "Not enough data";
endif;


          

$update   = $conn->prepare("UPDATE services SET  time=:time WHERE service_id=:id ");
     $update  -> execute(array("id"=>$order["service_id"] ,"time"=> $average ));       

endif;

endif;
endforeach;
?>
