<?php

require_once('funcs.php');

//1. POSTデータ取得
$sentence = $_POST['sentence'];
$source = $_POST['source'];

//２. 単語数カウントの処理
// A.　すべて小文字に
$smallSentence = strtolower($sentence);

// B.一般語を削除（キリがなくなったので記号だけ）
$replaceSpeCha = 
['	$','￡','￠','$','・','>','<','&','*','%','0','1','2','3','4', '5', '6', '7', '8', '9','-','‘','’','#','???', 'â', 'ﾃ｢ﾂﾂ', ':', ';', '"', "'", '?', '!', '(', ')', '/', '.', ',', '“', '”', '[', ']'];

foreach ($replaceSpeCha as $SpeCha) {
    $smallSentence = str_replace($SpeCha, "", $smallSentence);
}


$smallSentence = str_replace("ts ", "t ", $smallSentence);
$smallSentence = str_replace("rs ", "r ", $smallSentence);
$smallSentence = str_replace("ns ", "n ", $smallSentence);



// C.　配列化
$wordarray = explode(" ", $smallSentence);

// D.配列内の同じ要素をカウント。関数が勝手に連想配列を作ってくれる。
$countarray = array_count_values($wordarray);

//2. DB接続します
$pdo = db_conn();


// 一旦、中身を空にする（今回、同じ英文を操作しているので）
$pdo->exec('TRUNCATE TABLE tangocount');

//３．データ登録SQL作成

// 1. SQL文を用意
// 上記の単語と出現回数をSQLに入れていく
// 出現回数順での出力も見据えて、配列のままDBには入れず、それぞれDBに格納。。
foreach ($countarray as $key => $value) {
    $stmt = $pdo->prepare("INSERT INTO
                        tangocount(id, word, count, source, date)
                        VALUES(NULL, :word, :count, :source, sysdate() )");

    //  2. バインド変数を用意
    // Integer 数値の場合 PDO::PARAM_INT
    // String文字列の場合 PDO::PARAM_STR
    $stmt->bindValue(':word', $key, PDO::PARAM_STR);
    $stmt->bindValue(':count', $value, PDO::PARAM_STR);
    $stmt->bindValue(':source', $source, PDO::PARAM_STR);

    //  3. 実行
    $status = $stmt->execute();
}

//４．データ登録処理後
if ($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    //５．select.phpへリダイレクト
    header('Location: select.php');
}