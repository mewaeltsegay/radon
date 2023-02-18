<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/7/2020
 * Time: 10:11 AM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
//include "include/divisions/stat_cards.php";
include "include/divisions/top_nav.php";

$success = '';
$reason = '';

if(isset($_GET["success"])){
    $success = $_GET["success"];
    if($success == "false"){
        if(isset($_GET["reason"])){
            if($_GET["reason"] == "nocopy"){
                $reason = " Unable to upload image.Try again";
            }
            else{
                $reason = " Unable to add item to the inventory.Try again";
            }
        }
    }
}
?>
<div class="container-fluid mt--7 bg-gradient-dark">
    <div class="row mt-5 align-items-center">
        <div class="col"></div>
        <div class="col-xl-10 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Add Item</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($success == "true"){?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Success!</strong> Item was added to the inventory.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } if($success == "false"){?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Error!</strong><?php echo $reason;?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php }?>
                        <form autocomplete="off" id="form1" method="post" action="Items/processItem.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="label">Name</label>
                                <div class="autocomplete form-group">
                                    <input onkeyup="getItemInfo(this.value)" type="text" class="form-control" id="items" name="itemname" placeholder="Item Name" required pattern="[A-Za-z0-9/- ]{2,50}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="label" for="type">Item Type</label>
                                <select class="custom-select" name="type" id="type" onchange="showAssignedTo()" required>
                                    <option selected="selected" disabled="disabled" value="">Select Type</option>
                                    <option>Inventory</option>
                                    <option>Fixed Asset</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2" id="rowAssignedTo" hidden>
                            <div class="col">
                                <label for="assigned_to">Assigned To</label>
                                <select class="custom-select" name="assigned_to" id="assigned_to" disabled required>
                                    <option selected="selected" disabled="disabled" value="">Employee</option>
                                    <?php $fun->getAllEmployees();?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label">Category</label>
                                    <select class="custom-select" id="category" name="category" required>
                                        <option selected="selected" disabled="disabled" value="">Select Category</option>
                                        <?php $fun->getCategories();?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label">Location</label>
                                    <select class="custom-select" id="location" name="location" required>
                                        <option selected="selected" disabled="disabled" value="">Select Location</option>
                                        <?php $fun->getLocations();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Manufucturer</label>
                                    <input type="text" class="form-control" id="manufacturer" name="manufacturer" placeholder="Manufacturer" pattern="[a-zA-Z0-9/- ]{2,50}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Model</label>
                                    <input type="text" class="form-control" id="model" name="model" placeholder="Model" pattern="[a-zA-Z0-9/- ]{2,50}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Serial No.</label>
                                    <input onkeyup="setQuantity(this.value)" type="text" class="form-control" id="serialno" name="serialno" placeholder="Serial Number" pattern="[a-zA-Z0-9/-]{2,50}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Supplier</label>
                                    <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Supplier" pattern="[a-zA-Z0-9/- ]{2,50}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Reorder Level</label>
                                    <input type="text" class="form-control" id="reorderlevel" name="reorderlevel" placeholder="Reorder Level" required pattern="[0-9]{1,5}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Target Stock Level</label>
                                    <input type="text" class="form-control" id="target" name="target" placeholder="Target Stock Level" required pattern="[0-9]{1,5}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col">
                                        <label class="label">Discontinued</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <span class="clearfix"></span>
                                            <label class="custom-toggle">
                                                <input type="checkbox" id="discontinued" name="discontinued">
                                                <span class="custom-toggle-slider rounded-circle"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Unit Price</label>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" required pattern="[0-9.]{1,8}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Unit Measure</label>
                                    <select class="custom-select" name="measure" id="measure" required>
                                        <option selected="selected" disabled="disabled">Unit Measure</option>
                                        <?php $fun->getUnits();?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                            <div class="col">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" pattern="[0-9.]{1,5}" required>
                                            </div>
                                            <div class="col">
                                                <label>Expiry Date</label>
                                                <input type="date" class="form-control" id="expire" name="expire" placeholder="Expiry Date">
                                            </div>
                                        </div>
                        <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                        <div class="row pb-2">
                            <div class="col">
                                <label>GRN Number</label>
                                <input class="form-control" type="text" name="grn" placeholder="GRN Number" pattern="[0-9]{1,10}">
                            </div>
                            <div class="col">
                                <label>Purchase Order</label>
                                <input class="form-control" type="text" name="purchase" placeholder="Purchase Order Number" pattern="[0-9]{1,10}">
                            </div>
                            <div class="col">
                                <label>Purchase Date</label>
                                <input class="form-control" type="date" name="purchase_date" placeholder="Purchase Date">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col">
                                <label>Submitted By</label>
                                <select class="custom-select" name="submitted" id="submitter">
                                    <option selected="selected" disabled="disabled">Employee</option>
                                    <?php $fun->getAllEmployees();?>
                                </select>
                            </div>
                            <div class="col">
                                <label>Received By</label>
                                <select class="custom-select" name="received" id="receiver">
                                    <option selected="selected" disabled="disabled">Employee</option>
                                    <?php $fun->getAllEmployees();?>
                                </select>
                            </div>
                            <div class="col">
                                <label>Authorised By</label>
                                <select class="custom-select" name="authorised" id="authoriser">
                                    <option selected="selected" disabled="disabled">Employee</option>
                                    <?php $fun->getAllEmployees();?>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col"  id="image">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <div class="img-center card-img-top text-center border rounded" id="icon" style="height: 240px">
                                            <i class="fas fa-camera mt-6" style="font-size: 64pt;"></i>
                                        </div>
                                        <img class="img-center card-img-top text-center border rounded" id="pic" src="#" hidden/>
                                        <input class="" name="image" id="browse" type="file" style="width: 240pt;overflow: hidden;text-overflow: clip;display: none" onchange="preview(this)">
                                        <button type="button" class="btn btn-outline-primary mt--7 mb--3 ml-2 rounded-circle" style="width: 40px;height: 40px" onclick="document.getElementById('browse').click()"><i class="fas fa-plus ml--2 mr--2"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt--3">
                                    <div class="form-group">
                                        <label>In Stock</label>
                                        <input class="form-control text-right text-lg" type="text" id="stock" readonly placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" class="btn btn-primary" value="Add">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
        <?php
include 'include/divisions/footer.php'
?>
    <script>
        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("items"), getAllItems());
    </script>
