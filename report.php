<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 7/3/2020
 * Time: 5:33 PM
 */
$show = "";
if(isset($_GET["type"])){
    $show = $_GET["type"];
}
else{
    $show = "indiv";
}

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <button id="myBtn" class="print-hide" onclick="window.location.assign('report.php?type=<?php if($show == "tabular"){echo "indiv";}else{echo "tabular";}?>')"><i class="fas <?php if ($show == "indiv"){echo "fa-table";}else{echo "fa-th-large";}?>" style="font-size: 14pt"></i></button>
    <div class="container-fluid mt--7">

        <div class="card card-stats mb-4 mb-lg-0 sticky-top">
            <div class="card-header">
                <div class="card-header border-0 ml--4 mb--5">
                    <h3 class="mb-0 mt--4 print-hide">Reports</h3>
                    <p class="text-right mt--3"><button type="submit" form="form1" class="btn btn-outline-warning rounded-circle print-hide" style="width: 30pt;height: 30pt"><i class="ni ni-curved-next ml--2" style="font-size: 12pt"></i></button></p>
                </div>
                    <form class="mt--3" id="form1" method="post" action="<?php $_SERVER['PHP_SELF'];?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-sm">
                                        <label class="label">Start Date</label>
                                        <input class="form-control datepicker" type="text" name="start" id="start" value="<?php if(isset($_POST["start"])){echo $_POST["start"];} else{ echo date("m/d/Y");}?>">
                                    </div>
                                    <div class="col-sm">
                                        <label class="label">End Date</label>
                                        <input class="form-control datepicker" type="text" name="end" id="end" value="<?php if(isset($_POST["end"])){echo $_POST["end"];} else{ echo date("m/d/Y");}?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label class="label" id="lbl" for="item">Item</label>
                                <select class="custom-select" name="item" id="item">
                                    <option id="all" selected="selected">all</option>
                                    <?php $fun->getAllItems();?>
                                </select>
                            </div>
                            <div class="col">
                                <label class="label" for="category">Category</label>
                                <select class="custom-select" name="category" id="category">
                                    <option id="all" selected="selected">all</option>
                                    <?php $fun->getCategories();?>
                                </select>
                            </div>
                            <div class="col">
                                <label class="label" for="location">Location</label>
                                <select class="custom-select" name="location" id="location">
                                    <option id="all" selected="selected">all</option>
                                    <?php $fun->getLocations();?>
                                </select>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($_POST["item"] == "all"){
                $item = "%";
            }
            else{
                $item = $_POST["item"];
            }
            if($_POST["category"] == "all"){
                $cat = "%";
            }
            else{
                $cat = $fun->getCategoryId($_POST["category"]);
            }
            if($_POST["location"] == "all"){
                $loc = "%";
            }
            else{
                $loc = $fun->getLocationId($_POST["location"]);
            }
            if($show == "tabular") {
                $fun->populateTabularReports(date("Y-m-d", strtotime($_POST["start"])), date("Y-m-d", strtotime($_POST["end"])), $item, $cat, $loc);
            }
            else{
                $fun->populateReports(date("Y-m-d", strtotime($_POST["start"])), date("Y-m-d", strtotime($_POST["end"])), $item, $cat, $loc);
            }
        }
        else {
            if($show == "tabular") {
                $fun->populateTabularReports(date("Y-m-d"), date("Y-m-d"));
            }
            else{
                $fun->populateReports(date("Y-m-d"), date("Y-m-d"));
            }
        }
    ?>
<?php
include "include/divisions/footer.php";
