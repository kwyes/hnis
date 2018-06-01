<?
define("BBY_DB_SERVER", "172.16.3.60");
define("BBY_DB_USERID", "");
define("BBY_PASSWORD", "");
define("BBY_DB_NAME", "dbgal");

// Generate connection variable
$bbyinfo = array( "Database"=>BBY_DB_NAME, "UID"=>BBY_DB_USERID, "PWD"=>BBY_PASSWORD);
$conn_bby = sqlsrv_connect(BBY_DB_SERVER, $bbyinfo);
?>
