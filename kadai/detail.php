<?php


//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs.php');
$pdo = db_conn();

//2.対象のIDを取得
$id = $_GET['id'];
// echo $id;

//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM gs_bn_table WHERE id=:id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
if($status == false){
    sql_error($status);
}else{
    $result = $stmt->fetch();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="css/kadai.css" rel="stylesheet">
  <!-- <style>div{padding: 10px;font-size:16px;}</style> -->
</head>
<body>

<header>
</header>
<fieldset>
<!-- Main[Start] -->
<form method="POST" action="insert.php">
<div class="jumbotron">
<fieldset>
<h2>現在の登録内容</h2>
<label>書籍名：<?= $result["book_name"] ?></label><br>
<label>書籍URL：<?= $result["book_url"] ?></label><br>
<label>書籍コメント：<?= $result["book_comment"] ?></label><br>
<h2>更新内容</h2>
<label>書籍名：<input type="text" name="book_name"></label><br>
<label>書籍URL：<input type="text" name="book_url"></label><br>
<label>書籍コメント：<textArea name="book_comment" rows="4" cols="40"></textArea></label><br>
<input type="submit" value="更新">
</div>
</form>
<div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
</fieldset>

</script>
</body>
</html>