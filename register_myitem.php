<link rel="stylesheet" href="css/registermyitem.css">
<div class="col-md-11 md-long-width"><!--- div col-md-11 -->
  <div class="row row-relative">
    <div class="col-lg-4">
      <div class="register-form">
        <div class="form-group">
          <h4 class="heading">General</h4>
          <div class="row">
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="reg_Ename">
                <label for="">English Name</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="reg_Kname">
                <label for="">Korean Name</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="reg_Size" maxlength="10" size="10">
                <label for="">Size</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="reg_Upc">
                <label for="">Barcode(UPC)</label>
              </div>
            </div>
          </div>
        </div>
        <!--  Details -->
        <div class="form-group">
          <h4 class="heading">Details</h4>
          <div class="row">
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="reg_Itemcode">
                <label for="">Item Code</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" id="cell" class="floatLabel" name="reg_rPrice">
                <label for="">Regular Price</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <i class="fa fa-sort"></i>
                <select class="floatLabel" name="reg_Vunit">
                  <option value=""></option>
                  <option value="BOX">BOX</option>
                  <option value="EA">EA</option>
                  <option value="PK">PK</option>
                  <option value="LB">LB</option>
                </select>
                <label for="">Vendor Unit</label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="controls">
                <input type="text" class="floatLabel" name="reg_Vcont">
                <label for="">Vendor Content</label>
              </div>
            </div>
          </div>
          <div class="controls">
            <i class="fa fa-sort"></i>
            <select class="floatLabel" name="reg_Vtype">
              <option value=""></option>
              <option value="Refri">Refri</option>
              <option value="Frozen">Frozen</option>
              <option value="Dry">Dry</option>
              <option value="etc">etc</option>
            </select>
            <label for="">Vendor Type</label>
          </div>
        </div>
        <!--  More -->
        <div class="form-group">
          <div class="controls">
            <button onclick="register_item();">Submit</button>
          </div>
        </div>
      </div>
    </div>
    <div id="search" class="col-lg-8 col-border">
      <div class="panel col-border-padding">
        <div class="panel-heading" style="margin-right:-1px;margin-left:-1px;">
          <h4 class="panel-title">Item List</h4>
          <div class="panel-right">
            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
              <i class="glyphicon glyphicon-search"></i>
            </span>
          </div>
        </div>
        <div class="panel-body">
          <input type="text" class="form-control" id="myitem-table-filter" data-action="filter" data-filters="#myitem-register-table" placeholder="Filter Tasks" />
        </div>
        <table class="table table-hover" id="myitem-register-table">
          <thead>
            <tr>
              <th>V/Code</th>
              <th>Barcode</th>
              <th>Name</th>
              <th>Size</th>
              <th>V/Unit</th>
              <th>V/Content</th>
              <th>V/Type</th>
            </tr>
          </thead>
          <tbody id="myitem-register-tbody">
          </tbody>
        </table>
        <script>
        $(document).ready(function(){
          var countScroll= 1;
          fetch_myitem_inregister(countScroll);

          // var where = 'vendoritem-table-tbody';
          var e = document.getElementById("myitem-register-tbody");
          e.onscroll = function(){
            if(e.offsetHeight + e.scrollTop >= e.scrollHeight){
              countScroll++;
              fetch_myitem_inregister(countScroll);
              // console.log(countScroll);
            }
          };
        });
        </script>
      </div>
    </div>
  </div>
</div><!--- div col-md-11 -->
