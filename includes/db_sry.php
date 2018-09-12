<?

  $sryinfo = array( "Database"=>SRY_DB_NAME, "UID"=>SRY_DB_USERID, "PWD"=>SRY_PASSWORD, "CharacterSet" => "UTF-8");
  $conn_sry = sqlsrv_connect(SRY_DB_SERVER, $sryinfo);
?>
