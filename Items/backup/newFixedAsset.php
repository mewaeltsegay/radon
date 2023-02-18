<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 6/7/2020
 * Time: 11:07 AM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
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
                            <h3 class="mb-0">Add Asset</h3>
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
                    <form autocomplete="off" id="form1" method="post" action="../processAsset.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="label">Name</label>
                                        <div class="autocomplete form-group">
                                            <input type="text" class="form-control" id="items" name="itemname" placeholder="Item Name" required pattern="[A-Za-z0-9 ]{2,50}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Category</label>
                                            <select class="custom-select" id="category" name="category" required>
                                                <option selected="selected" disabled="disabled">Select Category</option>
                                                <?php $fun->getCategories();?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Location</label>
                                            <select class="custom-select" id="location" name="location" required>
                                                <option selected="selected" disabled="disabled">Select Location</option>
                                                <?php $fun->getLocations();?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Manufucturer</label>
                                            <input type="text" class="form-control" id="manufacturer" name="manufacturer" placeholder="Manufacturer" pattern="[a-zA-Z0-9]{2,50}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Model</label>
                                            <input type="text" class="form-control" id="model" name="model" placeholder="Model" pattern="[a-zA-Z0-9]{2,50}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Serial No.</label>
                                            <input onkeyup="setQuantity(this.value)" type="text" class="form-control" id="serialno" name="serialno" placeholder="Serial Number" pattern="[0-9]{2,50}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Unit Price</label>
                                            <input type="text" class="form-control" id="price" name="price" placeholder="price" required pattern="[0-9.]{1,8}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Unit Measure</label>
                                            <select class="custom-select" name="measure" id="measure" required>
                                                <option selected="selected" disabled="disabled">measure</option>
                                                <?php $fun->getUnits();?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" pattern="[0-9.]{1,5}" required>
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
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col"  id="image">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <img class="img-center card-img-top text-center border rounded" id="pic" src="#" alt="Image" />
                                            <input class="pt-1" name="image" id="browse" type="file" style="width: 240pt;overflow: hidden;text-overflow: clip" onchange="preview(this)">
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
include "include/divisions/footer.php";
