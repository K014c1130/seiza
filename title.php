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
  <link rel="stylesheet" type="text/css" href="title.css">
  <title>星座_title</title>
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
  <a href="リンク先のＵＲＬ" style="background-color:#000000;">星座の方角</a><br>
  <l2 class="title"></l2>今いる位置から星座達がどの方向にいるのか知ることができます。<br>
  <br>
  <a href="リンク先のＵＲＬ" style="background-color:#000000;">現在地から見える星座</a><br>
  <l2 class="title"></l2>今いる場所から見える星座がわかります。<br>
    <br>
  <a href="リンク先のＵＲＬ" style="background-color:#000000;">星座の説明</a><br>
  <l2 class="title"></l2>星座達の詳しい情報が見れます。<br>
    <br>
  <a href="リンク先のＵＲＬ" style="background-color:#000000;">星座占い</a><br>
  <l2 class="title"></l2>星座占いが見れます。あなたの運勢は...<br>
    <br>
    <br>
    <br>
</l1>
</fontcolor>


<?php
$ran = rand(1,90);//乱数生成

if($ran == 89){
    $ran = 100;
  }
else if($ran == 90){
    $ran = 101;
  }
?>




  <div style="position:absolute; top:73px; left:500px;">

  <FONT color="yellow">
    <?php
    print "「{$result["result"][$ran]["jpName"]}」
    （英名:「{$result["result"][$ran]["enName"]}」）";
    ?>
  </FONT>
  </div><br>

  <div style="position:absolute; top:90px; left:500px;"><img src=<?= $result["result"][$ran]["starImage"]?> alt="konkai_no_seiza"
    align="center"
    ></div>

  <br>
  <br>
</body>
</html>
