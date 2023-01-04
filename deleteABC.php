<?php
require_once('funcs.php');
$id = $_GET['id'];

//2. DB接続します
//*** function化する！  *****************

$pdo = db_conn('eigo', 'root', '', 'localhost');

//３．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM tangocount WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: selectABC.php');
    exit();
}