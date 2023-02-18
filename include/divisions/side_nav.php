<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/6/2020
 * Time: 5:59 PM
 */
include 'include/operations/DB_Functions.php';

$fun = new DB_Functions();

$permissions = $fun->getUserPermissions($_COOKIE["uuid"]);
?>

<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-dark bg-gradient-dark" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <div class="row flex">
            <div class="col-sm-1">
                <i style="font-size: 20pt" class="ni ni-atom mt-4 text-blue"></i>
            </div>
            <div class="col-sm-1">
                <h1 class="text-blue" style="font-size: 35pt;font-weight: 700">radon</h1>
            </div>
        </div>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                  <i class="fas fa-user-astronaut" style="font-size: 15pt"></i>
                </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <a href="profile.php" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>My profile</span>
                    </a>
<!--                    <a href="#" class="dropdown-item">-->
<!--                        <i class="ni ni-settings-gear-65"></i>-->
<!--                        <span>Settings</span>-->
<!--                    </a>-->
<!--                    <a href="#" class="dropdown-item">-->
<!--                        <i class="ni ni-calendar-grid-58"></i>-->
<!--                        <span>Activity</span>-->
<!--                    </a>-->
<!--                    <a href="#" class="dropdown-item">-->
<!--                        <i class="ni ni-support-16"></i>-->
<!--                        <span>Support</span>-->
<!--                    </a>-->
                    <div class="dropdown-divider"></div>
                    <a href="#!" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="dashboard.php">
                            <img src="./assets/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none" method="post" action="results.php">
                <div class="input-group input-group-rounded input-group-merge">
                    <input name="q" type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                    <input id="sub2" type="submit" hidden>
                    <div class="input-group-prepend" onclick="document.getElementById('sub2').click();">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item <?php if($fun->getScriptName() == "dashboard.php"){echo "active";}?>">
                    <a class="nav-link <?php if($fun->getScriptName() == "dashboard.php"){echo "active";}?>" href="dashboard.php">
                        <i class="ni ni-tv-2 text-blue"></i> Dashboard
                    </a>
                </li>
                <?php if(in_array("view_items",$permissions["name"]) || in_array("add_item",$permissions["name"])){?>
                <li class="nav-item <?php if($fun->getScriptName() == "inventory.php" || $fun->getScriptName() == "additems.php"){echo "active";}?>">
                    <a class="nav-link <?php if($fun->getScriptName() == "inventory.php" || $fun->getScriptName() == "additems.php"){echo "active";}?>" href="<?php if(in_array("view_items",$permissions["name"])){echo "inventory.php";}else{echo "additems.php";} ?>">
                        <i class="ni ni-collection text-orange"></i> Inventory
                    </a>
                    <?php if($fun->getScriptName() == "inventory.php" || $fun->getScriptName() == "additems.php"){?>
                    <ul class="nav-item" style="list-style-type: none">
                        <li class="nav-item <?php if($fun->getScriptName() == "inventory.php"){echo "active";}?>">
                            <?php if(in_array("view_items",$permissions["name"])){?>
                            <a class="nav-link nav-link-icon <?php if($fun->getScriptName() == "inventory.php"){echo "active";}?>" href="inventory.php">
                                <i class="fas fa-list text-blue"></i>
                                <span class="nav-link-inner--text">All Items</span>
                            </a>
                            <?php } ?>
                        </li>
                        <li class="nav-item <?php if($fun->getScriptName() == "additems.php"){echo "active";}?>" >
                            <?php if(in_array("add_item",$permissions["name"])){?>
                            <a class="nav-link nav-link-icon <?php if($fun->getScriptName() == "additems.php"){echo "active";}?>" href="additems.php">
                                <i class="ni ni-archive-2 text-yellow"></i>
                                <span class="nav-link-inner--text">Add Items</span>
                            </a>
                            <?php } ?>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <?php }
                if(in_array("view_fixed",$permissions["name"])){
                ?>
                <li class="nav-item <?php if($fun->getScriptName() == "fixedAsset.php"){echo "active";}?>">
                    <a class="nav-link" href="fixedAsset.php">
                        <i class="ni ni-building text-pink"></i> Fixed Asset
                    </a>
                </li>
                <?php }
                if(in_array("view_transactions",$permissions["name"]) || in_array("add_transaction",$permissions["name"])){
                ?>
                <li class="nav-item <?php if($fun->getScriptName() == "transactions.php" || $fun->getScriptName() == "newTransaction.php"){echo "active";}?>">
                    <a class="nav-link <?php if($fun->getScriptName() == "transactions.php" || $fun->getScriptName() == "newTransaction.php"){echo "active";}?>" href="<?php if(in_array("view_transactions",$permissions["name"])){echo "transactions.php";}else{echo "newTransaction.php";} ?>">
                        <i class="fas fa-exchange-alt text-cyan"></i> Transactions
                    </a>
                    <?php if($fun->getScriptName() == "transactions.php" || $fun->getScriptName() == "newTransaction.php"){?>
                        <!-- Navbar items -->
                        <ul class="nav-item" style="list-style-type: none">
                            <li class="nav-item <?php if($fun->getScriptName() == "transactions.php"){echo "active";}?>">
                                <?php if(in_array("view_transactions",$permissions["name"])){?>
                                <a class="nav-link nav-link-icon <?php if($fun->getScriptName() == "transactions.php"){echo "active";}?>" href="transactions.php">
                                    <i class="fas fa-list text-blue"></i>
                                    <span class="nav-link-inner--text">All Transactions</span>
                                </a>
                                <?php } ?>
                            </li>
                            <li class="nav-item <?php if($fun->getScriptName() == "newTransaction.php"){echo "active";}?>">
                                <?php if(in_array("add_transaction",$permissions["name"])){?>
                                <a class="nav-link nav-link-icon <?php if($fun->getScriptName() == "newTransaction.php"){echo "active";}?>" href="newTransaction.php">
                                    <i class="fas fa-people-carry text-yellow"></i>
                                    <span class="nav-link-inner--text">New</span>
                                </a>
                                <?php } ?>
                            </li>
                        </ul>
                    <?php }?>
                </li>
                <?php }
                if(in_array("view_damaged",$permissions["name"])){
                ?>
                <li class="nav-item <?php if($fun->getScriptName() == "damaged.php" || $fun->getScriptName() == "damaged2.php"){echo "active";}?>">
                    <a class="nav-link <?php if($fun->getScriptName() == "damaged.php" || $fun->getScriptName() == "damaged2.php"){echo "active";}?>" href="damaged.php">
                        <i class="fas fa-exclamation-triangle text-danger"></i> Damaged Items
                    </a>
                </li>
                <?php }
                if(in_array("view_employees",$permissions["name"]) || in_array("add_employee",$permissions["name"])){
                ?>
                <li class="nav-item <?php if($fun->getScriptName() == "employees.php" || $fun->getScriptName() == "addEmployee.php"){echo "active";}?>">
                    <a class="nav-link <?php if($fun->getScriptName() == "employees.php" || $fun->getScriptName() == "addEmployee.php"){echo "active";}?>" href="<?php if(in_array("view_employees",$permissions["name"])){echo "employees.php";}else{echo "addEmployee.php";} ?>">
                        <i class="fas fa-users text-yellow"></i> Employees
                    </a>
                    <?php if($fun->getScriptName() == "employees.php" || $fun->getScriptName() == "addEmployee.php" || $fun->getScriptName() == "editEmployee.php" ){?>
                        <!-- Navbar items -->
                        <ul class="nav-item" style="list-style-type: none">
                            <li class="nav-item <?php if($fun->getScriptName() == "employees.php"){echo "active";}?>">
                                <?php if(in_array("view_employees",$permissions["name"])){?>
                                <a class="nav-link nav-link-icon <?php if($fun->getScriptName() == "employees.php"){echo "active";}?>" href="employees.php">
                                    <i class="fas fa-list text-blue"></i>
                                    <span class="nav-link-inner--text">All Employees</span>
                                </a>
                                <?php }?>
                            </li>
                            <li class="nav-item <?php if($fun->getScriptName() == "addEmployee.php"){echo "active";}?>">
                                <?php if(in_array("add_employee",$permissions["name"])){?>
                                <a class="nav-link nav-link-icon <?php if($fun->getScriptName() == "addEmployee.php"){echo "active";}?>" href="addEmployee.php">
                                    <i class="fas fa-user-plus text-yellow"></i>
                                    <span class="nav-link-inner--text">Add Employee</span>
                                </a>
                                <?php } ?>
                            </li>
                        </ul>
                    <?php }?>
                </li>
                <?php }
                if(in_array("create_reports",$permissions["name"])){
                ?>
                <li class="nav-item <?php if($fun->getScriptName() == "report.php"){echo "active";}?>">
                    <a class="nav-link <?php if($fun->getScriptName() == "report.php"){echo "active";}?>" href="report.php">
                        <i class="fas fa-file-alt text-green"></i> Reports
                    </a>
                </li>
                <?php } ?>
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Additional</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <?php if(in_array("create_user",$permissions["name"])){?>
                <li class="nav-item <?php if($fun->getScriptName() == "users.php"){echo "active";}?>">
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users-cog"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="roles.php">
                        <i class="fas fa-user-ninja"></i> Roles
                    </a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">
                        <i class="fas fa-stream"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="locations.php">
                        <i class="fas fa-map-marker-alt"></i> Locations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="departments.php">
                        <i class="fas fa-university"></i> Departments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="units.php">
                        <i class="fas fa-balance-scale"></i> Units
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-dark <?php if($fun->getScriptName() != 'profile.php'){ echo 'pt-5 pt-md-8 pb-8';}?>">
        <div class="container-fluid">
            <div class="header-body">
