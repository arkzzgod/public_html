<?php
require "registerBd.php";
if (empty($_SESSION)) {
    header("Location: login.php");
    die();
}?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!-- Если авторизован выведет приветствие -->
<?php if(isset($_SESSION['logged_user'])) : ?>
    <div style="text-align: center "> Привет,
        <?php echo $_SESSION['logged_user']->login; ?></br> </div>
    <div style="text-align: center "><a href="logout.php">Выйти</a></div>
<?php else :  header('Location: login.php');?>
<?php endif; ?>
<form class="form2" style="text-align: center" action="downloadFile.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file"  accept=".jpg, .jpeg, .png">
    <input type="submit" value="Загрузить файл!">
</form>
<?php
$dir = 'img/'; // Папка с изображениями
$cols = 1; // Количество столбцов в будущей таблице с картинками
$files = scandir($dir); // Берём всё содержимое директории
echo "<div style='text-align: center' >"; // Начинаем таблицу
$k = 0; // Вспомогательный счётчик для перехода на новые строки
for ($i = 0; $i < count($files); $i++) { // Перебираем все файлы
    if (($files[$i] != ".") && ($files[$i] != "..")) { // Текущий каталог и родительский пропускаем
        if ($k % $cols == 0) echo "<tr>"; // Добавляем новую строку
        echo "<br>"; // Начинаем столбец
        $path = $dir.$files[$i]; // Получаем путь к картинке
        echo "<img src='$path' alt='' width='100' height='auto'/>"; // Вывод превью картинки
        echo "<br>";
        $_SESSION['form_id'] = $form ='form_id' . $i;
        echo "<form class='form' style='text-align: center' action='comments.php'>
        <button class=$form name=$form type='submit' >Подробнее</button></form>";
        echo "</a>"; // Закрываем ссылку
        echo "</td>"; // Закрываем столбец*/
        if ((($k + 1) % $cols == 0) || (($i + 1) == count($files))) echo "</tr>";
        $k++;
        $_SESSION['fileCount']=$form;
    }
}
echo "</div>"; ?>
</body>
</html>
