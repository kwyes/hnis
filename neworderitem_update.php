<?
// error_reporting(E_ALL ^ E_NOTICE);
include_once('includes/include_db.php');
include_once('includes/common_class.php');

/*** Function for Update ***/
function order_delete($OrdNo, $cId) {
  global $conn_hannam;
  $delOrder_query = "DELETE FROM trOrderDetail ".
            "WHERE tOrdNo = '$OrdNo' AND CID = '$cId' ";
  $od_rst = sqlsrv_query($conn_hannam, $delOrder_query);


  $delOrder_query = "DELETE FROM trOrderMaster ".
            "WHERE tOrdNo = '$OrdNo' AND CID = '$cId' ";
  $om_rst = sqlsrv_query($conn_hannam, $delOrder_query);

}

function order_submit($OrdNo, $cId){
  global $conn_hannam;
  $subOrder_query = "UPDATE trOrderMaster SET tStatus = '3' ".
            "WHERE tOrdNo = '$OrdNo' AND CID = '$cId' ";
  $od_rst = sqlsrv_query($conn_hannam, $subOrder_query);

}
/*** Function for Update ***/
/*** Post Data **/
$err = new Exception('DB 실행에 문제가 있습니다. 관리자에게 문의 바랍니다.');
$mode = ($_GET['mode']) ? $_GET['mode'] : $_POST['mode'];
$tCust = $_SESSION['hnisVendorID'];
$item_num = ($_GET['item_num']) ? $_GET['item_num'] : $_POST['item_num'];
$deliveryDate = ($_GET['deliveryDate']) ? $_GET['deliveryDate'] : $_POST['deliveryDate'];
$CustomerPO = ($_GET['customerPO']) ? $_GET['customerPO'] : $_POST['customerPO'];
$main_memo = ($_GET['main_memo']) ? $_GET['main_memo'] : $_POST['main_memo'];
$main_department = ($_GET['main_department']) ? $_GET['main_department'] : $_POST['main_department'];

$order_ename = ($_GET['order_ename']) ? $_GET['order_ename'] : $_POST['order_ename'];
$order_kname = ($_GET['order_kname']) ? $_GET['order_kname'] : $_POST['order_kname'];
$order_vendor = ($_GET['order_vendor']) ? $_GET['order_vendor'] : $_POST['order_vendor'];
$order_barcode = ($_GET['order_barcode']) ? $_GET['order_barcode'] : $_POST['order_barcode'];
$order_galcode = ($_GET['order_galcode']) ? $_GET['order_galcode'] : $_POST['order_galcode'];
$order_prodowncode = ($_GET['order_prodowncode']) ? $_GET['order_prodowncode'] : $_POST['order_prodowncode'];
$order_price = ($_GET['order_price']) ? $_GET['order_price'] : $_POST['order_price'];
$order_qty = ($_GET['order_qty']) ? $_GET['order_qty'] : $_POST['order_qty'];
$order_size = ($_GET['order_size']) ? $_GET['order_size'] : $_POST['order_size'];
$order_unit = ($_GET['order_unit']) ? $_GET['order_unit'] : $_POST['order_unit'];
$order_memo = ($_GET['order_memo']) ? $_GET['order_memo'] : $_POST['order_memo'];
// $order_memo = addslashes($order_memo);
$branchID = ($_GET['branchID']) ? $_GET['branchID'] : $_POST['branchID'];

if($branchID == 'bby'){
  $CID = '1';
  $branch = 'bby';
} elseif ($branchID == 'sry') {
  $CID = '2';
  $branch = 'sry';
} elseif ($branchID == 'dt') {
  $CID = '3';
  $branch = 'dt';
}

$delivery_date = ($_GET['delivery_date']) ? $_GET['delivery_date'] : $_POST['delivery_date'];
/*** Post Data **/
$tDate = date("Y-m-d");
if($mode == "submit") {
	$tOrdNo = ($_GET['order_no']) ? $_GET['order_no'] : $_POST['order_no'];

	order_submit($tOrdNo, $CID);

	if($mode == "submit")
	{
		echo("<script>location.replace('https://www.hannamsm.com/hnis/?page=frame&menu=dashboard');</script>");
		return;
	}
}

if($mode == "delete" || $mode == "modify") {
	$tOrdNo = ($_GET['order_no']) ? $_GET['order_no'] : $_POST['order_no'];

	order_delete($tOrdNo, $CID);

	if($mode == "delete")
	{
		echo("<script>location.replace('https://www.hannamsm.com/hnis/?page=frame&menu=dashboard');</script>");
		return;
	}
}
$tOrdNo = "";
$item_num = intval($item_num);

