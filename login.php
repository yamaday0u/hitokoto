<?php
session_start();
require_once('./functions/UserLogic.php');

$err = [];
if (!$email = filter_input(INPUT_POST, 'email')) {
  $err['email_err'] = 'メールアドレスを入力してください';
}
if (!$password = filter_input(INPUT_POST, 'password')) {
  $err['password_err'] = 'パスワードを入力してください';
}

if (count($err) > 0) {
  $_SESSION = $err;
  header('Location: index.php');
  return;
}

$result = UserLogic::login($email, $password);
//$emailと$passwordは上記のバリデーションで値が入っている。
// ログイン失敗時の処理
if (!$result) {
  $_SESSION['login_err'] = 'メールアドレスまたはパスワードが間違っています。';
  header('Location: index.php');
  return;
}else {
// ログイン成功時の処理
  $_SESSION  = UserLogic::getUserByEmail($email);
  header('Location: mypage.php');
}

?>
