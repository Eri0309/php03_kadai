<?php
//XSS対応（ echoする場所で使用！）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn() 
//※関数を作成し、内容をreturnさせる。
//※ DBname等、今回の授業に合わせる。
function db_conn(){
    try {
      $db_name = "gs_db";    //データベース名
      $db_id   = "root";      //アカウント名
      $db_pw   = "";      //パスワード：XAMPPはパスワードなしMAMPのパスワードはroot
      $db_host = "localhost"; //DBホスト
      $db_port = "3306"; //XAMPPの管理画面からport番号確認
      $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host.';port='.$db_port.'', $db_id, $db_pw);
      return $pdo;//ここを追加！！
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    header('Location: '.$file_name);
}