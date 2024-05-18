<?php
if( $panel["panel_status"] == "suspended" ): include 'app/views/frozen.twig';exit(); endif;
if( $panel["panel_status"] == "frozen" ): include 'app/views/frozen.twig';exit(); endif;
  if( $admin["access"]["kuponlar"] != 1  ):
    header("Location:".site_url("admin"));
    exit();
  endif;
  if( empty($action) ):
      
    $earn       = $conn->prepare("SELECT * FROM earn ");
    $earn       -> execute(array());
    $earn      = $earn->fetchAll(PDO::FETCH_ASSOC);
    $kupon_kullananlar        = $conn->prepare("SELECT * FROM kupon_kullananlar ");
    $kupon_kullananlar        -> execute(array());
    $kupon_kullananlar        = $kupon_kullananlar->fetchAll(PDO::FETCH_ASSOC);
endif;

if( $_POST ):

        if( route(2) == "set_earnnote" ):
          $id = route(3);
          $note= $_POST["note"];
          $update = $conn->prepare("UPDATE earn SET earn_note=:note WHERE earn_id=:id ");
          $update->execute(array("id"=>$id,"note"=>$note));
          header("Location:".site_url("admin/earn"));
     endif;
endif;

  if( $_SESSION["client"]["data"] ):
    $data = $_SESSION["client"]["data"];
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    unset($_SESSION["client"]);
  endif;

  if( !route(2) ):
    $page   = 1;
  elseif( is_numeric(route(2)) ):
    $page   = route(2);
  elseif( !is_numeric(route(2)) ):
    $action = route(2);
  endif;

  if( empty($action) ):
      
    $earn       = $conn->prepare("SELECT * FROM earn ");
    $earn       -> execute(array());
    $earn      = $earn->fetchAll(PDO::FETCH_ASSOC);
    $kupon_kullananlar        = $conn->prepare("SELECT * FROM kupon_kullananlar ");
    $kupon_kullananlar        -> execute(array());
    $kupon_kullananlar        = $kupon_kullananlar->fetchAll(PDO::FETCH_ASSOC);
    require admin_view('earn');
	
	
	
	
	elseif( $action == "delete" ):
	
	if( $_POST ):
		 
		 foreach ($_POST as $key => $value) {
			$$key = $value;
		  }
		  
		  
		  
		  
		   $delete = $conn->prepare("DELETE FROM kuponlar WHERE id=:kupon_id");
          $delete->execute(array("kupon_id"=>$kupon_id));
            if( $delete ):
			
              header("Location:".site_url("admin/kuponlar"));
            else:
			
              header("Location:".site_url("admin/kuponlar"));
            endif;
			
			
	  
	endif;
	
	
  elseif( $action == "new" ):
    if( $_POST ):
      foreach ($_POST as $key => $value) {
        $$key = $value;
      }
	  
	  
	  
	    $stmt = $conn->prepare("SELECT count(*) FROM broadcasts WHERE title= ?");
		$stmt->execute([$title]);
		$count = $stmt->fetchColumn();


      if($count>0):
        $error    = 1;
        $errorText= "Bu kupon adı mevcut";
        $icon     = "error";
      else:
          $conn->beginTransaction();
          $insert = $conn->prepare("INSERT INTO broadcasts SET title=:title, status=:status, description=:description");
          $insert = $insert->execute(array("title"=>$title,"status"=>$status,"description"=>$description));
          
          if( $insert ):
            $conn->commit();
            $referrer = site_url("admin/broadcasts");
            $error    = 1;
            $errorText= "Success";
            $icon     = "success";
          else:
            $conn->rollBack();
            $error    = 1;
            $errorText= "Failed";
            $icon     = "error";
          endif;
      endif;
      echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer]);
    
    endif;
  endif;

if( route(2) == "earn_reject" ):
    $id     = route(3);
    $update = $conn->prepare("UPDATE earn SET status=:status WHERE earn_id=:id ");
    $update->execute(array("status"=>"Rejected","id"=>$id));

header("Location:".site_url("admin/earn"));
endif;
  if( route(2) == "earn_grant" ):
    $id     = route(3);
    $update = $conn->prepare("UPDATE earn SET status=:status WHERE earn_id=:id ");
    $update->execute(array("status"=>"Funds Granted","id"=>$id));
    header("Location:".site_url("admin/earn"));
 endif;
 if( route(2) == "earn_review" ):
    $id     = route(3);
    $update = $conn->prepare("UPDATE earn SET status=:status WHERE earn_id=:id ");
    $update->execute(array("status"=>"Under Review","id"=>$id));
  header("Location:".site_url("admin/earn"));

endif;