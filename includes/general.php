<?php
//    session_save_path("../session_temp");
    session_start();
    define("SYSTEM_PATH","..");
    define("ABSOLUTE_PATH", "https://www.test.com/hnis");
    putenv("TZ=America/Vancouver");
    $today = date("Y-m-d H:i:s");

    $mode = $_POST['mode'];
	  include_once "include_db.php";
    // include_once "function.php";
    include_once "common_class.php";
?>
