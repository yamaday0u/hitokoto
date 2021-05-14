<?php
session_start();
require_once('./functions/security.php');
require_once('./functions/UserLogic.php');

$result = UserLogic::checkLogin();
if($result) {
  header('Location: mypage.php');
  return;
}
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>新規登録画面</title>
  </head>


  <body>
    <header>
      <h1>ひとこと掲示板</h1>
    </header>
    <div class="container">
      <div class="heading-index">ユーザー登録フォーム</div>
      <hr>

        <?php if(isset($_SESSION['register_err'])): ?>
        <p class="err"><?php echo $_SESSION['register_err']; ?></p>
        <?php endif ?>

      <form action="create_user.php" method="post">

        <?php if(isset($_SESSION['name_err'])): ?>
        <p class="err"><?php echo $_SESSION['name_err']; ?></p>
        <?php endif ?>

        <p class="row">
          <label class="col-sm-4 col-md-3" for="username">ユーザー名：</label>
          <input class="col-sm" type="text" name="username">
        </p>

          <?php if(isset($_SESSION['email_err'])): ?>
          <p class="err"><?php echo $_SESSION['email_err']; ?></p>
          <?php endif ?>

        <p class="row">
          <label class="col-sm-4 col-md-3" for="email">メールアドレス：</label>
          <input class="col-sm" type="email" name="email">
        </p>

        <?php if(isset($_SESSION['password_err1']) | isset($_SESSION['password_err2'])): ?>
        <p class="err"><?php echo $_SESSION['password_err1']; ?></p>
        <p class="err"><?php echo $_SESSION['password_err2']; ?></p>
        <?php endif ?>

        <p class="row">
          <label class="col-sm-4 col-md-3" for="password">パスワード：</label>
          <input class="col-sm" type="password" name="password">
        </p>


        <?php if(isset($_SESSION['password_err3'])): ?>
        <p class="err"><?php echo $_SESSION['password_err3']; ?></p>
        <?php endif; ?>
        <p class="row">
          <label class="col-sm-4 col-md-3" for="password_conf">パスワード確認：</label>
          <input class="col-sm" type="password" name="password_conf">
        </p>

        <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">

        <div class="row">
          <input class="btn btn-success mb-2 ml-1 col" type="submit" value="新規登録する">
          <div class="col-1"></div>
          <input class="btn btn-info mb-2 mr-1 col" type="button" onclick="location.href='/'" value="登録済みの方">
        </div>
      </form>
    </div><!-- end container-->

    <footer>
      <p>created by yamaday0u</p>
    </footer>
  </body>
</html>
<?php unset($_SESSION['register_err']) ?>
<?php unset($_SESSION['name_err']) ?>
<?php unset($_SESSION['email_err']) ?>
<?php unset($_SESSION['password_err1']) ?>
<?php unset($_SESSION['password_err2']) ?>
<?php unset($_SESSION['password_err3']) ?>
