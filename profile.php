<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/2/2020
 * Time: 4:38 PM
 */
$success = "";
$pass = "";
$old = "";
if(isset($_GET['success'])){
    $success = $_GET["success"];
}
if(isset($_GET["pass"])){
    $pass = $_GET["pass"];
}
if(isset($_GET["old"])){
    $old = $_GET["old"];
}
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";

?>
    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url('assets/img/theme/ncew logo.png'); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <h1 class="display-2 text-white">Hello <?php echo ucwords(explode(' ',$_COOKIE["username"])[0]);?></h1>
                    <p class="text-white mt-0 mb-5">This is your profile page. You can change your password or change your account and user name from here.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image rounded-circle border align-items-center ml--6 mt--6 text-center bg-gray" style="height: 200px;width: 200px;">
                                <a href="#">
                                    <i class="fas fa-user-astronaut mt-5 text-white" style="font-size: 74pt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
<!--                            <div class="col">-->
<!--                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">-->
<!--                                    <div>-->
<!--                                        <span class="heading">22</span>-->
<!--                                        <span class="description">Friends</span>-->
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <span class="heading">10</span>-->
<!--                                        <span class="description">Photos</span>-->
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <span class="heading">89</span>-->
<!--                                        <span class="description">Comments</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div class="text-center pt--6">
                            <h3>
                                <?php echo ucwords($_COOKIE["username"]);?>
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>Asmara, Eritrea
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i><?php echo ucwords($_COOKIE["usertype"])?>
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i><?php echo $fun->getDeptName($_COOKIE["deptid"]);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">My account</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button form="info" type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                        <?php if($success == 'true'){?>
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-inner--text"><strong>Success!</strong> User information updated.</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php } if($success == 'false'){?>
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-inner--text"><strong>Failed!</strong> Try again.</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php }?>
                    </div>
                    <div class="card-body">
                        <form id="info" method="post" action="users/processUserInfoChange.php">
                            <h6 class="heading-small text-muted mb-4">User information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Username</label>
                                            <input type="text" id="input-username" name="uname" class="form-control form-control-alternative" placeholder="Username" value="<?php echo $_COOKIE['uname'];?>" pattern="[a-zA-Z._-]{3,40}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Role</label>
                                            <input type="text" id="input-email" class="form-control form-control-alternative" placeholder="<?php echo $_COOKIE['usertype'];?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-first-name">First name</label>
                                            <input type="text" id="input-first-name" name="fname" class="form-control form-control-alternative" placeholder="First name" value="<?php echo explode(' ',$_COOKIE['username'])[0];?>" pattern="[a-zA-Z]{3,20}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-last-name">Last name</label>
                                            <input type="text" id="input-last-name" name="lname" class="form-control form-control-alternative" placeholder="Last name" value="<?php echo explode(' ',$_COOKIE['username'])[1];?>" pattern="[a-zA-Z]{3,20}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <hr class="my-4" />
                            <!-- Password -->
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h6 class="heading-small text-muted mb-4">Change Password</h6>
                                </div>
                                <div class="col-4 text-right mb-4">
                                    <button type="submit" form="password" class="btn btn-sm btn-primary">Save</button>
                                </div>
                            </div>
                        <?php if($pass == 'true'){?>
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-inner--text"><strong>Success!</strong> Password changed.</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } if($pass == 'false'){?>
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-inner--text"><strong>Failed!</strong> Try again.</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } if($old == 'false'){?>
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-inner--text"><strong>Failed!</strong> Old password incorrect.</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php }?>
<!--                            <h6 class="heading-small text-muted mb-4">Change Password</h6>-->
                        <form id="password" method="post" action="users/processUserPasswordChange.php" onsubmit="return confirmpasswords()">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Old Password</label>
                                            <input id="old" name="old" class="form-control form-control-alternative" placeholder="Old Password" type="password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-city">New Password</label>
                                            <input type="password" id="new" name="new" class="form-control form-control-alternative" placeholder="New Password" minlength="8" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-country">Confirm</label>
                                            <input type="password" id="confirm" name="confirm" class="form-control form-control-alternative" placeholder="Confirm Password" minlength="8" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <hr class="my-4" />
                            <!-- Description -->
                            <h6 class="heading-small text-muted mb-4">Privileges</h6>
                            <div class="pl-lg-4">
                                <div class="form-group" readonly>
                                    <div class="row">
                                        <div class="col">
                                            <?php $fun->populateRolePermissions($_COOKIE["usertype"],0,1);?>
                                        </div>
                                        <div class="col">
                                            <?php $fun->populateRolePermissions($_COOKIE["usertype"],8,1);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

<?php
include "include/divisions/footer.php";

