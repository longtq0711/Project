<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';
class UserController extends Controller{
    public function register(){
        if (isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
//            $email = $_POST['email'];
            $password_confirm = $_POST['password_confirm'];
            $user_model = new User();
            $user = $user_model->getUser($username);
            if(empty($username)||empty($password)){
                $this->error = "Please input username/password";
            } elseif($password!=$password_confirm){
                $this->error = "Please reconfirm the password";
            } elseif(!empty($user)){
                $this->error = "Username $username existed";
            }
            if(empty($this->error)){
                $user_model->username = $username;
                $user_model->password = md5($password);
                $is_insert = $user_model->registerUser();
                if($is_insert){
                    $_SESSION['success'] = 'Đăng ký thành công';
                    header('location:index.php?controller=user&action=login');
                    exit();
                } else $this->error = 'Đăng kí thất bại';
            }
        }
        $this->content = $this->render('views/login/register.php');
        require_once 'views/layouts/main_login.php';
    }
    public function login(){
        if(isset($_SESSION['username'])){
            $_SESSION['success'] = 'Bạn đã đăng nhập rồi';
            header('location:index.php?controller=product');
            exit();
        }
        if(isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (empty($username || empty($password))) {
                $this->error = 'Please input username/password';
            }
            if (empty($this->error)) {
                $user_model = new User();
                $user = $user_model->getUserLogin($username, md5($password));
                if (!empty($user)) {
                    $_SESSION['user'] = $user;
                    $_SESSION['success'] = 'Login thành công';
                    header('Location:index.php?controller=product');
                    exit();
                } else {
                    $this->error = 'Please check username/password';
                }
            }
        }
        $this->content = $this->render('views/login/login.php');
        require_once 'views/layouts/main_login.php';
    }
}