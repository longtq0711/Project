<?php
require_once 'models/Model.php';
class User extends Model
{

    public $username;
    public $password;

    public function registerUser()
    {
        $sql_insert = "INSERT INTO users(username, password) VALUES(:username, :password)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $inserts = [
            ':username' => $this->username,
            ':password' => $this->password
        ];
        $is_insert = $obj_insert->execute($inserts);
        return $is_insert;
    }

    public function getUserLogin($username, $password)
    {
        $sql_select_one = "SELECT * from users WHERE username = :username AND password = :password";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $selects = [
            ':username' => $username,
            ':password' => $password
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

};
