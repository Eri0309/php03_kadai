<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="css/kadai.css" rel="stylesheet">
  <!-- <style>div{padding: 10px;font-size:16px;}</style> -->
</head>
<body>

<header>
</header>
<fieldset>
<legend><h1>書籍検索</h1></legend>
<div id="search-area">
  <p id="search-box">
    <input type="search" id="keyword" placeholder="title search" required> 
    <button id="readbook" disabled="disabled"  onclick="disabled = true">検索</button>
  </p>
</div>

<div id="result-area">
    <h2>検索結果</h2>
    <p id="search-result"></p>
</div>
</fieldset>


<!-- Main[Start] -->
<form method="POST" action="insert.php">
  <div class="jumbotron">
   <fieldset>
   <legend><h1>ブックマーク</h1>  </legend>
     <label>書籍名：<input type="text" name="book_name"></label><br>
     <label>書籍URL：<input type="text" name="book_url"></label><br>
     <label>書籍コメント：<textArea name="book_comment" rows="4" cols="40"></textArea></label><br>
     <input type="submit" value="登録">
    </fieldset>
  </div>
</form>

<!-- Head[Start] -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
<!-- Head[End] -->



<!-- 以下、GoogleBooks APIとの連携 -->
<script src="js/jquery-3.5.1.min.js"></script>
<script>
const googleBooksURL = "https://www.googleapis.com/books/v1/volumes?q=maxResults=20";
const inputElement = $("#keyword").val();

$("#keyword").on("input",function(){
  if (inputElement === ''){
    $("#readbook").prop('disabled',false);
  }else{
    $("#readbook").prop('disabled',true);
  }
});

$("#readbook").on("click", function(){
  const searchInput = document.getElementById("keyword");
  // console.log(searchInput);
  const searchKeyword= searchInput.value;
  const googleBooksURL= "https://www.googleapis.com/books/v1/volumes?q=intitle:" + searchKeyword + "&maxResults=20"
  $.get(googleBooksURL, function (data) {
  let items = data.items; 
  const results = items.filter (function(item){
    return item.volumeInfo.title.includes(searchKeyword);
  });
  for (let i=0; i< results.length; i++){
    const title = items[i].volumeInfo.title;
    const url = items[i].volumeInfo.infoLink;
    if (items[i].infoLink !== undefined){
      url = items[i].infoLink;
    }
    if (items[i].volumeInfo.imageLinks !== undefined){
        thumb = items[i].volumeInfo.imageLinks.thumbnail;
    }else{
        thumb="";
    }
    // $("#search-result").append(`<ul id="result-list"><li>${"<img src ='"+thumb+"'/>"}</li><li>【タイトル】<div id=sTitle>${title}</div><button id="copy-title" class="copy-btn">コピー</button></li><li>【書籍URL】<div id=sURL>${url}</div><button id="copy-url" class="copy-btn">コピー</button></li></ul>`);
    $("#search-result").append(`
    <table id="result-table">
    <thread>
    <tr>
    <th>書籍画像</th>
    <th>書籍タイトル</th>
    <th>書籍URL</th>
    </tr>
    </thread>
    <tbody>
    <tr>
    <td><img src="${thumb}"/></td>
    <td><p id="sTitle">${title}</p><button id="copy-title" class="copy-btn">コピー</button></td>
    <td><p id="sURL">${url}</p><button id="copy-url" class="copy-btn">コピー</button></td>
    </tr>
    </tbody>  
    </table>`);
  }
  })})

  $(document).on("click", "#copy-title", function() {
  const targetTitle = $("#sTitle").text();
  console.log(targetTitle);
  const temp = $("<input>");
  $("body").append(temp);
  temp.val(targetTitle).select();
  document.execCommand("Copy");
  temp.remove();
});

$(document).on("click", "#copy-url", function() {
  const targetURL = $("#sURL").text();
  console.log(targetURL);
  const temp = $("<input>");
  $("body").append(temp);
  temp.val(targetURL).select();
  document.execCommand("Copy");
  temp.remove();
});


</script>
</body>
</html>