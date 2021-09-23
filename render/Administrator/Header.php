<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo gpPageCfg['DESCRIPTION']; ?>">
  <meta name="author" content="<?php echo gpPageCfg['AUTHOR']; ?>">
  <meta name="keyword" content="<?php echo gpPageCfg['KEYWORDS']; ?>">  
  <title><?php echo gpPageCfg['TITLE']; ?></title>
  <?php 
            
    if ( isset( $_SESSION['SessionIsStarted'] ) ) :                                          
        echo '<meta http-equiv="refresh" content="'. ( gpConfig['TIMEOUT'] * 60 ) .'; url='. gpConfig['URLPATH'] .'auth/logout">';                                     
    endif; 
        
  ?>
  <!-- Icons -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">  
  <script src="https://kit.fontawesome.com/4087daa772.js" crossorigin="anonymous"></script>
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/flag-icon.min.css" rel="stylesheet">  
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/simple-line-icons.min.css" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>css/style.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>css/hover.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>css/mvp.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>css/api.css" rel="stylesheet">
  
  <!-- Styles required by this views -->
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/daterangepicker.min.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/gauge.min.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/toastr.min.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/ionRangeSlider.min.css" rel="stylesheet">
  
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  

</head>


<body class="app header-fixed sidebar-minimized aside-menu-fixed aside-menu-hidden bg-light text-dark" style="font-family: Montserrat; ">

  <header class="app-header navbar text-dark bg-light" style="border: 1px solid #000;">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="<?php echo gpConfig['URLPATH'] . _ACCESS_ ; ?>"></a>
    <!-- <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <ul class="nav navbar-nav d-md-down-none mr-auto">

      <li class="nav-item px-3">
          <a class="nav-link" style="color: #000;" href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>"><i class="fa fa-bars text-warning"></i> Manage Users</a>
        </li>

        <li class="nav-item px-3">
          <a class="nav-link" style="color: #000;" href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>plans"><i class="fa fa-map text-purple"></i> Plan Mapping</a>
        </li>

        <li class="nav-item px-3">
          <a class="nav-link" style="color: #000;" href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>devices"><i class="fa fa-mobile-phone text-primary"></i> Device Catalog</a>
        </li>

        <li class="nav-item px-3">
          <a class="nav-link" style="color: #000;" href="<?php echo gpConfig['URLPATH']; ?>auth/logout"><i class="fa fa-sign-out text-danger"></i> Logout</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
      
      <li class="nav-item dropdown d-md-down-none pr-5 text-right"></li>
      
      <!-- <button class="navbar-toggler aside-menu-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
      </button> -->

    </ul>
  </header>

  <div class="app-body">

    <div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav ">
            <li class="nav-item">
              &nbsp;
            </li>
            <li class="nav-item">
              &nbsp;
            </li>
            <li class="nav-item">
              &nbsp;
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>"><i class="fa fa-bars text-warning"></i> Manage Users </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>plans"><i class="fa fa-map text-purple"></i> Plan Mapping </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>devices"><i class="fa fa-mobile-phone text-primary"></i> Device Catalog</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="<?php echo gpConfig['URLPATH']; ?>auth/logout/"><i class="fa fa-sign-out text-danger"></i> Logout</a>
            </li>

          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>