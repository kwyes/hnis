<link rel="stylesheet" href="css/myitem.css?ver=1">
<div class="col-md-11 md-long-width">
  <div id="search">
    <!-- <h3>Click the filter icon <small>(<i class="glyphicon glyphicon-filter"></i>)</small><br />Press Enter or Tab to save Vendor Code</h3> -->
    	<div class="row row-relative">
			<div class="col-lg-4">
				<div class="panel">
					<div class="panel-heading" style="margin-right:-1px;margin-left:-1px;">
						<h3 class="panel-title" style="color:#808080;">Search Vendor</h3>
						<div class="panel-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-search"></i>
							</span>
						</div>
					</div>
					<div class="panel-body" style="display:block;">
						<input type="text" class="form-control" id="admin-vendor-search-table-filter" data-action="filter" data-filters="#serach_Vendor_table" placeholder="Filter Tasks" />
            <input type="hidden" id="admin_vendor_id" value="">
					</div>
          <table class="table table-hover table-search" id="admin-vendor-search-table">
            <thead>
              <tr>
                <th width="45%">Company NAME</th>
                <th width="25%">Submitted Items</th>
                <th>Vendor ID</th>
              </tr>
            </thead>
            <tbody style="height:100% !important;">
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
              fetch_submititem_vendor();
            });
          </script>
				</div>
			</div>
			<div class="col-lg-8 col-border">
				<div class="panel col-border-padding">
					<div class="panel-heading" style="margin-right:-1px;margin-left:-1px;">
						<h3 class="panel-title">Vendor Item</h3>
						<div class="panel-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-search"></i>
							</span>
						</div>
            <!-- <div class="panel-right2">
							<button class="form-control">SAVE</button>
						</div> -->
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="vendoritem-table-filter" data-action="filter" data-filters="#vendoritem-table" placeholder="Filter Tasks" />
					</div>
					<table class="table table-hover table-item" id="vendoritem-table">
            <thead>
              <tr>
                <th>V/Code</th>
								<th>Barcode</th>
								<th>Name</th>
                <th>Size</th>
                <th>V/Unit</th>
								<th>V/Content</th>
                <th>V/Type</th>
                <th>SAVE</th>
                <th></th>
							</tr>
            </thead>
            <tbody id="vendoritem-table-tbody">
            </tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

<div id="search_mfprod_div" class="modal fade" role="dialog" style="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Item Detail</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="search_mfprod_row_num" value="">
        <div id="Item_Detail"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
