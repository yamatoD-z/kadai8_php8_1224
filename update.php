<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更
//1. POSTデータ取得
$word   = $_POST['word'];
$count  = $_POST['count'];
$source    = $_POST['source'];
$content    = $_POST['content'];
$id = $_POST['id'];

//2. DB接続します
//*** function化する！  *****************
$pdo = db_conn();


//３．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE tangocount SET word = :word, count = :count, source = :source, content = :content, indate = sysdate() WHERE id = :id;');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':word', $word, PDO::PARAM_STR);
$stmt->bindValue(':count', $count, PDO::PARAM_INT);
$stmt->bindValue(':source', $source, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意

$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: index.php');
    exit();
}