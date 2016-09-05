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
<?if(isset($_GET['id'])) {
      $id = $_GET['id'];
  }?>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title><?print $result["result"][$id]["jpName"];?></title>
  </script>
</head>

<body>
  <Div Align="center"><h1><?print $result["result"][$id]["jpName"];?></h1></Div>
  <hr>
  <table>
    <tr>
    <td>
      <img src="<?= $result['result'][$id]["starImage"] ?>"><br>
    </td>
    <td valign="top">
   <h3>
     英名<br><?print $result["result"][$id]["enName"];?><br><br>
     解説<br><?print $result["result"][$id]["content"];?><br><br>
     起源<br><?print $result["result"][$id]["origin"];?><br>
</h3>
</td>
</tr>
  </div>
</body>
</html>
