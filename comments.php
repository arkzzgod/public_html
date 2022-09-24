<?php
require "registerBd.php";
if (empty($_SESSION)) {
    header("Location: login.php");
    die();
}
$uri = $_SERVER['REQUEST_URI'];
$ex=explode('/comments.php?form_id',$uri);
$ex1=$ex[1];
$ex2=$ex1[0];
if($count = R::findOne('counts','picid = ?',array($ex2))){
    $count->views++;
}else{
    $count = R::dispense('counts');
    $count->picid=$ex2;
    $count->views=1;
}
R::store($count);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comments</title>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2 style="text-align: center">Коментарии</h2>
            <div style="text-align: center">
                <?php
                $dir = 'img/'; // Папка с изображениями
                $files = scandir($dir); // Берём всё содержимое директории
                $path = $dir.$files[$ex2]; // Получаем путь к картинке
                echo "<img src='$path' alt='' /> <br>"; // Вывод картинки
                print_r('Просмотры '. $count->views . "<br>");
                $commentShow = R::find('comments','num = ?',array($ex2));
                foreach ($commentShow as $comment){
                    printf('Коментарий:  ' . $comment->comment);
                    printf(' Автор: %d ',$comment->user);
                    print_r('Дата и Время ' . $comment->data);
                    if($comment->edited==true){
                        printf('[Edited]');
                    }
                    if($comment->user == $_SESSION['logged_user']['login']){
                        echo "
                                <tr><td><a href='update.php?id=$comment->id'>Редактировать</a></td>
                                <td><a href='delete.php?id=$comment->id'>Удалить</a></td></tr>";
                    }
                    echo "<br>";
                }
                ?>
                <form style="text-align: center" method="post">
                    <input type="text" class="form-control" name="comment" id="comment" placeholder="Введите коментарий" required><br>
                    <button class="btn btn-success" name="commentAdd" type="submit" action='comments.php'>Публиковать</button>
                </form>
                <p style="text-align: center">Вернуться на <a href="index.php">главную</a>.</p>
            </div>
                <?php
                $data = $_POST;
                if(isset($data['commentAdd'])) {
                    $errors = array();
                    if(empty($errors)) {
                        $comment = R::dispense('comments');
                        $BanWords=array('лес', 'поляна', 'озеро');
                        foreach($BanWords as $item)
                        {
                            if (preg_match("/$item/",mb_strtolower($data['comment']))){
                                echo "В предложении есть слово - $item<br>";
                                return false;
                            }
                        }
                            $comment->comment = $data['comment'];
                            $comment->user=$_SESSION['logged_user']['login'];
                            $comment->num= $ex2;
                            $comment->data=new DateTime('now');
                            $comment->edited=false;

                            R::store($comment);

                    } else {
                        echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
                    }
                }
                if(!empty($errors)) {
                    echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
                };
                ?>
        </div>
    </div>
</div>
</body>
</html>

