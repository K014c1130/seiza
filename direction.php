<?php
    $error="";

    $let =  0;//緯度
    $lng =  0;//緯度
      date_default_timezone_set('Asia/Tokyo'); //タイムゾーンの設定(東京)
      //↓現在時刻の受け渡し　javascriptで使用
      $mo = date('m');//日付
      $da = date('d');//時間
      $ho = date('H');//分

    $base_url = 'http://linedesign.cloudapp.net/hoshimiru/constellation';
    $query = ['lat'=>$let, 'lng'=>$lng, 'date'=>date('Y-m-d'), 'hour'=>date('H'), 'min'=>date('i'), 'disp'=>'on'];

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



<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>星座の方向</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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
             //document.getElementById("location").innerHTML = location;
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


function getGeocoording(){
  console.log("pass ");
   $.ajax({
     type: 'GET',
     url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + $('#place').val(),
     dataType: 'json',
     success: function(response){ console.log(response);
       var lat = response['results'][0]['geometry']['location']['lat'];
       var lng = response['results'][0]['geometry']['location']['lng'];
       //console.log(response['results'][0]['gemetry']['location']['lng']);
       var centerPosition = new google.maps.LatLng(lat , lng);
       mapInit(centerPosition);
     },
          error: function(req,err){console.log(err);}
});

console.log(function(response){console.log(response)});
}

</script>


    <ul id="location">
   </ul>
</head>
<Div Align="center"><h1>星座の方角</h1></Div>
<hr>
<tr>
  <p> <td>
    <form name ="serch" method ="POST" action ="direction.php">
      <input id="place" type="text" value="" size="35">
      <input type="button" value="検索" onClick="getGeocoording()">
</form>
    <div id="map-canvas"></div></p>
    <div id="mapField" style="width: 350px;height: 350px;"></div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCdVSV5ixujGbOl2dt0knIOrxNAMKDVQs"></script>
<script type="text/javascript">
function mapInit(location) {

var option = {
    zoom : 18,
    center : location,
    mapTypeId : google.maps.MapTypeId.ROADMAP
};
//地図本体描画
var googlemap = new google.maps.Map(document.getElementById("mapField"), option);

var panorama = new google.maps.StreetViewPanorama(
    document.getElementById('mapField'),{
position: location,
pov: {
   heading: 30,
   pitch:   10
  }
});
}

  function direction(){

  }

</script></p>
<form  method="post" action="direction.php">

<select>

      <?php


for ($i = 0; $i < 88; $i++) {
  ?>

          <option><?= $seiza_list[$i] ->name; ?></option>


<?php
}
?>
</form>


<?PHP//print "$_POST['seiza_select']";?>
</select>
  <script>
  //変数の受け渡し　PHPからjavascriptへ
  var $mo = "<?php echo $mo?>"
  var $da = "<?php echo $da?>"
  var $ho = "<?php echo $da?>"


</script>
<select name="month">
  <script>


    for(var i=1; i<=12; i++){
      if(i == $mo){
        document.write('<option value="i" selected="selected">'+i+'月</option>');
      }
      else{
  	  document.write('<option value="i">'+i+'月</option>');
    }
}

  </script>


</select>


  </select>

    <select name="day">
    <script>
      for(var i=1; i<=31; i++){
        if(i == $da){
          document.write('<option value="i" selected="selected">'+i+'日</option>');
        }
        else{
        document.write('<option value="i">'+i+'日</option>');
      }
      }
    </script>
  </select>

  <select name="hour">
    <script>
      for(var i=1; i<=24; i++){
        if(i == $ho){
          document.write('<option value="i" selected="selected">'+i+'時</option>');
        }
        else{
    	  document.write('<option value="i">'+i+'時</option>');
      }
    }
    </script>
  </select>
  <form>
    <input type="button" value="こっちだよ" onClick="direction()">




</form>
 <?php
//
// print "$_POST['text_select']";
// $ke = $result["result"][$seiza_list[1]->id]["directionNum"];
?>
      </td>
   </tr>
  </form>
  <body>

  </body>
      </html>
