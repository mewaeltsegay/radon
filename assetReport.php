<?php

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";

if (isset($_GET["location"])){
    $location = $_GET["location"];
}
else{
    $location = "";
}
?>

    <div class="container-fluid mt--7">
    <button id="AssetReportBtn" class="print-hide btn" onclick="window.print();"><i class="fas fa-print" style="font-size: 18pt"></i> Print</button>
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow landscape">
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h5>National Confederation of Eritrean Workers</h5>
                                    <h5 class="mt--2">Fixed Assets Count Sheet</h5>
                                    <h5 class="mt--2">As of <?php echo date("d F Y");?></h5>
                                </div>
                            </div>
                            <div class="row print-hide"></div>
                            <div class="row mb--4 mt--1">
                                <div class="col">
                                    <h4>Location: <?php echo $location;?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-fill-2">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Serial No.</th>
                            <th scope="col">Item</th>
                            <th scope="col">Serial No.</th>
                            <th scope="col">Unit Measure</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Value (in NKF)</th>
                            <th scope="col">Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $fun->populateAssetReport($location);?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
include "include/divisions/footer.php";
