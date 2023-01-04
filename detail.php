<?php
/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
* 3. SQL部分にwhereを追加
* 4. データ取得の箇所を修正。
*/

$id = $_GET['id'];

require_once('funcs.php');
$pdo = db_conn();


$stmt = $pdo->prepare('SELECT * FROM tangocount WHERE id = :id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意
$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
//*** function化する！******\
$error = $stmt->errorInfo();
exit('SQLError:' . print_r($error, true));
} else {
// データが取得できた場合の処理
$result = $stmt->fetch();
}
?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
    div {
        padding: 10px;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>詳細</legend>
                <label>単語：<input type="text" name="word" value="<?= $result['word']?>"></label><br>
                <label>出現回数：<input type="text" name="count" value="<?= $result['count']?>"></label><br>
                <label>出展：<input type="text" name="source" value="<?= $result['source']?>"></label><br>
                <label><textarea name="content" rows="4" cols="40"><?= $result['content']?></textarea></label><br>
                <input type="hidden" name="id" value="<?= $result['id']?>">
                <input type="submit" value="修正">
            </fieldset>
        </div>
    </form>
</body>

</html>