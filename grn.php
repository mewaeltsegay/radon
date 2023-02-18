<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 7/14/2020
 * Time: 3:00 PM
 */

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";

$db = new DB_Connect();
$conn = $db->connect();

echo '<div class="container-fluid mt--7">';

$not = $_GET["no"];
$nos = explode("**",$not);

foreach ($nos as $no) {
    $sql = "SELECT submittedby,receivedby,authorisedby,timestamp,grn_no FROM grn WHERE grn_no='" . $no . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <div class="card shadow center mt-3 landscape" style="width: 90%">
            <div class="card-header border-0">
                <img class="img-center img-fluid" src="assets/img/theme/ncew%20logo.png"
                     style="height: 100px;width: 100px"/>
                <h1 class="mb-0 text-center">National Confederation of Eritrean Workers</h1>
                <h2 class="mb-0 text-center">Goods Received Note</h2>
                <h4 class="mb-0 mt--9 text-right">No: <?php echo $row["grn_no"]; ?></h4>
                <h4 class="mb-0 mt-9 text-right">Date: <?php echo date("d/m/Y", strtotime($row["timestamp"])); ?></h4>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Location</th>
                        <th scope="col">Description</th>
                        <th scope="col">Unit Measure</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $fun->populateItemGRN($no); ?>
                    </tbody>
                </table>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <p class="ml-4" style="font-size: 10pt">Submitted
                        By:<?php $fun->getEmployee($row["submittedby"]); ?></p>
                </div>
                <div class="col-md-4">
                    <p class="ml-4 text-center" style="font-size: 10pt">Received
                        By:<?php $fun->getEmployee($row["receivedby"]); ?></p>
                </div>
                <div class="col-md-4">
                    <p class="ml-4 mr-4 text-right" style="font-size: 10pt">Authorised
                        By:<?php $fun->getEmployee($row["authorisedby"]); ?></p>
                </div>
            </div>

        </div>


        <?php
    }
}
include "include/divisions/footer.php";

