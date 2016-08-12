<?php

include_once 'Db.php';

if(isset($_POST['fileName'])){
    $fileName = $_POST['fileName'];
    // $fileName = "2.txt";
    $dir = 'downloads/';
    $content = file_get_contents($dir.$fileName);

    echo $content;
}



?>