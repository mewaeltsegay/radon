<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/4/2020
 * Time: 9:21 PM
 */
if($_COOKIE["usertype"] != "Administrator"){
    header('location:login.php');
}

$success = '';
if(isset($_GET["success"])){
    $success = $_GET["success"];
}
$role = "";
if(isset($_GET["role"])){
    $role = $_GET["role"];
}
else{
    header('location:roles.php');
}

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <div class="container-fluid mt--7">
    <div class="container-fluid mt--7">
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col"></div>
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Modify Role</h3>
                </div>
                <div class="card-body">
                    <?php if($success == "true"){?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Success!</strong> Role has been modified.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } if($success == "false"){?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-inner--text"><strong>Error!</strong> Try again.</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php }?>
                    <form method="post" action="admin/updateRole.php?rolename=<?php echo $role;?>">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">Role Name</label>
                                    <input type="text" class="form-control" id="role" name="role" placeholder="Role" value="<?php echo $role;?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">Description</label>
                                    <textarea type="text" class="form-control" id="role" name="description" placeholder="Description"><?php echo $fun->getRoleDescription($role);?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php $fun->populateRolePermissions($role,0,0);?>
                            </div>
                            <div class="col">
                                <?php $fun->populateRolePermissions($role,8,0);?>
                            </div>
                            <div class="col">
                                <?php $fun->populateRolePermissions($role,16,0);?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col text-right"><button class="btn btn-primary" type="submit">Update</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
<?php
include "include/divisions/footer.php";
