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
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-0">Fixed Assets</h3>
                        </div>
                        <div class="col-3 mt--2 mb--2">
                            <div class="row">
                                <div class="col center mt-2 mr--7">
                                    <label class="label" for="loc">Location:</label>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="loc" id="loc">
                                        <option selected="selected" disabled="disabled"> ANY </option>
                                        <?php $fun->getLocations();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Measure</th>
                            <th scope="col">Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $fun->populateFixedAssets();?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
include "include/divisions/footer.php";

