<?php
require "registerBd.php";
$comment_id = $_GET['id'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
</head>
<body>
<h3>Update comment</h3>
<form method="post">
    <input type="hidden" name="id" value="<?=1?>">
    <p>Форма редактирования</p>
    <input type="text" class="form-control" name="UpdateText" id="UpdateText" placeholder="Введите коментарий" required>
    <button class="btn btn-success" name="commentUpdate" type="submit">Update</button>
    <p style="text-align: center">Вернуться <a href="index.php">Назад</a>.</p>
</form>
</body>
</html>


<?php
$data = $_POST;

if(isset($data['commentUpdate'])){
    $commentUpdate = R::findOne('comments','id = ?',[$comment_id]);
    $newData=new DateTime('now');
    $b=new DateTime(''.$commentUpdate->data);
    $secondDifference = ($newData->getTimestamp()-$b->getTimestamp());
    if($secondDifference>300){
        echo "Прошло слишком много времени";
        return false;
    }else {
        $commentUpdate->comment=$data['UpdateText'];
        $commentUpdate->edited=true;
        R::store($commentUpdate);
    }
}