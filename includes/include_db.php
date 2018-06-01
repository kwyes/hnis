<?

	define("HANNAM_DB_SERVER", "");
	define("HANNAM_DB_USERID", "");
	define("HANNAM_DB_PASSWORD", "");
	define("HANNAM_DB_NAME", "HannamDB");

	$connectionInfo = array( "Database"=>HANNAM_DB_NAME, "UID"=>HANNAM_DB_USERID, "PWD"=>HANNAM_DB_PASSWORD);
  $conn_hannam =sqlsrv_connect(HANNAM_DB_SERVER, $connectionInfo);

?>
