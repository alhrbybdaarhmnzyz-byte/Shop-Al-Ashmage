<?php


class User{

private int $_id;
private string $_username;
private string $_email;
private string $_password;

private string $_role;


public function __construct(int $id, string $username, string $email, string $password, string $role){
$this->_id = $id;
$this->_username = $username;
$this->_email = $email ;
$this->_password = $password;
$this->_role = $role;
}

public function getID(): int{
    return $this->_id;
}
public function getUsername():string{
    return $this->_username;
}

public function getEmail():string{
    return $this->_email;
}

public function getPassword(): string{
    return $this->_password;
}

public function getRole(): string{
    return $this->_role;
}

public function isAdmin(): bool{
    return $this->_role=='admin';
}

}