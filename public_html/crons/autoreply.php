<?php
require '../vendor/autoload.php';
require '../app/init.php';
// use PHPMailer\PHPMailer\PHPMailer;
$to = "10";



  $orders = $conn->prepare("SELECT * FROM tickets INNER JOIN clients ON clients.client_id = tickets.client_id  ");
 $orders->execute(array());
 $orders = $orders->fetchAll(PDO::FETCH_ASSOC);
 foreach($orders as $order):


$failCount      = $conn->prepare("SELECT * FROM ticket_reply WHERE ticket_id=:error ");
  $failCount     -> execute(array("error"=>$order["ticket_id"]));
  $failCount      = $failCount->rowCount();

if( "1" == $failCount ) :
$message = "We have Sended You message to further support team. We're hardly working to solve you issues please be calm and wait for support team reply";

$tr_arr =array(
                "t_id" => $order["ticket_id"], 
                "time" => date("Y-m-d H:i:s"),
                "support" => '2',
                "message" => $message,
                "client_id"=>'0'
                );
           // print_r($tr_arr); die;
                   $insert = $conn->prepare("INSERT INTO ticket_reply SET ticket_id=:t_id, time=:time, support=:support, message=:message, client_id=:client_id");
            $insert = $insert->execute($tr_arr);
$ticket_id = $conn->lastInsertId();
if($insert) :
$update = $conn->prepare("UPDATE tickets SET canmessage=:canmessage, status=:status, lastupdate_time=:time, support_new=:new WHERE ticket_id=:t_id ");
            $update = $update->execute(array("t_id" => $order["ticket_id"], "time" => date("Y-m-d H:i:s"), "status" => "answered", "canmessage" => 2, "new" => 2));


if ($settings["alert_newmessage"] ==  2) {
$msg = "Hello,
You have a new message in the ticket
Follow the link below to see the message: " . site_url() . "tickets/$ticket_id";
        $send = mail($order['email'],"New Message",$msg);


} 
endif;
endif;

   





if($insert) :
$success = "Done Reply-";
print($success);
$success = $order["ticket_id"];
print($success);
$success = $failCount;
print($success);
else:
$success = "Failed Reply";
print($success);
$success = $order["ticket_id"];
print($success);

$success = $failCount;
print($success); 
endif;



endforeach;




?>
