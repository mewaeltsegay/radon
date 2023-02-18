<?php

/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 7/20/2020
 * Time: 9:40 PM
 */
class login
{
    private $fun;
    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Functions.php';
        require_once 'DB_Connect.php';
        $this->fun = new DB_Functions();
        $db = new DB_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {

    }
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

    public function createUser($uname,$username,$role,$password,$dept){
        $uuid = uniqid('',true);
        $hash = $this->hashSSHA($password);
        $enc_pass = $hash["encrypted"];
        $salt = $hash["salt"];
        $dept_id = $this->fun->getDeptID($dept);

        $sql = "INSERT INTO `users`(`uname`, `user_name`, `role_id`, `password`, `salt`, `dept_id`, `uuid`) VALUES ('".$uname."','".$username."','".$this->fun->getRoleID($role)."','".$enc_pass."','".$salt."','".$dept_id."','".$uuid."')";
        $result = mysqli_query($this->conn,$sql);

        if($result){
            $sql1 = "select * from users where uname = '".$uname."'";
            $result1 = mysqli_query($this->conn,$sql1);

            if(mysqli_num_rows($result1) > 0){
                while($row=mysqli_fetch_assoc($result1)){
                    return $row;
                }
            }
        }
        else{
            return false;
        }

    }
    public function createUserApp($uname,$username,$role,$password,$dept,$created_by){
        $uuid = uniqid('',true);
        $hash = $this->hashSSHA($password);
        $enc_pass = $hash["encrypted"];
        $salt = $hash["salt"];
        $dept_id = $this->fun->getDeptID($dept);

        $sql = "INSERT INTO `users`(`uname`, `user_name`, `role_id`, `password`, `salt`, `dept_id`, `uuid`,`created_by`) VALUES ('".$uname."','".$username."','".$this->fun->getRoleID($role)."','".$enc_pass."','".$salt."','".$dept_id."','".$uuid."','".$created_by."')";
        $result = mysqli_query($this->conn,$sql);

        if($result){
            $sql1 = "select users.user_name as name,users.uname as username,departments.name as department,roles.name as role,users.id from users join departments on users.dept_id = departments.id join roles on users.role_id = roles.id where uname = '".$uname."'";
            $result1 = mysqli_query($this->conn,$sql1);

            if(mysqli_num_rows($result1) > 0){
                while($row=mysqli_fetch_assoc($result1)){
                    $row['id'] = "<button class='btn cur-p bg-transparent border-0 edit m-0 p-2' data='".$row['id']."'><i class='fas fa-edit text-primary'></i></button><button class='btn cur-p bg-transparent border-0 delete m-0 p-2' data='".$row['id']."'><i class='fas fa-trash text-danger'></i></button>";
                    return $row;
                }
            }
        }
        else{
            return false;
        }

    }

    public function changePassword($uuid,$password){
        $hash = $this->hashSSHA($password);
        $enc_pass = $hash["encrypted"];
        $salt = $hash["salt"];

        $sql = "update users set password='".$enc_pass."',salt='".$salt."' where uuid='".$uuid."'";
        $result = mysqli_query($this->conn,$sql);

        if($result){
            return true;
        }
        else{
            return false;
        }

    }

    public function changePasswordApp($id,$password){
        $hash = $this->hashSSHA($password);
        $enc_pass = $hash["encrypted"];
        $salt = $hash["salt"];

        $sql = "update users set password='".$enc_pass."',salt='".$salt."' where id=".$id;
        $result = mysqli_query($this->conn,$sql);

        if($result){
            return true;
        }
        else{
            return false;
        }

    }

    public function checkPassword($uname,$password){
        $sql = "select * from users where uname='".$uname."'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($user = mysqli_fetch_assoc($result)){
                $salt = $user["salt"];
                $enc_pass = $user["password"];
                $hash = $this->checkhashSSHA($salt,$password);

                if($enc_pass == $hash){
                    return 1;
                }
                else{
                    return 0;
                }
            }
        }
    }
    public function getUser($uname,$password){
        $sql = "select * from users where uname='".$uname."' and deactivated!='Y'";
        $result = mysqli_query($this->conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            while($user = mysqli_fetch_assoc($result)){
                $salt = $user["salt"];
                $enc_pass = $user["password"];
                $hash = $this->checkhashSSHA($salt,$password);

                if($enc_pass == $hash){
                    return $user;
                }
                else{
                    return false;
                }
            }
        }
    }
}
