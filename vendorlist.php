<link rel="stylesheet" href="css/vendorlist.css">
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
					<div class="panel-body">
						<input type="text" class="form-control" id="admin-vendor-list-filter" data-action="filter" data-filters="#admin-vendor-list" placeholder="Filter Tasks" />
            <input type="hidden" id="admin_vendor_id" value="">
					</div>
          <table class="table table-hover" id="admin-vendor-list">
            <thead>
              <tr>
                <th>Vendor ID</th>
                <th>Name</th>
                <th>Phone</th>
              </tr>
            </thead>
            <tbody>
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
              fetch_vendor_list();
            });
          </script>
				</div>
			</div>
			<div class="col-lg-8 col-border">
				<div class="panel col-border-padding">
					<div class="panel-heading" style="margin-right:-1px;margin-left:-1px;">
						<h3 class="panel-title">Vendor Detail</h3>
            <div class="pull-right">
              <button class="btn btn-default vendorlist-add-btn" onclick="register_vendor();">
                <span style="font-size: 20px;" class="glyphicon glyphicon-plus"></span>
              </button>
              <button class="btn btn-default vendorlist-update-btn" onclick="update_vendor();">
                <span style="font-size: 20px;" class="glyphicon glyphicon-repeat"></span>
              </button>
            </div>
					</div>
          <div class="row">
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="ven_ID" disabled>
                <label for="">Vendor ID</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="ven_Name">
                <label for="">Company Name</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="ven_Phone">
                <label for="">Phone</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="ven_Fax">
                <label for="">FAX</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="ven_Email">
                <label for="">Email</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <i class="fa fa-sort"></i>
                <select class="floatLabel" name="ven_Useyn">
                  <option value="Y" selected>Y</option>
                  <option value="N">N</option>
                </select>
                <label for="" class="active">Use YN</label>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="controls">
                <input type="text" class="floatLabel" name="ven_Address">
                <label for="">Address</label>
              </div>
            </div>

          </div>
				</div>
			</div>
		</div>
	</div>
</div>
