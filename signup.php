<?php

include_once 'Db.php';

if(isset($_POST['name'])){
    if(checkUser($_POST['name'])){
        echo '3';
    }else if(checkUserEmail($_POST['email']))
    {
        echo '4';
    }else if(register($_POST['name'], $_POST['email'], $_POST['homepage'], $_POST['password']))
    {
        echo '1';
    }else
    {
        echo "2";
    }
}



// User register
function register($name, $email,$homepage,$password){
    $db = Db::getConnection();
    $sql = 'INSERT INTO users (name, email, homepage, password)
            VALUES (:name, :email, :homepage, :password)';
    $result = $db->prepare($sql);
    $result->bindParam(':name', $name, PDO::PARAM_STR);
    $result->bindParam(':email', $email, PDO::PARAM_STR);
    $result->bindParam(':homepage', $homepage, PDO::PARAM_STR);
    $result->bindParam(':password', $password, PDO::PARAM_STR);
    return $result->execute();
}

// Get user by user name
function checkUser($name){
    $db = Db::getConnection();
    $sql = 'SELECT * FROM users WHERE name = :name';
    $result = $db->prepare($sql);
    $result->bindParam(':name', $name, PDO::PARAM_STR);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    return $result->fetch();
}
// Get user by email name
function checkUserEmail($email){
    $db = Db::getConnection();
    $sql = 'SELECT * FROM users WHERE email = :email';
    $result = $db->prepare($sql);
    $result->bindParam(':email', $email, PDO::PARAM_STR);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    return $result->fetch();
}