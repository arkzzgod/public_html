<?php
require "registerBd.php";
$comment_id = $_GET['id'];
$commentUpdate = R::findOne('comments', 'id = ?', [$comment_id]);
R::trash($commentUpdate);

