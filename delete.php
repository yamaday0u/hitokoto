<?php
session_start();

require_once('dbconnect.php');
require_once('./functions/CommentLogic.php');

$result = CommentLogic::delete($_SESSION['id'], $_POST['number'], $_SESSION['name']);　// ログインユーザーのID, コメントの番号, ログインユーザー名

?>
<p><a href="bbs.php">戻る</a></p>
