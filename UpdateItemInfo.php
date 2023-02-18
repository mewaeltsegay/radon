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

$item ="";
$res = "";
$db = new DB_Connect();
$conn = $db->connect();

if(isset($_GET["item"]) && isset($_GET["type"])){
    $item = $_GET["item"];
    $type = $_GET["type"];
    $res = "";

    if($type == "Fixed Asset"){
        $sql = "select item,type,category,location,unit_price,unit_measure,manufacturer,model,reorder_level,target_stock_level,description,picture,assigned_to from inventory where unique_id='".$item."'";
    }
    else{
        $sql = "select item,type,category,location,unit_price,unit_measure,manufacturer,model,reorder_level,target_stock_level,description,picture from inventory where item='".$item."' and type='".$type."' group by item";
    }

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $res = $row;
        }
    }
}
elseif (isset($_GET["id"])){
    $id = $_GET["id"];
    $type = "none";
    $sql = "select item,type,category,location,unit_price,unit_measure,manufacturer,model,reorder_level,target_stock_level,description,picture from inventory where unique_id='".$id."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $res = $row;
        }
    }

}
else{
    echo "<script>
                window.location.assign(\"dashboard.php\");
          </script>";
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
                            <h3 class="mb-0">Edit Item</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form autocomplete="off" id="form1" method="post" action="Items/UpdateItem.php?<?php if($type=='Fixed Asset'){echo "item=".$res["item"];}elseif ($type=='none'){ }else{echo "item=".$item;} if($type=='Fixed Asset'){echo "&uuid=".$item;} if($type=='none'){ echo 'id='.$_GET['id'];}?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="label">Name</label>
                                        <div class="autocomplete form-group">
                                            <input type="text" class="form-control" id="items2" name="itemname" placeholder="Item Name" value='<?php if($type=='Fixed Asset'){echo $res["item"];}elseif ($type == "none"){echo $res["item"];}else{echo $item;}?>' required pattern="[A-Za-z0-9/- ]{2,50}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="label" for="type">Item Type</label>
                                        <select class="custom-select" name="type" id="type" required>
                                            <option selected="selected" disabled="disabled">Type</option>
                                            <option <?php if($res["type"] == 'Inventory'){ echo "selected";}?>>Inventory</option>
                                            <option <?php if($res["type"] == 'Fixed Asset'){ echo "selected";}?>>Fixed Asset</option>
                                        </select>
                                    </div>
                                </div>
                                <?php if($type == "Fixed Asset"){?>
                                <div class="row mb-2" id="rowAssignedTo" >
                                    <div class="col">
                                        <label for="assigned_to">Assigned To</label>
                                        <select class="custom-select" name="assigned_to" id="assigned_to" required>
                                            <option selected="selected" disabled="disabled" value="">Employee</option>
                                            <?php $fun->getAllEmployees($fun->getEmployee2($res["assigned_to"]));?>
                                        </select>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Category</label>
                                            <select class="custom-select" id="category" name="category" required>
                                                <option selected="selected" disabled="disabled">Select Category</option>
                                                <?php $fun->getCategories($fun->getCategory($res["category"]));?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Location</label>
                                            <select class="custom-select" id="location" name="location" required>
                                                <option selected="selected" disabled="disabled">Select Location</option>
                                                <?php $fun->getLocations($fun->getLocation($res["location"]));?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Manufucturer</label>
                                            <input type="text" class="form-control" id="manufacturer" name="manufacturer" placeholder="Manufacturer" value="<?php echo $res['manufacturer']?>" pattern="[a-zA-Z0-9/- ]{2,50}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Model</label>
                                            <input type="text" class="form-control" id="model" name="model" placeholder="Model" value="<?php echo $res['model']?>" pattern="[a-zA-Z0-9/- ]{2,50}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Reorder Level</label>
                                            <input type="text" class="form-control" id="reorderlevel" name="reorderlevel" placeholder="Reorder Level" value="<?php echo $res['reorder_level']?>" required pattern="[0-9]{1,5}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Target Stock Level</label>
                                            <input type="text" class="form-control" id="target" name="target" placeholder="Target Stock Level" value="<?php echo $res['target_stock_level']?>" required pattern="[0-9]{1,5}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Unit Price</label>
                                            <input type="text" class="form-control" id="price" name="price" placeholder="price" value="<?php echo $res['unit_price']?>" required pattern="[0-9.]{1,8}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">Unit Measure</label>
                                            <select class="custom-select" name="measure" id="measure" required>
                                                <option selected="selected" disabled="disabled">Unit Measure</option>
                                                <?php $fun->getUnits($res["unit_measure"]);?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"><?php echo $res["description"]?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col"  id="image">
                                        <div class="form-group">
                                            <?php if($res["picture"] == ""){?>
                                            <label>Image</label>
                                            <div class="img-center card-img-top text-center border rounded" id="icon" style="height: 240px">
                                                <i class="fas fa-camera mt-6" style="font-size: 64pt;"></i>
                                            </div>
                                            <img class="img-center card-img-top text-center border rounded" id="pic" src="#" hidden/>
                                            <input class="" name="image" id="browse" type="file" style="width: 240pt;overflow: hidden;text-overflow: clip;display: none" onchange="preview(this)">
                                            <button type="button" class="btn btn-outline-primary mt--7 mb--3 ml-2 rounded-circle" style="width: 40px;height: 40px" onclick="document.getElementById('browse').click()"><i class="fas fa-plus ml--2 mr--2"></i></button>
                                            <?php } else{?>
                                                <label>Image</label>
                                                <img class="img-center card-img-top text-center border rounded" id="pic" src="Items/images/<?php echo $res["picture"]?>.jpg"/>
                                                <input class="" name="image" id="browse" type="file" style="width: 240pt;overflow: hidden;text-overflow: clip;display: none" onchange="preview(this)">
                                                <input name="saved" type="text" value="<?php echo $res["picture"]?>" hidden>
                                                <button type="button" class="btn btn-outline-primary bg-white mt--7 mb--3 ml-2 rounded-circle" style="width: 40px;height: 40px" onclick="document.getElementById('browse').click()"><i class="fas fa-plus ml--2 mr--2"></i></button>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" class="btn btn-primary" value="Update">
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
