<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/12/2020
 * Time: 2:37 PM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";

$success = "";
if(isset($_GET["success"])){
    $success = $_GET["success"];
}

?>
    <div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col"></div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Transaction</h3>
                </div>
                <div class="card-body">
                    <?php if($success == "true"){?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Success!</strong> Transaction complete.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } if($success == "false"){?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="fas fa-exclamation-circle"></i></span>
                        <span class="alert-inner--text"><strong>Error!</strong> Transaction couldn't be completed. Try Again.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php }?>
                    <form method="post" action="transactions/processTransaction.php">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="employee">Department</label>
                                    <select class="custom-select" name="dept" id="dept" required onchange="getEmployees()">
                                        <option selected="selected" disabled="disabled">Select a Department</option>
                                        <?php $fun->getAllDepartments();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="transaction_type">Transaction Type</label>
                                    <select class="custom-select" name="transaction_type" id="transaction_type" onchange="SIVShow(this.value);populateItemsList(this.value)" required>
                                        <option selected="selected" disabled="disabled">Select Transaction Type</option>
                                        <?php $fun->getTransactionTypes();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="loc-row" hidden>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="transaction_type">Move To</label>
                                    <select class="custom-select" name="location" id="location" required>
                                        <option selected="selected" disabled="disabled">Select Location</option>
                                        <?php $fun->getLocations();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="item">Item</label>
                                    <select onchange="getIndvItem(this.value);getInStock(document.getElementById('item').value)" class="custom-select" name="item" id="item" required>
                                        <option selected="selected" disabled="disabled">Select an Item</option>
<!--                                        --><?php //$fun->getAllItems(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="items">Specifications</label>
                                    <select class="custom-select" name="items[]" id="items" onchange="Quantity();" required>
                                        <option selected="selected" disabled="disabled">Select an Item</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input class="form-control" type="number" id="quantity" name="quantity" placeholder="Quantity" title="Can not exceed in stock." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">In Stock</label>
                                    <input class="form-control" type="text" name="in_stock" id="in_stock" placeholder="In Stock" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remark">Remark</label>
                                    <textarea class="form-control" id="remark" name="remark" placeholder="Remark"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employee">Recipient</label>
                                    <select class="custom-select" name="employee" id="employee" required>
                                        <option selected="selected" disabled="disabled">Select an Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="label">SIV Number</label>
                                <input class="form-control" name="siv" type="text" id="siv" placeholder="SIV" pattern="[0-9]{1-10}">
                            </div>
                            <div class="col-md-4">
                                <label class="label">Requisition</label>
                                <input class="form-control" name="requisition" type="text" id="req" placeholder="Requisition Number" pattern="[0-9]{1-10}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col  text-right">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
<?php
include "include/divisions/footer.php";
