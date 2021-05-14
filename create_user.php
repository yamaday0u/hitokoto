<?php
session_start();
require_once('./functions/UserLogic.php');

$token = filter_input(INPUT_POST, 'csrf_token');
//トークンがない、もしくは一致しない場合、処理を中止
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
  exit('不正なリクエストです。');
}
unset($_SESSION['csrf_token']);

//バリデーション
if(!$username = filter_input(INPUT_POST, 'username')) {
  $_SESSION['name_err'] = '*ユーザー名を入力してください*';
}
if(!$email = filter_input(INPUT_POST, 'email')) {
  $_SESSION['email_err'] = '*メールアドレスを入力してください*';
}
$password = filter_input(INPUT_POST, 'password');
if(!$password) {
  $_SESSION['password_err1'] = '*パスワードを入力してください*';
}
// 正規表現の確認
if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
  $_SESSION['password_err2'] = '*パスワードは英数字８文字以上１００文字以下にしてください*';
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf) {
$_SESSION['password_err3'] = '*確認用パスワードが異なっています*';
}

if($_SESSION) {
  $_SESSION['register_err'] = '登録に失敗しました。';
  header('Location: register.php');}
  else {
    $hasCreated = UserLogic::createUser($_POST);
  }

  if(!$hasCreated) {
    $_SESSION['register_err'] = '登録に失敗しました。';
    header('Location: register.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
  </head>
  <body>
      <p>ユーザー登録が完了しました。</p>
    <a href="/">ログイン画面へ戻る</a>
  </body>
</html>
