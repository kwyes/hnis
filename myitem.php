<link rel="stylesheet" href="css/myitem.css?ver=2">
<div class="col-md-11 md-long-width">
  <div id="search">
    <!-- <h3>Click the filter icon <small>(<i class="glyphicon glyphicon-filter"></i>)</small><br />Press Enter or Tab to save Vendor Code</h3> -->
    	<div class="row">
			<div class="col-lg-12">
				<div class="panel">
					<div class="panel-heading" style="margin-right:-1px;margin-left:-1px;">
						<h3 class="panel-title">My Item</h3>
						<div class="panel-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-search"></i>
							</span>
						</div>
            <div class="floatright">
							<button class="btn btn-default" onclick="myitem_save();">SAVE</button>
						</div>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="myitem-table-filter" data-action="filter" data-filters="#myitem-table" placeholder="Filter Tasks" />
					</div>
					<table class="table table-hover table-item" id="myitem-table">
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
            <tbody id="myitem-tbody">
            </tbody>
					</table>
          <script>
            $(document).ready(function(){
              fetch_myitem(<?=$_SESSION['hnisVendorID']?> , 'myitem-tbody');
            });
          </script>
				</div>
			</div>
		</div>
	</div>
</div>
