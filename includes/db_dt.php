<?
define("DT_DB_SERVER", "172.16.3.60");
define("DT_DB_USERID", "");
define("DT_PASSWORD", "");
define("DT_DB_NAME", "dbgal");

// Generate connection variable
$dtinfo = array( "Database"=>DT_DB_NAME, "UID"=>DT_DB_USERID, "PWD"=>DT_PASSWORD);
$conn_dt = sqlsrv_connect(DT_DB_SERVER, $dtinfo);
?>
