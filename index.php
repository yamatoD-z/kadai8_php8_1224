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
    <form method="post" action="insert.php">
        <div class="jumbotron">
            <fieldset>
                <legend>英文を入力</legend>
                <label><textArea name="sentence" rows="50" cols="60">
<!-- 課題用には初めから文章を出力した状態に。コードの中に打ち込むのも汚いので、テキストファイルから。 -->
                    <?php echo file_get_contents('cnn.txt')?>
                    </textArea></label><br>
                <label>出展：<input type="text" name="source" value="Influence"></label><br>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->


</body>

</html>