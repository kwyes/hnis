<?

  $dtinfo = array( "Database"=>DT_DB_NAME, "UID"=>DT_DB_USERID, "PWD"=>DT_PASSWORD, "CharacterSet" => "UTF-8");
  $conn_dt = sqlsrv_connect(DT_DB_SERVER, $dtinfo);
?>
