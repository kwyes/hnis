<?


// Generate connection variable
$bbyinfo = array( "Database"=>BBY_DB_NAME, "UID"=>BBY_DB_USERID, "PWD"=>BBY_PASSWORD, "CharacterSet" => "UTF-8");
$conn_bby = sqlsrv_connect(BBY_DB_SERVER, $bbyinfo);
?>
