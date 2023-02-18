<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST["table"];
    if($table != "roles") {
        $fields = $_POST["fields"];
        $id = $_POST["id"];
        $response = array();

        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = \"{$value}\"";
            if ($x < count($fields)) {
                $set .= ',';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} where id = {$id}";

        if (mysqli_query($conn, $sql) != 1) {
            $response["success"] = "false";
        } else {
            if ($table != "users")
                $response["success"] = "true";
            else {
                $sql2 = "select users.user_name as name,users.uname as username,departments.name as department,r.name as role,users.id from users join departments on users.dept_id = departments.id join roles r on users.role_id = r.id where users.user_name != 'Administrator'";
                $res = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($res) > 0) {
                    while ($rows = mysqli_fetch_row($res)) {
                        $response["success"] = "true";
                        $rows[0] = ucwords($rows[0]);
                        $rows[count($rows) - 1] = "<button class='btn cur-p bg-transparent border-0 edit m-0 p-2' data='" . $rows[count($rows) - 1] . "' data-toggle='modal' data-target='#additionalModal'><i class='fas fa-edit text-primary'></i></button><button class='btn cur-p bg-transparent border-0 delete p-2 m-0' data='" . $rows[count($rows) - 1] . "'><i class='fas fa-trash text-danger'></i></button>";
                        $response['data'] = $rows;
                    }
                }
            }
        }

        echo json_encode($response);
    }
    else{
        $fields = $_POST["fields"];
        $permissions = $_POST["permissions"];
        $id = $_POST["id"];
        $response = array();

        $values = array();
        $values_string = "";

        foreach ($permissions as $permission){
            array_push($values,"(".$id.",".$permission.")");
        }
        for($i=0;$i<=count($values)-1;$i++){
            if($i == count($values)-1)
                $values_string = $values_string.$values[$i];
            else
                $values_string = $values_string.$values[$i].",";
        }

        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = \"{$value}\"";
            if ($x < count($fields)) {
                $set .= ',';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} where id = {$id}";

        if (mysqli_query($conn, $sql) != 1) {
            $response["success"] = "false";
        } else {
            $sql2 = "DELETE FROM permission_role where role_id={$id}";
            if(mysqli_query($conn,$sql2) != 1){
                $response["success"] = "false";
            }
            else{
                $sql3 = "INSERT INTO permission_role(role_id, permission_id) VALUES{$values_string}";
                if(mysqli_query($conn,$sql3) != 1){
                    $response["success"] = "false";
                }
                else{
                    $response["success"] = "true";
                }
            }
        }
        echo json_encode($response);
    }
}
