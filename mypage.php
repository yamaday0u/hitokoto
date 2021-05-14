<?php
session_start();
require_once('dbconnect.php');
require_once('./functions/security.php');
require_once('./functions/UserLogic.php');
require_once('./functions/CommentLogic.php');

$result = UserLogic::checkLogin();
if (!$result){
  $_SESSION['login_err'] = 'ユーザーを登録してログインしてください！';
  header ('Location: /');
  return;
}
$pagenation = CommentLogic::pagenation();
$posts = CommentLogic::show_comment(0,5);
?>

 <!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>マイページ</title>
  </head>

  <body>
    <header>
      <h1>ひとこと掲示板</h1>
    </header>

    <div class="container">

      <input id="menu" type="checkbox">
      <label for="menu" class="open"><i class="fas fa-bars"></i></label>
      <label for="menu" class="back"></label>

      <aside>
      <label for="menu" class="close"><i class="fas fa-window-close"></i></label>
      <nav class="row">
        <p class="col-11">こんにちは、<?php echo $_SESSION['name'] ?>さん</p>
        <div class="mb-2 mr-1 col">
          <form action="logout.php" method="post">
            <input class="btn btn-secondary" type="submit" name="logout" value="ログアウト">
          </form>
        </div>
      </nav>
      </aside>

          <div class="heading">マイページ</div>

          <hr>

          <h3 class="col-12">最新の掲示板</h3>
          <p class="col-12">最近のコメント（５件）</p>
          <?php if($posts !== false): ?>
            <ul>
              <?php foreach($posts as $post): ?>
              <li class="col">
                <?php echo h($post['name']); ?>:
                <?php echo h($post['comment']); ?>
                -<?php echo h($post['created_at']); ?>
              </li>
            <?php endforeach; ?>
            </ul>
          <?php endif; ?>
            <input class="btn btn-success" type="button" onclick="location.href='bbs.php?page=1'" value="掲示板へ移動する">

    </div> <!-- end container-->

    <footer>
      <p style="text-align:center; color:white; background-color:green;">created by yamaday0u</p>
    </footer>
  </body>
</html>
