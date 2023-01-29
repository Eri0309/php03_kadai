<?php
//insert.phpの処理を持ってくる
//1. POSTデータ取得
$name= $_POST['name'];
$email= $_POST['email'];
$naiyou= $_POST['naiyou'];
$id= $_POST['id'];

// echo $name;
// echo $email;
// echo $naiyou;
// echo $id;

//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();


//３．データ更新SQL作成（UPDATE テーブル名 SET 更新対象1=:更新データ ,更新対象2=:更新データ2,... WHERE id = 対象ID;）
// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
    "UPDATE gs_an_table 
    SET name=:name, email=:email, naiyou=:naiyou, indate=sysdate() 
    WHERE id=:id;" 
  );
  
  // 4. バインド変数を用意
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

  // 5. 実行
  $status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMassage:".$error[2]);
  }else{
    //５．index.phpへリダイレクト
    // header('Location: index.php');
    // func.phpで作った関数を活用する
    redirect('select.php');
  }
  ?>
  