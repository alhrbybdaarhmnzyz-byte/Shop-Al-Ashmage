<?php


class StaffData {
    
    private static string $_host;
    private static string $_username;
    private static string $_password;
    private static string $_database;
    
    private static ?mysqli $conn=null;

    private function __construct(){
        
    }
       
public static function connect(){
 ini_set('display_errors', 1);
    error_reporting(E_ALL);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (self::$conn === null) {
        try {
            $config = require __DIR__ .'/Config.php';

            
            self::$_host = $config['host'];
            self::$_username = $config['username'];
            self::$_password = $config['password'];
            self::$_database = $config['database'];

            
            self::$conn = new mysqli(
                self::$_host,
                self::$_username,
                self::$_password,
                self::$_database
            );
        } catch (\Throwable $e) {
            include __DIR__ . '/../Web/Pages/error.php';
            exit();
        }
    }
}

public static function close(){
    if(self::$conn !=null){
         self::$conn->close();
         self::$conn=null;
    }
       

    
}
public static function Getconnection(){
    if (self::$conn === null) {
        self::connect();
    }
    return self::$conn;
    }
  
        
    public static function GetHost(): string{
        return self::$_host;
    }
    
    public static function GetUsername(): string {
        return self::$_username;
    }
    
    
    public static function GetPassword(): string {
        return self::$_password;
    }
    
    public static function GetDataBase(){
        return self::$_database;
    }
       
}
    
    

