<!--
 * CoreUI Pro - Bootstrap 4 Admin Template
 * @version v1.0.8
 * @link http://coreui.io/pro/
 * Copyright (c) 2018 creativeLabs Łukasz Holeczek
 * @license http://coreui.io/pro/license/
 -->
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
            $this->GPLogicSession; 
            echo '<meta http-equiv="refresh" content="'. ( gpConfig['TIMEOUT'] * 60 ) .'; url='. gpConfig['URLPATH'] .'auth/logout">';                                     
        endif; 
        
  ?>

  <!-- Icons -->
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/flag-icon.min.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/simple-line-icons.min.css" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>css/style.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css"> -->

  <!-- Styles required by this views -->
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/daterangepicker.min.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/gauge.min.css" rel="stylesheet">
  <link href="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/css/toastr.min.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,800" rel="stylesheet">        

</head>

<body class="app header-fixed sidebar-hidden aside-menu-fixed aside-menu-hidden" style="background-color: #000; background-position: 0% 50%; background-size: cover; font-family: Poppins;">
  <header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none mr-auto">

      <li class="nav-item px-3">
        <a class="nav-link" href="#"><i class="fa fa-desktop"></i> Dashboard</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="#">Users</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="#">Settings</a>
      </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item dropdown d-md-down-none">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
          <div class="dropdown-header text-center">
            <strong>You have 5 notifications</strong>
          </div>
          <a href="#" class="dropdown-item">
            <i class="icon-user-follow text-success"></i> New user registered
          </a>
          <a href="#" class="dropdown-item">
            <i class="icon-user-unfollow text-danger"></i> User deleted
          </a>
          <a href="#" class="dropdown-item">
            <i class="icon-chart text-info"></i> Sales report is ready
          </a>
          <a href="#" class="dropdown-item">
            <i class="icon-basket-loaded text-primary"></i> New client
          </a>
          <a href="#" class="dropdown-item">
            <i class="icon-speedometer text-warning"></i> Server overloaded
          </a>
          <div class="dropdown-header text-center">
            <strong>Server</strong>
          </div>
          <a href="#" class="dropdown-item">
            <div class="text-uppercase mb-1">
              <small><b>CPU Usage</b></small>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
            <small class="text-muted">348 Processes. 1/4 Cores.</small>
          </a>
          <a href="#" class="dropdown-item">
            <div class="text-uppercase mb-1">
              <small><b>Memory Usage</b></small>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
            <small class="text-muted">11444GB/16384MB</small>
          </a>
          <a href="#" class="dropdown-item">
            <div class="text-uppercase mb-1">
              <small><b>SSD 1 Usage</b></small>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
            <small class="text-muted">243GB/256GB</small>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown d-md-down-none">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon-list"></i><span class="badge badge-pill badge-warning">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
          <div class="dropdown-header text-center">
            <strong>You have 5 pending tasks</strong>
          </div>
          <a href="#" class="dropdown-item">
            <div class="small mb-1">Upgrade NPM &amp; Bower
              <span class="float-right">
                <strong>0%</strong>
              </span>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
          </a>
          <a href="#" class="dropdown-item">
            <div class="small mb-1">ReactJS Version
              <span class="float-right">
                <strong>25%</strong>
              </span>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
          </a>
          <a href="#" class="dropdown-item">
            <div class="small mb-1">VueJS Version
              <span class="float-right">
                <strong>50%</strong>
              </span>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
          </a>
          <a href="#" class="dropdown-item">
            <div class="small mb-1">Add new layouts
              <span class="float-right">
                <strong>75%</strong>
              </span>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
          </a>
          <a href="#" class="dropdown-item">
            <div class="small mb-1">Angular 2 Cli Version
              <span class="float-right">
                <strong>100%</strong>
              </span>
            </div>
            <span class="progress progress-xs">
              <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </span>
          </a>
          <a href="#" class="dropdown-item text-center">
            <strong>View all tasks</strong>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown d-md-down-none">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon-envelope-letter"></i><span class="badge badge-pill badge-info">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
          <div class="dropdown-header text-center">
            <strong>You have 4 messages</strong>
          </div>
          <a href="#" class="dropdown-item">
            <div class="message">
              <div class="py-3 mr-3 float-left">
                <div class="avatar">
                  <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                  <span class="avatar-status badge-success"></span>
                </div>
              </div>
              <div>
                <small class="text-muted">John Doe</small>
                <small class="text-muted float-right mt-1">Just now</small>
              </div>
              <div class="text-truncate font-weight-bold">
                <span class="fa fa-exclamation text-danger"></span> Important message</div>
              <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
            </div>
          </a>
          <a href="#" class="dropdown-item">
            <div class="message">
              <div class="py-3 mr-3 float-left">
                <div class="avatar">
                  <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                  <span class="avatar-status badge-warning"></span>
                </div>
              </div>
              <div>
                <small class="text-muted">John Doe</small>
                <small class="text-muted float-right mt-1">5 minutes ago</small>
              </div>
              <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
              <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
            </div>
          </a>
          <a href="#" class="dropdown-item">
            <div class="message">
              <div class="py-3 mr-3 float-left">
                <div class="avatar">
                  <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/avatars/5.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                  <span class="avatar-status badge-danger"></span>
                </div>
              </div>
              <div>
                <small class="text-muted">John Doe</small>
                <small class="text-muted float-right mt-1">1:52 PM</small>
              </div>
              <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
              <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
            </div>
          </a>
          <a href="#" class="dropdown-item">
            <div class="message">
              <div class="py-3 mr-3 float-left">
                <div class="avatar">
                  <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/avatars/4.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                  <span class="avatar-status badge-info"></span>
                </div>
              </div>
              <div>
                <small class="text-muted">John Doe</small>
                <small class="text-muted float-right mt-1">4:03 PM</small>
              </div>
              <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
              <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
            </div>
          </a>
          <a href="#" class="dropdown-item text-center">
            <strong>View all messages</strong>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header text-center">
            <strong>Account</strong>
          </div>
          <a class="dropdown-item" href="#"><i class="fa fa-bell-o"></i> Updates<span class="badge badge-info">42</span></a>
          <a class="dropdown-item" href="#"><i class="fa fa-envelope-o"></i> Messages<span class="badge badge-success">42</span></a>
          <a class="dropdown-item" href="#"><i class="fa fa-tasks"></i> Tasks<span class="badge badge-danger">42</span></a>
          <a class="dropdown-item" href="#"><i class="fa fa-comments"></i> Comments<span class="badge badge-warning">42</span></a>
          <div class="dropdown-header text-center">
            <strong>Settings</strong>
          </div>
          <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
          <a class="dropdown-item" href="#"><i class="fa fa-wrench"></i> Settings</a>
          <a class="dropdown-item" href="#"><i class="fa fa-usd"></i> Payments<span class="badge badge-dark">42</span></a>
          <a class="dropdown-item" href="#"><i class="fa fa-file"></i> Projects<span class="badge badge-primary">42</span></a>
          <div class="divider"></div>
          <a class="dropdown-item" href="#"><i class="fa fa-shield"></i> Lock Account</a>
          <a class="dropdown-item" href="#"><i class="fa fa-lock"></i> Logout</a>
        </div>
      </li>
      <button class="navbar-toggler aside-menu-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>

    </ul>
  </header>

  <div class="app-body">

    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.html"><i class="fa fa-desktop"></i> Dashboard <span class="badge badge-info">NEW</span></a>
          </li>

          <li class="nav-title">
            Theme
          </li>
          <li class="nav-item">
            <a href="colors.html" class="nav-link"><i class="icon-drop"></i> Colors</a>
          </li>
          <li class="nav-item">
            <a href="typography.html" class="nav-link"><i class="icon-pencil"></i> Typograhy</a>
          </li>
          <li class="nav-title">
            Components
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Base</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="base-breadcrumb.html"><i class="icon-puzzle"></i> Breadcrumb</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-cards.html"><i class="icon-puzzle"></i> Cards</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-carousel.html"><i class="icon-puzzle"></i> Carousel</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-collapse.html"><i class="icon-puzzle"></i> Collapse</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-jumbotron.html"><i class="icon-puzzle"></i> Jumbotron</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-list-group.html"><i class="icon-puzzle"></i> List group</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-navs.html"><i class="icon-puzzle"></i> Navs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-pagination.html"><i class="icon-puzzle"></i> Pagination</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-popovers.html"><i class="icon-puzzle"></i> Popovers</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-progress.html"><i class="icon-puzzle"></i> Progress</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-switches.html"><i class="icon-puzzle"></i> Switches</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-tabs.html"><i class="icon-puzzle"></i> Tabs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="base-tooltips.html"><i class="icon-puzzle"></i> Tooltips</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-cursor"></i> Buttons</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="buttons-buttons.html"><i class="icon-cursor"></i> Buttons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="buttons-button-group.html"><i class="icon-cursor"></i> Buttons Group</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="buttons-dropdowns.html"><i class="icon-cursor"></i> Dropdowns</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="buttons-loading-buttons.html"><i class="icon-cursor"></i> Loading Buttons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="buttons-social-buttons.html"><i class="icon-cursor"></i> Social Buttons</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="charts.html"><i class="icon-pie-chart"></i> Charts</a>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-code"></i> Editors</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="editors-code-editor.html"><i class="icon-note"></i> Code Editor</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="editors-markdown-editor.html"><i class="fa fa-code"></i> Markdown Editor</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="editors-text-editors.html"><i class="icon-note"></i> Rich Text Editor</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-note"></i> Forms</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="forms-basic-forms.html"><i class="icon-note"></i> Basic Forms</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="forms-advanced-forms.html"><i class="icon-note"></i> Advanced Forms</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="forms-validation.html"><i class="icon-note"></i> Validation</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="google-maps.html"><i class="icon-map"></i> Google Maps <span class="badge badge-info">NEW</span></a>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-star"></i> Icons</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="icons-flags.html"><i class="icon-star"></i> Flags <span class="badge badge-success">NEW</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="icons-font-awesome.html"><i class="icon-star"></i> Font Awesome <span class="badge badge-secondary">4.7</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="icons-simple-line-icons.html"><i class="icon-star"></i> Simple Line Icons</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bell"></i> Notifications</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="notifications-alerts.html"><i class="icon-bell"></i> Alerts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="notifications-badge.html"><i class="icon-bell"></i> Badge</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="notifications-modals.html"><i class="icon-bell"></i> Modals</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="notifications-toastr.html"><i class="icon-bell"></i> Toastr</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-energy"></i> Plugins</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="plugins-calendar.html"><i class="icon-calendar"></i> Calendar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="plugins-draggable-cards.html"><i class="icon-cursor-move"></i> Draggable Cards</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="plugins-sliders.html"><i class="icon-equalizer"></i> Sliders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="plugins-spinners.html"><i class="fa fa-spinner"></i> Spinners</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-list"></i> Tables</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="tables-tables.html"><i class="icon-list"></i> Standard Tables</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tables-datatables.html"><i class="icon-list"></i> DataTables</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="widgets.html"><i class="icon-calculator"></i> Widgets <span class="badge badge-info">NEW</span></a>
          </li>
          <li class="divider"></li>
          <li class="nav-title">
            Extras
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-star"></i> Pages</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="pages-login.html" target="_top"><i class="icon-star"></i> Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pages-register.html" target="_top"><i class="icon-star"></i> Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pages-404.html" target="_top"><i class="icon-star"></i> Error 404</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pages-500.html" target="_top"><i class="icon-star"></i> Error 500</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-layers"></i> UI Kits</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-speech"></i> Invoicing</a>
                <ul class="nav-dropdown-items">
                  <li class="nav-item">
                    <a class="nav-link" href="UIkits-invoicing-invoice.html"><i class="icon-speech"></i> Invoice</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-speech"></i> Email</a>
                <ul class="nav-dropdown-items">
                  <li class="nav-item">
                    <a class="nav-link" href="UIkits-email-inbox.html"><i class="icon-speech"></i> Inbox</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="UIkits-email-message.html"><i class="icon-speech"></i> Message</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="UIkits-email-compose.html"><i class="icon-speech"></i> Compose</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="divider m-2"></li>
          <li class="nav-title">
            Labels
          </li>
          <li class="nav-item hidden-cn">
            <a class="nav-label" href="#"><i class="fa fa-circle text-danger"></i> Label danger</a>
          </li>
          <li class="nav-item hidden-cn">
            <a class="nav-label" href="#"><i class="fa fa-circle text-info"></i> Label info</a>
          </li>
          <li class="nav-item hidden-cn">
            <a class="nav-label" href="#"><i class="fa fa-circle text-warning"></i> Label warning</a>
          </li>
          <li class="divider"></li>
          <li class="nav-title">
            System Utilization
          </li>
          <li class="nav-item px-3 hidden-cn">
            <div class="text-uppercase mb-1">
              <small><b>CPU Usage</b></small>
            </div>
            <div class="progress progress-xs">
              <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">348 Processes. 1/4 Cores.</small>
          </li>
          <li class="nav-item px-3 hidden-cn">
            <div class="text-uppercase mb-1">
              <small><b>Memory Usage</b></small>
            </div>
            <div class="progress progress-xs">
              <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">11444GB/16384MB</small>
          </li>
          <li class="nav-item px-3 hidden-cn">
            <div class="text-uppercase mb-1">
              <small><b>SSD 1 Usage</b></small>
            </div>
            <div class="progress progress-xs">
              <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">243GB/256GB</small>
          </li>

        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>






