<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();
$columns = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['table'])){
        if($_POST['table'] == "users") {
            $sql = "select users.user_name as name,users.uname as username,departments.name as department,r.name as role,users.id from users left join departments on users.dept_id = departments.id join roles r on users.role_id = r.id where users.user_name != 'Administrator'";
        }
        else if ($_POST['table'] == 'roles'){
            $sql = "select roles.name as role,group_concat(p.description) as permissions,roles.id from roles join permission_role pr on roles.id = pr.role_id join permissions p on p.id = pr.permission_id group by role";
        }
        else if($_POST['table'] == 'categories'){
            $sql = "select category_name as name,id from category";
        }
        else if($_POST['table'] == 'locations'){
            $sql = "select location_name as name,description,id from location";
        }
        else if($_POST['table'] == 'departments'){
            $sql = "select name,description,id from departments";
        }
        else if($_POST['table'] == 'units'){
            $sql = "select unit_name as unit,unit_type as 'unit type',description,id from unit";
        }

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            $fields = mysqli_fetch_fields($result);
            foreach ($fields as $val) {
                $tmp = $val->name;
                array_push($columns,$tmp);
            }
            $columns[count($columns)-1] = "";
            while($row = mysqli_fetch_assoc($result)){
                $row[$columns[0]] = ucwords($row[$columns[0]]);
                $row['id'] = "<button class='btn cur-p bg-transparent border-0 edit m-0 p-2' data='".$row['id']."' data-toggle='modal' data-target='#additionalModal'><i class='fas fa-edit text-primary'></i></button><button class='btn cur-p bg-transparent border-0 delete m-0 p-2' data='".$row['id']."'><i class='fas fa-trash text-danger'></i></button>";
                array_push($rows,$row);
            }
        }
        else{
            $fields = mysqli_fetch_fields($result);
            foreach ($fields as $val) {
                $tmp = $val->name;
                array_push($columns,$tmp);
            }
            $columns[count($columns)-1] = "";
            $rows = [];
        }
        $response['columns'] = $columns;
        $response['rows'] = $rows;
//
        echo json_encode($response);
    }
}

