<?php
  $error="";
  $base_url = 'http://linedesign.cloudapp.net/hoshimiru/constellation';
  $query = ['lat'=>0, 'lng'=>0, 'date'=>'2016-01-01', 'hour'=>0, 'min'=>0, 'disp'=>'on' ];
  $proxy = array(
    "http" => array(
     "proxy" => "tcp://proxy.kmt.neec.ac.jp:8080",
     'request_fulluri' => true,
    ),
  );
  $proxy_context = stream_context_create($proxy);
  $response = file_get_contents(
                    $base_url.'?' .
                    http_build_query($query),
                    false,
                    $proxy_context
              );
  $result = json_decode($response,true);
?>
<!DOCTYPE html>
<html>
<head>
  <?php //cssファイルの読み込み?>
  <link rel="stylesheet" type="text/css" href="seiza.css">
<meta charset="UTF-8">
  <title>星空旅行</title>
</head>

<body>

<CENTER>
  <startitle class="title">
    星空旅行
  </startitle>
    <i>-素晴らしき夜空の世界へようこそ-</i><br>
</CENTER>
<br>
<l1 class="title">
<linkcolor class="title">
  <a href="direction_search.php">星座の方角を検索</a>
</linkcolor><br>
  <l2 class="title"></l2>指定位置から見える星座がどの方向にあるのか知ることができます。<br>
  <br>

  <a href="detail_star.php">星座の詳細</a><br>
  <l2 class="title"></l2>星座の詳しい情報が見れます。<br>
    <br>

  <a href="horoscopes.php" >星座占い</a><br>
  <l2 class="title"></l2>星座占いが見れます。あなたは何座ですか？<br>
    <br>

    <br>
    <br>
</l1>


<?php
$ran = rand(0,87);//乱数生成?>

  <div  style=" position:absolute; top:83px; left:500px;">
  <FONT color="yellow">


<?php
// 7cfc00 lawngreen
 print "「{$result["result"][$ran]["jpName"]}」（英名:{$result["result"][$ran]["enName"]}）
 "
 ?>
 </FONT>
 <FONT color="lawngreen">
 <?php
 print "↓画面クリックで詳細表示";
 ?>
  </FONT>
  </div>
  <br>

  <a href="detail_star_result.php?id=<?echo $ran?>&flg=<?true?>"
   style="position:absolute; top:100px; left:500px;">
    <img src=<?= $result["result"][$ran]["starImage"]?> alt="ran_seizu" align="center" width="640" height="480">
  </a>

  <br>
  <br>
</body>
</html>
