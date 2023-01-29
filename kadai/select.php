<?php
//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT) 全件データを取得
$stmt = $pdo->prepare("SELECT * FROM gs_bn_table");

//上で$stmtの中にアンケートの結果が全部返ってきている状況

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    //fetch(PDO::FETCH_ASSOC)で1行ずつ一レコードずつの塊に変換してくれるもの
    //$resultの中は配列でデータが入ってくる
    //その1行を繰り返し処理で描画していくコード
    $view .= "<p id=search-result>";
    $view .= "<br>";
    $view .= $result['indate'];
    $view .= "<br>";
    $view .= '書籍タイトル：'.$result['book_name'];
    $view .= "<br>";    
    $view .= '書籍URL：'.$result['book_url'];
    $view .= "<br>";
    $view .= 'コメント：'.$result['book_comment'];
    $view .= "<br>";
    $view .= '<a href="detail.php?id='.$result['id'].'">';
    $view .= '【更新】';
    $view .= "</a>";
    $view .= '<a href="delete.php?id='.$result['id'].'">';
    $view .= '【削除】';
    $view .= "</a>";
    $view .= "</p>";
  }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/kadaiselect.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <h1>ブックマーク一覧</h1>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->
<a class="navbar-brand" href="index.php">登録画面へ戻る</a>

</body>
</html>
