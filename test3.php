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

if(isset($_GET["page"])) {
    $page = $_GET["page"];
}
else{
    $page = 1;
}
?>
<div class="container-fluid mt--7">
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow landscape">
                <div class="card-header border-0">
                    <h3 class="mb-0">Inventory</h3>
                </div>
                <div class="table-responsive">
                    <table id="invTable" class="table align-items-center table-flush table-fill-2">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Location</th>
                            <th scope="col">Category</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Measure</th>
                            <th scope="col">Total Price</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        var dTAble = $("#invTable").dataTable();
        $.ajax({
            url: 'http://localhost/radon/items/datatableJson.php',
            success: function (json){
                jsonn = JSON.parse(json)
                dTAble.fnAddData(jsonn)
            }
        })
    </script>
<?php
include "include/divisions/footer.php";
?>
