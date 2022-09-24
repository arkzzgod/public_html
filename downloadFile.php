<?php
include_once('functionsUploadFile.php');

if(isset($_FILES['file'])) {
    // проверяем, можно ли загружать изображение
    $check = can_upload($_FILES['file']);

    if($check === true){
        header('Location: index.php');
    }
    else{
        // выводим сообщение об ошибке
        echo "<strong>$check</strong>";
    }
}
