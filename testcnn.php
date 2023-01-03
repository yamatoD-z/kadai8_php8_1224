<?php
header('Content-Type: text/html; charset=UTF-8');
require_once __DIR__ . '/vendor/autoload.php';
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\WebDriverBy;

echo '1';

function makeChrom() {
  // 環境変数にChromeドライバをセット
  putenv('webdriver.chrome.driver=' . __DIR__ . '\bin\chromedriver.exe');
  echo '2';
  // ブラウザ起動
  $driver = ChromeDriver::start();

// CNNへ遷移
$driver->get('https://edition.cnn.com/');
echo '3';
echo $driver->getTitle();

$array=[];

$elements = $driver->findElements(WebDriverBy::xpath('//h3[@class="cd__headline"]/a'));
foreach ($elements as $ele) {
  $href = $ele->getAttribute("href");   
  echo $href.'------';
  array_push($array,$href);
  }
        
$arrayClean = str_replace("https://edition.cnn.com","",$array);
$arrayFullLink =[];
foreach ($arrayClean as $link) {
  $fullLink = "https://edition.cnn.com".$link;
  echo $fullLink;
  array_push($arrayFullLink, $fullLink);
}

var_dump($array);
print_r($array);
// echo($array);

echo '---------------------';

var_dump($arrayFullLink);
print_r($arrayFullLink);
// echo($arrayFullLink);

sleep(5);

foreach($arrayFullLink as $URL){
  sleep(5);
  $article='';
  $dom = new DOMDocument('1.0', 'UTF-8');
  $html = file_get_contents($URL);
  @$dom->loadHTML($html);
  $xpath = new DOMXpath($dom);
  
  foreach($xpath->query('//p') as $nodeJP){
    $article .= ' '.$nodeJP->nodeValue;
  }
  
  foreach($xpath->query('//h1') as $titleCnn){
    $title = $titleCnn ->nodeValue;
  };

  
  $time = date('Y-m-d H:i:s');
  $file = fopen('cnn.txt', 'a');
  fwrite($file, "\n\n" . $time . "\n" . '**************************'. "\n" . $URL . "\n" . $title. "\n". '**************************' . "\n");
  fwrite($file, $article . "\n");
  fclose($file);
}

    


    // 全てのタブを閉じてブラウザを終了させる
    $driver->quit();
}

$driver = makeChrom();

?>