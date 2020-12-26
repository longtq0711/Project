<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';
class UserController extends Controller{
    public function register(){
        if (isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $password_confirm = $_POST['password_confirm'];
            $user_model = new User();
            $user = $user_model->getUser($username);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->error = "Please check your email format";
            } elseif($password!=$password_confirm){
                $this->error = "Please reconfirm the password";
            } elseif(!empty($user)){
                $this->error = "Username $username existed";
            }
            if(empty($this->error)){
                $user_model->username = $username;
                $user_model->password = md5($password);
                $user_model->email = $email;
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
//        echo "<pre>";
//        print_r($_SESSION['user']);
//        echo "</pre>";
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
                    if ($_SESSION['user']['roles'] == 0){
                        header('Location:index.php?controller=user&action=profile');
                        exit();
                    }
                    else {
                        header('Location:../backend/index.php');
                        exit();
                    }
                } else {
                    $this->error = 'Please check username/password';
                }
            }
        }
        $this->content = $this->render('views/login/login.php');
        require_once 'views/layouts/main_login.php';
    }
    public function profile()
    {
        if (isset($_POST['submit'])) {
            $user_model = new User();
            $id = $_SESSION['user']['id'];
            $fullname = $_POST['fullname'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $avatar = $_FILES['image']['name'];

            if ($_FILES['image']['error'] == 0) {
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $extension = strtolower($extension);
                    $arr_extension = ['jpg', 'jpeg', 'png', 'gif'];
                    $file_size = $_FILES['image']['size'] / 1024 / 1024;
                    $file_size = round($file_size, 2);

                    if (!in_array($extension, $arr_extension)) {
                        $this->error = "Please upload image file format";
                    } elseif ($file_size > 2) {
                        $this->error = "File upload can't be more than 2Mb";
                    }
                }
                if (empty($this->error)) {
                    if ($_FILES['image']['error'] == 0) {
                        $dir_uploads = __DIR__ . '/../assets/uploads';
                        if (!file_exists($dir_uploads)) {
                            mkdir($dir_uploads);
                        }
                        //tạo tên file theo 1 chuỗi ngẫu nhiên để tránh upload file trùng lặp
                        $filename = $_FILES['image']['name'];
                        move_uploaded_file($_FILES['image']['tmp_name'], $dir_uploads . '/' . $filename);
                    }
                    $user_model->fullname = $fullname;
                    $user_model->phone = $phone;
                    $user_model->address = $address;
                    $user_model->avatar = $avatar;
                    $is_insert = $user_model->insertProfile($id);

                    if ($is_insert) {
                        $user = $user_model->getUserProfile($id);
                        $_SESSION['user'] = $user;
                        $_SESSION['success'] = 'Save data successfully';
                    } else {
                        $_SESSION['error'] = 'Data not be saved yet';
                    }
                    header('Location: profile.html');
                    exit();
                }

        }
            $this->content = $this->render('views/login/user.php');
            require_once 'views/layouts/main_login.php';
        }
        public function logout()
        {
            $_SESSION=[];
            session_destroy();
            $_SESSION['success'] = 'Logout succesfully';
            header('Location:index.php?controller=user&action=login');
        }
}