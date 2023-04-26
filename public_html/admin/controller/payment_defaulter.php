<?php

  $logs = $conn->prepare("SELECT * FROM payments_defaulters ORDER BY id DESC");
  $logs->execute(array("risk" => "High"));
  $logs = $logs->fetchAll(PDO::FETCH_ASSOC);
  

  require admin_view('payment_defaulter');
  
  
  if($_GET['delete']):
      
    $log_id = $_GET['delete'];
    
    $logs = $conn->prepare("DELETE FROM payments_defaulters WHERE id=:id");
    $logs->execute(array("id" => $log_id));
    header("Location:".site_url("admin/payment_defaulter"));
    
    
  endif;