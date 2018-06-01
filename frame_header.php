<?
  $menu = ($_GET['menu']) ? $_GET['menu'] : $_POST['menu'];
  $level = $_SESSION['hnisLevel'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#2e353d" />
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#2e353d">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#2e353d">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#2e353d">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="js/right_content.js?ver=6"></script>
    <script src="js/common_function.js?ver=2"></script>
    <link href="css/left_menu.css?ver=1" rel="stylesheet">
    <link href="css/header.css?ver=5" rel="stylesheet">
    <link href="css/loader.css?ver=1" rel="stylesheet">
    <link href="css/dashboard.css?ver=4" rel="stylesheet">
    <!-- <link href="css/icon/font/flaticon.css?ver=1" rel="stylesheet"> -->
    <link href="css/icon/font/flaticon.css?ver=1" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" /> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>HNIS</title>
  </head>
