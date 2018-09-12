<?
  include_once("frame_header.php");
  $level = $_SESSION['hnisLevel'];
  $adminYN = $_SESSION['hnisAdminYN'];
?>
<div class="col-md-1 padding_zero sm-width">
<div class="nav-side-menu">
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
      <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
          <li>
            <a href="?page=frame&menu=dashboard">
            <img class="leftmenu_logo" src="images/left1.png" alt="">

            </a>
          </li>
          <li>
            <a href="?page=frame&menu=dashboard">
            <i class="flaticon-dashboard"></i>
            <div class="leftmenu_text">
              Dashboard
            </div>
            </a>
          </li>
          <!-- <li data-toggle="collapse" data-target="#new" class="collapsed">
            <a href="?page=frame&menu=newitem"><i class="fa fa-laptop fa-lg"></i> New Item</a>
          </li> -->
          <? if($adminYN !== 'Y'){ ?>
          <li class="collapsed">
            <a href="?page=frame&menu=register_myitem">
              <i class="flaticon-clipboard-with-pencil"></i>
              <div class="leftmenu_text">
                Register
              </div>
            </a>
          </li>

          <li class="collapsed">
            <a href="?page=frame&menu=myitem">
              <i class="flaticon-full-items-inside-a-shopping-bag"></i>
              <div class="leftmenu_text">
                My Item
              </div>
            </a>
          </li>

          <li class="collapsed">
            <a href="?page=frame&menu=neworder">
              <i class="flaticon-dish"></i>
              <div class="leftmenu_text">
                New Order
              </div>
            </a>
          </li>

          <li class="collapsed">
            <a href="?page=frame&menu=orderhistory">
              <i class="flaticon-clock"></i>
              <div class="leftmenu_text">
                History
              </div>
            </a>
          </li>
        <? } ?>
          <? if($adminYN == 'Y') { ?> <!-- admnn  --->

            <li class="collapsed">
              <a href="?page=frame&menu=autho">
                <i class="flaticon-police-card"></i>
                <div class="leftmenu_text">
                  Autho
                </div>
              </a>
            </li>

            <li class="collapsed">
              <a href="?page=frame&menu=vendorlist">
                <i class="flaticon-note"></i>
                <div class="leftmenu_text">
                  Vendor List
                </div>
              </a>
            </li>

            <li class="collapsed">
              <a href="?page=frame&menu=marketItem">
                <i class="flaticon-full-items-inside-a-shopping-bag"></i>
                <div class="leftmenu_text">
                  Market Item
                </div>
              </a>
            </li>

            <li class="collapsed">
              <a href="?page=frame&menu=adminorderitem">
                <i class="flaticon-dish"></i>
                <div class="leftmenu_text">
                  New Order
                </div>
              </a>
            </li>

            <li class="collapsed">
              <a href="?page=frame&menu=receivedorder">
                <i class="flaticon-clock"></i>
                <div class="leftmenu_text">
                  Received
                </div>
              </a>
            </li>

            <li class="collapsed">
              <a href="?page=frame&menu=adjust">
                <i class="flaticon-interface"></i>
                <div class="leftmenu_text">
                  Adjust
                </div>
              </a>
            </li>
            <? if($level > 2) { ?>
            <li class="collapsed">
              <a href="?page=frame&menu=confirmed">
                <i class="flaticon-stamp"></i>
                <div class="leftmenu_text">
                  Confirmed
                </div>
              </a>
            </li>
            <li class="collapsed">
              <a href="?page=frame&menu=checked">
                <i class="flaticon-stamp"></i>
                <div class="leftmenu_text">
                  Checked
                </div>
              </a>
            </li>
          <?  }   ?>

          <?  } else { ?>

          <? } ?>
        </ul>
     </div>
</div>
</div>

<? include_once("frame_footer.php"); ?>
