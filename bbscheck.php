<?php
session_start();
require_once('dbconnect.php');

$page = $_POST['page'];

if (!$comment = filter_input(INPUT_POST, 'comment')) {
  $_SESSION['comment_err'] = 'ひとことを入力してください';
}
if(mb_strlen($comment) > 200) {
  $_SESSION['comment_err'] = 'ひとことは200文字以内で入力してください';
}

// エラーがなければ保存
if (isset($_SESSION['comment_err'])) {
  header("Location: bbs.php?page=$page");
  return;
}else {
  // 保存するためのSQL文を作成
  $sql = connect()-> prepare("INSERT INTO bbs(name, comment, reply) VALUES (:name, :comment, :reply)");
  $sql->bindValue(':name', $_SESSION['name']);
  $sql->bindValue(':comment', $comment);
  $sql->bindValue(':reply', $_POST['reply']);

  // 保存する
  $sql->execute();
  $sql = null;
  // $_SESSION['username'] = $username;
  header("Location: bbs.php?page=$page");
}
?>
