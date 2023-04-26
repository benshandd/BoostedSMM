<?php
if( $panel["panel_status"] == "suspended" ): include 'app/views/frozen.twig';exit(); endif;
if( $panel["panel_status"] == "frozen" ): include 'app/views/frozen.twig';exit(); endif;


      if( $_GET["mode"] ):
        $mode = $_GET["mode"];
if($mode == "dark"):
$mode = "dark";
else:
$mode = "sun"; 
endif;
$update = $conn->prepare("UPDATE admins SET mode=:max WHERE admin_id=:id");
        $update->execute(array("max"=>$mode ,"id"=> $admin["admin_id"] )); 

header("Location:".site_url("admin"));
endif;
if( route(1) == "dark"):

$update = $conn->prepare("UPDATE admins SET mode=:max WHERE admin_id=:id");
        $update->execute(array("max"=> "dark","id"=> $admin["admin_id"] )); 
endif;
if( route(1) == "sun"):

$update = $conn->prepare("UPDATE admins SET mode=:max WHERE admin_id=:id");
        $update->execute(array("max"=> "sun","id"=> $admin["admin_id"] )); 
endif;
  $logs = $conn->prepare("SELECT * FROM serviceapi_alert ORDER BY id DESC LIMIT 10");
  $logs->execute(array());
  $logs = $logs->fetchAll(PDO::FETCH_ASSOC);

  $clients = $conn->prepare("SELECT * FROM clients ORDER BY id DESC LIMIT 500");
  $clients->execute(array());
  $clients = $clients->fetchAll(PDO::FETCH_ASSOC);

$payment = $conn->prepare("SELECT * FROM payments ORDER BY id DESC LIMIT 5");
  $payment->execute(array());
  $payment = $payment->fetchAll(PDO::FETCH_ASSOC);





$failCount      = $conn->prepare("SELECT * FROM orders WHERE orders.dripfeed='1' && orders.subscriptions_type='1' && order_error!=:error ");
  $failCount     -> execute(array("error"=>"-"));
  $failCount      = $failCount->rowCount();
$todayCount      = $conn->prepare("SELECT * FROM orders WHERE last_check=:error ");
  $todayCount     -> execute(array("error"=> date("Y-m-d") ));
  $todayCount     = $todayCount->rowCount();

  if( route(2) == "delete" ):
    $id     = route(3);
    $delete = $conn->prepare("DELETE FROM serviceapi_alert WHERE id=:id ");
    $delete->execute(array("id"=>$id));
    header("Location:".site_url("admin"));
  elseif( route(2) == "multi-action" ):
    $logs     = $_POST["log"];
    $action   = $_POST["bulkStatus"];
    foreach ($logs as $id => $value):
      $delete = $conn->prepare("DELETE FROM serviceapi_alert WHERE id=:id ");
      $delete->execute(array("id"=>$id));
    endforeach;
    header("Location:".site_url("admin"));
  endif;

require admin_view('index');