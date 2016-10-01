<?php
  $error="";
  $base_url = 'http://linedesign.cloudapp.net/hoshimiru/constellation';
  $query = ['lat'=>0, 'lng'=>0, 'date'=>'2016-01-01', 'hour'=>0, 'min'=>0, 'disp'=>'on' ];
  // $proxy = array(
  //   "http" => array(
  //    "proxy" => "tcp://proxy.kmt.neec.ac.jp:8080",
  //    'request_fulluri' => true,
  //   ),
  // );
  // $proxy_context = stream_context_create($proxy);
  $response = file_get_contents(
                    $base_url.'?' .
                    http_build_query($query),
                    false
                    // ,
                    // $proxy_context
              );
  $result = json_decode($response,true);
?>

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="seiza.css">
<html lang="ja">
<fontcolor class="title">
<head>
  <meta charset="UTF-8">
  <title>星座一覧</title>
</head>
<?php
class Seiza {
  Var $name;
  var $id;

  function __construct($n, $i) {
    $this->name = $n;
    $this->id = $i;
  }
}

  function seiza_sort($a, $b){
      $a = mb_convert_kana($a->name, 'c');
      $b = mb_convert_kana($b->name, 'c');
      return strcasecmp($a, $b);
  }
foreach ($result['result'] as $value) {
  $seiza_list[] = new Seiza($value['jpName'], $value['id']);
}
usort($seiza_list, "seiza_sort");
foreach ($seiza_list as $value) {
  $value->id = $value->id - 1;
}
?>
<body>
  <Div Align="center"><h1>星座一覧</h1></Div>
  <hr>
  <h3>
  <table align="center">
  <?for($count = 0; $count < 88; $count++) {
    if($count%8 == 0) {?>
      <tr>
    <?}?>
    <td width="300" height="35">
      <a href="detail_star_result.php?id=<?= $seiza_list[$count]->id?>"><?print $seiza_list[$count]->name;?></td>
      <?if($count%8 == 7) {?>
        </tr>
      <?}
  }?>
</table>
</h3>
<br><br>
<center><a href="title.php">もどる</a></center>

</body>
</fontcolor>
</html>
