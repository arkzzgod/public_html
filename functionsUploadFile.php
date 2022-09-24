<?php
require "registerBd.php";

function can_upload($file,){
    // если имя пустое, значит файл не выбран
    if($file['name'] == '')
        return 'Вы не выбрали файл.';
    /* если размер файла 0, значит его не пропустили настройки
    сервера из-за того, что он слишком большой */
    if($file['size'] < 25000)
        return 'Недопустимый размер файла. Размер не должен быть меньше 250кб';
    if($file['size'] > 5e+6)
        return 'Недопустимый размер файла. Размер не должен быть больше 5мб';
    // разбиваем имя файла по точке и получаем массив
    $getMime = explode('.', $file['name']);
    // нас интересует последний элемент массива - расширение
    $mime = strtolower(end($getMime));
    // объявим массив допустимых расширений
    $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
    // если расширение не входит в список допустимых - return
    if(!in_array($mime, $types))
        return 'Недопустимый тип файла.';

    $_FILES['file']['name'] = $_SESSION['fileCount'].".jpg";

    move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . '\img/' . $_FILES['file']['name']);
    return true;
}
