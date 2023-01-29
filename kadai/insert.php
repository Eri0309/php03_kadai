<?php
// 1. POSTデータ取得
$book_name = $_POST['book_name'];
$book_url = $_POST['book_url'];
$book_comment = $_POST['book_comment'];


// 2. DB接続します
// funcs.phpに書かれていることを呼び出して使うことができる様になる
require_once('funcs.php');
// 空の変数にdb_conn()を呼び出す
$pdo = db_conn();


// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO gs_bn_table(id,book_name,book_url,book_comment,indate )
  VALUES( NULL, :book_name, :book_url, :book_comment, sysdate() )"
);

//ダイレクトに送られてきたデータを保存するのではなく（攻撃の可能性があるから）、変換のための変数を間に噛ませる
// :name　でバインド変数
//PDO::PARAM_STRでただの文字列にする、という意味

// 4. バインド変数を用意
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
 header('Location:index.php') ;
}
?>
