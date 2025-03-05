<?php
require_once 'models/User_2.php';

class AuthController
{
    protected $userModel;

    public function __construct()
    {
       
        $this->userModel = new User_2();
    }

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        include_once './views/client/auth/register.php';
    }

    // Xử lý đăng ký
    public function processRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            if (empty($email) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
                header("Location: index.php?controller=authen&action=showRegisterForm");
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Mật khẩu xác nhận không khớp.";
                header("Location: index.php?controller=authen&action=showRegisterForm");
                exit;
            }

            if ($this->userModel->find('*', 'email = ?', [$email])) {
                $_SESSION['error'] = "Email đã tồn tại.";
                header("Location: index.php?controller=authen&action=showRegisterForm");
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userId = $this->userModel->insert([
                'email' => $email,
                'password' => $hashedPassword
            ]);

            if ($userId) {
                $_SESSION['success'] = "Đăng ký thành công! Hãy đăng nhập.";
                header("Location: index.php?controller=authen&action=showLoginForm");
            } else {
                $_SESSION['error'] = "Lỗi khi đăng ký.";
                header("Location: index.php?controller=authen&action=showRegisterForm");
            }
            exit;
        }
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
{
  

    // Nếu đã đăng nhập, chuyển sang checkout
    if (isset($_SESSION['user'])) {
        header("Location: index.php?controller=checkout");
        exit;
    }

    include_once './views/client/auth/login.php';
}

    // Xử lý đăng nhập
    public function processLogin()
    {
        // Bắt đầu session
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $redirect = $_GET['redirect'] ?? 'checkout'; // Nếu không có redirect thì mặc định là checkout
    
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Vui lòng nhập email và mật khẩu.";
                header("Location: index.php?controller=authen&action=showLoginForm&redirect=$redirect");
                exit;
            }
    
            $user = $this->userModel->find('*', 'email = ?', [$email]);
    
            if (!$user || !password_verify($password, $user['password'])) {
                $_SESSION['error'] = "Email hoặc mật khẩu không đúng.";
                header("Location: index.php?controller=authen&action=showLoginForm&redirect=$redirect");
                exit;
            }
    
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email']
            ];
    
            // Chuyển về trang cần thiết (mặc định là checkout)
            header("Location: index.php?action=$redirect");
            exit;
        }
    }
    


    // Đăng xuất
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?controller=authen&action=showLoginForm");
        exit;
    }

    
}
