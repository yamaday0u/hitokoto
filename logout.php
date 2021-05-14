<?php
session_start();
require_once('./functions/UserLogic.php');

if (!$logout = filter_input(INPUT_POST,'logout')) {
  exit('不正なリクエストです。');
}
// ログインしているか判定し、セッションが切れていたらログインしてくださいとメッセージを出す。
$result = UserLogic::checkLogin();
if (!$result){
  $_SESSION['session_err'] = 'セッションが切れたので、ログインし直してください。';
  header('Location: /');
}

// ログアウトする
UserLogic::logout();
?>

 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../resources/style.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <title>ログアウト</title>
   </head>
   <body>

     <header>
       <h1>ひとこと掲示板</h1>
     </header>

     <div class="container">
       <div class="heading-index">
         <p>ログアウト完了！</p>
         <p>アクセスありがとう<i class="far fa-laugh-wink"></i></P>
       </div>

          <hr>
          <div class="row">
            <div class="col"></div>
            <input class="heading col-6 btn btn-success" type="button" onclick="location.href='/'" value="ログイン画面へ">
            <div class="col"></div>
          </div>
     </div>

     <footer>
       <p>created by yamaday0u</p>
     </footer>
   </body>
 </html>
