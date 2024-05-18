<?php
if ($user["access"]["reports"] != 1):
    header("Location:" . site_url("admin"));
    exit();
endif;
if ($_SESSION["client"]["data"]):
    $data = $_SESSION["client"]["data"];
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    unset($_SESSION["client"]);
endif;
if (!route(2)):
    $action = "profit";
else:
    $action = route(2);
endif;
if ($_GET["year"]):
    $year = $_GET["year"];
else:
    $year = date("Y");
endif;
require admin_view('home');