<?
  include_once('includes/include_db.php');
  // include_once('includes/db_dt.php');

  $query = "SELECT * FROM trOrderDetail WHERE tCust = '10001' AND tGalcode = '' ";
  $i = 0;
  $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED));
  while ($row = sqlsrv_fetch_array($query_result)) {
    $vcode = $row['VendorCode'];
    $findQuery = "SELECT *  FROM Hnis_Vendor_Item WHERE VendorCode = '$vcode'";
    $findQuery_result = sqlsrv_query($conn_hannam, $findQuery, array(), array("scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED));
    $frow = sqlsrv_fetch_array($findQuery_result);
    $galcode = $frow['GalCode'];
    $prodowncode = $frow['ProdOwnCode'];
    $tProd = $frow['Barcode'];
    $newquery = "UPDATE trOrderDetail SET tGalcode = '$galcode', tProdOwnCode = '$prodowncode', tProd = '$tProd' WHERE VendorCode = '$vcode'";
    echo $newquery."<br />";
  }
  // echo $i;

?>
