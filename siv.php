<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 7/14/2020
 * Time: 4:58 PM
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
    $sql = "SELECT employee,creation_date FROM `inventory transactions` WHERE siv=" . $no;
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <div class="card shadow center mt-3" style="width: 90%">
            <div class="card-header border-0">
                <img class="img-center img-fluid" src="assets/img/theme/ncew%20logo.png"
                     style="height: 100px;width: 100px"/>
                <h1 class="mb-0 text-center">National Confederation of Eritrean Workers</h1>
                <h2 class="mb-0 text-center">Store Issue Voucher</h2>
                <h4 class="mb-0 mt--9 text-right">No: <?php echo $no; ?></h4>
                <h4 class="mb-0 mt-9">Department: <?php echo $fun->getEmployeeDept($row["employee"]); ?></h4>
                <h4 class="mb-0 mt--4 text-right">
                    Date: <?php echo date("d/m/Y", strtotime($row["creation_date"])); ?></h4>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Description</th>
                        <th scope="col">Unit Measure</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $price = $fun->populateSiv($no); ?>
                    </tbody>
                </table>
                <div class="flex-row-reverse">
                    <h4 class="text-right mr-5 text-green">Total:<?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency(array_sum($price), $currency) . " NKF";
                        ?></h4>
                </div>
            </div>

        </div>
        <?php
    }
}
include "include/divisions/footer.php";
