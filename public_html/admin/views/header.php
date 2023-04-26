<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="big5">

  <base href="<?= site_url() ?>">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $settings["site_name"] ?></title>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/public/admin/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/public/admin/style.css">
<link rel="stylesheet" type="text/css" href="/public/admin/tooltip.css">
  <link rel="stylesheet" type="text/css" href="/public/admin/toastDemo.css">
  <link rel="stylesheet" type="text/css" href="/public/datepicker/css/bootstrap-datepicker3.min.css">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
  <link rel="stylesheet" type="text/css" href="public/admin/tinytoggle.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <script src="https://kit.fontawesome.com/f9fbee3ddf.js" crossorigin="anonymous"></script>


  
  
<link id="bs-css" href="/assets/css2/bootstrap-cybrog.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css2/charisma-app.css">
    <link rel="stylesheet" type="text/css" href='/assets/css2/jquery.noty.css'>
    <link rel="stylesheet" type="text/css" href='/assets/css2/noty_theme_default.css'>
    <link rel="stylesheet" type="text/css" href='/assets/css2/elfinder.min.css'>
    <link rel="stylesheet" type="text/css" href='/assets/css2/elfinder.theme.css'>
    <link rel="stylesheet" type="text/css" href='/assets/css2/jquery.iphone.toggle.css'>
    <link rel="stylesheet" type="text/css" href='/assets/css2/uploadify.css'>
    <link rel="stylesheet" type="text/css" href='/assets/css2/animate.min.css'>
    <link href='/assets/bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='/assets/bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='/assets/bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='/assets/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='/assets/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='/assets/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>

    <script src="/public/admin/apex.js"></script>
 <link href="https://worldsmmstore.com/css/main.css?v=1631545690" rel="stylesheet">  
  <style>
    li {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    html,
    body {
      font-family: 'Poppins', sans-serif;


    }




    #loading {
      position: fixed;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      opacity: 0.7;
      background-color: #fff;
      z-index: 99;
    }

    #loading-image {
      z-index: 100;
    }

    #buy-smm {
      margin: 8px 15px;
      font-size: 15px;
      font-weight: 400;
    }

    #buy-smm a {
      cursor: pointer;
    }
  </style>

</head>

<body>

  <div class="container">
    <div class="row">
      <div id="loading">
        <img id="loading-image" src="/public/ajax-loading.gif" alt="Loading..." />
      </div>
    </div>
  </div>


<body class="<?php if($admin["mode"] == "dark"): echo "dark-mode"; endif; ?>">


     <nav class="navbar  navbar-fixed-top   navbar-default">
    <div class="container-fluid">
<div class="navbar-header">
       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left-block">          <?php if ($admin["access"]["admin_access"]  && $_SESSION["msmbilisim_adminlogin"]) : ?>
            <li class="<?php if (route(1) == "index") : echo 'active';
                        endif; ?>"><a class="<?php if (route(1) == "index") : echo 'active';
                          endif; ?>" href="<?php echo site_url("admin") ?>"><i class="fas fa-home"></i><span> Dashboard</span></a>
            </li>
            <li class="<?php if (route(1) == "clients") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/clients") ?>"><i class="fas fa-user"></i><span> Users</span></a>
            </li>



                        
<li class="" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-list"></i> Services<span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-max-height">

<li class="<?php if (route(1) == "services") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/services") ?>"><i class="glyphicon glyphicon-list"></i><span> Services</span></a></li>
<li class="<?php if (route(1) == "update-prices") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/update-prices") ?>"><i class="fa fa-cloud-upload"></i><span> Update Prices</span></a></li>
<li class="<?php if (route(1) == "synced_logs") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/synced_logs") ?>"><i class="fa fa-refresh"></i><span> Synced Logs</span></a></li>

       </ul>

            
<li class="" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-shopping-bag"></i> Order Logs<span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-max-height">

<li class="<?php if (route(1) == "orders") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/orders") ?>"><i class="fas fa-shopping-bag"></i><span> Orders</span></a></li>
               
<?php if(countRow(["table"=>"refill_status"])>0){ 
?>
                <li class="<?php if (route(1) == "refill") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/refill") ?>"><i class="fas fa-history"></i><span> Refill Logs</span></a></li>
