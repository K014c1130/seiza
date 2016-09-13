<?php
    $error="";
    $base_url = 'http://linedesign.cloudapp.net/hoshimiru/constellation';
    $query = ['lat'=>0, 'lng'=>0 ,'date'=>'2016-01-01', 'hour'=>0, 'min'=>0, 'disp'=>'on' ];
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
  <title>現在地から見える星座</title>
</head>
<Div Align="center"><h1>現在地から見える星座</h1></Div>
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
