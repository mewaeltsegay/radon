<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
        date_default_timezone_set('Africa/Nairobi');
    }

    // destructor
    function __destruct() {

    }

    public function getScriptName(){
        $fullname = explode("/",$_SERVER['SCRIPT_NAME']);

        return $fullname[count($fullname)-1];

    }

    public function getLocations($selected=null){
        $sql = "SELECT location_name FROM `location` order by location_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                if($selected == null) {
                    echo "<option id='" . $row["location_name"] . "'>" . $row["location_name"] . "</option>";
                }
                else{
                    if($row["location_name"] == $selected){
                        echo "<option id='" . $row["location_name"] . "' selected>" . $row["location_name"] . "</option>";
                    }
                    else{
                        echo "<option id='" . $row["location_name"] . "'>" . $row["location_name"] . "</option>";
                    }
                }
            }
        }
    }

    public function populateLocations(){
        $sql = "SELECT * FROM `location` order by location_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                        <button class="btn btn-icon btn-outline-secondary" type="button" data-toggle="modal" data-target="#modal-default" onclick="document.getElementById('loc').value='<?php echo $row["location_name"];?>';document.getElementById('descript').value='<?php echo $row["description"];?>';document.getElementById('id').value='<?php echo $row["id"];?>'">
                            <span class="btn-inner--icon"><i class="fas fa-pen"></i></span>
                        </button>
                        <?php echo $row["location_name"];?>
                    </td>
                    <td>
                        <?php echo $row["description"];?>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function getLocation($id){
        if($id == '%'){
            return "all";
        }
        else {
            $sql = "SELECT location_name FROM `location` where id=" . $id;
            $result = mysqli_query($this->conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    return $row["location_name"];
                }
            }
        }
    }

    public function getLocationId($name){
        $sql = "SELECT id FROM `location` where location_name='".$name."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                return $row["id"];
            }
        }
    }

    public function getItemDetails($item,$type=null){
        if($type == null) {
            $sql = "SELECT unique_id as details FROM `inventory` WHERE (not exists (select details from `inventory transactions` where inventory.unique_id=details and (returned!='Y' and returned!='R')) or (select unit_type from unit where unit_name=inventory.unit_measure)='bulk') and item='" . $item . "'";
        }
        else{
            $sql ="SELECT unique_id as details,location FROM `inventory` WHERE item='".$item."' and type='fixed asset'";
        }
        $result = mysqli_query($this->conn,$sql);

        $arr = array();
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($type == null) {
                    $arr2["data"] = $row["details"];
                    array_push($arr, $arr2);
                    }
                if($type == "relocate"){
                    $arr2["data"] = $row["details"];
                    $arr2["location"] = $this->getLocation($row["location"]);
                    array_push($arr, $arr2);
                }
            }
        }
        $arr3["content"] = $arr;
        return $arr3;
    }


    public function getCategories($selected=null)
    {
        $sql = "SELECT category_name FROM `category` order by category_name";
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($selected == null) {
                    echo "<option id='" . str_replace(" ", "_", $row["category_name"]) . "'>" . $row["category_name"] . "</option>";
                }
                else{
                    if($row["category_name"] == $selected) {
                        echo "<option id='" . str_replace(" ", "_", $row["category_name"]) . "' selected>" . $row["category_name"] . "</option>";
                    }
                    else{
                        echo "<option id='" . str_replace(" ", "_", $row["category_name"]) . "'>" . $row["category_name"] . "</option>";
                    }
                }
            }
        }
    }
    public function getCategorieCode($category){
        $sql = "SELECT code FROM `category` where category_name='".$category."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                return $row["code"];
            }
        }
    }

    public function populateCategories(){
        $sql = "SELECT * FROM `category` order by category_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                        <button class="btn btn-icon btn-outline-secondary" type="button" data-toggle="modal" data-target="#modal-default" onclick="document.getElementById('cat').value='<?php echo $row["category_name"];?>';document.getElementById('code').value='<?php echo $row["code"];?>';document.getElementById('id').value='<?php echo $row["id"];?>'">
                            <span class="btn-inner--icon"><i class="fas fa-pen"></i></span>
                        </button>
                        <?php echo $row["category_name"];?>
                    </td>
                    <td>
                        <?php echo $row["code"];?>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function getCategory($id){
        $sql = "SELECT category_name FROM `category` WHERE id=".$id;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                return $row["category_name"];
            }
        }
    }

    public function getCategoryId($name){
        $sql = "SELECT id FROM `category` WHERE category_name='".$name."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                return $row["id"];
            }
        }
    }

    public function getQuantity($id){
        $sql = "select quantity from quantity where id=".$id;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                return $row["quantity"];
            }
        }
    }

    public function getItemReorderLevel($item){
        $sql = "SELECT reorder_level FROM `inventory` WHERE item='".$item."' group by reorder_level";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result)["reorder_level"];
        }
    }

    public function getItemTargetStockLevel($item){
        $sql = "SELECT target_stock_level FROM `inventory` WHERE item='".$item."' group by reorder_level";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result)["target_stock_level"];
        }
    }
    public function populateUsers(){
        $permissions = $this->getUserPermissions($_COOKIE["uuid"]);
        $sql = "select * from users where deactivated!='Y' and uuid!='".$_COOKIE["uuid"]."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                ?>
                <tr id="<?php echo $row['id'];?>">
                    <th scope="row" class="name">
                        <div class="media align-items-center">
                            <a href="#" class="avatar rounded-circle mr-3 bg-white border border-primary" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="document.getElementById('fname').value='<?php echo ucwords(explode(' ',$row["user_name"])[0]);?>';document.getElementById('lname').value='<?php echo ucwords(explode(' ',$row["user_name"])[1]);?>';document.getElementById('uname').value='<?php echo $row["uname"];?>';document.getElementById('dept1').value='<?php echo $this->getDeptName($row["dept_id"]);?>';document.getElementById('role1').value='<?php echo ucwords($this->getRole($row["role_id"]));?>';document.getElementById('uuid').value='<?php echo $row["uuid"];?>';document.getElementById('uuid2').value='<?php echo $row["uuid"];?>';">
                                <i class="fas fa-user-astronaut text-primary"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" data-toggle="modal" data-target="#modal-default" href="#">Update User Information</a>
                                <a class="dropdown-item" data-toggle="modal" data-target="#modal-password" href="#">Change User Password</a>
                            </div>
                            <div class="media-body">
                                <span class="mb-0 text-sm font-weight-light"><?php echo ucwords($row["user_name"]);?></span>
                            </div>
                        </div>
                    </th>
                    <td>
                        <?php echo $row["uname"];?>
                    </td>
                    <td>
                        <?php echo $this->getDeptName($row["dept_id"]);?>
                    </td>
                    <td>
                        <?php echo ucwords($this->getRole($row["role_id"]));?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-primary" onclick="deleteUser(<?php echo $row['id'];?>)" <?php if(!in_array("delete_user",$permissions["name"])){echo "disabled";}?>>Delete</button>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function getPrivileges($offset=0){
        $sql = "select id,description from permissions where 1 LIMIT 8 offset ".$offset;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
                ?>
                <div class="custom-control custom-checkbox mb-3">
                    <input class="custom-control-input" id="<?php echo $row["id"];?>" name="<?php echo $row["id"];?>" type="checkbox">
                    <label class="custom-control-label" for="<?php echo $row["id"];?>"><?php echo $row["description"];?></label>
                </div>
                <?php
            }
        }
    }

    public function getUserPermissions($userUniqueID){
        $permissions = array();
        $sql = "select role_id from users where uuid='".$userUniqueID."'";
        $result = mysqli_query($this->conn,$sql);

        if (mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $permissions = $this->getRolePermissionsAsArray($this->getRole($row["role_id"]));
        }

        return $permissions;
    }

    public function getRolePermissionsAsArray($roleName){
        $description = $return = $name = array();
        $sql = "select permissions.name,permissions.description from permissions inner JOIN permission_role on permissions.id = permission_role.permission_id where permission_role.role_id=".$this->getRoleID($roleName);
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                array_push($description,$row["description"]);
                array_push($name, $row["name"]);
            }
        }
        $return["name"] = $name;
        $return["description"] = $description;

        return $return;
    }
    public function getRolePermissions($roleName){
        $str = "";
        $sql2 = "select permissions.description from permission_role left join permissions on permission_role.permission_id = permissions.id where role_id=".$this->getRoleID($roleName);
        $result2 = mysqli_query($this->conn,$sql2);

        if(mysqli_num_rows($result2) > 0){
            while($row2 = mysqli_fetch_assoc($result2)){
                $str = $str.$row2["description"].", ";
            }
        }
        else{
            $str = "None";
        }
        echo $str;
    }
    public function getAllRoles(){
        $sql = "select name from roles where 1";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
                echo "<option>".ucwords($row["name"])."</option>";
            }
        }
    }

    public function getRoleID($role){
        $sql = "select id from roles where name='".$role."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
                return $row["id"];
            }
        }
    }

    public function getRole($roleId){
        $sql = "select name from roles where id=".$roleId;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
                return $row["name"];
            }
        }
    }

    /**
     *List Roles
     */
    public function getRoles(){
        $sql = "select name from roles order by name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                    <div class="media align-items-center">
                        <a href="roledetails.php?role=<?php echo $row['name']?>" class="avatar rounded-circle mr-1 bg-white border border-primary">
                            <i class="fas fa-robot text-primary"></i>
                        </a>
                        <div class="media-body">
                            <span class="mb-0 text-sm font-weight-light"><?php echo ucwords($row["name"]);?></span>
                        </div>
                    </div>
                    </td>
                    <td>
                        <?php $this->getRolePermissions($row["name"]);?>
                    </td>
                </tr>
                <?php
            }
        }
    }
    public function getRoleDescription($roleName){
        $sql = "select description from roles where name='".$roleName."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result)["description"];
        }
    }
    public function populateRolePermissions($roleName,$offset,$profile=0){
        $permissions = $this->getRolePermissionsAsArray($roleName);

        $sql = "select id,description from permissions where 1 ORDER BY description LIMIT 8 offset ".$offset;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="custom-control custom-checkbox mb-3">
                        <input class="custom-control-input" id="<?php echo $row["id"]; ?>"
                               name="<?php echo $row["id"]; ?>"
                               type="checkbox"
                            <?php if (in_array($row["description"], $permissions["description"])) {
                            echo "checked";
                            } ?>

                            <?php
                            if($profile != 0) {
                                echo "disabled";
                            }?>
                        >
                        <label class="custom-control-label"
                               for="<?php echo $row["id"]; ?>"><?php echo $row["description"]; ?></label>
                    </div>
                    <?php
            }
        }
    }

    public function populateTransactionsPreview(){
        $sql = "SELECT `inventory transactions`.id,concat(employees.first_name) as name,inventory.item,`inventory transactions`.details,`inventory transactions`.quantity,inventory.unit_measure,`transaction types`.description,`transaction types`.`id` as tid,`inventory transactions`.`creation_date`,`inventory transactions`.`comment` FROM (((`inventory transactions` inner join inventory on transaction_item=inventory.id) inner join employees on employee=employees.id) inner join `transaction types` on transaction_type=`transaction types`.id) where `inventory transactions`.returned='' order by name LIMIT 7";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                <th scope="row">
                    <div class="media-body"><span class="mb-0 text-sm"><?php echo ucwords($row["name"]); ?></span></div>
                </th>
                <td class="pl-1 pr-0">
                    <?php echo $row["item"]; ?>
                </td>
                <td class="pl-1 pr-0">
                    <?php echo ucwords($row["description"]); ?>
                </td>
                <td class="pl-1">
                    <?php echo date("d-m-Y", strtotime($row["creation_date"])); ?>
                </td>
            <?php }
        }
    }
    public function populateTransactions(){
        $permissions = $this->getUserPermissions($_COOKIE["uuid"]);
        $sql = "SELECT `inventory transactions`.id,concat(employees.first_name,' ',employees.last_name) as name,inventory.item,`inventory transactions`.details,`inventory transactions`.quantity,inventory.unit_measure,`transaction types`.description,`transaction types`.`id` as tid,`inventory transactions`.`creation_date`,`inventory transactions`.`comment` FROM (((`inventory transactions` inner join inventory on transaction_item=inventory.id) inner join employees on employee=employees.id) inner join `transaction types` on transaction_type=`transaction types`.id) where `inventory transactions`.returned='' order by name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <th scope="row">
                        <div class="media-body"><span class="mb-0 text-sm"><?php echo ucwords($row["name"]);?></span></div>
                    </th>
                    <td>
                        <?php echo $row["item"];?>
                    </td>
                    <td>
                        <?php echo $row["details"];?>
                    </td>
                    <td>
                        <?php echo $row["quantity"];?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]);?>
                    </td>
                    <td>
                        <?php echo ucwords($row["description"]);?>
                    </td>
                    <td>
                        <?php echo date("d-m-Y h:i A",strtotime($row["creation_date"]));?>
                    </td>
                    <td>
                        <?php echo $row["comment"];?>
                    </td>
                    <td class="custom-control">
                    <?php if($this->getTransactionType($row["tid"]) != 'Consume'){?>
                        <div class="custom-control custom-checkbox mb-4 ml-3">
                            <input form="tform" class="custom-control-input border print-hide" id="<?php echo $row["id"];?>" name="damaged" type="checkbox" <?php if(!in_array("update_transactions",$permissions["name"])){echo "disabled";}?>>
                            <label class="custom-control-label" for="<?php echo $row["id"];?>"></label>
                        </div>
                    <?php }?>
                    </td>
                    <?php if($this->getTransactionType($row["tid"]) == 'Consume'){
                        ?>
                        <td>
                            <div class="btn-group-vertical print-hide">
                            <button form="tform" formaction="transactions/processPerish.php" class="btn btn-warning" type="submit" id="<?php echo $row["id"];?>" name="perish" value="<?php echo $row["id"];?>" <?php if(!in_array("update_transactions",$permissions["name"])){echo "disabled";}?>>Consumed</button>
                            <button form="tform" formaction="transactions/processReturn.php" class="btn btn-success" type="submit" id="<?php echo $row["id"];?>" name="return" value="<?php echo $row["id"];?>" <?php if(!in_array("update_transactions",$permissions["name"])){echo "disabled";}?>>Return</button>
                            </div>
                        </td>
                        <?php
                    }else{?>
                    <td>
                        <button form="tform" formaction="transactions/processReturn.php" class="btn btn-success print-hide" type="submit" id="<?php echo $row["id"];?>" name="return" value="<?php echo $row["id"];?>" <?php if(!in_array("update_transactions",$permissions["name"])){echo "disabled";}?>>Return</button>
                    </td>
                    <?php }?>
                </tr>
                <?php
            }
        }
    }

    public function getTransactionType($id){
        $sql = "select description from `transaction types` where id=".$id;
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["description"];
    }

    public function populateFixedAssets(){
        $sql = "Select id,item,unit_price,unit_measure,sum(quantity) as quantity,picture from inventory where type='fixed asset' group by item order by item";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <th scope="row">
                        <div class="media align-items-center">
                            <a class="rounded mr-3">
                                <?php if($row["picture"] == ""){?>
                                    <div class="img-center text-center border rounded" style="width: 40pt;height: 40pt">
                                        <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                    </div>
                                <?php } else{?>
                                    <img onmouseleave="resizeBAck(this.id)" onmouseover="enlarge(this.id)" id="<?php echo $row["id"];?>" class="card-img" src="Items/images/thumbs/<?php echo $row["picture"];?>.jpg" style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                                <?php } ?>
                            </a>
                            <div class="media-body">
                                <span class="mb-0 text-sm"><input class="border-0 bg-transparent" style="font-weight:600;color:#525f7f ;" type="submit" formaction="assetDetails.php" form="form1" name="item" value="<?php echo ucwords($row["item"]);?>"></span>
                            </div>
                        </div>
                    </th>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"], $currency)." NKF";
                        //echo "$".$row["unit_price"]." NKF";
                        ?>
                    </td>
                    <td>
                        <?php echo $row["quantity"];?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]);?>
                    </td>
                    <td>
                        <?php
                        echo $formatter->formatCurrency(($row["quantity"] * $row["unit_price"]),$currency)." NKF";
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function populateDamagedItems($type){
        $sql  = "SELECT unique_id as iid,item,category,location,picture,(select if(NOW() >= `expiry_date` and `expiry_date`!= '0000-00-00','Expired','Damaged') from `inventory` where unique_id=iid) as status FROM `inventory` WHERE NOW() >= `expiry_date` and `expiry_date`!= '0000-00-00' or exists (select * from `inventory transactions` where returned = 'D' and details=inventory.unique_id)";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                if($type == "list") {
                    ?>
                    <tr>
                        <th scope="row">
                            <div class="media align-items-center">
                                <a class="rounded mr-3">
                                    <?php if ($row["picture"] == "") { ?>
                                        <div class="img-center text-center border rounded"
                                             style="width: 40pt;height: 40pt">
                                            <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                        </div>
                                    <?php } else { ?>
                                        <img onmouseleave="resizeBAck(this.id)" onmouseover="enlarge(this.id)"
                                             id="<?php echo $row["iid"]; ?>" class="card-img"
                                             src="Items/images/thumbs/<?php echo $row["picture"]; ?>.jpg"
                                             style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                                    <?php } ?>
                                </a>
                                <div class="media-body">
                                    <span class="mb-0 text-sm"><input class="border-0 bg-transparent"
                                                                      style="font-weight:600;color:#525f7f ;"
                                                                      type="submit" formaction="#" form="form1"
                                                                      name="item"
                                                                      value="<?php echo ucwords($row["item"]); ?>"></span>
                                </div>
                            </div>
                        </th>
                        <td>
                            <?php
                            echo $row["iid"];
                            ?>
                        </td>
                        <td>
                            <?php echo $this->getLocation($row["location"]); ?>
                        </td>
                        <td>
                            <?php echo $this->getCategory($row["category"]); ?>
                        </td>
                        <td>
                            <?php echo $row["status"]; ?>
                        </td>
                    </tr>
                    <?php
                }
                if($type == 'card'){

                    ?>
                    <div class="col mb--6 rounded pb-4">
                        <div class="card3 rounded">
                            <div class="face3 face13 rounded">
                                <div class="content3 rounded">
                                    <div class="icon3 rounded">
                                        <?php if($row["picture"] == ""){?>
                                            <i class="fas fa-camera text-center pt-5 pb-5" style="color:white;font-size: 70pt;top: 50%;left: 50%;position: absolute;transform: translate(-50%,-50%);"></i>
                                        <?php } else{?>
                                            <img class="icon3" src="items/images/thumbs/<?php echo $row["picture"]; ?>.jpg" style="object-fit: cover">
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="face3 face23 rounded">
                                <div class="content3 rounded">
                                    <h3 class="h3 text-blue">
                                        <?php echo ucwords($row["item"]); ?>
                                    </h3>
                                    <p class="mt--3" style="font-size: 10pt">
                                        Status: <code class="text-danger" style="font-size: 11pt;"><?php echo $row["status"]; ?></code>
                                    </p>
                                    <p class="mt--3" style="font-size: 10pt">
                                        ID: <code class="text-success" style="font-size: 11pt;"><?php echo $row["iid"]; ?></code>
                                    </p>
                                    <p class="mt--3" style="font-size: 10pt">
                                        Category: <code class="text-warning" style="font-size: 11pt;"><?php echo $this->getCategory($row["category"]); ?></code>
                                    </p>
                                    <p class="mt--3" style="font-size: 10pt">
                                        Location: <code class="text-purple" style="font-size: 11pt;"><?php echo $this->getLocation($row["location"]); ?></code>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
    }
    public function populateInventoryList(){
        $sql = "Select id,unique_id as uid,item,location,category,unit_price,unit_measure,quantity,picture from inventory where type='inventory' and not exists(
          select * from `inventory transactions` where returned='D' and details=inventory.unique_id
          ) and (NOW() < expiry_date or  expiry_date = '0000-00-00') 
          group by item order by item";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <th scope="row">
                        <div class="media align-items-center">
                            <a class="rounded mr-3">
                                <?php if($row["picture"] == ""){?>
                                <div class="img-center text-center border rounded" style="width: 40pt;height: 40pt">
                                <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                </div>
                                <?php } else{?>
                                <img onclick="setImageModalSRC('<?php echo $row['picture'];?>')" onmouseleave="resizeBAck(this.id)" onmouseover="enlarge(this.id)" id="<?php echo $row["id"];?>" class="card-img" src="Items/images/thumbs/<?php echo $row["picture"];?>.jpg" style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                                <button id="imageModal" type="button" data-toggle="modal" data-target="#modal-notification" hidden></button>
                                <?php } ?>
                            </a>
                            <div class="media-body">
                                <span class="mb-0 text-sm"><input class="border-0 bg-transparent" style="font-weight:600;color:#525f7f ;" type="submit" formaction="itemDetails.php" form="form1" name="item" value="<?php echo ucwords($row["item"]);?>"></span>
                            </div>
                        </div>
                    </th>
                    <td>
                        <?php echo $this->getLocation($row["location"]);?>
                    </td>
                    <td>
                        <?php echo $this->getCategory($row["category"]);?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"], $currency)." NKF";
                        //echo "$".$row["unit_price"]." NKF";
                        ?>
                    </td>
                    <td>
                        <?php echo $this->getItemQuantity($row["item"]);?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]);?>
                    </td>
                    <td>
                        <?php
                        echo $formatter->formatCurrency(($this->getItemQuantity($row["item"]) * $row["unit_price"]),$currency)." NKF";
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function inventoryPageCount(){
        $sql = "Select id,unique_id as uid,item,location,category,unit_price,unit_measure,quantity,picture from inventory where type='inventory' group by item order by item";
        $result = mysqli_query($this->conn,$sql);
        return mysqli_num_rows($result);
    }
    public function populateInventoryListMod($offset){
        $permissions = $this->getUserPermissions($_COOKIE["uuid"]);
        $sql = "Select id,unique_id as uid,item,location,category,unit_price,unit_measure,sum(quantity) as quantity,picture from inventory where not exists(select * from `inventory transactions` where details=inventory.unique_id and (returned = 'D' or returned = 'P' or returned = 'Q' or returned = '')) and type='inventory' group by item order by item limit 14 offset ".$offset;
        $result = mysqli_query($this->conn,$sql);
        $count = mysqli_num_rows($result);

        if($count > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($row["quantity"] > 0 ) {
                    ?>
                    <tr>
                        <th scope="row">
                            <div class="media align-items-center">
                                <a class="rounded mr-3">
                                    <?php if ($row["picture"] == "") { ?>
                                        <div class="img-center text-center border rounded"
                                             style="width: 40pt;height: 40pt">
                                            <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                        </div>
                                    <?php } else { ?>
                                        <img onclick="setImageModalSRC('<?php echo $row['picture'];?>')" onmouseleave="resizeBAck(this.id)" onmouseover="enlarge(this.id)"
                                             id="<?php echo $row["id"]; ?>" class="card-img"
                                             src="Items/images/thumbs/<?php echo $row["picture"]; ?>.jpg"
                                             style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                                        <button id="imageModal" type="button" data-toggle="modal" data-target="#modal-notification" hidden></button>
                                    <?php } ?>
                                </a>
                                <div class="media-body">
                                    <span class="mb-0 text-sm"><input class="border-0 bg-transparent"
                                                                      style="font-weight:600;color:#525f7f ;"
                                                                      type="submit" formaction="itemDetails.php"
                                                                      form="form1" name="item"
                                                                      value="<?php echo ucwords($row["item"]); ?>"></span>
                                </div>
                            </div>
                        </th>
                        <td>
                            <?php echo $this->getLocation($row["location"]); ?>
                        </td>
                        <td>
                            <?php echo $this->getCategory($row["category"]); ?>
                        </td>
                        <td>
                            <?php
                            $region = 'en_US';
                            $currency = 'USD';
                            $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                            echo $formatter->formatCurrency($row["unit_price"], $currency) . " NKF";
                            //echo "$".$row["unit_price"]." NKF";
                            ?>
                        </td>
                        <td>
                            <?php echo $row["quantity"]; ?>
                        </td>
                        <td>
                            <?php $this->getUnit($row["unit_measure"]); ?>
                        </td>
                        <td>
                            <?php
                            echo $formatter->formatCurrency($row["quantity"] * $row["unit_price"], $currency) . " NKF";
                            ?>
                        </td>
                        <td class="print-hide">
                            <?php
                            if(in_array("edit_item",$permissions["name"])) {
                                echo "<button class='btn border-0 bg-transparent' onclick='location.assign(\"UpdateItemInfo.php?item=" . $row["item"] . "&type=Inventory\")'><i class='fas fa-edit text-blue'></i></button>";
                            }
                            if(in_array("delete_item",$permissions["name"])) {
                                echo "<button class='btn border-0 bg-transparent' onclick='location.assign(\"items/removeItem.php?item=" . $row["item"] . "&type=Inventory\")'><i class='fas fa-trash-alt text-red'></i></button>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        }

        return $count;
    }
    public function inventoryJSON(){
        $permissions = $this->getUserPermissions($_COOKIE["uuid"]);
        $sql = "Select id,unique_id as uid,item,location,category,unit_price,unit_measure,sum(quantity) as quantity,picture from inventory where not exists(select * from `inventory transactions` where details=inventory.unique_id and (returned = 'D' or returned = 'P' or returned = 'Q' or returned = '')) and type='inventory' group by item order by item limit 10";
        $result = mysqli_query($this->conn,$sql);
        $datas = array();

        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data = array();
                array_push($data, ucwords($row["item"]));
                array_push($data, $this->getLocation($row["location"]));
                array_push($data, $this->getCategory($row["category"]));
                $region = 'en_US';
                $currency = 'USD';
                $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                array_push($data, $formatter->formatCurrency($row["unit_price"], $currency) . " NKF");
                array_push($data, $row["quantity"]);
                array_push($data, $this->getJSONUnit($row["unit_measure"]));
                array_push($data, $formatter->formatCurrency($row["quantity"] * $row["unit_price"], $currency) . " NKF");

//            if(in_array("edit_item",$permissions["name"])) {
//                array_push($data,"<button class='btn border-0 bg-transparent' onclick='location.assign(\"UpdateItemInfo.php?item=" . $row["item"] . "&type=Inventory\")'><i class='fas fa-edit text-blue'></i></button>" );
//                }
//            if(in_array("delete_item",$permissions["name"])) {
//                array_push($data,"<button class='btn border-0 bg-transparent' onclick='location.assign(\"items/removeItem.php?item=" . $row["item"] . "&type=Inventory\")'><i class='fas fa-trash-alt text-red'></i></button>");
//                }
                array_push($datas, $data);
            }
            echo json_encode($datas);
        }
    }
    public function expiringItemsCount(){
        $sql = "select count(*) from inventory where NOW() >= expiry_date and expiry_date != '0000-00-00' group by expiry_date";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["count(*)"];
    }
    public function populateExpiringItems($limit){
        $sql = "select unique_id,item,expiry_date,location from inventory where NOW() >= expiry_date and expiry_date != '0000-00-00' group by expiry_date LIMIT ".$limit;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                        <?php echo ucwords($row["item"]);?>
                    </td>
                    <td>
                        <?php echo $row["unique_id"];?>
                    </td>
                    <td>
                        <?php echo date('d/m/Y',strtotime($row["expiry_date"]));?>
                    </td>
                    <td>
                        <?php echo $this->getActualItemQuantity($row["unique_id"]);?>
                    </td>
                    <td>
                        <?php echo $this->getLocation($row["location"]);?>
                    </td>
                </tr>
                <?php
            }
        }
    }
    public function populateRunningOutItemsPreview(){
        $sql = "SELECT item,reorder_level,location FROM `inventory` GROUP BY item";
        $result = mysqli_query($this->conn,$sql);
        $count = 0;
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($this->getActualItemQuantity($row["item"]) <= $row["reorder_level"] && $count < 5){
                    $count = $count + 1;
                    $percentage = round(($this->getActualItemQuantity($row["item"])/$this->getItemTargetStockLevel($row["item"]))*100,0);
                    ?>
                    <tr>
                        <td>
                            <?php echo ucwords($row["item"]);?>
                        </td>
                        <td class="pl-1 pr-0">
                            <?php echo $this->getActualItemQuantity($row["item"]);?>
                        </td>
                        <td class="pl-1 pr-0">
                            <?php echo $this->getLocation($row["location"]);?>
                        </td>
                        <td class="pl-1">
                            <div class="d-flex align-items-center">
                                <span class="mr-1"><?php echo $percentage."%";?></span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage;?>%;"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
    }
    public function populateItemReport($unit_measure,$itemOrUniqueID,$strtDate,$endDate,$isItem = true){
        $sql = '';
        if($isItem == false) {
            $sql = "SELECT inventory.timestamp FROM inventory WHERE unique_id='" . $itemOrUniqueID . "' UNION SELECT creation_date FROM `inventory transactions` WHERE details='" . $itemOrUniqueID . "' AND (returned!='Y' AND returned!='') order by timestamp";
        }
        else{
            $sql = "SELECT date(inventory.timestamp) as timestamp FROM inventory WHERE item='" . $itemOrUniqueID . "' and (date(inventory.timestamp) between '".$strtDate."' and '".$endDate."') UNION SELECT date(creation_date) as creation_date FROM `inventory transactions` WHERE transaction_item in (select id from inventory where item ='{$itemOrUniqueID}') AND (returned!='Y' AND returned!='') and (date(creation_date) between '".$strtDate."' and '".$endDate."') order by timestamp ";
        }
        $result = mysqli_query($this->conn,$sql);

        $arr = array();
        $arr2 = array();
        $arr3 = array();
        if(mysqli_num_rows($result) > 0){
            while($row=mysqli_fetch_assoc($result)){
                array_push($arr2,$row["timestamp"]);
            }
            $arr3 = array_unique($arr2,SORT_ASC);
            foreach ($arr3 as $ar){
                array_push($arr,$ar);
            }
        }

        for($i = 0; $i<count($arr);$i++){
            ?>
            <tr>
                <td>
                    <?php echo date('d/m/Y',strtotime($arr[$i]));?>
                </td>
                <td>
                    <?php $this->getUnit($unit_measure);?>
                </td>
                <td>
                    <?php
                    $region = 'en_US';
                    $currency = 'USD';
                    $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                    echo $formatter->formatCurrency($this->getAveragePrice($itemOrUniqueID,$isItem), $currency)." NKF";
                    //echo "$".$row["unit_price"]." NKF";
                    ?>
                </td>
                <td>
                    <?php
                        echo $this->getBeginningBalance($arr[$i],$itemOrUniqueID,$isItem)." 
                        <span class='text-warning'>
                            (".$formatter->formatCurrency(($this->getBeginningBalance($arr[$i],$itemOrUniqueID,$isItem)*$this->getAveragePrice($itemOrUniqueID,$isItem)),$currency).")
                        </span>";
                    ?>
                </td>
                <td>
                    <?php
                        echo $this->getIN($arr[$i],$itemOrUniqueID,$isItem)." 
                        <a ".$this->getGrn($arr[$i],$itemOrUniqueID,$isItem)."><span class='text-success'>
                            (".$formatter->formatCurrency(($this->getIN($arr[$i],$itemOrUniqueID,$isItem)*$this->getAveragePrice($itemOrUniqueID,$isItem)),$currency).")
                        </span></a>";
                    ?>
                </td>
                <td>
                    <?php
                        echo $this->getOUT($arr[$i],$itemOrUniqueID,$isItem)." 
                        <a ".$this->getSiv($arr[$i],$itemOrUniqueID,$isItem)."><span class='text-danger'>
                            (".$formatter->formatCurrency(($this->getOUT($arr[$i],$itemOrUniqueID,$isItem)*$this->getAveragePrice($itemOrUniqueID,$isItem)),$currency).")
                        </span></a>";
                    ?>
                </td>
                <td>
                    <?php
                        echo $this->getBeginningBalance($arr[$i],$itemOrUniqueID,$isItem)+$this->getIN($arr[$i],$itemOrUniqueID,$isItem)-$this->getOUT($arr[$i],$itemOrUniqueID,$isItem)." 
                        <span class='text-primary'>
                            (".$formatter->formatCurrency((($this->getBeginningBalance($arr[$i],$itemOrUniqueID,$isItem)+$this->getIN($arr[$i],$itemOrUniqueID,$isItem)-$this->getOUT($arr[$i],$itemOrUniqueID,$isItem))*$this->getAveragePrice($itemOrUniqueID,$isItem)),$currency).")
                        </span>";
                    ?>
                </td>
            </tr>
            <?php
        }
    }

    public function populateTabularItemReport($unit_measure,$itemOrUniqueID,$strtDate,$endDate,$isItem = true){
            ?>
            <tr>
                <td>
                    <?php echo $itemOrUniqueID;?>
                </td>
                <td>
                    <?php $this->getUnit($unit_measure);?>
                </td>
                <td>
                    <span class='text-warning'>
                    <?php
                    echo $this->getBeginningBalance($strtDate,$itemOrUniqueID,$isItem);
                    ?>
                    </span>
                </td>
                <td>
                    <span class='text-primary'>
                    <?php
                    echo $this->getTotalIN($strtDate,$endDate,$itemOrUniqueID,$isItem);
                    ?>
                    </span>
                </td>
                <td>
                    <?php
                    echo $this->getBeginningBalance($strtDate,$itemOrUniqueID,$isItem) + $this->getTotalIN($strtDate,$endDate,$itemOrUniqueID,$isItem);
                    ?>
                </td>
                <td>
                    <span class='text-danger'>
                    <?php
                    echo $this->getTotalOUT($strtDate,$endDate,$itemOrUniqueID,$isItem);
                    ?>
                    </span>
                </td>
                <td>
                    <span class='text-success'>
                    <?php
                    echo $this->getBeginningBalance($strtDate,$itemOrUniqueID,$isItem)+$this->getTotalIN($strtDate,$endDate,$itemOrUniqueID,$isItem)-$this->getTotalOUT($strtDate,$endDate,$itemOrUniqueID,$isItem);
                    ?>
                    </span>
                </td>
                <td>
                    <?php echo $this->getAllSiv($strtDate,$endDate,$itemOrUniqueID,$isItem);?>
                </td>
                <td>
                    <?php echo $this->getAllGrn($strtDate,$endDate,$itemOrUniqueID,$isItem);?>
                </td>
            </tr>
            <?php
    }

    public function populateReports($strtDate,$endDate,$item = "%",$category = "%",$location = "%"){
        $sql = "select item,category,location,description,unit_measure from inventory where type='Inventory' and item like '".$item."' and category like '".$category."' and location like '".$location."' group by item ORDER BY item";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <div class="card shadow center mt-3" style="width: 90%">
                    <div class="card-header border-0">
                        <img class="img-center img-fluid logo" src="assets/img/theme/ncew%20logo.png" style="height: 100px;width: 100px"/>
                        <h1 class="mb-0 text-center title">National Confederation of Eritrean Workers</h1>
                        <h2 class="mb-0 text-center title2">Item Report</h2>
                        <h4 class="mb-0 mt-5">Item Name: <?php echo $row["item"];?></h4>
                        <h4 class="mb-0">Category: <?php echo $this->getCategory($row["category"]);?></h4>
                        <h4 class="mb-0">Location: <?php echo $this->getLocation($row["location"]);?></h4>
                        <h4 class="mb-0">Description: <?php echo $row["description"];?></h4>
                        <h4 class="mb-0">Pricing Level: Average</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-fill">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Unit Measure</th>
                                <th scope="col">Price</th>
                                <th scope="col">B.Balance</th>
                                <th scope="col">In</th>
                                <th scope="col">Out</th>
                                <th scope="col">Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $this->populateItemReport($row["unit_measure"],$row["item"],$strtDate,$endDate);?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <?php
            }
        }
    }

    public function populateTabularReports($strtDate,$endDate,$item = "%",$category = "%",$location = "%"){
        $sql = "select item,category,location,description,unit_measure from inventory where type='Inventory' and item like '".$item."' and category like '".$category."' and location like '".$location."' group by item ORDER BY item";
        $result = mysqli_query($this->conn,$sql);

        echo '<div class="card shadow center mt-3 landscape" style="width: 90%">
                    <div class="card-header border-0">
                        <div class="row" id="tabular-report">
                            <div class="col-md-9">
                                <h4 class="mb-0">NCEW</h4>
                                <h4 class="mb-0">Inventory Movement</h4>
                                <h4 class="mb-0">Location: '.ucwords($this->getLocation($location)).'</h4>
                            </div>
                            <div class="col-md-3">';
                            if($strtDate == $endDate) {
                                echo '<div class="justify-content-end"><h4 class="mt-1 mb-0">Date: ' . date("M dS, Y",strtotime($strtDate)) . '</h4></div>';
                            }
                            else{
                                echo '<h4 class="mt-1 mb-0 align-content-end">Date: ' . date("M dS, Y",strtotime($strtDate)) ." - ".date("M dS,Y",strtotime($endDate)). '</h4>';
                            }

                    echo '</div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-fill">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Unit Measure</th>
                                <th scope="col">B.Balance</th>
                                <th scope="col">Purchases</th>
                                <th scope="col">Total</th>
                                <th scope="col">Consumption</th>
                                <th scope="col">Balance</th>
                                <th scope="col">SIV No.</th>
                                <th scope="col">GRN NO.</th>
                            </tr>
                            </thead>
                            <tbody>';

        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                $this->populateTabularItemReport($row["unit_measure"],$row["item"],$strtDate,$endDate);
            }
        }

        echo '</tbody>
                        </table>
                    </div>

                </div>';
    }

    public function getGrn($date,$itemorUniqueId,$isItem=true){
        if($isItem){
            $sql = "select distinct grn_no from inventory where date(inventory.timestamp)='".$date."' and item='".$itemorUniqueId."'";
        }
        else{
            $sql = "select distinct grn_no from inventory where date(inventory.timestamp)='".$date."' and unique_id='".$itemorUniqueId."'";
        }
        $result = mysqli_query($this->conn,$sql);
        $str  = "";

//        if(mysqli_num_rows($result) > 0){
////            if(mysqli_fetch_assoc($result)["grn_no"]!="") {
////                return "href='grn.php?no=" . mysqli_fetch_assoc($result)["grn_no"]."'";
////            }
////            while($row = mysqli_fetch_assoc($result)){
////                if(strlen($row["grn_no"])>0) {
////                    return "href='grn.php?no=" . $row["grn_no"] . "'";
////                }
////            }
//        }
        if(mysqli_num_rows($result) > 0){
            if(mysqli_num_rows($result) >1){
                while($row = mysqli_fetch_assoc($result)){
                    if(strlen($row["grn_no"]) > 0) {
                        if ($str == "") {
                            $str = $row["grn_no"];
                        } else {
                            $str = $str . "**" . $row["grn_no"];
                        }
                    }
                }
                return "href='grn.php?no=" . $str . "'";
            }
            if(mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if(strlen($row["grn_no"]) > 0) {
                        return "href='grn.php?no=" . $row["grn_no"] . "'";
                    }
                }
            }
        }
    }
    public function getAllGrn($startdate,$enddate,$itemorUniqueId,$isItem=true){
        if($isItem){
            $sql = "select distinct grn_no from inventory where (date(inventory.timestamp) BETWEEN '".$startdate."' and '".$enddate."') and item='".$itemorUniqueId."'";
        }
        else{
            $sql = "select distinct grn_no from inventory where (date(inventory.timestamp) BETWEEN '".$startdate."' and '".$enddate."') and unique_id='".$itemorUniqueId."'";
        }
        $result = mysqli_query($this->conn,$sql);
        $str  = "";

//        if(mysqli_num_rows($result) > 0){
////            if(mysqli_fetch_assoc($result)["grn_no"]!="") {
////                return "href='grn.php?no=" . mysqli_fetch_assoc($result)["grn_no"]."'";
////            }
////            while($row = mysqli_fetch_assoc($result)){
////                if(strlen($row["grn_no"])>0) {
////                    return "href='grn.php?no=" . $row["grn_no"] . "'";
////                }
////            }
//        }
        if(mysqli_num_rows($result) > 0){
            if(mysqli_num_rows($result) >1){
                while($row = mysqli_fetch_assoc($result)){
                    if(strlen($row["grn_no"]) > 0) {
                        if ($str == "") {
                            $str = "<button class='border-0 btn-outline- bg-transparent text-primary' onclick='window.location.assign(\"grn.php?no=".$row["grn_no"]."\")'>".$row["grn_no"]."</button>";
                        } else {
                            $str = $str . "/" . "<button class='border-0 btn-outline- bg-transparent text-primary' onclick='window.location.assign(\"grn.php?no=".$row["grn_no"]."\")'>".$row["grn_no"]."</button>";;
                        }
                    }
                }
                return $str;
            }
            if(mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if(strlen($row["grn_no"]) > 0) {
                        return "<button class='border-0 btn-outline- bg-transparent text-primary' onclick='window.location.assign(\"grn.php?no=".$row["grn_no"]."\")'>".$row["grn_no"]."</button>";;
                    }
                }
            }
        }
    }

    public function getSiv($date,$itemorUniqueId,$isItem=true){
        if($isItem){
            $sql = "SELECT distinct siv FROM `inventory transactions` WHERE date(creation_date)='".$date."' and transaction_item=".$this->getItemId($itemorUniqueId);
        }
        else{
            $sql = "SELECT distinct siv FROM `inventory transactions` WHERE date(creation_date)='".$date."' and details='".$itemorUniqueId."'";
        }
        $result = mysqli_query($this->conn,$sql);
        $str  = "";
        if(mysqli_num_rows($result) > 0){
            if(mysqli_num_rows($result) >1){
                while($row = mysqli_fetch_assoc($result)){
                    if(strlen($row["siv"]) > 0) {
                        if ($str == "") {
                            $str = $row["siv"];
                        } else {
                            $str = $str . "**" . $row["siv"];
                        }
                    }
                }
                return "href='siv.php?no=" . $str . "'";
            }
            if(mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (strlen($row["siv"]) > 0) {
                        return "href='siv.php?no=" . $row["siv"] . "'";
                    }
                }
            }
        }
    }
    public function getAllSiv($strtdate,$enddate,$itemorUniqueId,$isItem=true){
        if($isItem){
            $sql = "SELECT distinct siv FROM `inventory transactions` WHERE (date(creation_date) BETWEEN '".$strtdate."' and '".$enddate."') and transaction_item=".$this->getItemId($itemorUniqueId);
        }
        else{
            $sql = "SELECT distinct siv FROM `inventory transactions` WHERE (date(creation_date) BETWEEN '".$strtdate."' and '".$enddate."') and details='".$itemorUniqueId."'";
        }
        $result = mysqli_query($this->conn,$sql);
        $str  = "";
        if(mysqli_num_rows($result) > 0){
            if(mysqli_num_rows($result) >1){
                while($row = mysqli_fetch_assoc($result)){
                    if(strlen($row["siv"]) > 0) {
                        if ($str == "") {
                            $str = "<button class='border-0 btn-outline- bg-transparent text-primary' onclick='window.location.assign(\"siv.php?no=".$row["siv"]."\")'>".$row["siv"]."</button>";
                        } else {
                            $str = $str . "/" . "<button class='border-0 btn-outline- bg-transparent text-primary' onclick='window.location.assign(\"siv.php?no=".$row["siv"]."\")'>".$row["siv"]."</button>";;
                        }
                    }
                }
                return $str;
            }
            if(mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (strlen($row["siv"]) > 0) {
                        return "<button class='border-0 btn-outline- bg-transparent text-primary' onclick='window.location.assign(\"siv.php?no=".$row["siv"]."\")'>".$row["siv"]."</button>";;
                    }
                }
            }
        }
    }
    public function getAveragePrice($itemOrUniqueID,$isItem = true){
        if($isItem) {
            $sql = "SELECT avg(unit_price) AS avg FROM `inventory` WHERE item='" . $itemOrUniqueID . "' AND type='inventory'";
        }
        else{
            $sql = "SELECT unit_price AS avg FROM `inventory` WHERE unique_id='" . $itemOrUniqueID . "' AND type='inventory'";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            return mysqli_fetch_assoc($result)["avg"];
        }
    }
    public function getIN($date,$itemOrUniqueID,$isItem = true){
        $sql = '';
        if($isItem) {
            $sql = "SELECT IFNULL(sum(quantity),0) as quantity FROM `inventory` WHERE item='" . $itemOrUniqueID . "' AND date(inventory.timestamp)='" . $date . "' ";
        }
        else{
            $sql = "SELECT `quantity` FROM `inventory` WHERE unique_id='" . $itemOrUniqueID . "' AND inventory.timestamp='" . $date . "' ";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_array($result)["quantity"];
        }
        else{
            return 0;
        }
    }

    public function getAllIN($date,$itemOrUniqueID,$isItem = true){
        if($isItem){
            $sql = "SELECT IFNULL(sum(`quantity`),0) AS quantity FROM `inventory` WHERE type='inventory' and item='" . $itemOrUniqueID . "' AND inventory.timestamp < '" . $date . "'";
        }
        else {
            $sql = "SELECT sum(`quantity`) AS quantity FROM `inventory` WHERE unique_id='" . $itemOrUniqueID . "' AND inventory.timestamp<'" . $date . "'";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_array($result)["quantity"];
        }
        else{
            return 0;
        }
    }

    public function getTotalIN($strtdate,$enddate,$itemOrUniqueID,$isItem = true){
        if($isItem){
            $sql = "SELECT IFNULL(sum(`quantity`),0) AS quantity FROM `inventory` WHERE item='" . $itemOrUniqueID . "' AND (date(inventory.timestamp) BETWEEN '" . $strtdate . "' and '".$enddate."')";
        }
        else {
            $sql = "SELECT IFNULL(sum(`quantity`),0) AS quantity FROM `inventory` WHERE unique_id='" . $itemOrUniqueID . "' AND (date(inventory.timestamp) BETWEEN '" . $strtdate . "' and '".$enddate."')";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_array($result)["quantity"];
        }
        else{
            return 0;
        }
    }

    public function getOUT($date,$itemOrUniqueID,$isItem = true){
        if($isItem){
            $sql = "SELECT IFNULL(sum(quantity),0) as quantity FROM `inventory transactions` WHERE date(creation_date)='" . $date . "' AND transaction_item in (select id from inventory where item='{$itemOrUniqueID}') AND (returned!='Y' AND returned!='')";
        }
        else {
            $sql = "SELECT quantity FROM `inventory transactions` WHERE creation_date='" . $date . "' AND details='" . $itemOrUniqueID . "' AND (returned!='Y' AND returned!='')";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_array($result)["quantity"];
        }
        else{
            return 0;
        }
    }

    public function getAllOUT($date,$itemOrUniqueID,$isItem = true){
        if($isItem){
            $sql = "SELECT IFNULL(sum(quantity),0) AS quantity FROM `inventory transactions` WHERE date(creation_date) < '" . $date . "' AND transaction_item in (select id from inventory where item='{$itemOrUniqueID}') AND (returned!='Y' AND returned!='')";
        }
        else {
            $sql = "SELECT sum(quantity) AS quantity FROM `inventory transactions` WHERE creation_date<'" . $date . "' AND details='" . $itemOrUniqueID . "' AND (returned!='Y' AND returned!='')";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_array($result)["quantity"];
        }
        else{
            return 0;
        }
    }

    public function getTotalOUT($strtdate,$enddate,$itemOrUniqueID,$isItem = true){
        if($isItem){
            $sql = "SELECT IFNULL(sum(quantity),0) AS quantity FROM `inventory transactions` WHERE (date(creation_date) BETWEEN '" . $strtdate . "' and '".$enddate."') AND transaction_item='" . $this->getItemId($itemOrUniqueID) . "' AND (returned!='Y' AND returned!='')";
        }
        else {
            $sql = "SELECT sum(quantity) AS quantity FROM `inventory transactions` WHERE (date(creation_date) BETWEEN '" . $strtdate . "' and '".$enddate."') AND details='" . $itemOrUniqueID . "' AND (returned!='Y' AND returned!='')";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_array($result)["quantity"];
        }
        else{
            return 0;
        }
    }

    public function getBeginningBalance($date,$itemOrUniqueID,$isItem = true){
        return $this->getAllIN($date,$itemOrUniqueID,$isItem) - $this->getAllOUT($date,$itemOrUniqueID,$isItem);
    }

    public function getLoanedItemQuantity($item){
        $sql = "select sum(quantity) from inventory where exists(select * from `inventory transactions` where details=inventory.unique_id and returned=' ') and item = '".$item."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["sum(quantity)"];
    }

    public function getPerishedItemQuantity($item){
        $sql = "select sum(quantity) from inventory where exists(select * from `inventory transactions` where details=inventory.unique_id and returned='P') and item = '".$item."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["sum(quantity)"];
    }

    public function getDamagedItemQuantity($item){
        $sql = "select sum(quantity) from inventory where exists(select * from `inventory transactions` where details=inventory.unique_id and returned='D') and item = '".$item."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["sum(quantity)"];
    }

    public function getExpiredItemQuantity($item){
        $sql = "select sum(quantity) from inventory where item = '".$item."' and NOW() >= `expiry_date` and `expiry_date`!= '0000-00-00'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["sum(quantity)"];
    }

    public function getMovedItemQuantity($item){
        $sql = "select sum(quantity) from inventory where exists(select * from `inventory transactions` where details=inventory.unique_id and returned='Q') and item = '".$item."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["sum(quantity)"];
    }

    public function getItemQuantity($item){
        $sql2 = "SELECT quantity as quant FROM `inventory` WHERE item='".$item."'";
        $result2 = mysqli_query($this->conn,$sql2);
        $total = 0;
        if(mysqli_num_rows($result2) > 0){
            while ($row2 = mysqli_fetch_assoc($result2)){
                $total = $total + $row2["quant"];
            }
        }
        return $total;
    }

    public function getItemMeasure($item){
        $sql = "select (select unit_type from unit where id=inventory.unit_measure) as unit from inventory where item='".$item."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["unit"];
    }

    public function getIndividualItemQuantity($item){
        $sql2 = "SELECT sum(quantity) FROM `inventory` WHERE item='".$item."' or unique_id='".$item."'";
        $result2 = mysqli_query($this->conn,$sql2);

        return mysqli_fetch_assoc($result2)["sum(quantity)"];
    }

    public function populateItemGRN($grnNo){
        $sql = "SELECT `grn`.item,`grn`.quantity,inventory.location,inventory.unit_measure,inventory.unit_price FROM `grn` inner join inventory on inventory.grn_no = grn.grn_no where grn.grn_no='".$grnNo."' group by grn.item";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                        <?php echo $this->getLocation($row["location"]);?>
                    </td>
                    <td>
                        <?php echo ucwords($row["item"]);?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]); ?>
                    </td>
                    <td>
                        <?php echo $row["quantity"] ?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"], $currency)." NKF";
                        ?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency(($row["unit_price"]*$row["quantity"]), $currency)." NKF";
                        ?>
                    </td>
                    <td>

                    </td>
                </tr>
                <?php
            }
        }
    }

    public function populateSiv($sivNo){
        $sql = "SELECT `inventory transactions`.`siv`,`inventory transactions`.details,sum(`inventory transactions`.`quantity`) as quantity,inventory.item,inventory.unit_measure,sum(inventory.unit_price) as unit_price FROM `inventory transactions` inner join inventory on transaction_item = inventory.id where `inventory transactions`.siv=".$sivNo." GROUP BY `inventory`.item";
        $result = mysqli_query($this->conn,$sql);

        $prices = array();
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                array_push($prices,($row["unit_price"]*$row["quantity"]));
                ?>
                <tr>
                    <td>
                        <?php echo $row["item"];?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]); ?>
                    </td>
                    <td>
                        <?php echo $row["quantity"] ?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"], $currency)." NKF";
                        ?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency(($row["unit_price"]*$row["quantity"]), $currency)." NKF";
                        ?>
                    </td>
                </tr>
                <?php
            }
            return $prices;
        }
    }
    public function populateAssetDetailsList($item,$location){
        $permissions = $this->getUserPermissions($_COOKIE["uuid"]);
        $sql = "Select id,item,location,category,unit_price,unit_measure,quantity,picture,manufacturer,model,serial_no,unique_id,description,assigned_to from inventory where not exists(select details from `inventory transactions` where details=unique_id and returned = 'D') and item='".$item."' and location=".$location." and type='Fixed Asset'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <th scope="row">
                        <div class="media align-items-center">
                            <a class="rounded mr-3">
                                <?php if($row["picture"] == ""){?>
                                    <div class="img-center text-center border rounded" style="width: 40pt;height: 40pt">
                                        <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                    </div>
                                <?php } else{?>
                                    <img onclick="setImageModalSRC('<?php echo $row['picture'];?>');" onmouseleave="resizeBAck(this.id)" onmouseover="enlarge(this.id)" id="<?php echo $row["id"];?>" class="card-img" src="Items/images/thumbs/<?php echo $row["picture"];?>.jpg" style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                                    <button id="imageModal" type="button" data-toggle="modal" data-target="#modal-notification" hidden></button>
                                <?php } ?>
                            </a>
                            <div class="media-body">
                                <span class="mb-0 text-sm"><input class="border-0 bg-transparent" style="font-weight:600;color:#525f7f ;" type="submit" formaction="" form="form1" name="item" value="<?php echo ucwords($row["item"]);?>"></span>
                            </div>
                        </div>
                    </th>
                    <td>
                        <?php echo $row["description"];?>
                    </td>
                    <td>
                        <?php echo $this->getLocation($row["location"]);?>
                    </td>
                    <td>
                        <?php echo $this->getCategory($row["category"]);?>
                    </td>
                    <td>
                        <?php echo ucwords($row["manufacturer"]);?>
                    </td>
                    <td>
                        <?php echo ucwords($row["model"]);?>
                    </td>
                    <td>
                        <?php echo $row["serial_no"];?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"], $currency)." NKF";
                        //echo "$".$row["unit_price"]." NKF";
                        ?>
                    </td>
                    <td>
                        <?php echo $row["quantity"];?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]);?>
                    </td>
                    <td class="print-hide">
                        <div class="custom-control custom-checkbox mb-4 ml-3">
                            <input onchange="setDamaged(<?php echo $row["id"]?>,this.id,<?php echo $row["quantity"]?>,'fixed asset')" class="custom-control-input border print-hide" id="<?php echo $row["unique_id"];?>" name="damaged" type="checkbox">
                            <label class="custom-control-label" for="<?php echo $row["unique_id"];?>"></label>
                        </div>
                    </td>
                    <td>
                        <?php $this->getEmployee($row["assigned_to"]);?>
                    </td>
                    <td class="print-hide">
                        <?php
                        if(in_array("edit_asset",$permissions["name"])) {
                            echo "<button class='btn border-0 bg-transparent print-hide' onclick='location.assign(\"UpdateItemInfo.php?item=" . $row["unique_id"] . "&type=Fixed Asset\")'><i class='fas fa-edit text-blue'></i></button>";
                        }
                        if(in_array("delete_asset",$permissions["name"])) {
                            echo "<button class='btn border-0 bg-transparent print-hide' onclick='location.assign(\"items/removeItem.php?item=" . $row["item"] . "&type=Fixed Asset&loc=" . $row["unique_id"] . "&location=".$row["location"]."\")'><i class='fas fa-trash-alt text-red'></i></button>";
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    }
    public function populateAssetDetails(){
        $sql = "Select id,item,location,category,unit_price,unit_measure,sum(quantity) as quantity,picture,manufacturer,model,serial_no,unique_id,assigned_to from inventory where not exists(select details from `inventory transactions` where details=unique_id and returned = 'D') and type='Fixed Asset' group by location,item order by item";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <th scope="row">
                        <div class="media align-items-center">
                            <a class="rounded mr-3">
                                <?php if($row["picture"] == ""){?>
                                    <div class="img-center text-center border rounded" style="width: 40pt;height: 40pt">
                                        <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                    </div>
                                <?php } else{?>
                                    <img onclick="setImageModalSRC('<?php echo $row['picture'];?>');" onmouseleave="resizeBAck(this.id)" onmouseover="enlarge(this.id)" id="<?php echo $row["id"];?>" class="card-img" src="Items/images/thumbs/<?php echo $row["picture"];?>.jpg" style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #dddddd;border-radius: 4px;object-fit: cover;" alt="">
                                    <button id="imageModal" type="button" data-toggle="modal" data-target="#modal-notification" hidden></button>
                                <?php } ?>
                            </a>
                            <div class="media-body">
                                <span class="mb-0 text-sm"><input class="border-0 bg-transparent" style="font-weight:600;color:#525f7f ;" type="submit" formaction="assetdetails.php?location=<?php echo $row['location'];?>" form="form1" name="item" value="<?php echo ucwords($row["item"]);?>"></span>
                            </div>
                        </div>
                    </th>
                    <td>
                        <?php echo $this->getLocation($row["location"]);?>
                    </td>
                    <td>
                        <?php echo $this->getCategory($row["category"]);?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"], $currency)." NKF";
                        //echo "$".$row["unit_price"]." NKF";
                        ?>
                    </td>
                    <td>
                        <?php echo $row["quantity"];?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]);?>
                    </td>
                    <td>
                        <?php $this->getEmployee($row["assigned_to"]);?>
                    </td>
                </tr>
                <?php
            }
        }
    }
    public function populateAssetReport($location){
        if($location == "ANY"){
            $loc = "";
        }
        else{
            $loc = "and location=".$this->getLocationId($location);
        }
        $sql = "Select item,unit_price,unit_measure,sum(quantity) as quantity,serial_no,description from inventory where type='Fixed Asset'".$loc." group by serial_no,item order by item";
        $result = mysqli_query($this->conn,$sql);

        $count = 1;
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                        <?php echo $count;?>
                    </td>
                    <td>
                        <?php echo $row["item"];?>
                    </td>
                    <td>
                        <?php echo $row["serial_no"];?>
                    </td>
                    <td>
                        <?php echo ucwords($this->getUnit($row["unit_measure"]));?>
                    </td>
                    <td>
                        <?php echo ucwords($row["quantity"]);?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"]*$row["quantity"], $currency)." NKF";
                        ?>
                    </td>
                    <td>
                        <?php echo $row["description"];?>
                    </td>
                </tr>
                <?php
                $count = $count + 1;
            }
        }
    }
    public function populateItemDetailsList($item){
        $permissions = $this->getUserPermissions($_COOKIE["uuid"]);
        $sql = "Select id,item,location,category,unit_price,unit_measure,quantity,picture,manufacturer,model,serial_no,expiry_date,discontinued,supplier,unique_id,description from inventory where not exists(select details from `inventory transactions` where details=unique_id and returned != 'Y') and item='".$item."' and type='inventory'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <th scope="row">
                        <div class="media align-items-center">
                            <a class="rounded mr-3">
                                <?php if($row["picture"] == ""){?>
                                    <div class="img-center text-center border rounded" style="width: 40pt;height: 40pt">
                                        <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                    </div>
                                <?php } else{?>
                                    <img onclick="setImageModalSRC('<?php echo $row['picture'];?>')" onmouseleave="resizeBAck(this.id)" onmouseover="enlarge(this.id)" id="<?php echo $row["id"];?>" class="card-img" src="Items/images/thumbs/<?php echo $row["picture"];?>.jpg" style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                                    <button id="imageModal" type="button" data-toggle="modal" data-target="#modal-notification" hidden></button>
                                <?php } ?>
                            </a>
                            <div class="media-body">
                                <span class="mb-0 text-sm"><input class="border-0 bg-transparent" style="font-weight:600;color:#525f7f ;" type="submit" formaction="itemreport.php?id=<?php echo $row['unique_id'];?>" form="form1" name="item" value="<?php echo($row["item"]);?>"></span>
                            </div>
                        </div>
                    </th>
                    <td>
                        <?php echo $row["description"];?>
                    </td>
                    <td>
                        <?php echo $this->getLocation($row["location"]);?>
                    </td>
                    <td>
                        <?php echo $this->getCategory($row["category"]);?>
                    </td>
                    <td>
                        <?php echo ucwords($row["manufacturer"]);?>
                    </td>
                    <td>
                        <?php echo ucwords($row["model"]);?>
                    </td>
                    <td>
                        <?php echo $row["serial_no"];?>
                    </td>
                    <td>
                        <?php echo ucwords($row["supplier"]);?>
                    </td>
                    <td>
                        <?php
                        $region = 'en_US';
                        $currency = 'USD';
                        $formatter = new NumberFormatter($region, NumberFormatter::CURRENCY);
                        echo $formatter->formatCurrency($row["unit_price"], $currency)." NKF";
                        //echo "$".$row["unit_price"]." NKF";
                        ?>
                    </td>
                    <td>
                        <?php echo $row["quantity"];?>
                    </td>
                    <td>
                        <?php $this->getUnit($row["unit_measure"]);?>
                    </td>
                    <td>
                        <?php
                        if($row["expiry_date"] != "0000-00-00") {
                            echo date("d-m-Y", strtotime($row["expiry_date"]));
                        }
                        else{
                            echo "";
                        }
                        ?>
                    </td>
                    <td class="print-hide">
                    <div class="custom-control custom-checkbox mb-4 ml-3">
                        <input onchange="setDamaged(<?php echo $row["id"]?>,this.id,<?php echo $row["quantity"]?>,'inventory')" class="custom-control-input border print-hide" id="<?php echo $row["unique_id"];?>" name="damaged" type="checkbox">
                        <label class="custom-control-label" for="<?php echo $row["unique_id"];?>"></label>
                    </div>
                    </td>
                    <td class="print-hide">
                        <?php
                        if(in_array("edit_item",$permissions["name"])) {
                            echo "<button class='btn border-0 bg-transparent' onclick='location.assign(\"UpdateItemInfo.php?id=" . $row["unique_id"] . "\")'><i class='fas fa-edit text-blue'></i></button>";
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function populateEmployeeList(){
        $sql = 'SELECT `id`, concat(`first_name`," ",`last_name`) as name, `department`, `work_phone`, `home_phone`, `mobile_phone`, `address`, `city`, `zoba`, `picture` FROM `employees` WHERE 1 ';
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <th scope="row">
                        <div class="media align-items-center">
                            <a href="editEmployee.php?id=<?php echo $row["id"];?>" class="rounded mr-3">
                            <?php if($row["picture"] == ""){?>
                                <div class="img-center text-center border rounded" style="width: 40pt;height: 40pt">
                                    <i class="fas fa-camera pt-3 text-blue" style="font-size: 16pt"></i>
                                </div>
                            <?php } else{?>
                                <img id="<?php echo $row["id"];?>" class="card-img" src="employees/images/thumbs/<?php echo $row["picture"];?>.jpg" style="width: 40pt;height: 40pt;display: block;margin-left: auto;margin-right: auto;border: 1px solid #ddd;border-radius: 4px;object-fit: cover;">
                            <?php } ?>
                            </a>
                            <div class="media-body">
                                <span class="mb-0 text-sm"><?php echo $row["name"];?></span>
                            </div>
                        </div>
                    </th>
                    <td>
                        <?php echo $this->getDeptName($row["department"]);?>
                    </td>
                    <td>
                        <?php echo $row["work_phone"];?>
                    </td>
                    <td>
                        <?php echo $row["home_phone"];?>
                    </td>
                    <td>
                        <?php echo $row["mobile_phone"];?>
                    </td>
                    <td>
                        <?php echo $row["address"];?>
                    </td>
                    <td>
                        <?php echo $row["city"];?>
                    </td>
                    <td>
                        <?php echo $row["zoba"];?>
                    </td>
                    <td>
                        <?php
                        echo "<button class='btn border-0 bg-transparent' onclick='location.assign(\"employees/removeEmployee.php?id=".$row["id"]."\")'><i class='fas fa-trash-alt text-red'></i></button>";
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function getAllDepartments($selected=null){
        $sql = "select * from departments";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($selected == null) {
                    echo "<option>" . ucwords($row["name"]) . "</option>";
                }
                else{
                    if($selected == $row["id"]){
                        echo "<option selected>" . ucwords($row["name"]) . "</option>";
                    }
                    else{
                        echo "<option>" . ucwords($row["name"]) . "</option>";
                    }
                }
            }
        }
    }

    public function populateDepartments(){
        $sql = "select * from departments";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                        <button class="btn btn-icon btn-outline-secondary" type="button" data-toggle="modal" data-target="#modal-default" onclick="document.getElementById('dept').value='<?php echo $row["name"];?>';document.getElementById('descript').value='<?php echo $row["description"];?>';document.getElementById('id').value='<?php echo $row["id"];?>'">
                            <span class="btn-inner--icon"><i class="fas fa-pen"></i></span>
                        </button>
                        <?php echo $row["name"];?>
                    </td>
                    <td>
                        <?php echo $row["description"];?>
                    </td>
                </tr>
                <?php
            }
        }
    }
    public function populateUnits(){
        $sql = "select * from unit order by unit_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td>
                        <button class="btn btn-icon btn-outline-secondary" type="button" data-toggle="modal" data-target="#modal-default" onclick="document.getElementById('unitname').value='<?php echo $row["unit_name"];?>';document.getElementById('unittype').value='<?php echo $row["unit_type"];?>';document.getElementById('descript').value='<?php echo $row["description"];?>';document.getElementById('id').value='<?php echo $row["id"];?>'">
                            <span class="btn-inner--icon"><i class="fas fa-pen"></i></span>
                        </button>
                        <?php echo ucwords($row["unit_name"]);?>
                    </td>
                    <td>
                        <?php echo $row["unit_type"];?>
                    </td>
                    <td>
                        <?php echo $row["description"];?>
                    </td>
                </tr>
                <?php
            }
        }
    }

    public function getDeptID($dept){
        $sql = "select id from departments where name='".$dept."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result)["id"];
        }
    }

    public function getDeptName($deptID){
        $sql = "select name from departments where id=".$deptID;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result)["name"];
        }
    }

    public function getAllItems($type='inventory'){
        if($type == 'inventory') {
            $sql = "select distinct item from inventory where type='inventory' order by item ";
        }
        if ($type == 'fixed asset'){
            $sql = "select distinct item from inventory where type='fixed asset' order by item ";
        }
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<option id='".ucwords($row["item"])."'>".ucwords($row["item"])."</option>";
            }
        }
    }

    public function getActualItemQuantity($item){
        return $this->getIndividualItemQuantity($item) - $this->getLoanedItemQuantity($item) - $this->getPerishedItemQuantity($item) - $this->getMovedItemQuantity($item) - $this->getDamagedItemQuantity($item);
    }

    public function getAllEmployees($selected=null){
        $sql = "select concat(first_name,' ',last_name) as name from employees where 1 order by first_name,last_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($selected == null) {
                    echo "<option>" . ucwords($row["name"]) . "</option>";
                }
                else{
                    if(ucwords($row["name"]) == $selected){
                        echo "<option selected='selected'>" . ucwords($row["name"]) . "</option>";
                    }
                    else{
                        echo "<option>" . ucwords($row["name"]) . "</option>";
                    }
                }
            }
        }
    }

    public function getEmployee($id){
        $sql = "select concat(first_name,' ',last_name) as name from employees where id=".$id." order by first_name,last_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo ucwords($row["name"]);
            }
        }
    }
    public function getEmployee2($id){
        $sql = "select concat(first_name,' ',last_name) as name from employees where id=".$id." order by first_name,last_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                return ucwords($row["name"]);
            }
        }
    }

    public function getEmployeeDept($empId){
        $sql = "select (select name from departments where id=employees.department) as department from employees where id=".$empId;
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo ucwords($row["department"]);
            }
        }
    }

    public function getUnitType($unit){
        $sql = "select unit_type from unit where unit_name='".$unit."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["unit_type"];
    }

    public function getUnits($selected=null){
        $sql = "select id,unit_name,description from unit where 1 order by unit_name";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($selected == null) {
                    if ($row["description"] != "") {
                        echo "<option id='".$row["id"]."'>" . ucwords($row["unit_name"]) . " (" . $row["description"] . ")</option>";
                    } else {
                        echo "<option id='".$row["id"]."'>" . ucwords($row["unit_name"]) . "</option>";
                    }
                }
                else{
                    if($selected == $row["id"]){
                        if ($row["description"] != "") {
                            echo "<option id='".$row["id"]."' selected>" . ucwords($row["unit_name"]) . " (" . $row["description"] . ")</option>";
                        } else {
                            echo "<option id='".$row["id"]."' selected>" . ucwords($row["unit_name"]) . "</option>";
                        }
                    }
                    else{
                        if ($row["description"] != "") {
                            echo "<option id='".$row["id"]."'>" . ucwords($row["unit_name"]) . " (" . $row["description"] . ")</option>";
                        } else {
                            echo "<option id='".$row["id"]."'>" . ucwords($row["unit_name"]) . "</option>";
                        }
                    }
                }
            }
        }
    }
    public function getUnitID($unit){
        $description = "";
        if(strpos($unit,"(") != ""){
            $description = substr($unit,strpos($unit,"(") + 1,(strpos($unit,")") - strpos($unit,"(")) - 1 );
            $unit = trim(explode("(",$unit)[0]);
        }
        $sql = "select id from unit where unit_name='".$unit."' and description='".$description."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["id"];

    }

    public function getUnit($id){
        $unit = "";
        $sql = "select unit_name,description from unit where id=".$id;
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                if($row["description"] != ""){
                    $unit = ucwords($row["unit_name"])." (".$row["description"].")";
                    echo $unit;
                }
                else{
                    $unit = ucwords($row["unit_name"]);
                    echo $unit;
                }
            }
            return $unit;
        }
    }
    public function getJSONUnit($id){
        $unit = "";
        $sql = "select unit_name,description from unit where id=".$id;
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                if($row["description"] != ""){
                    $unit = ucwords($row["unit_name"])." (".$row["description"].")";
                }
                else{
                    $unit = ucwords($row["unit_name"]);
                }
            }
            return $unit;
        }
    }

    public function getTransactionTypes(){
        $sql = "SELECT `description` FROM `transaction types` where 1";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<option>".ucwords($row["description"])."</option>";
            }
        }
    }

    public function getItemId($item){
        $sql = "select DISTINCT id from inventory where item='".$item."' or unique_id='".$item."' group by item";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["id"];
    }

    public function getEmployeeId($name){
        $fname = explode(" ",$name);
        $first = $fname[0];
        $last = $fname[1];

        $sql = "select id from employees where first_name='".$first."' and last_name='".$last."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["id"];
    }

    public function getTransactionTypeId($type){
        $sql = "select id from `transaction types` where description='".$type."'";
        $result = mysqli_query($this->conn,$sql);

        return mysqli_fetch_assoc($result)["id"];
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function createThumb($path,$file){
        $filename = $path.$file;
        $percent = 0.5;

        // Get new dimensions
        list($width, $height) = getimagesize($filename);
        $new_width = $width * $percent;
        $new_height = $height * $percent;

        // Resample
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // Output
        imagejpeg($image_p, $path."thumbs/".$file, 100);

    }

    public function createUniqueID($item,$cat,$type){
////        $item = trim($item);
////        $type = trim($type);
////        if($type == "Inventory") {
////            $sql = "select count(*)from inventory where item='" . $item . "'";
////            $result = mysqli_query($this->conn, $sql);
////
////            $count = mysqli_fetch_assoc($result)["count(*)"];
////
////            $org = "NCEW";
////            $item2 = "";
////            $shortname = "";
////            if (strpos($item, " ") != FALSE) {
////                $item2 = explode(" ", $item);
////                $shortname = substr($item2[0], 0, 1) . substr($item2[1], 0, 1) . substr($item2[1], (strlen($item2[1]) - 1), 1);
////            } else {
////                $shortname = substr($item, 0, 1) . substr($item, ceil(strlen($item) / 2) - 1, 1) . substr($item, (strlen($item) - 1), 1);
////            }
////            $shortcat = $this->getCategorieCode($cat);
////
////            return strtoupper($org . "-" . $shortname . "-" . $shortcat . "-" . ($count + 1));
//        }
//        if($type == "Fixed Asset") {
//            return $this->generateFixedAssetID();
//        }
        return $this->generateFixedAssetID();
    }

    public function generateFixedAssetID(){
        while(true) {
            $uuid = strtoupper(uniqid("NCEW"));

            $sql = "select * from items where unique_id='" . $uuid . "'";
            $result = mysqli_query($this->conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                return $uuid;
            }
        }
    }

    public function randomItems(){
        $items = $in_stock = $target = $reorder = $res = [];
        $sql = "select item,target_stock_level,reorder_level,sum(quantity) as in_stock from inventory where not EXISTS(select * from `inventory transactions` where details = inventory.unique_id and (returned='D' or returned='P')) group by inventory.item ORDER BY RAND() limit 10";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                array_push($items,$row["item"]);
                array_push($target,number_format($row["target_stock_level"]));
                array_push($reorder,number_format($row["reorder_level"]));
                array_push($in_stock,number_format($row["in_stock"]));
            }
            $res["item"] = $items;
            $res["target"] = $target;
            $res["reorder"] = $reorder;
            $res["instock"] = $in_stock;
        }
        echo json_encode($res);
    }

    public function getAvgPrice($id){
        $sql = "select group_concat(price.quantity) as price_quantity,group_concat(price.unit_price) as price_unit_price from items 
            left join(
                SELECT item_id,quantity,unit_price FROM stock WHERE type='inventory' and unit_price != 0
                UNION
                SELECT item_id,quantity,unit_price from transaction_in where unit_price != 0
            ) price on price.item_id = items.id where items.id = {$id}  group by items.id";
        $result  = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $qty = $row["price_quantity"] == null ? [] : explode(',',$row["price_quantity"]);
                $prices = $row["price_unit_price"] == null ? 0 : explode(',',$row["price_unit_price"]);
                $sum = 0;
                for ($i = 0;$i<= count($qty)-1; $i++) {
                    $sum = $sum + ($qty[$i]*$prices[$i]);
                }

                $total = array_sum($qty);

                if($total !== 0)
                {
                    return $sum/$total;
                }
            }
        }
    }
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $username, $password,$deptid,$usertype) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO users(`unique_id`,`Uname`, `user_name`, `password`, `salt`, `dept_id`,`user_type`) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $uuid, $name, $username, $encrypted_password, $salt, $deptid, $usertype);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE Uname = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByUsernameAndPassword($username, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE uname = ?");

        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    public function randomPicID($item){
        $random = mt_rand();
        return uniqid($item.$random,true);
    }

    public function randomPicIDApp(){
        $random = mt_rand();
        return uniqid("Item",true);
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

    public function in($date, $item)
    {
        $sql = "select IFNULL(sum(inventory.quantity),0) as item_in,IFNULL(group_concat(distinct inventory.grn_no),'') as grn from inventory where date(inventory.timestamp) = '{$date}' and inventory.item = '{$item}' and not exists(select details from `inventory transactions` where returned!='Y' and returned !='' and date(creation_date) = '{$date}')";
        $res = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($res) > 0){
            return mysqli_fetch_assoc($res);
        }
    }

    public function allIn($date,$item){
        $sql = "select IFNULL(sum(inventory.quantity),0) as item_in from inventory where date(inventory.timestamp) < '{$date}' and inventory.item = '{$item}'";
        $res = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($res) > 0){
            return mysqli_fetch_assoc($res)["item_in"];
        }
    }

    public function out($date,$item){
        $sql = "select IFNULL(sum(quantity),0) as item_out,IFNULL(group_concat(distinct siv),'') as siv from `inventory transactions` where date(`inventory transactions`.creation_date) = '{$date}' and details in ( select unique_id from inventory where item = '{$item}' ) AND (returned!='Y' AND returned!='')";
        $res = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($res) > 0){
            return mysqli_fetch_assoc($res);
        }
    }

    public function allOut($date,$item){
        $sql = "select IFNULL(sum(quantity),0) as item_out from (select * from `inventory transactions` where date(`inventory transactions`.creation_date) < '{$date}' and details in ( select unique_id from inventory where item = '{$item}') AND (returned!='Y' AND returned!='') group by details) as tab";
        $res = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($res) > 0){
            return mysqli_fetch_assoc($res)["item_out"];
        }
    }

    public function getItemSIV($start_date,$end_date,$item){
        $sql = "select IFNULL(group_concat(distinct `inventory transactions`.siv),'') as siv from `inventory transactions` where siv!='' and date(`inventory transactions`.creation_date) between '{$start_date}' and '{$end_date}' and details in ( select unique_id from inventory where item = '{$item}' ) AND (returned!='Y' AND returned!='')";
        $res = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($res) > 0){
            return mysqli_fetch_assoc($res)["siv"];
        }
    }

    public function getItemGRN($start_date,$end_date,$item){
        $sql = "select IFNULL(group_concat(distinct grn_no),'') as grn from inventory where grn_no!='' and item='{$item}' and date(timestamp) between '{$start_date}' and '{$end_date}' group by item";
        $res = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($res) > 0){
            return mysqli_fetch_assoc($res)["grn"];
        }
    }

    public function getAllInitialQuantity($location){
        $rows = array();
        $sql = "select items.id,items.item,IF(NOT EXISTS(select stock.item_id from stock join location on stock.location_id = location.id where stock.item_id = items.id and location.location_name = '{$location}' group by stock.item_id),0,(select sum(stock.quantity) from stock join location on stock.location_id = location.id where stock.item_id = items.id and location.location_name = '{$location}' group by stock.item_id)) as quantity from items join stock on stock.item_id = items.id where stock.type = 'inventory' group by stock.item_id";
        $result  = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                array_push($rows,$row);
            }
            return $rows;
        }
    }

    public function getAllTransactionIn($location){
        $rows = array();
        $sql = "select items.id,items.item,IF(NOT EXISTS(select transaction_in.item_id from transaction_in join location on transaction_in.location_id = location.id where transaction_in.item_id = items.id and location.location_name = '{$location}' group by transaction_in.item_id),0,(select sum(transaction_in.quantity) from transaction_in join location on transaction_in.location_id = location.id where transaction_in.item_id = items.id and location.location_name = '{$location}' group by transaction_in.item_id)) as quantity from items join stock on stock.item_id = items.id where stock.type = 'inventory' group by stock.item_id";
        $result  = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                array_push($rows,$row);
            }
            return $rows;
        }
    }

    public function getAllTransactionOut($location){
        $rows = array();
        $sql = "select items.id,items.item,IF(NOT EXISTS(select transaction_out.item_id from transaction_out join location on transaction_out.location_id = location.id where transaction_out.item_id = items.id and location.location_name = '{$location}' group by transaction_out.item_id),0,(select sum(transaction_out.quantity) from transaction_out join location on transaction_out.location_id = location.id where transaction_out.item_id = items.id and location.location_name = '{$location}' group by transaction_out.item_id)) as quantity from items join stock on stock.item_id = items.id where stock.type = 'inventory' group by stock.item_id";
        $result  = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                array_push($rows,$row);
            }
            return $rows;
        }
    }
}
?>
