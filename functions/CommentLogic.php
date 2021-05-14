<?php
require_once('./dbconnect.php');

class CommentLogic{
    /**
    *コメント削除
    *@param void
    *@return bool $result
    */
    public static function delete($id, $number, $name) { // ログインユーザーのID, コメントの番号, ログインユーザー名
      if(empty($id)) {
        exit('IDが不正です。');
      }

      $getUsername = connect()->query("SELECT name FROM bbs WHERE number = $number");// コメントの番号からコメントの主名を取り出す
      $username = $getUsername->fetch(PDO::FETCH_ASSOC);

      if($username['name'] === $name) { // コメントの主名とログインユーザー名が一致すれば削除処理
        $stmt = connect()->prepare("DELETE FROM bbs WHERE number = :number");
        $stmt->bindValue(':number', (int)$number, PDO::PARAM_INT);

        // SQL実行
        $stmt->execute();
        echo 'コメントを削除しました！';
      }else {
        echo "他のユーザーのコメントは削除できません。";
      }
    }

    /**
    *ページネーションスタート
    *
    *@return $start
    */
    public static function pagenation_start($get_page) {
      if (isset($get_page)) {
        $page = (int)$get_page;
      }else {
        $page = 1;
      }
      // スタートのポジションを計算する
      if ($page > 1) {
        $start = ($page *10) - 10;
      }else {
        $start = 0;
      }
      return $start;
    }

    /**
    *ページネーション
    *
    *
    */
    public static function pagenation() {
      // bbsテーブルのデータ件数を取得する
      $page_num = connect()->prepare("SELECT COUNT(*) number FROM bbs");
      $page_num->execute();
      $page_num = $page_num->fetchcolumn();
      // ページネーションの数を取得する
      $pagenation = ceil($page_num / 10);
      // ページネーションの準備完了
      return $pagenation;
    }

    /**
    *コメントの表示準備
    *
    *
    */
    public static function show_comment($start,$end) {
      $posts = connect()->prepare("SELECT * FROM bbs ORDER BY created_at DESC LIMIT $start, $end");
      $posts ->execute();
      $posts = $posts ->fetchall(PDO::FETCH_ASSOC);
      return $posts;
    }

    /**
    *コメント返信準備
    *
    *
    */
    public static function show_reply_comment($number) {
      $post = connect()->prepare("SELECT * FROM bbs WHERE number = $number");
      $post->execute();
      $replyPost = $post->fetch(PDO::FETCH_ASSOC);
      return $replyPost;
    }
}
?>
