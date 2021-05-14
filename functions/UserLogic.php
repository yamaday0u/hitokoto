<?php
require_once('./dbconnect.php');

class UserLogic{
  /**
  *ユーザーを登録する
  *@param array $userData
  *@return bool $result
  */
  public static function createUser($userData) {
    $result = false;
    $sql = 'INSERT INTO hitokoto_users (name, email, password) VALUES (?, ?, ?)';

  //ユーザーデータを配列に入れる
  $arr = []; //配列を空にする
  $arr[] = $userData['username']; //name
  $arr[] = $userData['email']; //$email
  $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT); //password ハッシュ化

    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);//$arrの値を$sqlに入れる。
      return $result;
    }catch(\Exception $e) {
      return $result;
    }
  }

  /**
  *ログイン処理
  *@param string $userData
  *@param string $password
  *@return bool $result
  */
  public static function login($email, $password) {
    // 結果の初期化
    $result = false;
    // ユーザーをemailから検索して取得
    $user = self::getUserByEmail($email);

    if(!$user) {
      return $result;
    }

    // パスワードの照会
    if (password_verify($password, $user['password'])) {
      // ログイン成功
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    }
    return $result;
  }

  /**
  *emailからユーザー情報全てを取得
  *@param string $email
  *@return array|bool $user|false
  */
  public static function getUserByEmail($email) {
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    $sql = 'SELECT * FROM hitokoto_users WHERE email = ?';

    //ユーザーデータを配列に入れる
    $arr = [];
    $arr[] = $email;

    try {
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);
      // SQLの結果を返す
      $user = $stmt->fetch();
      return $user;
    }catch(\Exception $e) {
      return $result;
    }
  }

  /**
  *ログインチェック
  *@param void
  *@return bool $result
  */
  public static function checkLogin() {
    $result = false;
    // セッションにログインユーザーが入っていなかったらfalse
    if (isset($_SESSION['name']) && $_SESSION['id'] > 0){
      return $result = true;
    }
    return $result;
  }

  /**
  *ログアウト処理
  */
  public static function logout() {
    $_SESSION = array();// セッションの中身を空にする。
    session_destroy();
  }
}
?>
