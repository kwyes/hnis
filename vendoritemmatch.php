<?
  include_once('includes/include_db.php');
  include_once('includes/db_dt.php');

  $query = "SELECT * FROM Hnis_Vendor_Item WHERE VendorID = '10001' and chkYN != 'Y' ";
  $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED));
  while ($row = sqlsrv_fetch_array($query_result)) {
    $barcode = $row['Barcode'];
    if($barcode !== '') {
      $findquery = "SELECT GalCode, ProdOwnCode FROM mfProd WHERE prodId = '$barcode'";
      $findquery_result = sqlsrv_query($conn_dt, $findquery, array(), array("scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED));
      $findrow = sqlsrv_fetch_array($findquery_result);
      $galcode = $findrow['GalCode'];
      $prodowncode = $findrow['ProdOwnCode'];
      if($galcode !== '' && $prodowncode !== '')  {
        $update_query = "UPDATE Hnis_Vendor_Item SET GalCode = '$galcode', ProdOwnCode = '$prodowncode', chkYN = 'Y' WHERE Barcode = '$barcode' AND VendorID = '10001'";
      }
      // sqlsrv_query($conn_hannam, $update_query);
      echo $update_query."<br />";
    }
  }

?>
