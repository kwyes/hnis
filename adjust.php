<?
  include_once("includes/include_db.php");
  $branch = strtolower($_SESSION['hnisCompanyName']);
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
  } else {
    $adjOrderMaster_query = "SELECT *, CONVERT(char(10), tDate, 126) AS tDate FROM trAdjustMaster WHERE tAdjNo = '$orderNo'";
    $adjOrderMaster_query_result = sqlsrv_query($conn_hannam, $adjOrderMaster_query);
    $tM_row = sqlsrv_fetch_array($adjOrderMaster_query_result);
    $tStatus = $tM_row['tStatus'];
    $tMemo = Br_iconv($tM_row['tMemo']);
    $order_date = $tM_row['tDate'];
  }
?>
<link rel="stylesheet" href="css/adjust.css?ver=6">
<form name="order_sheet" action="?page=frame&menu=adjustupdate" method="POST" accept-charset="utf-8">
<div class="col-md-11 md-long-width padding_zero">
  <div id="search">
      <div class="master_order_form">
        <table class="table order_information table-borderless">
          <tr height="36px" style="background-color:#DCDDDE;color:#666666;font-weight:bold;">
            <td width="60px" rowspan="2" style="vertical-align:bottom;background-color:#E63946;color:white;font-weight:bolder;font-size:15px;"><?=$header_branch?></td>
            <td style="width:5%;text-align:center;white-space:nowrap">Adjust No</td>
            <td width="100px">
              <input type="text" class="form-control" id="orderNum" name="orderNum" value="<?=$orderNo?>" readonly/>
            </td>
            <td width="7%" style="text-align:center;white-space:nowrap">Adjust Date</td>
            <td width="120px">
              <input type="text" class="form-control" id="" name="orderDate" value="<?=$order_date?>" readonly/>
            </td>
            <td width="5%" style="text-align:center;">Memo</td>
            <td>
              <input type="text" class="form-control" id="main_memo" name="main_memo" value="<?=$tMemo?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="row row-relative">
      <div class="col-lg-6">
				<div class="panel">
        <!-- <div class="panel panel-primary"> -->
					<div class="panel-heading">
						<h3 class="panel-title">Search Item</h3>
						<div class="pull-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-search"></i>
							</span>
						</div>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="adj-table-filter" data-action="filter" data-filters="#adjust_myitem_table" placeholder="Filter" />
					</div>
					<table class="table table-hover customtable" id="adjust_myitem_table">
						<thead class="customtable_thead">
							<tr class="customtable_tr">
								<th width="150px">B/Code</th>
								<th>Name</th>
								<th width="80px">Size</th>
                <th width="80px">Balance</th>
							</tr>
						</thead>
						<tbody class="customtable_tbody">
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
				</div>
			</div>
			<div class="col-lg-6 col-border">
        <div class="col-border-padding">
          <input type="hidden" name="mode">
          <input type="hidden" name="order_no" value="<?=$orderNo?>">
          <input type="hidden" name="item_num" id = "item_num" value="0">
          <input type="hidden" name="branchID" value="<?=$branch?>">
          <input type="hidden" name="orderNo" value="<?=$orderNo?>">
          <input type="hidden" name="credit" id="credit" value="<?=$creditValue?>">
  				<div class="panel">
  					<div class="panel-heading">
  						<h3 class="panel-title">My Adjust</h3>
  						<div class="pull-right">
  							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
  								<i class="glyphicon glyphicon-search"></i>
  							</span>
  						</div>
              <? if(isset($orderNo)){ ?>

              <div class="floatright" id="adjust_delete">
                <button type="button" name="button" onClick="proceed_adjust_submit('delete')" class="form-control">DELETE</button>
              </div>
              <div class="floatright" id="adjust_modify">
                <button type="button" name="button" onClick="proceed_adjust_submit('modify')" class="form-control">MODIFY</button>
              </div>
              <? if($tStatus <= 1) { ?>
              <div class="floatright" id="adjust_submit">
                <button type="button" name="button" onClick="proceed_adjust_submit('submit')" class="form-control">SUBMIT</button>
              </div>
              <? } ?>
              <? if($tStatus >= 2 && $tStatus !== 5) { ?>
              <div class="floatright" id="adjust_submit">
                <button type="button" name="button" onClick="proceed_adjust_submit('complete')" class="form-control">COMPLETE</button>
              </div>
              <? } ?>
              <? } else { ?>
              <div class="floatright" id="adjust_save">
                <button type="button" name="button" onClick="proceed_adjust_submit('add')" class="form-control">SUBMIT</button>
              </div>
              <? } ?>
  					</div>
  					<div class="panel-body">
  						<input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#adjust_item_table" placeholder="Filter" />
  					</div>
  					<table class="table table-hover ordertable" id="adjust_item_table">
  						<thead class="ordertable_thead">
  							<tr>
  								<th>B/Code</th>
  								<th>Name</th>
  								<th>Size</th>
  								<th>Qty</th>
                  <th>Memo</th>
  								<th></th>
  							</tr>
  						</thead>
  						<tbody id="adjust_item_tbody" class="ordertable_tbody">

  						</tbody>
              <?
                if(isset($orderNo)){
              ?>
                <script>
                    $(document).ready(function(){
                      fetch_adjust_itemlist('<?=$orderNo?>');
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
                <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary" onclick="save_data(this)">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
