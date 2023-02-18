<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/13/2020
 * Time: 9:36 PM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <div class="container-fluid mt--7">
    <form method="post" id="tform">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow landscape">
                <div class="card-header border-0">
                    <h3 class="mb-0">Transactions</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-fill">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">item</th>
                            <th scope="col">Details</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Measure</th>
                            <th scope="col">Transaction Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Remark</th>
                            <th scope="col">Damaged</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $fun->populateTransactions();?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
include "include/divisions/footer.php";
