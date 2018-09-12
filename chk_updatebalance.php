<?
  include_once('includes/db_dt.php');
  include_once('includes/include_db.php');
  // header( "Content-type: application/vnd.ms-excel" );
  // header( "Content-type: application/vnd.ms-excel; charset=utf-8");
  // header( "Content-Disposition: attachment; filename = 'test.xls'" );
  // header( "Content-Description: PHP4 Generated Data" );
  function get_balance($tProd){
    global $conn_dt;
    $query = "SELECT prodBal FROM [dbgal].[dbo].[mfProd] WHERE prodId = '$tProd'";
    $query_result = sqlsrv_query($conn_dt, $query);
    $row = sqlsrv_fetch_array($query_result);
    return $row['prodBal'];
  }
  function get_sales($tProd){
    global $conn_dt;
    $query2 = "SELECT SUM(tQty) as total FROM ( SELECT tQty FROM [db1gal].[dbo].[tfTran2] where tProd = '$tProd' UNION ALL SELECT tQty FROM [db1gal].[dbo].[tfTran1] where tProd = '$tProd') q";
    $query_result2 = sqlsrv_query($conn_dt, $query2);
    $row = sqlsrv_fetch_array($query_result2);
    return $row['total'];
  }
  $query = "SELECT t.tProd,sum(t.Qty) as q, COUNT(t.tProd) AS count FROM [HannamDB].[dbo].[trHnisUpdateBalance] as t GROUP BY t.tProd ";
  $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED));
  $row_num = sqlsrv_num_rows($query_result);
  $tr = '';
  $i = 1;
  if($row_num > 0){
    while($row = sqlsrv_fetch_array($query_result)){
      $tProd = $row['tProd'];
      $count = get_sales($tProd);
      $tQty = $row['q'];
      // $kName = @iconv($row['ProdKname'], 'euc-kr','utf-8');
      // $kName2 = $row['ProdKname'];
      // $eName = $row['ProdEname'];
      $realqty = get_balance($tProd);
      $minus = $tQty - $count;
      $tr .= "<tr>
      <td>
      $i
      </td>
      <td>
      $tProd
      </td>
      <td>
      $tQty
      </td>
      <td>
      $realqty
      </td>
      <td>
      $count
      </td>
      <td>
      $minus
      </td>
      </tr>";
      $i++;
    }
  }

  $table = "<table border = '1'>
  <th>
  SEQ
  </th>
  <th>
  Barcode
  </th>
  <th>
  Input
  </th>
  <th>
  Real Bal
  </th>
  <th>
  Sales
  </th>
  <th>
  Minus
  </th>
  <tbody>
  $tr
  </tbody>
  </table>";
  echo $table;

?>
