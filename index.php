<?php
session_start();
require_once('gest.php');
$gest_email = GEST_EMAIL;
$gest_pass = GEST_PASS;
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>ひとこと掲示板ログイン画面</title>
  </head>


  <body>
    <header>
      <h1>ひとこと掲示板</h1>
    </header>

    <div class="container">
      <div class="heading-index">
        このサービスは、PHPを使ってログイン機能、掲示板投稿機能、データベース、セッションなどの機能により作っています。
      </div>

        <form action="login.php" method="post"><!--../login.php-->

          <!-- ログインせずにマイページや掲示板にアクセスした場合のエラーメッセージ -->
          <?php if(isset($_SESSION['login_err'])): ?>
            <p class="err"><?php echo $_SESSION['login_err']; ?></p>
          <?php endif ?>

          <!-- セッションが切れている場合のエラーメッセージ -->
          <?php if(isset($_SESSION['session_err'])): ?>
            <p class="err"><?php echo $_SESSION['session_err']; ?></p>
          <?php endif ?>

<!-- メールアドレス入力 -->
          <?php if(isset($_SESSION['email_err'])): ?>
          <p class="err"><?php echo $_SESSION['email_err']; ?></p>
          <?php endif ?>
          <div class="row">
            <label for="email" class="col-4">メールアドレス：</label>
            <input class="mb-2 mr-1 col" type="email" name="email" id="email">
          </div>

<!-- パスワード入力 -->
          <?php if(isset($_SESSION['password_err'])): ?>
          <p class="err"><?php echo $_SESSION['password_err']; ?></p>
          <?php endif ?>
          <div class="row">
            <label for="password" class="col-4">パスワード：</label>
            <input class="mb-2 mr-1 col" type="password" name="password" id="password">
          </div>

<!-- 　　ボタン　　 -->
          <div class="row">
            <input class="btn btn-success mb-2 ml-1 col" type="submit" name="submit" value="ログイン">
            <div class="col-1"></div>
            <input class="btn btn-info mb-2 mr-1 col" type="button" onclick="location.href='register.php'" value="新規登録"><!--../register.php-->
          </div>
        </form>

<!-- ゲストユーザーでログイン -->
        <hr>
        <form action="login.php" method="post"><!--../login.php-->
          <div class="row">
            <div class="col-1 col-sm-4"></div>
            <p class="col col-sm">ゲストユーザーでログインできます。</p>
            <div class="w-100"></div>

            <div class="col"></div>
            <input type="hidden" name="email" value="<?php echo $gest_email; ?>">
            <input type="hidden" name="password" value="<?php echo $gest_pass ?>">
            <input class="btn btn-warning mb-2 col-6" style="color:white" type="submit" name="submit" value="ゲストユーザー">
            <div class="col"></div>
          </div>
        </form>



    <div>
      <img class="col" src="puppy-3688871_1920.jpg" alt="top-image"><!--..puppy-3688871_1920.jpg-->
    </div>
    <footer>
      <p>created by yamaday0u</p>
    </footer>
</div><!-- end container-->
  </body>
</html>
