<?
  include_once("includes/include_db.php");
  $branch = $_GET['branch'];
  if($branch == 'bby'){
    $company = 'HANNAM SUPERMARKET BURNABY';
    $location = 'BURNABY';
  } elseif ($branch == 'sry') {
    $company = 'HANNAM SUPERMARKET SURREY';
    $location = 'SURREY';
  } else {
    $company = 'HANNAM SUPERMARKET DOWNTOWN';
    $location = 'DOWNTOWN';
  }

  $orderNo = ($_GET['order_no']) ? $_GET['order_no'] : $_POST['order_no'];
  // $deliveryDate = Br_dconv($_POST["tDeliveryDate"]);
  $tOrderMaster_query = "SELECT *, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate, CONVERT(char(10), tDate, 126) AS tDate FROM trOrderMaster WHERE tOrdNo = '$orderNo'";
  $tOrderMaster_query_result = sqlsrv_query($conn_hannam, $tOrderMaster_query);
  $tM_row = sqlsrv_fetch_array($tOrderMaster_query_result);
  $deliveryDate = $tM_row['tDeliveryDate'];
  if($deliveryDate == "") $deliveryDate = date("Y-m-d", strtotime('tomorrow'));

  $CustomerPO = Br_iconv($tM_row['CustomerPO']);
  $tMemo = Br_iconv($tM_row['tMemo']);
  if(!$orderNo){
    $order_date = date("Y-m-d");
    $total_Amt = "0.00";
  } else {
    $order_date = $tM_row['tDate'];
    $total_Amt = number_format($tM_row['tAMT'],2);
  }
?>
<link rel="stylesheet" href="css/neworder.css?ver=6">
<form name="order_sheet" action="?page=frame&menu=neworderupdate" method="POST" accept-charset="utf-8">
<div class="col-md-11 md-long-width padding_zero">
  <div id="search">
      <div class="master_order_form">
        <table class="table order_information table-borderless">
          <tr height="36px" style="background-color:#DCDDDE;color:#666666;font-weight:bold;">
            <td width="60px" rowspan="2" style="vertical-align:bottom;background-color:#E63946;color:white;font-weight:bolder;font-size:20px;">BBY</td>
            <td style="width:5%;text-align:center;white-space:nowrap">Order No</td>
            <td><input type="text" class="form-control" id="orderNum" name="orderNum" value="<?=$orderNo?>" readonly/></td>
            <td style="text-align:center;white-space:nowrap">Order Date</td>
            <td><input type="text" class="form-control" id="orderDate" name="orderDate" value="<?=$order_date?>" readonly/></td>
            <td style="text-align:center;white-space:nowrap">Delivery Date</td>
            <td><input type="text" class="form-control" id="deliveryDate" name="deliveryDate" value="<?=$deliveryDate?>"/></td>
            <td style="text-align:center;vertical-align:middle;background-color:#666666;color:white;" colspan="2" rowspan="2">
              <span class="neworder_total_text">Total Amount</span> $<span class="neworder_total_num"><?=$total_Amt?></span>
            </td>
          </tr>
          <tr height="25px;" style="background-color:#B3B3B3;color:#666666;font-weight:bold;">
            <td style="text-align:center;">Memo</td>
            <td colspan="5">
              <input type="text" class="form-control" id="main_memo" name="main_memo" value="<?=$tMemo?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
			<div class="col-lg-4">
				<div class="panel panel-primary">
					<div class="panel-heading" style="margin-left:-1px;">
						<h3 class="panel-title">Search Item</h3>
						<div class="pull-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-filter"></i>
							</span>
						</div>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#neworder_myitem_table" placeholder="Filter Developers" />
					</div>
					<table class="table table-hover customtable" id="neworder_myitem_table">
						<thead class="customtable_thead">
							<tr class="customtable_tr">
                <th width="15%">V.Code</th>
								<th>B.code</th>
								<th>Name</th>
								<th width="14%">Size</th>
							</tr>
						</thead>
						<tbody id="neworder_myitem_tbody" class="customtable_tbody">
              <div id="loader">
              	<div class="dot"></div>
          			<div class="dot"></div>
          			<div class="dot"></div>
          			<div class="dot"></div>
          			<div class="dot"></div>
          			<div class="dot"></div>
          			<div class="dot"></div>
          			<div class="dot"></div>
          			<div class="lading"></div>
          		</div>
						</tbody>
					</table>
          <script>
            $(document).ready(function(){
              fetch_neworder_myitem();
              var trlength = $('#neworder_item_tbody tr').length;
            });
          </script>
				</div>
			</div>
			<div class="col-lg-8">
          <input type="hidden" name="mode">
          <input type="hidden" name="order_no" value="<?=$orderNo?>">
          <input type="hidden" name="item_num" id = "item_num" value="0">
          <input type="hidden" name="CID" value="<?=$branch?>">
          <input type="hidden" name="orderNo" value="<?=$orderNo?>">
          <input type="hidden" name="credit" id="credit" value="<?=$creditValue?>">
  				<div class="panel panel-success">
  					<div class="panel-heading">
  						<h3 class="panel-title">My Order</h3>
  						<div class="pull-right">
  							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
  								<i class="glyphicon glyphicon-filter"></i>
  							</span>
  						</div>
              <? if(isset($orderNo)){ ?>
              <div class="floatright" id="neworder_delete">
                <button type="button" name="button" onClick="proceed_submit('delete')" class="form-control">DELETE</button>
              </div>
              <div class="floatright" id="neworder_modify">
                <button type="button" name="button" onClick="proceed_submit('modify')" class="form-control">MODIFY</button>
              </div>
              <? } else { ?>
              <div class="floatright" id="neworder_save">
                <button type="button" name="button" onClick="proceed_submit('add')" class="form-control">SAVE</button>
              </div>
              <? } ?>
  					</div>
  					<div class="panel-body">
  						<input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#neworder_item_table" placeholder="Filter Tasks" />
  					</div>
  					<table class="table table-bordered ordertable" id="neworder_item_table">
  						<thead class="ordertable_thead">
  							<tr>
  								<th width="105px">CODE</th>
  								<th width="100px">BARCODE</th>
  								<th>ITEM NAME</th>
  								<th width="100px">SIZE</th>
                  <th width="75px">PRICE</th>
  								<th width="50px">QTY</th>
  								<th width="85px">SUM</th>
                  <th width="140px">MEMO</th>
  								<th width="40px"></th>
  							</tr>
  						</thead>
  						<tbody id = "neworder_item_tbody" class="ordertable_tbody">

  						</tbody>
              <?
                if(isset($orderNo)){
              ?>
                <script>
                    $(document).ready(function(){
                      fetch_myorder_itemlist('<?=$orderNo?>');
                    });
                </script>
              <?
                }
              ?>
  					</table>
  				</div>
        </form>
			</div>
		</div>
	</div>
</div>
