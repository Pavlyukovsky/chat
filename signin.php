<?php

include_once 'Db.php';

if(isset($_POST['name'])){
    if(checkPassword($_POST['name'],$_POST['password'])){
        echo '1';
    }else{
        echo '2';
    }
}

function checkPassword($name, $password){
    $db = Db::getConnection();
    $sql = 'SELECT * FROM users WHERE name =:name AND password = :password';
    $result = $db->prepare($sql);
    $result->bindParam(':name', $name, PDO::PARAM_STR);
    $result->bindParam(':password', $password, PDO::PARAM_STR);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    return $result->fetch();
}