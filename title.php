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

  <title>星空旅行</title>
</head>
<body>
  <fontcolor class="title">
<CENTER>
  <startitle class="title">
    星空旅行
  </startitle>
    <i>-素晴らしき夜空の世界へようこそ-</i><br>
</CENTER>
<br>
<l1 class="title">

  <a href="direction.php">星座の方角</a><br>
  <l2 class="title"></l2>今いる位置から星座達がどの方向にいるのか知ることができます。<br>
  <br>

  <a href="here_star.php">現在の位置から見える星座</a><br>
  <l2 class="title"></l2>今いる場所から見える星座がわかります。<br>
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
</fontcolor>

<?php
$ran = rand(1,88);//乱数生成?>

  <div  style=" position:absolute; top:73px; left:500px;">
  <FONT color="yellow">


<?php
 print "「{$result["result"][$ran]["jpName"]}」（英名:{$result["result"][$ran]["enName"]}）";?>

  </FONT>
  </div>
  <br>

  <a href="detail_star_result.php?id=<?echo $ran?>"
   style="position:absolute; top:90px; left:500px;">
    <img src=<?= $result["result"][$ran]["starImage"]?> alt="ran_seizu" align="center">
  </a>

  <br>
  <br>
</body>
</html>
