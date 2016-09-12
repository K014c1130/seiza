<?php
    $error="";
    $base_url = 'http://linedesign.cloudapp.net/hoshimiru/constellation';
    $query = ['lat'=>0, 'lng'=>0 ,'date'=>'2016-01-01','month' =>'n','day' =>13, 'hour'=>0, 'min'=>0, 'disp'=>'on' ];
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
  <script type="text/javascript">
    if (navigator.geolocation) {
        // 現在の位置情報取得を実施
        navigator.geolocation.getCurrentPosition(
        // 位置情報取得成功時
        function (p) {
                var location ="<li>"+"緯度：" + p.coords.latitude + "</li>";
                location += "<li>"+"経度：" + p.coords.longitude + "</li>";
                document.getElementById("location").innerHTML = location;
        },
        // 位置情報取得失敗時
        function (pos) {
                var location ="<li>位置情報が取得できませんでした。</li>";
                document.getElementById("location").innerHTML = location;
        });
    } else {
        window.alert("本ブラウザではGeolocationが使えません");
    }
</script>
    <ul id="location">
    </ul>
</head>
<p><h1>     星座の方角      </h1></p>

<tr>
  <p> <td><input type="text" name="name" size="30" maxlength="20"></td><td>
    <input type="submit" value="現在位置" onClick="mapInit();"></p>
    <div id="mapField" style="width: 350px;height: 350px;"></div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCdVSV5ixujGbOl2dt0knIOrxNAMKDVQs"></script>
<script type="text/javascript">
function mapInit() {
//    var centerPosition = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
    var centerPosition = new google.maps.LatLng(p.coords.latitude , 139.71544609999998);
    var option = {
        zoom : 18,
        center : centerPosition,
        mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    //地図本体描画
    var googlemap = new google.maps.Map(document.getElementById("mapField"), option);
}

mapInit();
    </script>

<p><select name="見たい星座">
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




<select name="hour">

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
