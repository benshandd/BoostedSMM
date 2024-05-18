
<?php


if( $panel["panel_status"] == "suspended" ): include 'app/views/frozen.twig';exit(); endif;
if( $panel["panel_status"] == "frozen" ): include 'app/views/frozen.twig';exit(); endif;


if ($_GET["approve"]) :

    $r_p_id  = $_GET["approve"];


    $r_payout = $conn->prepare("SELECT * FROM referral_payouts INNER JOIN clients ON clients.ref_code=referral_payouts.r_p_code
     INNER JOIN referral ON referral.referral_code=referral_payouts.r_p_code  WHERE  r_p_id=:r_p_id");
    $r_payout->execute(array("r_p_id" => $r_p_id));
    $r_payout = $r_payout->fetchAll(PDO::FETCH_ASSOC);

    $user  = $conn->prepare("SELECT * FROM clients WHERE client_id=:client_id ");
    $user->execute(array("client_id" => $r_payout[0]["client_id"]));
    $user  = $user->fetch(PDO::FETCH_ASSOC);

    if ($r_payout[0]["r_p_status"] == 2 || $r_payout[0]["r_p_status"] == 1) {

        //already processsed
        Header("Location:" . site_url('admin/payouts'));
    } else {

        // print_r($r_payout);
        // exit();

        $conn->beginTransaction();
        $update = $conn->prepare("UPDATE referral_payouts SET 	r_p_status=:r_p_status , 
        r_p_updated_at=:r_p_updated_at WHERE r_p_id=:r_p_id");
        $update = $update->execute(array("r_p_id" => $r_p_id, "r_p_status" => 2, "r_p_updated_at" =>  date("Y-m-d H:i:s")));


        $insert = $conn->prepare("INSERT INTO payments SET client_id=:client_id , client_balance=:client_balance , 
            payment_amount=:payment_amount , payment_method=:payment_method ,
            payment_status=:payment_status , payment_delivery=:payment_delivery , payment_note=:payment_note,
            payment_create_date=:payment_create_date ,
             payment_update_date=:payment_update_date, 	payment_ip=:payment_ip , 
             payment_extra=:payment_extra ");
        $insert = $insert->execute(array(
            "client_id" => $r_payout[0]["client_id"],
            "client_balance" => $r_payout[0]["balance"],
            "payment_amount" => $r_payout[0]["r_p_amount_requested"], "payment_method" => 25,
            "payment_status" => 3, "payment_delivery" => 2, "payment_note" => "Referral Amount of Referred Payout id : $r_p_id ",
             "payment_create_date" => date("Y-m-d H:i:s"),
            "payment_update_date" => date("Y-m-d H:i:s"), "payment_ip" => GetIP(),
            "payment_extra" => "Referral Amount of referred payout id : $r_p_id "
        ));




        if ($insert) : $last_payment_id = $conn->lastInsertId();
        endif;


        //add balance too

        $update4 = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id ");
        $update4 = $update4->execute(array(
            "id" => $user["client_id"],
            "balance" => $r_payout[0]["r_p_amount_requested"] + $user["balance"]
        ));

        //add balance too




        $update2 = $conn->prepare("UPDATE referral SET 
        referral_earned_commision=:referral_earned_commision ,
        referral_requested_commision=:referral_requested_commision WHERE referral_code=:referral_code ");
        $update2 = $update2->execute(array(
            "referral_code" => $r_payout[0]["r_p_code"],
            "referral_earned_commision" => $r_payout[0]["referral_earned_commision"] + $r_payout[0]["r_p_amount_requested"],
            "referral_requested_commision" => 0
        ));

        //success or failure
        if ($update2 && $update && $insert && $update4) :
            $conn->commit();
            $success    = 1;
            $successText = "Successful";
            $icon     = "success";


          $amount = $r_payout[0]['r_p_amount_requested'];  
            
        //cleints_report
        $insert5 = $conn->prepare("INSERT INTO client_report SET client_id=:client_id
         ,action=:action, report_ip=:report_ip , report_date=:report_date");
        $insert5 = $insert5->execute(array(
            "client_id" => $user["client_id"],
            "action" => "Amount added :  $amount , #Referral Payout id : $r_p_id " , 
            "report_ip" =>  GetIP(), "report_date" => date("Y-m-d H:i:s")
        ));

        //cleints_report


        else :
            $conn->rollBack();
            $error    = 1;
            $errorText = "Unsuccessful";
            $icon     = "error";
            if ($update4) :
                $update4 = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id ");
                $update4 = $update4->execute(array(
                    "id" => $user["client_id"],
                    "balance" => $user["balance"]
                ));
            endif;
            if ($insert) :
                $delete = $conn->prepare("DELETE FROM payments WHERE payment_id=:id ");
                $delete = $delete->execute(array(
                    "id" => $last_payment_id,
                ));
            endif;


        endif;
        Header("Location:" . site_url('admin/payouts'));
    }


elseif ($_GET["disapprove"]) :

    $r_p_id  = $_GET["disapprove"];


    $r_payout = $conn->prepare("SELECT * FROM referral_payouts INNER JOIN clients ON clients.ref_code=referral_payouts.r_p_code
     INNER JOIN referral ON referral.referral_code=referral_payouts.r_p_code  WHERE  r_p_id=:r_p_id");
    $r_payout->execute(array("r_p_id" => $r_p_id));
    $r_payout = $r_payout->fetchAll(PDO::FETCH_ASSOC);

    if ($r_payout[0]["r_p_status"] == 2 || $r_payout[0]["r_p_status"] == 1) {

        //already processsed
        Header("Location:" . site_url('admin/payouts'));
    } else {

        $conn->beginTransaction();
        $update = $conn->prepare("UPDATE referral_payouts SET r_p_status=:r_p_status , 
        r_p_updated_at=:r_p_updated_at WHERE r_p_id=:r_p_id ");
        $update = $update->execute(array("r_p_id" => $r_p_id, "r_p_status" => 1, "r_p_updated_at" =>  date("Y-m-d H:i:s")));

        $update2 = $conn->prepare("UPDATE referral SET 
     referral_requested_commision=:referral_requested_commision WHERE referral_code=:referral_code ");
        $update2 = $update2->execute(array(
            "referral_code" => $r_payout[0]["r_p_code"],
            "referral_requested_commision" => 0
        ));

        //success or failure
        if ($update2 && $update) :
            $conn->commit();
            $success    = 1;
            $successText = "Successful";
            $icon     = "success";


        else :
            $conn->rollBack();
            $error    = 1;
            $errorText = "Unsuccessful";
            $icon     = "error";


        endif;
        Header("Location:" . site_url('admin/payouts'));
    }
elseif ($_GET["reject"]) :

    $r_p_id  = $_GET["reject"];


    $r_payout = $conn->prepare("SELECT * FROM referral_payouts INNER JOIN clients ON clients.ref_code=referral_payouts.r_p_code
     INNER JOIN referral ON referral.referral_code=referral_payouts.r_p_code  WHERE  r_p_id=:r_p_id");
    $r_payout->execute(array("r_p_id" => $r_p_id));
    $r_payout = $r_payout->fetchAll(PDO::FETCH_ASSOC);

    if ($r_payout[0]["r_p_status"] == 2 || $r_payout[0]["r_p_status"] == 1) {

        //already processsed
        Header("Location:" . site_url('admin/payouts'));
    } else {

        $conn->beginTransaction();
        $update = $conn->prepare("UPDATE referral_payouts SET r_p_status=:r_p_status , 
        r_p_updated_at=:r_p_updated_at WHERE r_p_id=:r_p_id ");
        $update = $update->execute(array("r_p_id" => $r_p_id, "r_p_status" => 3, "r_p_updated_at" =>  date("Y-m-d H:i:s")));

        $update2 = $conn->prepare("UPDATE referral SET 
     referral_rejected_commision=:referral_rejected_commision,
     referral_requested_commision=:referral_requested_commision WHERE referral_code=:referral_code ");
        $update2 = $update2->execute(array(
            "referral_code" => $r_payout[0]["r_p_code"],
            "referral_rejected_commision" =>$r_payout[0]["referral_rejected_commision"] + $r_payout[0]["r_p_amount_requested"],
            "referral_requested_commision" => 0
        ));

        //success or failure
        if ($update2 && $update) :
            $conn->commit();
            $success    = 1;
            $successText = "Successful";
            $icon     = "success";

            $amount = $r_payout[0]['r_p_amount_requested'];  
            
            //cleints_report
            $insert5 = $conn->prepare("INSERT INTO client_report SET client_id=:client_id
             ,action=:action, report_ip=:report_ip , report_date=:report_date");
            $insert5 = $insert5->execute(array(
                "client_id" => $user["client_id"],
                "action" => "Amount rejected :  $amount ,#Referral Payout id : $r_p_id " , 
                "report_ip" =>  GetIP(), "report_date" => date("Y-m-d H:i:s")
            ));
    
            //cleints_report


        else :
            $conn->rollBack();
            $error    = 1;
            $errorText = "Unsuccessful";
            $icon     = "error";


        endif;
        Header("Location:" . site_url('admin/payouts'));
    }

endif;




$referral_payouts = $conn->prepare("SELECT * FROM referral_payouts INNER JOIN clients ON clients.ref_code=referral_payouts.r_p_code ORDER BY r_p_id DESC");
$referral_payouts->execute(array());
$referral_payouts = $referral_payouts->fetchAll(PDO::FETCH_ASSOC);


require admin_view('payouts');
