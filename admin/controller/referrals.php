<?php
if( $panel["panel_status"] == "suspended" ): include 'app/views/frozen.twig';exit(); endif;
if( $panel["panel_status"] == "frozen" ): include 'app/views/frozen.twig';exit(); endif;



if($_GET["remove"]){
  $client_id = $_GET["remove"];
  $ref_code = $_GET["ref_code"];
  $update=$conn->prepare("UPDATE clients SET ref_by=:ref_by WHERE client_id=:client_id");
  $update-> execute(array("ref_by" => "" , "client_id" =>$client_id ));  


  $referral=$conn->prepare("SELECT * FROM referral  WHERE referral_code=:referral_code");
  $referral-> execute(array("referral_code" => $ref_code ));
  $referral= $referral->fetchAll(PDO::FETCH_ASSOC);

 


  $update=$conn->prepare("UPDATE referral SET referral_sign_up=:referral_sign_up WHERE referral_code=:referral_code");
  $update-> execute(array("referral_code" => $ref_code ,
   "referral_sign_up" =>$referral[0]["referral_sign_up"]- 1 )); 
  Header("Location:".site_url('admin/referrals'));
}



 
$referrals=$conn->prepare("SELECT * FROM referral INNER JOIN clients ON clients.ref_code=referral.referral_code WHERE referral_status=:referral_status
 ORDER BY referral_id DESC");
$referrals-> execute(array("referral_status"=> 2));
$referrals= $referrals->fetchAll(PDO::FETCH_ASSOC);

require admin_view('referrals');





?>