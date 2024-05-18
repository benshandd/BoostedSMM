<?php


  if( $admin["access"]["services"] != 1  ):
    header("Location:".site_url("admin"));
    exit();
  endif;

  if( $_SESSION["client"]["data"] ):
    $data = $_SESSION["client"]["data"];
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    unset($_SESSION["client"]);
  endif;


    $services       = $conn->prepare("SELECT * FROM services ") ;
    $services       -> execute(array());
    $services       = $services->fetchAll(PDO::FETCH_ASSOC);
    
    require admin_view('bulk');


  if( $_POST) :

        
    $services = $_POST["service"];

        foreach ($services as $id => $value):


            $update = $conn->prepare("UPDATE services SET service_name=:name   , service_min=:min, service_max=:max  , service_price=:price , service_description=:description WHERE service_id=:id ");
            $update->execute(array("description" => $_POST["desc-$id"], "price" => $_POST["price-$id"] , "max" =>$_POST["max-$id"], "min" => $_POST["min-$id"] , "name" => $_POST["name-$id"], "id" => $id ));

echo  $_POST["name-$id"] ;
if( $update ):
                header("Location:" . site_url("admin/bulk"));
                    $_SESSION["client"]["data"]["success"] = 1;
                    $_SESSION["client"]["data"]["successText"] = "Successful";
              else:
                $errorText  = "Failed";
                $error      = 1;
	header("Location:" . site_url("admin/bulk"));	

	            endif;


endforeach;
        
endif;





$max  = "$max-$id";
$min  = "$min-$id";
$price  = "$price-$id";
$desc  = "$desc-$id";
$name = "$name-$id";