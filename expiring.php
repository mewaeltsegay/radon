<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/8/2020
 * Time: 4:32 PM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
<div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Expiring Items</h3>
                </div>
                <div class="table-responsive">
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
                        <?php $fun->populateExpiringItems(1000);?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "include/divisions/footer.php";
    ?>
