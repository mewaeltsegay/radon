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
$success = "";

if(isset($_GET["success"])){
    if($_GET["success"] == 'true'){
        $success = 'true';
    }
    if($_GET["success"] == 'false'){
        $success = 'false';
    }
}
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <div class="container-fluid mt--7">
    <?php if($success == 'true'){?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
        <span class="alert-inner--text"><strong>Success!</strong> Password has been changed.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php } if($success == 'false'){?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
        <span class="alert-inner--text"><strong>Failure!</strong> Please try again.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php  } ?>
        <div class="mb-2">
            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                <li class="nav-item ">
                    <a class="nav-link mb-sm-3 mb-md-0 active card" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fas fa-users"></i>Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 card" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fas fa-user-plus"></i>New User</a>
                </li>
            </ul>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="table-responsive">
                            <div>
                                <table class="table align-items-center">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">
                                            Name
                                        </th>
                                        <th scope="col">
                                            Username
                                        </th>
                                        <th scope="col">
                                            Department
                                        </th>
                                        <th scope="col">Role</th>
                                        <th scope="col"></th>                                    </tr>
                                    </thead>
                                    <tbody class="list">
                                        <?php $fun->populateUsers();?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                        <form method="post" action="admin/processUserRegistration.php" onsubmit="return confirmpasswords2()">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="label">First Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="fname" placeholder="First Name" pattern="[a-zA-Z]{3,20}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label">Last Name</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Last Name" class="form-control" name="lname"pattern="[a-zA-Z]{3,20}" required/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label">User Name</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="User Name" class="form-control" name="uname"pattern="[a-zA-Z.-_]{3,20}" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label class="label" for="dept">Department</label>
                                    <select class="custom-select" name="dept" id="dept" required>
                                        <option selected="selected" disabled="disabled">Select a Department</option>
                                        <?php $fun->getAllDepartments();?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="label" for="role">Role</label>
                                    <select class="custom-select" name="role" id="role" required>
                                        <option selected="selected" disabled="disabled">Select Role</option>
                                        <?php $fun->getAllRoles();?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="label">Password</label>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="pass" name="password" placeholder="Password" required minlength="8">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="label">Confirm</label>
                                    <div class="form-group">
                                        <input type="password" placeholder="Re-enter Password" id="pass2" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col"></div>
                                <div class="col"></div>
                                <div class="col text-right"><button type="submit" class="btn btn-primary" <?php if(!in_array("create_user",$permissions["name"])){echo "disabled";}?>>Register</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Update User Info</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body card">
                    <form id="users-form" method="post" action="admin/updateUserInfo.php" onsubmit="return confirmpasswords2()">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="label">First Name</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" pattern="[a-zA-Z]{3,20}" required>
                                    <input type="text" class="form-control" id="uuid" name="uuid" placeholder="uuid" hidden>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="label">Last Name</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Last Name" class="form-control" id="lname" name="lname"pattern="[a-zA-Z]{3,20}" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="label">User Name</label>
                                <div class="form-group">
                                    <input type="text" placeholder="User Name" class="form-control" id="uname" name="uname"pattern="[a-zA-Z.-_]{3,20}" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label class="label" for="dept">Department</label>
                                <select class="custom-select" name="dept" id="dept1" required>
                                    <option selected="selected" disabled="disabled">Select a Department</option>
                                    <?php $fun->getAllDepartments();?>
                                </select>
                            </div>
                            <div class="col">
                                <label class="label" for="role">Role</label>
                                <select class="custom-select" name="role" id="role1" required>
                                    <option selected="selected" disabled="disabled">Select Role</option>
                                    <?php $fun->getAllRoles();?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button form="users-form" type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="modal-password" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Change User Password</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body card">
                    <form id="pass-form" method="post" action="admin/updateUserPassword.php" onsubmit="return confirmpasswords3()">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="label">Password</label>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="pass1" name="password" placeholder="Password" required minlength="8">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="label">Confirm</label>
                                <div class="form-group">
                                    <input type="password" placeholder="Re-enter Password" id="pass12" class="form-control"/>
                                    <input type="text" id="uuid2" name="uuid2" class="form-control" hidden/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="pass-form" type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

<?php
include "include/divisions/footer.php";
