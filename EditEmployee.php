<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/12/2020
 * Time: 3:17 PM
 */
if(!isset($_GET["id"])){
    header('location:employees.php');
}

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";

$success = "";
if(isset($_GET["success"])){
    $success = $_GET["success"];
}

$db = new DB_Connect();
$conn = $db->connect();

$sql = "select * from employees where id=".$_GET["id"];
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
?>
    <div class="container-fluid mt--7">
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col"></div>
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Employee Info</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="employees/processEmployeeEdit.php?id=<?php echo $_GET["id"];?>" id="form1" enctype="multipart/form-data">
                        <?php if($row["picture"] != ""){?>
                            <div class="card-img-top text-center">
                                <img class="border rounded-circle p-1 bg-white" style="width:160pt; height:160pt;object-fit: cover" id="pic" src="employees/images/<?php echo $row["picture"];?>.jpg"/>
                                <div class="text-center pt-2 pl-6 pb-2">
                                    <button type="button" class="btn btn-primary rounded-circle border ml--9 mt--6" style="width: 40pt;height: 40pt" onclick="document.getElementById('browse').click()"><i class="fas fa-plus ml--2 mr--2" style="font-size: 16pt"></i></button>
                                    <input type="file" name="picture" id="browse" onchange="preview(this)" style="display: none">
                                    <input type="text" name="saved" value="<?php echo $row["picture"];?>" hidden>
                                </div>
                            </div>
                        <?php }
                        if($row["picture"] == ""){?>
                            <div class="card-img-top text-center">
                                <div id="icon">
                                    <i class="icon-lg rounded-circle border fas fa-user text-center pt-5" style="width:160pt; height:160pt; font-size: 70pt"></i>
                                </div>
                                <img class="border rounded-circle p-1 bg-white" style="width:160pt; height:160pt;object-fit: cover" id="pic" src="#" hidden/>
                                <div class="text-center pt-2 pl-6 pb-2">
                                    <button type="button" class="btn btn-primary rounded-circle border ml--9 mt--6" style="width: 40pt;height: 40pt" onclick="document.getElementById('browse').click()"><i class="fas fa-plus ml--2 mr--2" style="font-size: 16pt"></i></button>
                                    <input type="file" name="picture" id="browse" onchange="preview(this)" style="display: none">
                                </div>
                            </div>
                            <?php } ?>
                        <?php if($success == 'true'){?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-inner--text"><strong>Success!</strong> Done.</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php } if($success == 'false'){?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-inner--text"><strong>Error!</strong> Something went wrong. Try Again.</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php } if($success == 'false2'){?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-inner--text"><strong>Error!</strong> Couldn't Upload Image. Try Again.</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php }?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name" required pattern="[a-zA-Z]{2,40}" value="<?php echo ucwords($row["first_name"]);?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" required pattern="[a-zA-Z]{2,40}"  value="<?php echo ucwords($row["last_name"]);?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                <label for="dept">Department</label>
                                <select name="department" id="dept" class="custom-select" required>
                                    <option selected="selected" disabled="disabled">Select a Department</option>
                                    <?php $fun->getAllDepartments($row["department"]);?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Work Phone No.</label>
                                    <input type="text" class="form-control" name="work_phone" placeholder="Work Phone" pattern="([0-9]{6}|^08[0-9]{6})" value="<?php echo $row["work_phone"];?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Home Phone No.</label>
                                    <input type="text" class="form-control" name="home_phone" placeholder="Home Phone" pattern="([0-9]{6}|^08[0-9]{6})" value="<?php echo $row["home_phone"];?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile Phone</label>
                                    <input type="text" class="form-control" name="mobile_phone" placeholder="Mobile" pattern="^07[0-9]{6}" value="<?php echo $row["mobile_phone"];?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo ucwords($row["address"]);?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo ucwords($row["city"]);?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Zoba</label>
                                    <input type="text" class="form-control" name="zoba" placeholder="Zoba" value="<?php echo ucwords($row["zoba"]);?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col text-right">
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
    }
}
include "include/divisions/footer.php";
