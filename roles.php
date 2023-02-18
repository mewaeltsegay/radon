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

include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <div class="container-fluid mt--7">
    <div class="mb-2">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
            <li class="nav-item ">
                <a class="nav-link mb-sm-3 mb-md-0 active card" id="tabs-icons-text-1-tab" data-toggle="tab" href="#roles" role="tab" aria-controls="roles" aria-selected="true"><i class="fas fa-user-friends"></i>Roles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 card" id="tabs-icons-text-2-tab" data-toggle="tab" href="#newrole" role="tab" aria-controls="new_role" aria-selected="false"><i class="fas fa-robot"></i>New Role</a>
            </li>
        </ul>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Roles</th>
                                    <th scope="col">Permissions</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $fun->getRoles();?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="newrole" role="tabpanel" aria-labelledby="newrole">
                    <?php if($success == "true"){?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-inner--text"><strong>Success!</strong> Role has been created.</span>
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
                    <form method="post" action="admin/processRole.php">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">Role Name</label>
                                    <input type="text" class="form-control" id="role" name="role" placeholder="Role">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">Description</label>
                                    <textarea type="text" class="form-control" id="role" name="description" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php $fun->getPrivileges();?>
                            </div>
                            <div class="col">
                                <?php $fun->getPrivileges(8);?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col text-right"><button class="btn btn-primary" type="submit">Save</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
include "include/divisions/footer.php";
