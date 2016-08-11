<?php

include_once 'Db.php';

if(isset($_POST['name'])){
    $id = selectUserID($_POST['name'])['id'];
    if(sendMessage($id, $_POST['message'])){
        echo '1';
    }else{
        echo '2';
    }
}

function sendMessage($user_id, $message){
    $time = time();
    $db = Db::getConnection();
    $sql = 'INSERT INTO messages (user_id, message, date)
            VALUES (:user_id, :message, :date)';
    $result = $db->prepare($sql);
    $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $result->bindParam(':message', $message, PDO::PARAM_STR);
    $result->bindParam(':date', $time, PDO::PARAM_INT);
    return $result->execute();
}
function selectUserID($name){
    $db = Db::getConnection();
    $sql = 'SELECT * FROM users WHERE name = :name';
    $result = $db->prepare($sql);
    $result->bindParam(':name', $name, PDO::PARAM_INT);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    return $result->fetch();
}


// $uploaddir = '/var/www/uploads/';
// $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

// echo '<pre>';
// if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
//     echo "Файл корректен и был успешно загружен.\n";
// } else {
//     echo "Возможная атака с помощью файловой загрузки!\n";
// }

// echo 'Некоторая отладочная информация:';
// print_r($_FILES);

// print "</pre>";

?>