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

$replyComment = Commentlogic::show_reply_comment($_POST['number']);//返信したいコメントの情報を取得
$page = $_POST['page'];
?>

 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../resources/style.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
   <title>ひとこと掲示板・返信</title>
 </head>

 <body>
   <header>
     <h1>ひとこと掲示板</h1>
   </header>

   <div class="container">
     <div class="heading"><?php echo $replyComment['name'] ?>さんへのコメント</div>
       <div class="row">
         <p class="col-sm-11 col-12">こんにちは、<?php echo $_SESSION['name'] ?>さん</p>
         <div class="mb-2 mr-1 col">
           <input class="btn btn-success mb-2" type="button" onclick="location.href='mypage.php'" value="マイページへ戻る">
           <input class="btn btn-info mb-2" type="button" onclick="location.href='bbs.php?page=<?php echo (int)$page ?>'" value="掲示板へ戻る">
           <form action="logout.php" method="post">
             <input class="btn btn-secondary" type="submit" name="logout" value="ログアウト">
           </form>
         </div>
       </div>
     <hr>

<!--   コメントの投稿   -->
    <form action="bbscheck.php" method="post">
       <?php if(isset($_SESSION['comment_err'])): ?>
       <p class="err"><?php echo $_SESSION['comment_err']; ?></p>
       <?php endif ?>
       <p class="row">
         <label class="col-12">ひとこと：</label>
         <input class="col-12" type="text" name="comment" accept="text/html">
      </p>
      <div class="row">
       <input type="hidden" name="reply" value="<?php echo $_POST['number'] ?>">
       <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
       <input type="submit" name="submit" value="投稿する">
      </div>
    </form>

  <hr>

<!--   返信するコメントの表示   -->
    <div class="row">
      <div class="comment-index-item">
        <p><?php echo $replyComment['name'] ?>さんのコメント</p>
        <p><?php echo h($replyComment['created_at']); ?></p><!-- コメントの日時 -->
        <p><?php echo h($replyComment['comment']); ?></p><!-- コメントの内容 -->
      </div>
    </div>
  </div><!-- end container-->

  <footer>
      <p>created by yamaday0u</p>
  </footer>
</body>
</html>
<?php unset($_SESSION['comment_err']) ?>
