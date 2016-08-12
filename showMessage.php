<?php

include_once 'Db.php';

if(isset($_POST['name'])){
    if(checkPassword($_POST['name'],$_POST['password'])){
        echo '1';
    }else{
        echo '2';
    }
}

function selectMessage(){
    $db = Db::getConnection();
    $sql = 'SELECT * FROM messages';
    $result = $db->prepare($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    return $result->fetchAll();
}
function selectName($id){
    $db = Db::getConnection();
    $sql = 'SELECT * FROM users WHERE id = :id';
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    return $result->fetch();
}


$message = selectMessage();

for($i = 0; $i < count($message); $i++){
    $msg = $message[$i]['message'];
    $name = selectName($message[$i]['user_id']);
    $name = $name['name'];
    $time = $message[$i]['date'];
    $time = date('Y-m-d H:i:s', $time);
    $fileName = $message[$i]['file'];
    if($fileName != ""){
         //   (<a href='#' onclick='pop($fileName);' >$fileName</a>)
        
        echo "
            <div class='drop-mess'>
            $time  
            <b>$name пишет: </b>
            $msg
            (<a href='#' class='files' onclick='console.log(\"$fileName\");

            $.ajax({
                    url: \"runPopup.php\",
                    type: \"POST\",
                    data: ({ fileName: \"$fileName\"}),
                    success: function (msg) {
                        document.getElementById(\"popUpText\").innerHTML = msg;
                        return true;
                    },
                    error: function () {
                        alert(\"error\");
                        return false;
                    }
                });

            document.getElementById(\"popUp\").style.display = \"block\";



            ' >$fileName</a>)
            </div>
        ";
    }else
    {
        echo "
            <div class='drop-mess'>
            $time  
            <b class='name-mess'>$name пишет: </b>
            $msg
            </div>
        ";
    }
}
