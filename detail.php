<?php
//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs.php');
$pdo = db_conn();


//2.対象のIDを取得
$id = $_GET['id'];
// echo $id;

//3．データ取得SQLを作成（SELECT文）
// WHERE id=:id バインド変数にする
$stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id=:id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
if($status == false){
    sql_error($status);
}else{
    $result = $stmt->fetch();
    // var_dump($result);
}



?>

<!-- 以下はindex.phpのHTMLをまるっと持ってくる -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>データ更新</legend>
     <label>名前：<input type="text" name="name" value="<?=$result['name']?>"></label><br>
     <label>Email：<input type="text" name="email" value="<?=$result['email']?>"></label><br>
     <label><textArea name="naiyou" rows="4" cols="40"><?=$result['naiyou']?></textArea></label><br>
    <!-- POSTで送るとGETと違ってURLにIDが載っていない。POSTで送る場合はフォームにIDの情報を載せる必要がある -->  
      <!-- ただし直接IDを見える形では載せたくないのでtypeをhiddenにする -->
    <input type="hidden" name="id" value="<?=$result['id']?>">
    <input type="submit" value="送信">

    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
