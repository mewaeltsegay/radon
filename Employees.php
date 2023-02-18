<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/12/2020
 * Time: 2:46 PM
 */

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <div class="container-fluid mt--7">
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Employees</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Work Phone</th>
                            <th scope="col">Home Phone</th>
                            <th scope="col">Mobile Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">City</th>
                            <th scope="col">Zoba</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $fun->populateEmployeeList();?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
include "include/divisions/footer.php";
