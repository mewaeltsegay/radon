<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 6/9/2020
 * Time: 6:17 PM
 */

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";


?>
    <div class="container-fluid mt--7">
    <button id="AssetReportBtn" class="print-hide btn" onclick="window.location.assign('assetReport.php?location='+document.getElementById('loc').value)"><i class="border-danger fas fa-file"></i> Report</button>
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow landscape">
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col-3">
                            <h3 class="mb-0">Fixed Assets</h3>
                        </div>
                        <div class="col-3 mt--2 mb--2">
                            <div class="row" id="loc-inline">
                                <div class="col-3 mt-2 pr--3">
                                    <label class="label inline" for="loc">Location:</label>
                                </div>
                                <div class="col-6">
                                    <select class="form-control inline" name="loc" id="loc" onchange="assetFilter();">
                                        <option selected="selected"> ANY </option>
                                        <?php $fun->getLocations();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt--2 mb--2 ml--6">
                            <div class="row" id="cat-inline">
                                <div class="col-3 mt-2 pr--3">
                                    <label class="label inline" for="loc">Category:</label>
                                </div>
                                <div class="col-7">
                                    <select class="form-control inline" name="cat" id="cat" onchange="assetFilter();">
                                        <option selected="selected"> ANY </option>
                                        <?php $fun->getCategories();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt--2 mb--2 ml--6">
                            <div class="row" id="cat-inline">
                                <div class="col-4 mt-2 pr--3">
                                    <label class="label inline" for="loc">Assigned To:</label>
                                </div>
                                <div class="col-6">
                                    <select class="form-control inline" name="loc" id="emps" onchange="assetFilter();">
                                        <option selected="selected"> ANY </option>
                                        <?php $fun->getAllEmployees();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-fill-2" id="assets">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Location</th>
                            <th scope="col">Category</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Measure</th>
                            <th scope="col">Assigned To</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $fun->populateAssetDetails();?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-fluid" role="document">
            <div class="modal-content bg-gradient-danger">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img id="imageModalContent" class="img-fluid img-center border border-light">
                </div>

            </div>
        </div>
<?php
include "include/divisions/footer.php";

