<?php

include_once 'Db.php';

if(isset($_POST['name'])){
    $id = selectUserID($_POST['name'])['id'];
    if($_FILES['files'])
    {
        if(moveFile($_FILES['files']))
        {
            if(sendMessage($id, $_POST['message'], $_FILES['files']['name'])){
                echo '1';
            }else{
                echo '2';
            }
        }
    }else{
        if(sendMessage($id, $_POST['message'])){
            echo '1';
        }else{
            echo '2';
        }
    }
}

function sendMessage($user_id, $message, $files = ""){
    $time = time();
    $db = Db::getConnection();
    $sql = 'INSERT INTO messages (user_id, message, date, file)
            VALUES (:user_id, :message, :date, :file)';
    $result = $db->prepare($sql);
    $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $result->bindParam(':message', $message, PDO::PARAM_STR);
    $result->bindParam(':date', $time, PDO::PARAM_INT);
    $result->bindParam(':file', $files, PDO::PARAM_STR);
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

function moveFile($file){
    $uploaddir = 'downloads/'; // Dir name
    $uploadfile = $uploaddir . basename($_FILES['files']['name']); // File Path in the Server
    @mkdir("downloads", 0777);  // Create dir if don't exist

    // Copy file to the Server
    if (copy($_FILES['files']['tmp_name'], $uploadfile)) {
        echo "Файл корректен и был успешно загружен.\n";
        return true;
    } else {
        echo "Возможная атака с помощью файловой загрузки!\n";
        return false;
    }
}
?>