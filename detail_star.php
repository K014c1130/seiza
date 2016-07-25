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
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>星座一覧</title>
  </script>
</head>

<body>
  <Div Align="center"><h1>星座一覧</h1></Div>
  <hr>
  <?php
  for($count = 0; $count < 88; $count++) {?>
    <a href="http://localhost/seiza/detail_star_result.php"><?print $result["result"][$count]["jpName"];
  }?>

</body>
</html>