for($i = 1; $i <= $item_num; $i++) {


	$tQty = $order_qty[$item_num - $i];
	$tOUprice = $order_price[$item_num - $i];
  $ProdEname = $order_ename[$item_num - $i];
	$ProdKname = $order_kname[$item_num - $i];
  $VendorCode = $order_vendor[$item_num - $i];
	$tProd = $order_barcode[$item_num - $i];
  $tGalCode = $order_galcode[$item_num - $i];
  $tProdOwnCode = $order_prodowncode[$item_num - $i];
  $tSize = $order_size[$item_num - $i];
	$tUnit = $order_unit[$item_num - $i];
  $tMemo = $order_memo[$item_num - $i];
  $tMemo = addslashes($tMemo);
	$tAmt = ($tQty * $tOUprice);
	$tGst = 0;
	$tPst = 0;
	$tTime = date("H:i:s");

	$total_Amt = $total_Amt + $tAmt + $tGst + $tPst;

	if($mode == "add") {
		// get OrdNo
		try{
    	if(!$tOrdNo) {
        //		begin();
    		$Query = "SELECT OrNo FROM mOrdNo WHERE OrDate = '".date("Y-m-d")."' ";
    			 if(!$rst = sqlsrv_query($conn_hannam, $Query, array(), array("scrollable" => 'keyset'))) throw $err;
    		      $num_row = sqlsrv_num_rows($rst);

    		     if($num_row != 0)
    		      {
    				        $row = sqlsrv_fetch_array($rst);
    				        $sOrdNo = $row['OrNo'] + 1;
    				        $tOrdNo = date("ymd").sprintf("%02d", $sOrdNo);
    				        $Query = "UPDATE mOrdNo SET OrNo='$sOrdNo' WHERE OrDate = '".date("Y-m-d")."' ";
    				        if(!$rst = sqlsrv_query($conn_hannam,$Query)) throw $err;
    			     }
    			  else
    			  {
    		        $Query = "INSERT INTO mOrdNo VALUES ('".date("Y-m-d")."', 1)";
    		        if(!$rst = sqlsrv_query($conn_hannam,$Query)) throw $err;
    		        $tOrdNo = date("ymd")."01";

    		    }
            // echo $Query;
    //		commit();
    	}

    		$addOrder_query = "INSERT INTO trOrderDetail (CID, tID, tProd, tDate, tQty, tOUPrice, tAmt, tOrdNo, tCust, tTime, tPunit, tDeliveryDate, tSize, tMemo, ProdEname, ProdKname, VendorCode, tGalCode, tProdOwnCode) ".
    						  "VALUES ('$CID', $i, '$tProd', '$tDate', ".$tQty.", ".$tOUprice.", $tAmt, '$tOrdNo', '$tCust', '$tTime', '$tUnit', '$deliveryDate','$tSize','".Br_dconv($tMemo)."', '".$ProdEname."', '".Br_dconv($ProdKname)."', '".Br_dconv($VendorCode)."', '".$tGalCode."', '".$tProdOwnCode."') ";
    		sqlsrv_query($conn_hannam,$addOrder_query);
        // echo $addOrder_query."<br />";
		}
		catch(Exception $e){
			echo $e->getMessage();
		}

	}
	if($mode == "modify") {
		$tOrdNo = ($_GET['order_no']) ? $_GET['order_no'] : $_POST['order_no'];

		$modOrder_query = "INSERT INTO trOrderDetail (CID, tID, tProd, tDate, tQty, tOUPrice, tAmt, tOrdNo, tCust, tTime, tPunit, tDeliveryDate, tSize, tMemo, ProdEname, ProdKname, VendorCode, tGalCode, tProdOwnCode) ".
						  "VALUES ('$CID', $i, '$tProd', '$tDate', ".$tQty.", ".$tOUprice.", $tAmt, '$tOrdNo', '$tCust', '$tTime', '$tUnit', '$deliveryDate','$tSize','".Br_dconv($tMemo)."', '".$ProdEname."', '".Br_dconv($ProdKname)."', '".Br_dconv($VendorCode)."', '".$tGalCode."', '".$tProdOwnCode."') ";
		sqlsrv_query($conn_hannam,$modOrder_query);
		// echo $modOrder_query."<br>";
	}

	$Insert_Record = "YES";
}

if ($Insert_Record) {
  // if($mode == 'add'){
  //
  // } elseif (condition) {
  //   # code...
  // }
  $tStatus = '1';
	// $orderMemo=Br_dconv($orderMemo);
  $CustomerPO = Br_dconv($CustomerPO);
  $main_memo = Br_dconv($main_memo);
	$master_query = "INSERT INTO trOrderMaster (CID,tOrdNo,tDate, tAMT, tCust, tDeliveryDate,tStatus,CustomerPO,tMemo,Department) ".
				  "VALUES ('$CID', '$tOrdNo', '$tDate', $total_Amt, '$tCust', '$deliveryDate', '$tStatus', '$CustomerPO', '$main_memo', '$main_department') ";
  // echo $query;
	sqlsrv_query($conn_hannam,$master_query);
}

if($mode == "add") {
		echo("<script>
			alert('완료되었습니다.');
			location.replace('?page=frame&menu=orderhistory');
		</script>");
} else {
  // echo("<script>alert($CID)</script>");
	echo("<script>location.replace('?page=frame&menu=neworderitem&branch=$branch&order_no=$tOrdNo');</script>");

}
?>
