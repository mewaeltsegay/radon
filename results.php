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

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

?>
<form id="form1" method="post">
</form>
<div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Results</h3>
                </div>
                <div class="card-body">
                    <div class="container3 mt--4 center flex-lg-wrap">
                        <div class="row">
                            <?php if($_SERVER["REQUEST_METHOD"] == "POST"){

                            $sql = "select * from inventory where item like '%".$_POST["q"]."%' or category in (SELECT id from category where category_name like '%".$_POST["q"]."%' GROUP BY id) GROUP BY item";
                            $result = mysqli_query($conn,$sql);

                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_assoc($result)){
                                        ?>
                                        <div class="card mt-3 mr-3" style="width: 18rem;">
                                            <?php if($row["picture"]!=''){?>
                                                <input id="<?php echo $row["id"];?>" name="item" type="submit" form="form1" formaction="<?php if($row['type'] == 'Inventory') {echo 'itemDetails.php';} else{ echo 'assetDetails.php?item='.$row['item'].'&location='.$row['location'];}?>" value="<?php echo ucwords($row['item'])?>" hidden>
                                                <a onclick="document.getElementById('<?php echo $row["id"];?>').click();">
                                                <img class="card-img-top" src="items/images/<?php echo $row["picture"]?>.jpg" alt="Card image cap" style="width: 18rem;height: 18rem;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                                                </a>
                                            <?php }else{?>
                                                <input id="<?php echo $row["id"];?>" name="item" type="submit" form="form1" formaction="<?php if($row['type'] == 'Inventory') {echo 'itemDetails.php';} else{ echo 'assetDetails.php?item='.$row['item'].'&location='.$row['location'];}?>" value="<?php echo ucwords($row['item'])?>" hidden>
                                                <a onclick="document.getElementById('<?php echo $row["id"];?>').click();">
                                                <div class="img-center card-img-top text-center border rounded" id="icon" style="height: 18rem">
                                                    <i class="fas fa-camera mt-7" style="font-size: 64pt;"></i>
                                                </div>
                                                </a>
                                            <?php }?>
                                            <div class="card-body mb--5">
                                                <h3 class="card-title mt--4"><?php echo ucwords($row["item"]);?></h3>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                    <div class="center2">
                                    <h2> Can't find what you searched for.</h2>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include "include/divisions/footer.php";
?>
