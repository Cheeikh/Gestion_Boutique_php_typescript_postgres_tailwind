<?php
// src/App/Authorize/Authorize.php

namespace App\Authorize;


class Authorize {
public function saveUser($user){
    $_SESSION['user'] = $user;
}
public function getUserLogged(){
    if(isset($_SESSION['user'])){
        return $_SESSION['user'];
    }
    return null;
}
public function isLogged(){
    return isset($_SESSION['user']);
}

public function hasRole($role){
    if($this->isLogged()){
        return $_SESSION['user']['role'] == $role;
    }
    return false;
}
}

