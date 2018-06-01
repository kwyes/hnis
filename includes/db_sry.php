<?
  define("SRY_DB_SERVER", "172.16.3.77");
  define("SRY_DB_USERID", "");
  define("SRY_PASSWORD", "");
  define("SRY_DB_NAME", "dbgal");

  // Generate connection variable
  $sryinfo = array( "Database"=>SRY_DB_NAME, "UID"=>SRY_DB_USERID, "PWD"=>SRY_PASSWORD);
  $conn_sry = sqlsrv_connect(SRY_DB_SERVER, $sryinfo);
?>
