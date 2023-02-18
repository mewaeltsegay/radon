<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/11/2020
 * Time: 9:46 PM
 */

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/stat_cards.php";
include "include/divisions/top_nav.php";

$item = "";
if(isset($_POST["item"])){
    $item = $_POST["item"];
}
if(isset($_GET["item"])){
    $item = $_GET["item"];
}
if(isset($_GET["location"])){
    $loc = $_GET["location"];
}
?>
    <div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0"><?php echo $item;?></h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Location</th>
                            <th scope="col">Category</th>
                            <th scope="col">Manufacturer</th>
                            <th scope="col">Model</th>
                            <th scope="col">Serial No.</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Unit Measure</th>
                            <th scope="col">Damaged</th>
                            <th scope="col">Assigned to</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $fun->populateAssetDetailsList($item,$loc);?>
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
