<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 6/11/2020
 * Time: 7:25 PM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <button id="myBtn" class="print-hide" onclick="window.location.assign('damaged2.php')"><i class="fas fa-th-large" style="font-size: 18pt"></i></button>
    <div class="container-fluid mt--7">
    <form id="form1" method="post" class="print-hide">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow landscape">
                <div class="card-header border-0">
                    <h3 class="mb-0">Damaged Items</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-fill-2">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">ID</th>
                            <th scope="col">Location</th>
                            <th scope="col">Category</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $fun -> populateDamagedItems("list");?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
include "include/divisions/footer.php";
