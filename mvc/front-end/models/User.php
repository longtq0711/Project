<?php
require_once 'models/Model.php';
class User extends Model
{

    public $username;
    public $password;
    public $role;
    public $email;
    public $fullname;
    public $phone;
    public $address;
    public $avatar;

    public function registerUser()
    {
        $sql_insert = "INSERT INTO users(username, password, roles, email) VALUES(:username, :password, 0, :email)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $inserts = [
            ':username' => $this->username,
            ':password' => $this->password,
            ':email' => $this->email
        ];
        $is_insert = $obj_insert->execute($inserts);
        return $is_insert;
    }
    public function insertProfile($id){
        $sql_insert = "UPDATE users SET fullname = :fullname, phone = :phone, address = :address, avatar = :avatar
                       WHERE id = $id";
        $obj_insert = $this->connection->prepare($sql_insert);
        $insert = [
            ':fullname' => $this->fullname,
            ':phone' => $this->phone,
            ':address' => $this->address,
            ':avatar' => $this->avatar
        ];
        $is_insert = $obj_insert->execute($insert);
        return $is_insert;
    }
    public function getUserLogin($username, $password)
    {
        $sql_select_one = "SELECT * from users WHERE username = :username AND password = :password";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $selects = [
            ':username' => $username,
            ':password' => $password,
        ];
        $obj_select_one->execute($selects);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function getUser($username)
    {
        $sql_select_one = "SELECT * from users WHERE username = :username";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $selects = [
            ':username' => $username
        ];
        $obj_select_one->execute($selects);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function getUserProfile($id)
    {
        $sql_select_one = "SELECT * from users WHERE id = :id";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $selects = [
            ':id' => $id
        ];
        $obj_select_one->execute($selects);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

};
