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
    <style type="text/css">
    ul {
        list-style: none;
    }

    #recordingslist audio {
        display: block;
        margin-bottom: 10px;
    }
    </style>
    <script src="chrome-extension://mooikfkahbdckldjjndioackbalphokd/assets/prompt.js"></script>
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
    <form method="POST" action="insert.php">
        <div class="jumbotron">
            <fieldset>
                <legend>フリーアンケート</legend>
                <label>名前：<input type="text" name="name"></label><br>
                <label>Email：<input type="text" name="email"></label><br>
                <label>年齢：<input type="text" name="age"></label><br>
                <label><textarea name="content" rows="4" cols="40"></textarea></label><br>
                <div id="Control">
                    <button id="MicOn">マイクの使用を開始</button><br>
                    <button id="RecStart">録音開始</button>
                    <button id="RecStop" disabled>録音終了</button><br>
                    <div id="RecMime"></div>
                </div>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
</body>

<body class="vsc-initialized">
    <h2>Web Audio API を使用した録音、及びWAVファイル出力のデモ</h2>
    ※ 録音後、音声ファイル(WAVファイル)がダウンロードできます。<br><br>
    <button onclick="startRecording(this);">録音</button>
    <button onclick="stopRecording(this);" disabled="">停止</button>
    <h3>録音ファイル</h3>
    <ul id="recordingslist">
        <li><audio controls="" src="blob:https://labs.irohasoft.com/2f2b7a6f-3436-42e8-a529-336c8a388305"></audio><a
                href="blob:https://labs.irohasoft.com/2f2b7a6f-3436-42e8-a529-336c8a388305"
                download="2022-12-28T15:28:19.554Z.wav">2022-12-28T15:28:19.554Z.wav</a></li>
    </ul>
    <h3>ステータス</h3>
    <pre id="log">Audio context set up. 
navigator.getUserMedia available. 
Media stream created. 
Recorder initialised. 
Recording... 
Stopped recording. 
</pre>
    <script>
    function __log(e, data) {
        log.innerHTML += e + " " + (data || '') + '\n';
    }
    var audio_context;
    var recorder;

    function startUserMedia(stream) {
        var input = audio_context.createMediaStreamSource(stream);
        __log('Media stream created.');
        recorder = new Recorder(input);
        __log('Recorder initialised.');
    }

    function startRecording(button) {
        recorder && recorder.record();
        button.disabled = true;
        button.nextElementSibling.disabled = false;
        __log('Recording...');
    }

    function stopRecording(button) {
        recorder && recorder.stop();
        button.disabled = true;
        button.previousElementSibling.disabled = false;
        __log('Stopped recording.');
        createDownloadLink();
        recorder.clear();
    }

    function createDownloadLink() {
        recorder && recorder.exportWAV(function(blob) {
            var url = URL.createObjectURL(blob);
            var li = document.createElement('li');
            var au = document.createElement('audio');
            var hf = document.createElement('a');
            au.controls = true;
            au.src = url;
            hf.href = url;
            hf.download = new Date().toISOString() + '.wav';
            hf.innerHTML = hf.download;
            li.appendChild(au);
            li.appendChild(hf);
            recordingslist.appendChild(li);
        });
    }
    window.onload = function init() {
        try {
            window.AudioContext = window.AudioContext || window.webkitAudioContext;
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
            window.URL = window.URL || window.webkitURL;
            audio_context = new AudioContext;
            __log('Audio context set up.');
            __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
        } catch (e) {
            alert('No web audio support in this browser!');
        }
        navigator.getUserMedia({
            audio: true
        }, startUserMedia, function(e) {
            __log('No live audio input: ' + e);
        });
    };
    </script>
    <script src="./Web Audio API を使用した録音、及びWAVファイル出力のデモ - iroha Soft_files/recorder.js.ダウンロード"></script>
    <div id="UMS_TOOLTIP"
        style="position: absolute; cursor: pointer; z-index: 2147483647; background: transparent; top: -100000px; left: -100000px;">
    </div>
    <div id="trend_notification_app" class="trend_notification_app_outer">
        <div id="trend_notification">
            <div id="trend_notification_con" class="clearfix"></div>
        </div>
    </div>
</body>
<umsdataelement id="UMSSendDataEventElement"></umsdataelement>
<div id="tmtoolbar_manual_rating_injected" style="display: none;">
    init
</div>

</html>