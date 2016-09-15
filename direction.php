<?php
    $error="";

    $let =  0;//緯度
    $lng =  0;//緯度
      date_default_timezone_set('Asia/Tokyo'); //タイムゾーンの設定(東京)
      //↓現在時刻の習得
      $data = date('Y-m-d');//日付
      $hour = date('H');//時間
      $min = date('i');//分

    $base_url = 'http://linedesign.cloudapp.net/hoshimiru/constellation';
    $query = ['lat'=>$let, 'lng'=>$lng, 'date'=>$data, 'hour'=>$hour, 'min'=>$min,　'disp'=>'on' ];
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
  <meta charset="UTF-8">
  <title>星座の方向</title>
</head>
<Div Align="center"><h1>星座の方角</h1></Div>
<hr>
<tr>
  <td><input type="text" name="name" size="30" maxlength="20"></td><td>
    <input type="submit" value="現在位置"></p>
<select name="見たい星座">
      <?php
for ($i = 0; $i < 88; $i++) {
  ?>
          <option><?= $result["result"][$i]["jpName"] ?></option>
<?php
}
?>
</select></p>

<select name="month">
  <script>
    var i;
    for(i=1; i<=12; i++){
  	  document.write('<option value="i">'+i+'月</option>');
    }
  </script>
</select>

  <select name="day">
  <script>
    var i;
    for(i=1; i<=31; i++){
  	  document.write('<option value="i">'+i+'日</option>');
    }
  </script>
</select>

<select>
  <script>
    var i;
    for(i=0; i<=23; i++){
  	  document.write('<option value="i">'+i+'時</option>');
    }
  </script>
  </script>
    </td>
 </tr>

<body>

</body>
    </html>
