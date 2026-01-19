<?php
require_once __DIR__.'/../Business/User.php';
class UserData{


    private function __construct(){

    }

    public static function getUserByUsername($username): ?User{
        $conn = StaffData::Getconnection();
        $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE username =?");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result =$stmt->get_result();
        $data = $result->fetch_assoc();

        if($data){
            return new User($data['id'], $data['username'], $data['email'], $data['password'], $data['role']);
        }
        
        return null;

    }


    public static function getUserByEmail($email): ?User{
        $conn = StaffData::Getconnection();
        $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email =?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result =$stmt->get_result();
        $data = $result->fetch_assoc();

        if($data){
            return new User($data['id'], $data['username'], $data['email'], $data['password'], $data['role']);
        }
        
        return null;

    }

    public static function GetUserByID(int $id): ?User{
        $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if ($data) {
        return new User(
            $data['id'], 
            $data['username'], 
            $data['email'], 
            $data['password'], 
            $data['role']
        );
    }
    return null;
    }

    public static function createUser(string $username, string $email, string $password, string $role='user'){
        $conn = StaffData::Getconnection();
        $hashed = password_hash($password,PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss",$username,$email,$hashed,$role);
        $stmt->execute();
        return $conn->insert_id;
    }

    
    public static function VerifyLogin(string $username, string $password):?User{
        $user = self::getUserByEmail($username) ?? self::getUserByUsername($username);
    
    if ($user && password_verify($password, $user->getPassword())) {
        return $user;
    }
    
    return null;
}
}