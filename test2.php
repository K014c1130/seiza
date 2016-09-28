
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="seiza.css">
<html>
  <head>
    <meta charset="utf-8">
    <title>Street View side-by-side</title>
    <style>
      #ul{
        width: 500px;
        margin: 0 auto;
        list-style: none;
      }

      h1{
        text-align: center;
      }

      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #month, #day, #hour, #starButton{
        margin-right: 10px;
      }

      #starList{
        list-style: none;
      }

      #starButton{

        margin-right: 10px;
        width: 120px;
        height: 20px;
      }

      #form{

        width: 100px
        float: left;
      }

      #lat,#lng{
        text-align: left;
      }

      #map, #pano {
        float: left;
        height: 45%;
        width: 45%;
      }

      .view{
        width: 800px;
        height: 800px;
        margin-left: auto;
        margin-right: auto;

      }

      body{
        color: #ffffff;
      }

    </style>
  </head>
  <body>
    <h1>
      現在地から見える星座
    </h1>
    <p>
    <!-- <form id = 'form' > -->
      <div>
        <ul id ="ul">
          <li>
      <input id="location" name = "address" type = "text" size　= "70" placeholder="表示したい場所名を入力" onkeypress="keyOn();"/>
      <input type ="button" value = "マップを表示" onClick="getGeocoording();">
      <input id="searchHere" name = "searchHere" type = "button" value = "現在地取得" onClick="getHere();" />
          </li>
          <p>

          <li>
      <select id="horoscope" name = "selectStar" >
        <option value = 0>選択してください</option>
      </select>
    </li>

      <li>
      <select id="month" name = "month" onchange="onChange();">
        <?php for($i = 1;$i <= 12;$i++){ ?>
        <option value ="<?= $i ?>"><?= $i ?>月</option>
        <?php } ?>
      </select>

      <select id="day" name = "day" onchange="onChange();">
        <?php for($i = 1;$i <= 31;$i++){ ?>
        <option value ="<?= $i ?>"><?= $i ?>日</option>
        <?php } ?>
      </select>

      <select id="hour" name = "hour" onchange="onChange();">
        <?php for($i = 0;$i <= 23;$i++){ ?>
        <option value ="<?= $i ?>"><?= $i ?>時</option>
        <?php } ?>
      </select>

      <input type = "button" name="searchTime" value = "現在時刻を取得" onClick="getTime();">
    </li>
    <li>
      <input type="button" id ="serchHoroscope" name = "selectStar" value="方向を表示" onClick= "searchD($('#horoscope').val());">
    </li>
    </ul>
    </div>
    <!-- </form> -->

<div class="latLngLabel">
  <label>現在の緯度：</label>
  <span id="lat"></span><br />
  <label>現在の経度：</label>
  <span id="lng"></span>
