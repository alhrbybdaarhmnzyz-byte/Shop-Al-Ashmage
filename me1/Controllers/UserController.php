<?php
require_once __DIR__.'/../Web/Others/init.php';
require_once __DIR__.'/../Business/User.php';

class UserController{

    private $errors = [];

    public function login(){
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $validation = $this->validateLoginInput($username, $password);

        if (!$validation['valid']) {
            $this->errors = array_merge($this->errors, $validation['errors']);
            return;
        }
        
        $result = $this->authenticateUser($username, $password);

        if($result['success']){

             $user = $result['user'];


            $_SESSION['user'] = $user;

            if($user->isAdmin()){
                 header("Location: admin.php");
        exit;
            }
            else {
    header("Location: index.php");
            }
            exit;
        }
        else {
            $this->errors[] = $result['message'];
        }
        }
    }

    public static function requireNonUser(){
        if (isset($_SESSION['user'])) {
        
            header("Location: notAllowed.php");
            exit;
    }
}


    public static function requireNonAdmin() {
    
   if (isset($_SESSION['user'])) {
        
        if ($_SESSION['user']->isAdmin()) {
            header("Location: notAllowed.php");
            exit;
        }
    }
}

public static function requireAdmin() {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
    
    
    if (!$_SESSION['user']->isAdmin()) {
        header("Location: notAllowed.php");
        exit;
    }
}

public static function requireLogin() {
    
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
}
    private function authenticateUser(string $username, string $password):array{

        $user = UserData::VerifyLogin($username, $password);
    
    if ($user) {
        return [
            'success' => true, 
            'message' => 'تم تسجيل الدخول بنجاح.', 
            'user' => $user
        ];
    }
    
    return [
        'success' => false, 
        'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة.', 
        'user' => null
    ];
}

    private function validateLoginInput(string $username, string $password){
        $errors = [];
        
        if (empty($username) || empty($password)) {
            $errors[] = 'جميع الحقول مطلوبة.';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
    public function register():void{
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm-password'] ?? '';

            $validation = $this->validateRegisterInput($username, $email, $password, $confirm);

            if(!$validation['valid']){
                $this->errors = array_merge($this->errors, $validation['errors']);
                return;
            }

            $result = $this->registerUser($username, $email, $password);

            if($result['success']){
                header("Location: login.php");
                exit;
            } else {
                $this->errors[] = $result['message'];
            }
        }
    }

    public function getErrors():array{
        return $this->errors;
    }

    private function validateRegisterInput(string $username, string $email, string $password, string $confirm):array{
        $errors = [];
        
        
        if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
            $errors[] = 'جميع الحقول مطلوبة.';
            return ['valid' => false, 'errors' => $errors]; // Return early
        }
        
        
        if (strlen($username) < 3) {
            $errors[] = 'اسم المستخدم يجب أن يكون 3 أحرف على الأقل.';
        }
        
        if (strlen($username) > 50) {
            $errors[] = 'اسم المستخدم يجب ألا يتجاوز 50 حرفاً.';
        }
        
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'البريد الإلكتروني غير صالح.';
        }
        
        
        if (strlen($password) < 6) {
            $errors[] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.';
        }
        
        
        if ($password !== $confirm) {
            $errors[] = 'كلمتا المرور غير متطابقتين.';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    private function registerUser(string $username, string $email, string $password): array{

        
        if(UserData::getUserByUsername($username)){
            return ['success' => false, 'message' => 'اسم المستخدم موجود بالفعل.', 'user' => null];
        }

        
        if(UserData::getUserByEmail($email)){
            return ['success' => false, 'message' => 'البريد الإلكتروني مسجل بالفعل.', 'user' => null];
        }

        
        $userId = UserData::CreateUser($username, $email, $password);
        
        if ($userId > 0) {
            $user = UserData::GetUserByID($userId);
            return ['success' => true, 'message' => 'تم إنشاء الحساب بنجاح.', 'user' => $user];
        }
        
        return ['success' => false, 'message' => 'حدث خطأ أثناء إنشاء الحساب.', 'user' => null];
    }
}