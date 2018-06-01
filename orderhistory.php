<link rel="stylesheet" href="css/history.css?ver=3">
<div class="col-md-11 md-long-width">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="location_container flex-location-container">
          <div class="location_box box_all">
            ALL
          </div>
          <div class="location_box box_bby">
            BBY
          </div>
          <div class="location_box box_sry">
            SRY
          </div>
          <div class="location_box box_dt">
            D/T
          </div>
          <div class="location_box box_nv">
            N/V
          </div>

          <div class="status_listbox">
            <h5>Status</h5>
            <select class="form-control" onchange="select_status_listbox(this.value)">
              <option value="0">
                ALL
              </option>
              <option value="1">
                SAVE
              </option>
              <option value="2">
                UPDATE
              </option>
              <option value="3">
                SUBMIT
              </option>
              <option value="4">
                CONFIRM
              </option>
              <option value="5">
                COMPLETE
              </option>
            </select>
          </div>

          <div class="date_listbox">
            <h5>Delivery Date</h5>
            <select class="form-control">
              <option value="1">
                Today
              </option>
              <option value="7">
                1 Week
              </option>
              <option value="30">
                1 Month
              </option>
              <option value="90">
                3 Months
              </option>
            </select>
          </div>

        </div>
      </div>

      <div class="clearfix"></div>
      <h4 class="orderhistory_h4"><span id="orderhistory_status"></span></h4>
      <div class="table-responsive">
        <table id="mytable" class="table table-hover">
          <thead>
            <th>Order #</th>
            <th>Date</th>
            <th>Delivery Date</th>
            <th>Company</th>
            <th>Status</th>
            <th>Total Price</th>
            <th></th>
          </thead>
          <tbody id="order_history_list">
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
          <script>
            $(document).ready(function() {
              $('.box_all').css('background-color','#E63946');
              fetch_orderhistory_list();
            });
          </script>
        </table>

        <div class="clearfix"></div>
        <!-- <ul class="pagination pull-right">
            <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
          </ul> -->
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
    </div>
  </div>
</div>

<div id="view_complete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Order Detail</h4>

      </div>
      <div class="modal-body">
        <div id="orderItem_Detail"></div>
      </div>
      <div class="modal-footer">
        <button type="button-" class="btn btn-default" onclick="print_order_form($('.orderNo').val())"><i class="flaticon-print"></i></button><button type="button" class="btn btn-default" data-dismiss="modal"><i class="flaticon-cross"></i></button>
      </div>
    </div>

  </div>
</div>
