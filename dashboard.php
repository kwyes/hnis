<?
  $sessionid = $_SESSION['hnisVendorID'];
  $query = "SELECT TOP 5 CONVERT(char(10), tDate, 126) AS tDate, tAMT FROM trOrderMaster WHERE tCust = '$sessionid' ORDER BY tDate ASC";
  $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
  $row_num = sqlsrv_num_rows($query_result);
?>
<script type="text/javascript">
  $(document).ready(function(){
    $(window).resize(function(){
      drawChart();
    });
  });

  google.charts.load("visualization", "1", {'packages':['corechart','bar']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
                          ['Date', 'Sales Volume'],
                          <?
                            if($row_num > 0){
                              while($row = sqlsrv_fetch_array($query_result))
                              {
                                   echo "['".$row["tDate"]."', ".$row["tAMT"]."],";
                              }
                            } else {
                                echo "['',0],";
                            }
                          ?>
                     ]);
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    var options = {
       bar: {groupWidth: "25%"}
    };

   chart.draw(data, options);
  }

  $(document).ready(function(){
    get_number_vendorItem();
    get_number_Totalamount();
  });

</script>

    <!--Div that will hold the pie chart-->
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
                          <span class="box-number box-total"></span>
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
                          <span class="box-number box-item"></span>
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
                    $(document).ready(function(){
                      fetch_saved_list();
                    });
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
                    $(document).ready(function(){
                      fetch_confirmed_list();
                    });
                  </script>
                </div>
              </div>
            </div>
          </div>
          <? include_once("right_menu.php"); ?>
        </div>
      </div>
    </div>
<!--- Completed Modal when clicking the view button in Completed table list -->
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
