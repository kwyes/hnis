<link rel="stylesheet" href="css/history.css?ver=2">
<div class="col-md-11 md-long-width">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <!-- <div class="location_container flex-location-container">
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
            <select class="form-control" onchange="select_statis_listbox(this.value)">
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
              <option value="Today">
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

        </div> -->
        <div style="margin-top:33px;"></div>

        <div class="row">
          <div class="col-md-3 col-md-offset-9">
            <div class="input-group stylish-input-group input-append">
              <span class="input-group-addon">
              <input type="hidden" id="orderDate" class="form-control" value="" size="12" autocomplete="off" />
              <button type="submit" onclick="open_Orderdate_calendar();">
                <span class="glyphicon glyphicon-calendar"></span>
              </button>
              </span>
              <input type="text" class="form-control" placeholder="Search" id="search_received_txt" onkeypress="handle(event,'search_receivedorder')">
              <span class="input-group-addon">
              <button type="submit" onclick="search_ReceivedOrder()">
                <span class="glyphicon glyphicon-search"></span>
              </button>
              </span>
            </div>
          </div>
        </div>
        <div style="margin-top:33px;"></div>
        <div class="table-responsive">
          <table id="mytable" class="table table-bordred table-striped">
            <thead>
              <th>Order #</th>
              <th>Date</th>
              <th>Delivery Date</th>
              <th>Company</th>
              <th>Status</th>
              <th>Total Price</th>
              <th>View</th>
           </thead>
           <tbody id="fetch_received_list">
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
            $(document).ready(function(){
              fetch_received_list();
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


<!-- <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input class="form-control " type="text" placeholder="Mohsin">
        </div>
      <div class="form-group">
        <input class="form-control " type="text" placeholder="Irshad">
      </div>
      <div class="form-group">
        <textarea rows="2" class="form-control" placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>
      </div>
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      </div>
    </div>
  </div>
</div> -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            <h4 class="modal-title custom_align" id="Heading">Delete This Order</h4>
          </div>
          <div class="modal-body">
           <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record(Order NO : <span id='delete_order_no'></span>)?</div>
          </div>
          <div class="modal-footer ">
            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="Order_delete_chk();"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
          </div>
        </div>
     </div>
  </div>
</div>
