    <div class="col-md-11 sm-long-width padding_zero">
      <div class="container-fluid">
        <div class="row row-relative-left">
          <div class="col-md-11">
            <div class="row row-relative">
              <div class="col-lg-6">
                <h4>PRODUCT SALES VOLUME</h4>
                <div id="chart_div" class="chart"></div>
              </div>
              <div class="col-lg-6 col-border">
                <div class="col-border-padding">
                  <h4>CURRENT SCORE</h4>
                  <div class="grid2x2">
                    <div class="gridbox gridbox1">
                      <div class="box">
                        <div class="box-icon">
                          <i class="flaticon-earning-money-idea"></i>
                        </div>
                        <div class="box-text">
                          TOTAL AMOUNT
                          <span class="box-number box-total">150,000</span>
                        </div>
                      </div>
                    </div>
                    <div class="gridbox gridbox2">
                      <div class="box">
                        <div class="box-icon">
                          <i class="flaticon-commerce"></i>
                        </div>
                        <div class="box-text">
                          Item
                          <span class="box-number box-item">50</span>
                        </div>
                      </div>
                    </div>
                    <div class="gridbox gridbox3">
                      <div class="box">
                        <div class="box-icon">
                          <i class="flaticon-libra-scale-balance-symbol"></i>
                        </div>
                        <div class="box-text">
                          Balance
                          <span class="box-number box-balance">150,000</span>
                        </div>
                      </div>
                    </div>
                    <div class="gridbox gridbox4">
                      <div class="box">
                        <div class="box-icon">
                          <i class="flaticon-credit-cards-payment"></i>
                        </div>
                        <div class="box-text">
                          Credit
                          <span class="box-number box-credit">150,000</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-relative">
              <div class="col-md-6">
                <div id="saved">
                  <h4>SAVED ORDER</h4>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th width="22%">Location</th>
                        <th width="22%">Price</th>
                        <th width="50px">Edit</th>
                      </tr>
                    </thead>
                    <tbody id="dashboard_saved_list">

                    </tbody>
                  </table>
                  <script>

                  </script>
                </div>
              </div>
              <div class="col-md-6 col-border">
                <div class="col-border-padding" id="recentcomplete">
                  <h4>CONFIRMED ORDER</h4>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th width="22%">Location</th>
                        <th width="22%">Price</th>
                        <th width="50px">View</th>
                      </tr>
                    </thead>
                    <tbody id="dashboard_confirmed_list">

                    </tbody>
                  </table>
                  <script>

                  </script>
                </div>
              </div>
            </div>
          </div>
          <? include_once("right_menu.php"); ?>
        </div>
      </div>
    </div>
