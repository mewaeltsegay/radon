<?php
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/stat_cards.php";
include "include/divisions/top_nav.php";
?>
    <div class="container-fluid mt--7 bg-gradient-dark">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                  <h2 class="text-gray-dark mb-0">Items</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
                <div id="chart">
                </div>
            </div>
          </div>
        </div>
<!--        <div class="col-xl-4">-->
<!--          <div class="card shadow" style="height: 30.5rem;">-->
<!--            <div class="card-header bg-transparent">-->
<!--              <div class="row align-items-center">-->
<!--                <div class="col">-->
<!--                  <h6 class="text-uppercase text-muted ls-1 mb-1">Current</h6>-->
<!--                  <h2 class="mb-0">Transactions</h2>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--              <div class="table-responsive overflow-hidden">-->
<!--                  <!-- Projects table -->
<!--                  <table class="table align-items-center table-flush">-->
<!--                      <thead class="thead-light">-->
<!--                      <tr>-->
<!--                          <th class="pr-0" scope="col">Name</th>-->
<!--                          <th class="pl-1 pr-0" scope="col">item</th>-->
<!--                          <th class="pl-1 pr-0" scope="col">Transaction Type</th>-->
<!--                          <th class="pl-1" scope="col">Date</th>-->
<!--                      </tr>-->
<!--                      </thead>-->
<!--                      <tbody>-->
<!--                      --><?php //$fun->populateTransactionsPreview();?>
<!--                      </tbody>-->
<!--                  </table>-->
<!--              </div>-->
<!--          </div>-->
<!--        </div>-->
      </div>
      <div class="row mt-5">
        <div class="col-xl-8 mb-5 mb-xl-0">
          <div class="card shadow" style="height: 20.5rem;">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Expiring Items</h3>
                </div>
                  <?php if($fun->expiringItemsCount() > 5){?>
                <div class="col text-right">
                  <a href="expiring.php" class="btn btn-sm btn-primary">See all</a>
                </div>
                <?php }?>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Item</th>
                    <th scope="col">ID</th>
                    <th scope="col">Expiry Date</th>
                    <th scope="col">In Stock</th>
                    <th scope="col">Location</th>
                  </tr>
                </thead>
                <tbody>
                <?php $fun->populateExpiringItems(5);?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card shadow" style="height: 20.5rem;">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Items Running Out</h3>
                </div>
                <div class="col text-right">
                  <a href="runningout.php" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="pr-0" scope="col">Item</th>
                    <th class="pl-1 pr-0" scope="col">In Stock</th>
                    <th class="pl-1 pr-0" scope="col">Location</th>
                    <th class="pl-1" scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                <?php $fun->populateRunningOutItemsPreview();?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    <script>
            var xhttp = new XMLHttpRequest();
            var jsonn = "";
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    jsonn = JSON.parse(this.responseText);

                    var options = {
                        series: [{
                            name: 'Target Stock Level',
                            data: jsonn.target
                        }, {
                            name: 'In Stock',
                            data: jsonn.instock
                        }, {
                            name: 'Reorder Level',
                            data: jsonn.reorder
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: jsonn.item,
                        },
                        yaxis: {
                            title: {
                                text: 'Count'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();

                }
            };
            xhttp.open("GET", "items/getDataForChart.php", true);
            xhttp.send();
    </script>
<?php
include 'include/divisions/footer.php'
?>