<!-- <body class="app sidebar-hidden aside-menu-hidden aside-menu-hidden bg-white" style="font-family: Poppins; color: #000;">
  
    <header class="app-header navbar" style='border-bottom: 1px solid #FFF;'>
        
        <div class="container">
            
            <div class="fa fa-bars font-xl" id="menu">
                
            </div>
            
    <a class="navbar-brand" href="<?php echo gpConfig['URLPATH']; ?>account"></a>
    
    <ul class="nav navbar-nav d-md-down-none mr-auto">

      <?php if ( !isset( $_SESSION['SessionIsStarted'] ) ) : ?>
        
           <li class="nav-item px-3">
              <a class="nav-link" href="<?php echo gpConfig['URLPATH']; ?>" style='color: #000;'>Login</a>
            </li>


      
      <?php endif; ?>      
            
      <?php if ( isset( $_SESSION['SessionIsStarted'] ) ) : ?>
      
            <?php if ( !isset( $_SESSION['sess2FALock'] ) ) : ?>
            
                <li class="nav-item px-3 dropdown d-md-down-none">
                  <a class="nav-link font-lg" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style='color: #000;'><i class="fa fa-history"></i> Billing</a>

                  <div class="dropdown-menu dropdown-menu-lg">
                    

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/payment" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-money text-danger" style="color: #d61e31;"></i>Make a payment</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/schedulepymts" class="dropdown-item"style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-calendar-alt text-danger"></i>Schedule payments</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/statements" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-file-pdf text-danger"></i> Past Statements</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/history" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-history text-danger"></i> Online Payment History</div>            
                    </a>



                    <a href="<?php echo gpConfig['URLPATH']; ?>account/cardsonfile" class="dropdown-item"style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-credit-card text-danger"></i>Cards on file</div>            
                    </a>

                  </div>

                </li>

                <li class="nav-item px-3 dropdown d-md-down-none">
                  <a class="nav-link font-lg font-weight-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true" style='color: #000;'><i class="fa fa-television"></i> Services</a>


                  <div class="dropdown-menu dropdown-menu-lg">
                    
                    <a href="<?php echo gpConfig['URLPATH']; ?>account/services" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-truck text-danger"></i>Active Services</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/equipment" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-unlock-alt text-danger"></i> My Equipment</div>            
                    </a>


                    <a href="<?php echo gpConfig['URLPATH']; ?>account/revgovoice" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-phone text-danger"></i> REVGO Voice</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/revgoplay" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-television text-danger"></i> REVGO Play</div>            
                    </a>

                  </div>

                </li>

                <li class="nav-item px-3 dropdown d-md-down-none">
                  <a class="nav-link font-lg" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style='color: #000;'><i class="fa fa-user"></i> Account</a>


                  <div class="dropdown-menu dropdown-menu-lg">
                    
                    <a href="<?php echo gpConfig['URLPATH']; ?>account/changelogin" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-envelope-open-o text-danger"></i>Change my login</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/changepasswd" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-unlock-alt text-danger"></i>Change my password</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/changemobile" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-mobile text-danger"></i> Change my mobile phone</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/communications" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-bullhorn text-danger"></i> Communication settings</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/security" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-question-circle text-danger"></i> Security questions</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/twofactor" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-user-secret text-danger"></i>Two factor authentication</div>            
                    </a>

                    <a href="<?php echo gpConfig['URLPATH']; ?>account/manager" class="dropdown-item" style='color: #000;'>
                      <div class="mb-1"><i class="fa fa-users text-danger"></i>Multiple Account Manager</div>            
                    </a>

                  </div>

                </li>

                <?php if ( isset( $_SESSION['sessAcctParent'] ) AND ( $_SESSION['sessAcctParent'] > 0 ) ) : ?>

                    <li class="nav-item px-3">
                      <a class="nav-link text-dark font-lg font-weight-light" href="<?php echo gpConfig['URLPATH']; ?>auth/primary"><i class="fa fa-refresh"></i> Primary Account</a>
                    </li>  

                <?php endif; ?>
                
            <?php endif; ?>
      
            <li class="nav-item px-3">
              <a class="nav-link text-danger font-lg font-weight-light" style="color: #d61e31;" href="<?php echo gpConfig['URLPATH']; ?>auth/logout"><i class="fa fa-sign-out"></i>Logout</a>
            </li>  
      
      <?php endif; ?>
      
    </ul>
    <ul class="nav navbar-nav ml-auto">
      
    </ul>
    
        </div>
        
    </header>
    
    <div id="menucontainer">
        
        <div class="container">
            
            <?php if ( !isset( $_SESSION['SessionIsStarted'] ) ) : ?>
            
                <ul>
                    <li class="font-lg">
                        <a href="<?php echo gpConfig['URLPATH']; ?>auth/create"><i class="fa fa-user-plus"></i> Create Account</a>
                    </li>

                    <li class="font-lg">
                        <a href="<?php echo gpConfig['URLPATH']; ?>auth/forgotpasswd"><i class="fa fa-question-circle"></i> Forgot Password</a>
                    </li>


                    
                    <li class="font-lg">
                        <a href="<?php echo gpConfig['URLPATH']; ?>"><i class="fa fa-unlock-alt"></i> Login</a>
                    </li>
                </ul>
            
            <?php else: ?>
            
                <div class="row">
                    
                    <div class="col-sm-6">
                        
                        <h5 class="text-white font-weight-bold mt-4">Billing Options</h5>
                        
                        <ul>
                            
                            <li class="font-lg ">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/payment">
                                    <i class="fa fa-money text-danger" style="color: #d61e31;"></i> Make a Payment
                                </a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/schedulepymts">
                                    <i class="fa fa-calendar-alt text-danger" style="color: #d61e31;"></i> Schedule Payments</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/statements">
                                    <i class="fa fa-file-pdf text-danger" style="color: #d61e31;"></i> Past Statements</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/history">
                                    <i class="fa fa-history text-danger" style="color: #d61e31;"></i> Online Payment History</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/cardsonfile">
                                    <i class="fa fa-credit-card text-danger" style="color: #d61e31;"></i> Cards on File</a>
                            </li>

                        </ul>
                        
                        <h5 class="text-white font-weight-bold mt-4">Service Options</h5>
                        
                        <ul>
                            
                            <li class="font-lg ">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/services">
                                    <i class="fa fa-truck text-danger" style="color: #d61e31;"></i> Active Services
                                </a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/equipment">
                                    <i class="fa fa fa-unlock-alt text-danger" style="color: #d61e31;"></i> My Equipment</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/revgovoice">
                                    <i class="fa fa-phone text-danger" style="color: #d61e31;"></i> REVGO Voice</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/revgoplay">
                                    <i class="fa fa-television text-danger" style="color: #d61e31;"></i> REVGO Play</a>
                            </li>
                            
                            
                        </ul>
                        
                    </div>
                    
                    <div class="col-sm-6">
                        
                        <h5 class="text-white font-weight-bold mt-4">Account Settings</h5>
                        <ul>
                            <li class="font-lg ">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/changelogin">
                                    <i class="fa fa-envelope-open-o text-danger" style="color: #d61e31;"></i> Change my login
                                </a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/changepasswd">
                                    <i class="fa fa-unlock-alt text-danger" style="color: #d61e31;"></i> Change my password</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/changemobile">
                                    <i class="fa fa-mobile text-danger" style="color: #d61e31;"></i> Change my mobile</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/communications">
                                    <i class="fa fa-bullhorn text-danger" style="color: #d61e31;"></i> Communication settings</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/security">
                                    <i class="fa fa-question-circle text-danger" style="color: #d61e31;"></i> Security questions</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/twofactor">
                                    <i class="fa fa-user-secret text-danger" style="color: #d61e31;"></i> Two factor authentication</a>
                            </li>
                            
                            <li class="font-lg">
                                <a href="<?php echo gpConfig['URLPATH']; ?>account/manager">
                                    <i class="fa fa-users text-danger" style="color: #d61e31;"></i> Multiple Accounts</a>
                            </li>
                        </ul>
                        
                        <h5 class="text-white font-weight-bold mt-4">Session</h5>
                        <ul>
                            <li class="font-lg ">
                                <a href="<?php echo gpConfig['URLPATH']; ?>auth/logout">
                                    <i class="fa fa-sign-out text-danger"></i> Logout
                                </a>
                            </li>
                            
                        </ul>
                        
                    </div>
                    
                </div>
            
            <?php endif; ?>
            
        </div>
        
        
    </div>
    
  <div class="app-body" id="lift">
      
      <main class="main">

      <div class="container-fluid">

        <div class="animated fadeIn">
       -->
      