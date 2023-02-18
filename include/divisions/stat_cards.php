<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/6/2020
 * Time: 5:57 PM
 */
if($fun->getScriptName() == "itemDetails.php") {
    ?>
    <!-- Card stats -->
    <div class="row">
        <div class="col"></div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Reorder Level</h5>
                            <span class="h2 font-weight-bold mb-0"><?php echo $fun->getItemReorderLevel($_POST["item"]);?></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                <i class="ni ni-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Target Stock Level</h5>
                            <span class="h2 font-weight-bold mb-0"><?php echo $fun->getItemTargetStockLevel($_POST["item"]);?></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                <i class="fas fa-crosshairs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Quantity</h5>
                            <span class="h2 font-weight-bold mb-0 <?php if($fun->getActualItemQuantity($_POST["item"]) >= $fun->getItemTargetStockLevel($_POST["item"])){echo "text-green";}elseif($fun->getActualItemQuantity($_POST["item"]) > $fun->getItemReorderLevel($_POST["item"]) && $fun->getActualItemQuantity($_POST["item"]) < $fun->getItemTargetStockLevel($_POST["item"])){echo "text-yellow";}else{echo "text-danger";}?>"><?php echo $fun->getActualItemQuantity($_POST["item"]);?></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                <i class="fas fa-boxes"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
    <?php
}
//else{
//    ?>
   <!-- Card stats -->
<!--    <div class="row">-->
<!--        <div class="col-xl-3 col-lg-6">-->
<!--            <div class="card card-stats mb-4 mb-xl-0">-->
<!--                <div class="card-body">-->
<!--                    <div class="row">-->
<!--                        <div class="col">-->
<!--                            <h5 class="card-title text-uppercase text-muted mb-0">Traffic</h5>-->
<!--                            <span class="h2 font-weight-bold mb-0">350,897</span>-->
<!--                        </div>-->
<!--                        <div class="col-auto">-->
<!--                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">-->
<!--                                <i class="fas fa-chart-bar"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="mt-3 mb-0 text-muted text-sm">-->
<!--                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>-->
<!--                        <span class="text-nowrap">Since last month</span>-->
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-xl-3 col-lg-6">-->
<!--            <div class="card card-stats mb-4 mb-xl-0">-->
<!--                <div class="card-body">-->
<!--                    <div class="row">-->
<!--                        <div class="col">-->
<!--                            <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>-->
<!--                            <span class="h2 font-weight-bold mb-0">2,356</span>-->
<!--                        </div>-->
<!--                        <div class="col-auto">-->
<!--                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">-->
<!--                                <i class="fas fa-chart-pie"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="mt-3 mb-0 text-muted text-sm">-->
<!--                        <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>-->
<!--                        <span class="text-nowrap">Since last week</span>-->
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-xl-3 col-lg-6">-->
<!--            <div class="card card-stats mb-4 mb-xl-0">-->
<!--                <div class="card-body">-->
<!--                    <div class="row">-->
<!--                        <div class="col">-->
<!--                            <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>-->
<!--                            <span class="h2 font-weight-bold mb-0">924</span>-->
<!--                        </div>-->
<!--                        <div class="col-auto">-->
<!--                            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">-->
<!--                                <i class="fas fa-users"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="mt-3 mb-0 text-muted text-sm">-->
<!--                        <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>-->
<!--                        <span class="text-nowrap">Since yesterday</span>-->
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-xl-3 col-lg-6">-->
<!--            <div class="card card-stats mb-4 mb-xl-0">-->
<!--                <div class="card-body">-->
<!--                    <div class="row">-->
<!--                        <div class="col">-->
<!--                            <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>-->
<!--                            <span class="h2 font-weight-bold mb-0">49,65%</span>-->
<!--                        </div>-->
<!--                        <div class="col-auto">-->
<!--                            <div class="icon icon-shape bg-info text-white rounded-circle shadow">-->
<!--                                <i class="fas fa-percent"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="mt-3 mb-0 text-muted text-sm">-->
<!--                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>-->
<!--                        <span class="text-nowrap">Since last month</span>-->
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php
//}