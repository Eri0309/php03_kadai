<?php
//insert.phpの処理を持ってくる
//1. POSTデータ取得
$name= $_POST['name'];
$book_url= $_POST['book_url'];
$book_comment= $_POST['book_comment'];
$id= $_POST['id'];

//2. DB接続
require_once('funcs.php');
$pdo = db_conn();


//３．データ更新SQL作成（UPDATE テーブル名 SET 更新対象1=:更新データ ,更新対象2=:更新データ2,... WHERE id = 対象ID;）
$stmt = $pdo->prepare(
    "UPDATE gs_bn_table 
    SET name=:name, book_url=:book_url, book_comment=:book_comment, indate=sysdate() 
    WHERE id=:id;" 
  );
  
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

  $status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    $error = $stmt->errorInfo();
    exit("ErrorMassage:".$error[2]);
  }else{
    redirect('select.php');
  }
  ?>