<?php		
			}else{			
			}	
			?>
<?php if(countRow(["table"=>"orders","where"=>["dripfeed"=>2]])>0){   ?>
		
<li class="<?php if (route(1) == "dripfeed") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/dripfeed") ?>"><i class="fas fa-shopping-bag"></i><span>Drip-feeds</span></a></li>
<?php
				
			}else{
				
			}
			
			?>
                </li><?php if(countRow(["table"=>"orders","where"=>["subscriptions_type"=>2]])>0){
			
			?>
<li class="<?php if (route(1) == "subscriptions") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/subscriptions") ?>"><i class="fas fa-bag"></i><span> Subscriptions</span></a></li>
<?php
				
			}else{
				
			}
			
			?>
              </ul>
            </li>




            <li class="<?php if (route(1) == "payments") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/payments/online") ?>"><i class="fas fa-money-bill-alt"></i><span> Payments</span></a>
            </li>

            <li class="<?php if (route(1) == "broadcasts") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/broadcasts") ?>"><i class="fas fa-bullhorn"></i><span> Broadcasts</span></a>
                </li>
            
          

            <li class="<?php if (route(1) == "tickets") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/tickets") ?>"><i class="fas fa-headset"></i><span> Tickets <?php if(countRow(["table"=>"tickets","where"=>["client_new"=>2]])>0){
			
			?><span class="badge" style="background-color:#cc9616 "><?=countRow(["table"=>"tickets","where"=>["client_new"=>2]]);?></span><?php
				
			}else{
				
			}
			
			?></span></a>
            </li>

            <li class="" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-clipboard-check"></i> Logs <span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-max-height">

                <li><a class="ajax-link" href="<?php echo site_url("admin/logs") ?>"><span><i class="fas fa-file-text"></i> Logs</span></a>
                </li>

                <li><a class="ajax-link" href="<?php echo site_url("admin/reports") ?>"><span><i class="fas fa-chart-line"></i> Reports</span></a>
                </li>

              </ul>
            </li>

            <li class="<?php if (route(1) == "referrals") : echo 'active'; endif; ?>"><li class="<?php if (route(1) == "payouts") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/referrals") ?>"><i class="fas fa-bezier-curve"></i><span> Affiliates</span></a></li>
                

            </li>
     

            <li class="" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-question-circle"></i> Additionals <span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-max-height">
              <li class="<?php if (route(1) == "earn") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/earn") ?>"><i class="fas fa-video"></i><span> Promotion</span></a></li>
                        
                <li class="<?php if (route(1) == "kuponlar") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/kuponlar") ?>"><i class="fas fa-tags"></i><span> Coupon Code</span></a></li>


                <li class="<?php if (route(1) == "child-panels") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/child-panels") ?>"><i class="fas fa-child"></i><span> Child Panels</span></a></li>
<li class="<?php if (route(1) == "updates") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/updates") ?>"><i class="fas fa-bell"></i><span> Updates</span></a></li>

               

              </ul>
            </li>

</li>
<li class="<?php if (route(1) == "appearance") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/appearance") ?>"><i class="fas fa-sun"></i><span> Appearance</span></a>
            </li>

            <li class="<?php if (route(1) == "settings") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/settings") ?>"><i class="glyphicon glyphicon-cog"></i><span> Settings</span></a>
            </li>

         <?php if ($admin["mode"] == "dark") : ?>

<li><a href="admin?mode=sun"><i class="fas fa-sun"></i><span></span></a></li>

<?php else: ?>

<li><a href="admin?mode=dark"><i class="fas fa-moon"></i><span></span></a></li>


<?php endif; ?>
<li class="<?php if (route(1) == "account") : echo 'active';
                        endif; ?>"><a class="ajax-link" href="<?php echo site_url("admin/account") ?>"><i class="fas fa-user"></i><span> Account</span></a>
            </li
          <?php endif; ?>
        </ul>




        <li><a href="admin/logout"><i class="fa fa-sign-out-alt "></i><span> Logout</span></a></li>
        
      </div>

    </div>
  </nav>
<br>
<br>
<br>
