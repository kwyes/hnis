<?
  $adminYN = $_SESSION['hnisAdminYN'];
  if($adminYN == 'Y'){
    $nav_header_class = 'admin_header_color';
  } else {
    $nav_header_class = 'header_color';
  }
?>
<body>
  <div class="col-md-11 padding_zero sm-long-width">
    <nav class="navbar navbar-inverse navbar-static-top margin_bottom_zero custom_navbar <?=$nav_header_class?>">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand custom_navbar_brand" href="/hnis" id="logo">
              <img src="images/top.png" alt="">
            </a>
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navHeaderCollapse">

          <ul class="nav navbar-nav navbar-right custom_nav">
            <!-- <div class="sm-dropdown-reverse"> -->
              <li class="dropdown sm-dropdown-reverse">
                <a href="#" class="dropdown-toggle custom_a" data-toggle="dropdown">
                  <i class="flaticon-user"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li class="active"><a href="?page=frame&menu=dashboard">Home<span style="font-size:16px; margin-left: 10px;" class="pull-right hidden-xs showopacity"></span></a></li>
                  <li><a href="?page=frame&menu=profile">Profile</a></li>
                  <li><a href="?page=logout">Sign Out</a></li>
                </ul>
              </li>
            <!-- </div> -->
              <!-- <div class="sm-dropdown"> -->
                <li class="sm-dropdown"><a href="?page=frame&menu=dashboard">Home<span style="font-size:16px; margin-left: 10px;" class="pull-right hidden-xs showopacity"></span></a></li>
                <li class="sm-dropdown"><a href="?page=frame&menu=profile">Profile</a></li>
                <li class="dropdown sm-dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Orders <span style="padding-left:10px;" class="pull-right hidden-xs showopacity"></span><span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                      <a href="?page=frame&menu=dashboard">
                      <!-- <i class="fa fa-dashboard fa-lg"></i>&nbsp;&nbsp; -->
                      Dashboard</a>
                    </li>

                    <!-- <li data-toggle="collapse" data-target="#new" class="collapsed">
                      <a href="?page=frame&menu=newitem"><i class="fa fa-laptop fa-lg"></i> New Item</a>
                    </li> -->


                    <? if($level > 1) { ?>
                      <li class="collapsed">
                        <a href="?page=frame&menu=marketItem">
                            Market Item
                        </a>
                      </li>
                      <li class="collapsed">
                        <a href="?page=frame&menu=adminorderitem">
                          <!-- <i class="fa fa-gift fa-lg"></i>&nbsp;&nbsp; -->
                          New Order </a>
                      </li>
                      <li class="collapsed">
                        <a href="?page=frame&menu=receivedorder">
                          <!-- <i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp; -->
                          Received Order</a>
                      </li>
                    <?  } else { ?>
                      <li class="collapsed">
                        <a href="?page=frame&menu=register_myitem">
                          <!-- <i class="fa fa-car fa-lg"></i>&nbsp;&nbsp; -->
                          Register</a>
                      </li>

                      <li class="collapsed">
                        <a href="?page=frame&menu=myitem">
                          <!-- <i class="fa fa-car fa-lg"></i>&nbsp;&nbsp; -->
                          My Item</a>
                      </li>

                      <li class="collapsed">
                        <a href="?page=frame&menu=neworder">
                          <!-- <i class="fa fa-gift fa-lg"></i>&nbsp;&nbsp; -->
                          New Order </a>
                      </li>
                      <li class="collapsed">
                        <a href="?page=frame&menu=orderhistory">
                          <!-- <i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp; -->
                          History</a>
                      </li>
                    <? } ?>

                  </ul>
                  <li class="sm-dropdown"><a href="?page=logout">Sign Out</a></li>

                </li>
              <!-- </div> -->
          </ul>

      </div>
      <div class="company-header hidden-xs">
        <span><?=$_SESSION['hnisCompanyName']?></span>
      </div>
      <!-- <div class="pull-right"><span>Westview Investment</span></div> -->
    </div>
    </nav>
    <div>
      <div class="well well-sm margin_bottom_zero" style="background-color: #e9ebec;font-weight:bold;">
        <span style="color:#337ab7;">HOME</span> / <?=header_submenu($menu)?>
      </div>
    </div>
  </div>
  <div class="sm-width">

  </div>
