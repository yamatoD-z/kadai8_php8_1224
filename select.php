<?php

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．データ取得SQL作成

// 出現回数の降順で出力
$stmt = $pdo->prepare("SELECT * FROM tangocount ORDER BY count DESC;");
$status = $stmt->execute();


//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
} else {
    // elseの中は、SQL実行成功した場合
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    
    // SQLのデータをテーブル形式で出力。単語出現回数の累計を追加。
    $int=0;
    $acCount=0;
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {        
        $acCount = $acCount+h($result['count']);
      $view .= '<tr>' 
      . '<td>' . $int . '</td>'
      . '<td>' . $result['id'] . '</td>' 
      .'<td>' .'<a href="detail.php?id=' . $result['id'] . '">' .  h($result['word']). '</a>' .'</td>' 
      .  '<td>'  . h($result['count']) . '</td>'  
      .  '<td>'  . h($result['content']) . '</td>' 
      . '<td>'  .$acCount . '</td>' 
      . '<td>'  .'<a href="delete.php?id=' . $result['id'] . '">' . '  [削除]' . '</a>'. '</td>' 

      . '</tr>'
      
      ;
        $int++;
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>フリーアンケート表示</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
    div {
        padding: 10px;
        font-size: 16px;
    }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">データ登録</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron">
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>id</th>
                    <th>word</th>
                    <th>count</th>
                    <th>備考</th>
                    <th>累計count</th>

                </tr>
                <?= $view ?>
            </table>
        </div>
    </div>
    <!-- Main[End] -->

</body>

</html>