<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/8/2020
 * Time: 4:32 PM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";

if(isset($_GET["page"])) {
    $page = $_GET["page"];
}
else{
    $page = 1;
}
?>
<div class="container-fluid mt--7">
    <form id="form1" method="post">
    </form>
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow landscape">
                <div class="card-header border-0">
                    <h3 class="mb-0">Inventory</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-fill-2">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Location</th>
                            <th scope="col">Category</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Measure</th>
                            <th scope="col">Total Price</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $count = $fun->inventoryPageCount();
                            $fun->populateInventoryListMod(($page-1)*14);
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php if(($page-1)<1){echo "disabled";}?>">
                                <a class="page-link" href="<?php if(($page-1)>=1){echo "inventory.php?page=".($page-1);}?>" tabindex="-1">
                                    <i class="fa fa-angle-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?php

                            $pages = ceil(($count/14));
                            for($i=1;$i<=$pages;$i++){
                                ?>
                                <li class="page-item <?php if($i == $page){echo "active";}?>"><a class="page-link" href="inventory.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                            <?php
                            }
                            ?>
                            <li class="page-item <?php if(($page+1)>$pages){echo "disabled";}?>">
                                <a class="page-link" href="<?php if(($page+1)<=$pages){echo "inventory.php?page=".($page+1);}?>">
                                    <i class="fa fa-angle-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-fluid" role="document">
            <div class="modal-content bg-gradient-danger">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img id="imageModalContent" class="img-fluid img-center border border-light">
                </div>

            </div>
        </div>
<?php
include "include/divisions/footer.php";
?>