</div>
    <div class = "view">
    <span id="map"></span>
    <span id="pano"></span>
  </div>
  <div><a href = "/title">タイトルに戻る</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
    var time = new Date();
    var Year = time.getFullYear();
    var month = time.getMonth()+1;
    var day = time.getDate();
    var hour = time.getHours();
    var minute = time.getMinutes();
    var fullDate = Year+"-"+month+"-"+day;
    var lat=0;
    var lng=0;
    var directionNum = 0 ;
    var altitudeNum = 0 ;
    var here = "";
    var latLng = "";
    var map;
    var panorama;
    var starList = [];
    var seeStarList =[];
    var locationLat;
    var locationLng;
    var beforeLat,beforeLng;
    var subtractBeforeLat,subtractBeforeLng,subtractLat,subtractLng;


    function review(){
      console.log("review");



      var positionCell = panorama.getPosition();
      map.panTo(positionCell);

      lat = positionCell.lat();
      lng = positionCell.lng();
      $("#lat").text(lat);
      $("#lng").text(lng);


      console.log(lat);
      console.log(lng);


            subtractBeforeLat = lat - beforeLat;
            subtractBeforeLng = lng - beforeLng;
            subtractLat = beforeLat - lat;
            subtractLng = beforeLng - lng;

            console.log(subtractLat);
            console.log(subtractLng);
            console.log(subtractBeforeLat);
            console.log(subtractBeforeLng);

            if(subtractLat > 0.001 || subtractLng > 0.001 || subtractBeforeLat > 0.001 || subtractBeforeLng > 0.001){

              beforeLat = lat;
              beforeLng = lng;
              onChange();
            }
    }


    function keyOn(){
      if(window.event.keyCode == 13){
        getGeocoording();
        return false;
      }
    }

    function onChange(){

      month = $("#month").val();
      day = $("#day").val();
      hour = $("#hour").val();
      fullDate = time.getFullYear()+"-"+month+"-"+day;

      $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
        {
          lat: lat,
          lng: lng,
          date: fullDate,
          hour: hour,
          min: minute,
          disp: "on"
        }
      )
      // 結果を取得したら…
      .done(function(data) {
        // 中身が空でなければ、セレクトボックスを選択可の星座のみに書き換える
        $("#horoscope").val(0);
        console.log("onChange開始");

        for(var i of starList){
          document.getElementById(i.id).disabled = false;
        }

        for (var i of data.result){

          if(i.altitude == "水平線の下"){
            document.getElementById(i.id).disabled = true;
            console.log(i.id);
          }

        }
                console.log("onChange終了");

      });

    }

    function searchD(searchId){

      month = $("#month").val();
      day = $("#day").val();
      hour = $("#hour").val();
      fullDate = time.getFullYear()+"-"+month+"-"+day;

      console.log("検索： "+lat);
      console.log("検索: "+lng);


      $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
        {
          lat: lat,
          lng: lng,
          date: fullDate,
          hour: hour,
          min: minute,
          disp: "on",
          id: searchId
        }
      )
      // 結果を取得したら…
      .done(function(data) {
        // 中身が空でなければ、その値を［住所］欄に反映
        console.log(data);
        for (var i of data.result){
          directionNum = i.directionNum;
          altitudeNum = i.altitudeNum;
        }

        var fenway = {lat: lat, lng: lng};
            panorama.setPov({heading:directionNum, pitch:altitudeNum, zoom:0});
            panorama.setPosition(fenway);


      });


    }

    //現在地取得
    function getHere(){
      reverseGeocoording();
    };

    //現在時刻取得
    function getTime(){
      var time = new Date();
      var month = time.getMonth()+1;
      var day = time.getDate();
      var hour = time.getHours();
      $("#month").val(month);
      $("#day").val(day);
      $("#hour").val(hour);
    };

    //住所検索結果をマップに反映させる
    function getGeocoording() {

      $.ajax({
        type: 'GET',
        url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + $('#location').val(),
        dataType: 'json',
        success: function(response){ console.log(response);
          lat = response['results'][0]['geometry']['location']['lat'];
          lng = response['results'][0]['geometry']['location']['lng'];
          load(lat,lng);
        },
        error: function(req, err){ console.log(err); }
      });


    }

    //リバースジオコーディング
    function reverseGeocoording() {
      $.ajax({
        type: 'GET',
        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+locationLat+","+locationLng,
        dataType: 'json',
        success: function(response){ console.log(response);
          $("#location").val(response['results'][2]["formatted_address"]);
        },
        error: function(req, err){ console.log(err); }
      });
    }

    function katakanaToHiragana(src) {
        return src.replace(/[\u30a1-\u30f6]/g, function(match) {
            var chr = match.charCodeAt(0) - 0x60;
            return String.fromCharCode(chr);
        });
    }

    function initMap() {
        if (!navigator.geolocation) {
            alert('Geolocation APIに対応していません');
            return false;
        }

        // 現在地の取得
        navigator.geolocation.getCurrentPosition(function(position) {
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            beforeLat = lat;
            beforeLng = lng;
            locationLat = position.coords.latitude;
            locationLng = position.coords.longitude;

            // 緯度経度の取得
            latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                    　//selectボックスに全星座の名前を入力する
                    $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
                      {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        date: fullDate,
                        hour: hour,
                        min: minute,
                        disp: "on"
                      }
                    )
                    // 結果を取得したら…
                    .done(function(data) {
                      // 中身が空でなければ、その値を［住所］欄に反映

                      for (var i of data.result){
                        var star = {id: i.id,name: i.jpName, image: i.starImage,
                                    altitude: i.altitude}

                        starList.push(star);
                        starList.sort(function(a, b){
                          a = katakanaToHiragana(a.name);
                          b = katakanaToHiragana(b.name);
                          if(a < b){
                              return -1;
                          }else if(a > b){
                              return 1;
                          }
                          return 0;
                      });
                      }
                      //selectに代入
                      for (var i of starList){
                        var select = document.createElement('option');

                        select.textContent = i.name;
                        select.value = i.id;
                        select.id = i.id;


                        if (i.altitude == "水平線の下") {
                          select.disabled = true;

                        }

                        document.getElementById('horoscope').appendChild(select);
                      }




                      directionNum = data.result[0].directionNum;
                      altitudeNum = data.result[0].altitudeNum;

                      $("#month").val(month);
                      $("#day").val(day);
                      $("#hour").val(hour);

                    });

            // 地図の作成
            map = new google.maps.Map(document.getElementById('map'), {
                center: latLng,
                zoom: 17
            });
                  panorama = new google.maps.StreetViewPanorama(
                  document.getElementById('pano'), {
                    position: latLng,
                    pov: {
                      heading: directionNum,
                      pitch: altitudeNum
                    }
                  });
                  // google.maps.event.addListener(panorama, 'tilesloaded', review);
                  google.maps.event.addListener(panorama, 'position_changed', review);

             map.setStreetView(panorama);

        }, function() {
            alert('位置情報取得に失敗しました');
        });

    }


// function initialize() {
//   load(42.345573, -71.098326);
// }
//
function load(lat, lng) {
  $("#horoscope").val(0);
  var fenway = {lat: lat, lng: lng};
  map.setCenter(fenway);
  map.setZoom(17);
  panorama.setPov({heading:34, pitch:10, zoom:0});
  panorama.setPosition(fenway);
}

      </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzUQO_hY340FGTACPZ3p2doh8ZUEJlqlc&callback=initMap">
    </script>

  </body>
</html>
