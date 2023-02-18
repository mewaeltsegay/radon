<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();
$columns = array();

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['table'])) {
        if(!isset($_POST['permissions'])){
            $table = $_POST['table'];
            $columns = $_POST['columns'];
            $rows = $_POST['row'];
            $params = "";
            $cols = count($rows) - 1;

            for ($i = 0; $i <= $cols; $i++) {
                if ($i != $cols) {
                    if (gettype($rows[$i]) == "string") {
                        $params = $params . "'" . $rows[$i] . "',";
                    } else {
                        $params = $params . $rows[$i] . ",";
                    }
                } else {
                    if (gettype($rows[$i]) == "string") {
                        $params = $params . "'" . $rows[$i] . "'";
                    } else {
                        $params = $params . "'" . $rows[$i] . "'";
                    }
                }
            }

            $sql = "insert into " . $table . "(" . $columns . ") values (" . $params . ");";
            if($table == "category"){
                $sql .= "select category_name as name,id from category where id=last_insert_id()";
            }
            else if($table == "location"){
                $sql .= "select location_name as name,description,id from location where id=last_insert_id()";
            }
            else if($table == 'departments'){
                $sql .= "select name,description,id from departments where id=last_insert_id()";
            }
            else if($table == 'unit'){
                $sql .= "select unit_name as unit,unit_type as 'unit type',description,id from unit where id=last_insert_id()";
            }

            if (mysqli_multi_query($conn, $sql)) {
                do {
                    $response['success'] = "true";
                    if ($result = mysqli_store_result($conn)) {
                        while ($row = mysqli_fetch_row($result)) {
                            $row[0] = ucwords($row[0]);
                            $row[count($row) - 1] = "<button class='btn cur-p bg-transparent border-0 edit m-0 p-2' data='".$row[count($row) - 1]."' data-toggle='modal' data-target='#additionalModal'><i class='fas fa-edit text-primary'></i></button><button class='btn cur-p bg-transparent border-0 delete p-2 m-0' data='".$row[count($row) - 1]."'><i class='fas fa-trash text-danger'></i></button>";
                            $response['data'] = $row;
                        }
                        mysqli_free_result($result);
                    }
                }while(mysqli_next_result($conn));
            }
            else{
                $response['success'] = "false";
                $response['message'] = mysqli_error($conn);
            }

            echo json_encode($response);
        }
        else{
            $table = $_POST['table'];
            $columns = $_POST['columns'];
            $rows = $_POST['row'];
            $params = "";
            $cols = count($rows) - 1;

            for ($i = 0; $i <= $cols; $i++) {
                if ($i != $cols) {
                    if (gettype($rows[$i]) == "string") {
                        $params = $params . "'" . $rows[$i] . "',";
                    } else {
                        $params = $params . $rows[$i] . ",";
                    }
                } else {
                    if (gettype($rows[$i]) == "string") {
                        $params = $params . "'" . $rows[$i] . "'";
                    } else {
                        $params = $params . "'" . $rows[$i] . "'";
                    }
                }
            }

            $sql = "insert into " . $table . "(" . $columns . ") values (" . $params . "); select last_insert_id() as id;";
            $id = "";
            if(mysqli_multi_query($conn,$sql)) {
                do{
                if ($result = mysqli_store_result($conn)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row["id"];
                        foreach ($_POST['permissions'] as $per) {
                            $sql2 = "INSERT INTO `permission_role`(`role_id`, `permission_id`) VALUES (" . $id . "," . $per . ")";
                            $result2 = mysqli_query($conn, $sql2);
                        }
                    }
                    if ($result2 == 1) {
                        $sql3 = "select roles.name as role,group_concat(p.description) as permissions,roles.id from roles join permission_role pr on roles.id = pr.role_id join permissions p on p.id = pr.permission_id where role_id = " . $id . " group by role";
                        $result3 = mysqli_query($conn, $sql3);

                        if (mysqli_num_rows($result3) > 0) {
                            while ($row2 = mysqli_fetch_row($result3)) {
                                $row2[0] = ucwords($row2[0]);
                                $row2[count($row2) - 1] = "<button class='btn cur-p bg-transparent border-0 edit m-0 p-2' data='".$row2[count($row2) - 1]."' data-toggle='modal' data-target='#additionalModal'><i class='fas fa-edit text-primary'></i></button><button class='btn cur-p bg-transparent border-0 delete m-0 p-2' data='".$row2[count($row2) - 1]."'><i class='fas fa-trash text-danger'></i></button>";
                                $response['success'] = 'true';
                                $response['data'] = $row2;
                            }
                        }
                    } else {
                        $response['success'] = "false";
                        $response['message'] = mysqli_error($conn);
                    }
                }
                }while(mysqli_next_result($conn));
            }
            else{
                $response['success'] = "false";
                $response['message'] = mysqli_error($conn);
            }

            echo json_encode($response);
        }
}}
