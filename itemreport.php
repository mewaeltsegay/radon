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

$db = new DB_Connect();
$conn = $db->connect();

$id = $_GET["id"];
$itemname = "";
$cat = "";
$desc = "";
$unit = "";

$sql = "select item,unit_measure,(select category_name from category WHERE id=inventory.category) as cat,description from inventory where unique_id='".$id."'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){
    $res = mysqli_fetch_assoc($result);
    $itemname = $res["item"];
    $cat = $res["cat"];
    $desc = $res["description"];
    $unit = $res["unit_measure"];
}
?>

    <div class="container-fluid mt--7">
    <div class="card shadow center" style="width: 90%">
        <div class="card-header border-0">
            <img class="img-center img-fluid" src="assets/img/theme/ncew%20logo.png" style="height: 100px;width: 100px"/>
            <h1 class="mb-0 text-center">National Confederation of Eritrean Workers</h1>
            <h2 class="mb-0 text-center">Individual Item Report</h2>
            <h4 class="mb-0 mt-5">Item Name: <?php echo $itemname;?></h4>
            <h4 class="mb-0">Item ID: <?php echo $id;?></h4>
            <h4 class="mb-0">Category: <?php echo $cat;?></h4>
            <h4 class="mb-0">Description: <?php echo $desc;?></h4>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Unit Measure</th>
                    <th scope="col">Price</th>
                    <th scope="col">B.Balance</th>
                    <th scope="col">In</th>
                    <th scope="col">Out</th>
                    <th scope="col">Balance</th>
                </tr>
                </thead>
                <tbody>
                <?php $fun->populateItemReport($unit,$id,0,0,false)?>
                </tbody>
            </table>
        </div>

    </div>

<?php
include "include/divisions/footer.php";

