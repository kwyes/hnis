<?
error_reporting(E_ALL ^ E_NOTICE);
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
		$redirect = 'https://' . $surl . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $redirect);
		exit();
}
$page = ($_GET['page']) ? $_GET['page'] : $_POST['page'];
$menu = ($_GET['menu']) ? $_GET['menu'] : $_POST['menu'];
$sub = ($_GET['sub']) ? $_GET['sub'] : $_POST['sub'];
$url = $_SERVER['REQUEST_URI'];
$adminYN = $_SESSION['hnisAdminYN'];

include_once "includes/setup.php";
if(!isset($_SESSION['hnisID'])) {
	if($page == "login_registration") {
		include_once "register.php";
	} else {
		include_once "login.php";
	}
} else if(isset($_SESSION['hnisID'])) {
	include_once "frame_header.php";
	switch($page) {
		default : {
			include_once "error.php";
			break;
		}
		case "login" : {
			include_once "login.php";
			break;
		}
		case "logout" : {
			include_once 'logout.php';
			break;
		}
		case "":
		case "frame" : {
			include_once 'left_menu.php';
			include_once 'frame.php';

			switch($menu) {
				default : {
					if($adminYN == 'Y'){
						include_once 'admin_dashboard.php';
					}
					else {
						include_once 'dashboard.php';
					}
					break;
				}
				case "dashboard" : {
					if($adminYN == 'Y'){
						include_once 'admin_dashboard.php';
					}
					else {
						include_once 'dashboard.php';
					}
					break;
				}
				case "neworder" : {
					include_once 'neworder.php';
					break;
				}
				case "neworderitem" : {
					include_once 'neworderitem.php';
					break;
				}
				case "adminorderitem" : {
					include_once 'adminOrderitem.php';
					break;
				}
				case "adminorderitemupdate" : {
					include_once 'adminOrderitem_update.php';
					break;
				}
				case "neworderupdate" : {
					include_once 'neworderitem_update.php';
					break;
				}
				case "orderhistory" : {
					include_once 'orderhistory.php';
					break;
				}
				case "register_myitem" : {
					include_once 'register_myitem.php';
					break;
				}
				case "myitem" : {
					include_once 'myitem.php';
					break;
				}
				case "profile" : {
					include_once 'profile.php';
					break;
				}

				case "newitem" : {
					include_once 'newitem.php';
					break;
				}

				case "receivedorder" : {
					include_once 'receivedorder.php';
					break;
				}

				case "vendorItem" : {
					include_once 'vditem.php';
					break;
				}

				case "marketItem" : {
					include_once 'mkmyitem.php';
					break;
				}

				case "vendorlist" : {
					include_once 'vendorlist.php';
					break;
				}

				case "autho" : {
					include_once 'autho.php';
					break;
				}

				case "adjust" : {
					include_once 'adjust.php';
					break;
				}

				case "adjustupdate" : {
					include_once 'adjustupdate.php';
					break;
				}

				case "confirmed" : {
					include_once 'confirmed.php';
					break;
				}

				case "checked" : {
					include_once 'check.php';
					break;
				}

			}
			break;
		}
	}
	include_once "frame_footer.php";
}
?>
