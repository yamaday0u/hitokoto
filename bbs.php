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

$start = CommentLogic::pagenation_start($_GET['page']);//URLのpageの値をpagenation_startに渡す
$pagenation = CommentLogic::pagenation();
$posts = Commentlogic::show_comment($start, 10);
?>

 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../resources/style.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
   <title>ひとこと掲示板</title>
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
         <p class="col-sm-11 col-12">こんにちは、<?php echo $_SESSION['name'] ?>さん</p>
         <div class="mb-2 mr-1 col">
           <input class="btn btn-info mb-2" type="button" onclick="location.href='mypage.php'" value="マイページへ戻る">
           <form action="logout.php" method="post">
             <input class="btn btn-secondary" type="submit" name="logout" value="ログアウト">
           </form>
         </div>
       </nav>
    </aside>

    <div class="heading">掲示板</div>

    <hr>

    <!--   コメントの投稿   -->
    <!-- 投稿のエラーメッセージ -->
    <?php if(isset($_SESSION['comment_err'])): ?>
    <p class="err"><?php echo $_SESSION['comment_err']; ?></p>
    <?php endif ?>

    <form action="bbscheck.php" method="post">
       <p class="row">
         <label class="col-12">ひとこと：</label>
         <input class="col-12" type="text" name="comment" accept="text/html">
      </p>
      <div class="row">
       <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>"><!-- 現在のページ情報を送る-->
       <input type="submit" name="submit" value="投稿する">
      </div>
    </form>


  <hr>

<!-- ページリンクの表示（上部） -->
  <?php for($i = 1; $i <= $pagenation; $i++) { ?>　
    <a href = "?page=<?php echo $i ?>"><?php echo $i; ?></a>
  <?php } ?>

<!--   掲示板の表示   -->
    <div class="row">
      <?php if($posts !== false): ?>
        <ul>
          <?php foreach($posts as $post): ?>
            <div class="comment-index-item"><a id="<?php echo $post['reply']; ?>"></a>
              <li style="list-style: none;">
                <div class="">
                  <?php echo h($post['id']); ?>:<!-- コメントの番号 -->
                  <?php echo h($post['created_at']); ?><!-- コメントの日時 -->
                </div>

                  <?php echo h($post['name']); ?>:<!-- コメントの主 -->
                  <p><?php echo h($post['comment']); ?></p><!-- コメントの内容 -->

                  <?php if($post['reply']): ?>
                  <div class="reply">
                    <p><a href="#<?php echo $post['reply']; ?>"><?php echo $post['reply']; ?>のひとことに返信</a></p>
                  </div>
                  <?php endif; ?>

                  <div class="comment-bottom">
                    <form action="delete.php" method="post">
                      <input type="hidden" name="id" value="<?php echo h($post['id']); ?>"><!-- コメントの番号を送る-->
                      <input class="mr-1" type="submit" value="削除">
                    </form>
                    <form action="reply.php" method="post">
                      <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>"><!-- 現在のページ情報を送る-->
                      <input type="hidden" name="id" value="<?php echo h($post['id']); ?>"><!-- コメントの番号を送る-->
                      <input type="submit" value="返信">
                    </form>
                  </div>
              </li>
            </div>
        <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

  <!-- ページリンクの表示（下部） -->
  <?php for($i = 1; $i <= $pagenation; $i++) { ?>　
    <a href = "?page=<?php echo $i ?>"><?php echo $i; ?></a>
  <?php } ?>

  </div><!-- end container-->

  <footer>
      <p>created by yamaday0u</p>
  </footer>
</body>
</html>
<?php unset($_SESSION['comment_err']) ?>
