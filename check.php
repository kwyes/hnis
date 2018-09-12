<link rel="stylesheet" href="css/history.css?ver=2">
<div class="col-md-11 md-long-width">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div style="margin-top:33px;"></div>
        <div class="row">
          <div class="col-md-3 col-md-offset-9">
            <div class="input-group stylish-input-group input-append">
              <input type="text" class="form-control" placeholder="Search" id="chk_search">
              <span class="input-group-addon">
              <button type="submit" onclick="chk_search()">
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
              <th>Adjust #</th>
              <th>Date</th>
              <th>Company</th>
              <th>Status</th>
              <th>View</th>
           </thead>
           <tbody id="fetch_adjust_received_list">
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

        <div class="clearfix"></div>
        </div>
    </div>
	 </div>
  </div>
</div>
