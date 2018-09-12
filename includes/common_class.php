<?
  function header_submenu($menu){
    if($menu == 'dashboard' || $menu == ''){
      $header_submenu = 'DashBoard';
    } elseif ($menu == 'neworder') {
      $header_submenu = 'New Order';
    } elseif ($menu == 'orderhistory') {
      $header_submenu = 'Order History';
    } elseif ($menu == 'myitem') {
      $header_submenu = 'My Item';
    } elseif ($menu == 'profile') {
      $header_submenu = 'Profile';
    } elseif ($menu == 'newitem') {
      $header_submenu = 'New Item';
    } elseif ($menu == 'neworderitem') {
      $header_submenu = 'New Order Item';
    } elseif ($menu == 'receivedorder') {
      $header_submenu = 'Received Order';
    } elseif ($menu == 'adminorderitem') {
      $header_submenu = 'Admin Order Item';
    } elseif ($menu == 'register_myitem'){
      $header_submenu = 'Register Item';
    } elseif ($menu == 'marketItem'){
      $header_submenu = 'Market Item';
    } elseif ($menu == 'vendorlist'){
      $header_submenu = 'Vendor List';
    } elseif ($menu == 'autho'){
      $header_submenu = 'Authorize';
    } elseif ($menu == 'adjust'){
      $header_submenu = 'Adjust';
    } elseif ($menu == 'confirmed'){
      $header_submenu = 'Confirmed';
    }
    return $header_submenu;
  }

  function Br_dconv($string) {
  	$quote = array("\'", '\"');
  	$replace_quote = array("''", '"');
  	$string = str_replace($quote, $replace_quote, $string);

      if($string) {
          // $string = iconv('utf-8', 'euc-kr', $string);
          $string = iconv('utf-8', 'utf-8', $string);
          return $string;
      } else {
          return false;
      }
  }

  function Br_iconv($string) {
      if($string == " ") {
          return "";
      } else if($string) {
          // $string = iconv('euc-kr', 'utf-8', $string);
          $string = iconv('utf-8', 'utf-8', $string);
          return $string;
      } else {
          return false;
      }
  }

  function dconv_addslash($context){
    $context = Br_dconv($context);
    $context = addslashes($context);
    return $context;
  }

  function iconv_stripslash($context){
    $context = Br_iconv($context);
    $context = stripslashes($context);
    return $context;
  }

  function get_Company_CID($adminCompany){
    switch ($adminCompany) {
      case 'BBY':
        $CID_Admin = '1';
      break;

      case 'SRY':
        $CID_Admin = '2';
      break;

      case 'DT':
        $CID_Admin = '3';
      break;

      case 'NV':
        $CID_Admin = '4';
      break;

      case 'ALL':
        $CID_Admin = '5';
      break;
    }
    return $CID_Admin;
  }

  function get_tStatus_text($tStatus){
    switch ($tStatus) {
      case '1':
        $tStatus_text = 'SAVED';
      break;

      case '2':
        $tStatus_text = 'UPDATED';
      break;

      case '3':
        $tStatus_text = 'SUBMITTED';
      break;

      case '4':
        $tStatus_text = 'CONFIRMED';
      break;

      case '5':
        $tStatus_text = 'COMPLETED';
      break;
    }
    return $tStatus_text;
  }
?>
