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
    <button id="myBtn" onclick="window.location.assign('damaged.php')"><i class="fas fa-list" style="font-size: 18pt"></i></button>
    <div class="container-fluid mt--7">
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Damaged Items</h3>
                </div>
                <div class="card-body">
                    <div class="container3 mt--4 center flex-lg-wrap">
                        <div class="row">
                            <?php $fun->populateDamagedItems("card");?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include "include/divisions/footer.php";
