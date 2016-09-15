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
    $query = ['lat'=>$let, 'lng'=>$lng, 'date'=>$data, 'hour'=>$hour, 'min'=>$min, 'disp'=>'on'];
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
               var lat = p.coords.latitude;
               var lng = p.coords.longitude;
            //   var location ="<li>"+"緯度：" + lat + "</li>";
              // location += "<li>"+"経度：" + lng + "</li>";
               document.getElementById("location").innerHTML = location;
               var centerPosition = new google.maps.LatLng(lat , lng);
               mapInit(centerPosition);
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
<Div Align="center"><h1>星座の方角</h1></Div>
<hr>
<tr>
  <p> <td><div id="panel">
      <input id="address" type="text" value="" size="35">
      <input type="button" id="button" value="検索" onclick=>
    </div>
    <div id="map-canvas"></div></p>
    <div id="mapField" style="width: 350px;height: 350px;"></div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCdVSV5ixujGbOl2dt0knIOrxNAMKDVQs"></script>
<script type="text/javascript">
function mapInit(location) {
//    var centerPosition = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);

var option = {
    zoom : 18,
    center : location,
    mapTypeId : google.maps.MapTypeId.ROADMAP
};
//地図本体描画
var googlemap = new google.maps.Map(document.getElementById("mapField"), option);
}

mapInit(new google.maps.LatLng(lat, lng));
</script>

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
