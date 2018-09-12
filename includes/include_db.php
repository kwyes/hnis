<?


	$connectionInfo = array( "Database"=>HANNAM_DB_NAME, "UID"=>HANNAM_DB_USERID, "PWD"=>HANNAM_DB_PASSWORD, "CharacterSet" => "UTF-8");
  $conn_hannam =sqlsrv_connect(HANNAM_DB_SERVER, $connectionInfo);

?>
