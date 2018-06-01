<?
  include_once("includes/include_db.php");
  $branch = $_GET['branch'];
  if($branch == 'bby'){
    $company = 'HANNAM SUPERMARKET BURNABY';
    $location = 'BURNABY';
    $header_branch = 'BBY';
  } elseif ($branch == 'sry') {
    $company = 'HANNAM SUPERMARKET SURREY';
    $location = 'SURREY';
    $header_branch = 'SRY';
  } elseif($branch == 'dt') {
    $company = 'HANNAM SUPERMARKET DOWNTOWN';
    $location = 'DOWNTOWN';
    $header_branch = 'DT';
  } elseif ($branch == 'nv') {
    $company = 'HANNAM SUPERMARKET North Vancouver';
    $location = 'N.VANCOUVER';
    $header_branch = 'NV';
  }

  $orderNo = ($_GET['order_no']) ? $_GET['order_no'] : $_POST['order_no'];
  // $deliveryDate = Br_dconv($_POST["tDeliveryDate"]);

  if(!$orderNo){
    $order_date = date("Y-m-d");
    $deliveryDate = date("Y-m-d");
    $total_Amt = 0.00;
  } else {
    $tOrderMaster_query = "SELECT *, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate, CONVERT(char(10), tDate, 126) AS tDate FROM trOrderMaster WHERE tOrdNo = '$orderNo'";
    $tOrderMaster_query_result = sqlsrv_query($conn_hannam, $tOrderMaster_query);
    $tM_row = sqlsrv_fetch_array($tOrderMaster_query_result);
    $deliveryDate = $tM_row['tDeliveryDate'];
    $tStatus = $tM_row['tStatus'];
    if($deliveryDate == "") $deliveryDate = date("Y-m-d");
    // $deliveryDate = date("Y-m-d", strtotime('tomorrow'));
    $CustomerPO = Br_iconv($tM_row['CustomerPO']);
    $tMemo = Br_iconv($tM_row['tMemo']);
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
            <td width="60px" rowspan="2" style="vertical-align:bottom;background-color:#E63946;color:white;font-weight:bolder;font-size:20px;"><?=$header_branch?></td>
            <td style="width:5%;text-align:center;white-space:nowrap">Order No</td>
            <td><input type="text" class="form-control" id="orderNum" name="orderNum" value="<?=$orderNo?>" readonly/></td>
            <td style="text-align:center;white-space:nowrap">Order Date</td>
            <td>
              <input type="text" class="form-control" id="orderDate" name="orderDate" value="<?=$order_date?>" readonly/>
            </td>
            <td style="text-align:center;white-space:nowrap">Delivery Date</td>
            <td><input type="text" class="form-control" id="deliveryDate" name="deliveryDate" value="<?=$deliveryDate?>"/></td>
            <td style="text-align:center;vertical-align:middle;background-color:#666666;color:white;width:13%;min-width:150px;" colspan="2">
              <span class="neworder_total_text">Total Amount</span>
            </td>
          </tr>
          <tr height="25px;" style="background-color:#B3B3B3;color:#666666;font-weight:bold;">
            <td style="text-align:center;">Memo</td>
            <td colspan="4">
              <input type="text" class="form-control" id="main_memo" name="main_memo" value="<?=$tMemo?>" />
            </td>
            <td>
              <select class="form-control neworder-select-department" id="main_department" name="main_department">
                <option value="Grocery">Grocery</option>
                <option value="Seafood">Seafood</option>
                <option value="Produce">Produce</option>
                <option value="Meat">Meat</option>
                <option value="Deli">Deli</option>
                <option value="Houseware">Houseware</option>
              </select>
            </td>
            <td colspan="2" style="text-align:center;vertical-align:middle;background-color:#666666;color:white;width:13%;min-width:150px;">
               $<span id="neworder_total_num"><?=$total_Amt?></span>
            </td>
          </tr>
        </table>
      </div>
      <div class="row row-relative">
      <div class="col-lg-4">
				<div class="panel">
        <!-- <div class="panel panel-primary"> -->
					<div class="panel-heading">
						<h3 class="panel-title">My Item</h3>
						<div class="pull-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-search"></i>
							</span>
						</div>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#neworder_myitem_table" placeholder="Filter" />
					</div>
					<table class="table table-hover customtable" id="neworder_myitem_table">
						<thead class="customtable_thead">
							<tr class="customtable_tr">
                <th width="100px">V/Code</th>
								<th class="hidden-xs" width="150px">B/Code</th>
								<th>Name</th>
								<th class="hidden-lg" width="75px">Size</th>
                <th class="hidden-lg" width="75px">Balance</th>
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
			<div class="col-lg-8 col-border">
        <div class="col-border-padding">
          <input type="hidden" name="mode">
          <input type="hidden" name="order_no" value="<?=$orderNo?>">
          <input type="hidden" name="item_num" id = "item_num" value="0">
          <input type="hidden" name="branchID" value="<?=$branch?>">
          <input type="hidden" name="orderNo" value="<?=$orderNo?>">
          <input type="hidden" name="credit" id="credit" value="<?=$creditValue?>">
  				<div class="panel">
  					<div class="panel-heading">
  						<h3 class="panel-title">My Order</h3>
  						<div class="pull-right">
  							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
  								<i class="glyphicon glyphicon-search"></i>
  							</span>
  						</div>
              <? if(isset($orderNo) && $tStatus < 3){ ?>
              <div class="floatright" id="neworder_delete">
                <button type="button" name="button" onClick="proceed_submit('delete')" class="form-control">DELETE</button>
              </div>
              <div class="floatright" id="neworder_modify">
                <button type="button" name="button" onClick="proceed_submit('modify')" class="form-control">MODIFY</button>
              </div>
              <div class="floatright" id="neworder_submit">
                <button type="button" name="button" onClick="proceed_submit('submit')" class="form-control">SUBMIT</button>
              </div>
              <? } else { ?>
              <div class="floatright" id="neworder_save">
                <button type="button" name="button" onClick="proceed_submit('add')" class="form-control">SAVE</button>
              </div>
              <? } ?>
  					</div>
  					<div class="panel-body">
  						<input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#neworder_item_table" placeholder="Filter" />
  					</div>
  					<table class="table table-hover ordertable" id="neworder_item_table">
  						<thead class="ordertable_thead">
  							<tr>
  								<th>V/Code</th>
  								<th>B/Code</th>
  								<th>Name</th>
  								<th>Size</th>
                  <th>V/Unit</th>
                  <th>V/Cont</th>
                  <th>Price</th>
  								<th>Qty</th>
  								<th>Sum</th>
                  <th>Memo</th>
  								<th></th>
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
</div>

<div class="modal fade" id="memo_modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    MEMO
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form role="form">
                  <div class="form-group">
                    <label for="textarea_memo">Any Comment?</label>
                    <input type="hidden" class="row_num_temp" />
                      <textarea class="form-control" rows="10" id="textarea_memo" placeholder="Enter Something"></textarea>
                  </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary" onclick="save_data(this)">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
