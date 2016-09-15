
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Street View side-by-side</title>
    <style>
      #ul {
        width: 500px;
        margin: 0 auto;
        list-style: none;
      }

      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map, #pano {
        float: left;
        height: 45%;
        width: 45%;
      }

      #date {
        margin-right: 10px;
      }

      #form {

        width: 100px
        float: left;
      }

    </style>
  </head>
  <body>
    <form id = 'form' >
      <div>
        <ul id ="ul">
          <li>
      <input id="location" name = "address" type = "text" size= "40" />
      <input id="searchHere" name = "searchHere" type = "button" value = "現在地取得" onClick="getHere();" />
          </li>
          <br />
          <li>
      <select id="horoscope" name = "selectStar" >
      </select>
    </li>
    <br />
      <li>
      <select id="month" name = "month">
        <option value ="false">月</option>
        <?php for($i = 1;$i <= 12;$i++){ ?>
        <option value ="<?= $i ?>"><?= $i ?></option>
        <?php } ?>c
      </select>

      <select id="day" name = "day">
        <option value ="false">日</option>
        <?php for($i = 1;$i <= 31;$i++){ ?>
        <option value ="<?= $i ?>"><?= $i ?></option>
        <?php } ?>
      </select>

      <select id="hour" name = "hour">
        <option value ="false">時</option>
        <?php for($i = 0;$i <= 23;$i++){ ?>
        <option value ="<?= $i ?>"><?= $i ?></option>
        <?php } ?>
      </select>

      <input type = "button" name="searchTime" value = "現在時刻を取得" onClick="getTime();">
    </li>
    <li>
      <input type ="button" value = "検索" onClick="getGeocoording();">
    </ul>
    </div>
    </form>

    <ul id ="canSeeStar">
      <li id ="starLi">
      </li>
    </ul>
    <div id="map"></div>
    <div id="pano"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
    var time = new Date();
    var fullDate = time.getFullYear()+"-"+time.getMonth()+"-"+time.getDate();
    var nowDate = time.getDate();
    var hour = time.getHours();
    var minute = time.getMinutes();
    var lat=0;
    var lng=0;
    var directionNum = 0 ;
    var altitudeNum = 0 ;
    var here = "";
    var latLng = "";
    var map;
    var marker;
    var starList = [];
    var seeStarList =[];

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


    function searchStar(searchId){
      console.log(searchId);
      var time = new Date();
      var fullDate = time.getFullYear()+"-"+time.getMonth()+"-"+time.getDate();
      var nowDate = time.getDate();
      var hour = time.getHours();
      var minute = time.getMinutes();


      $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
        {
          lat: lat,
          lng: lng,
          date: fullDate,
          hour: hour,
          min: minute,
          id : searchId
        }
      )
      // 結果を取得したら…
      .done(function(data) {
        // 中身が空でなければ、その値を［住所］欄に反映
        console.log(data);
        for (var i of data.result){
          searchLoad(i.altitudeNum,i.directionNum);
        }
      });
    }

    function searchLoad(altitudeNum,directionNum){
      var fenway = {lat: lat, lng: lng};
      var map = new google.maps.Map(document.getElementById('map'), {
        center: fenway,
        zoom: 14
      });
      var panorama = new google.maps.StreetViewPanorama(
          document.getElementById('pano'), {
            position: fenway,
            pov: {
              heading: directionNum,
              pitch: altitudeNum

            }
          });
      map.setStreetView(panorama);

    }


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
        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+","+lng,
        dataType: 'json',
        success: function(response){ console.log(response);
          $("#location").val(response['results'][2]["formatted_address"]);
        },
        error: function(req, err){ console.log(err); }
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
            // 緯度経度の取得
            latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

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
                        var star = {id: i.id,name: i.jpName, image: i.starImage}

                        starList.push(star);
                      }

                      //selectに代入
                      for (var i of starList){
                        var select = document.createElement('option');

                        select.textContent = i.name;
                        select.value = i.id;
                        document.getElementById('horoscope').appendChild(select);
                      }

                      //ランダムな星を５個表示される
                      for (var i of starList){
                        var select = document.createElement('option');

                        select.textContent = i.name;
                        select.value = i.id;
                        document.getElementById('horoscope').appendChild(select);
                      }


                      directionNum = data.result[0].directionNum;
                      altitudeNum = data.result[0].altitudeNum;

                    });



                    $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
                      {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        date: fullDate,
                        hour: hour,
                        min: minute,
                        disp: "off"
                      }
                    )
                    // 結果を取得したら…
                    .done(function(data) {
                      // 中身が空でなければ、その値を［住所］欄に反映

                      for (var i of data.result){
                        var star = {id: i.id,name: i.jpName, image: i.starImage,
                        altitudeNum: i.altitudeNum,directionNum: i.directionNum}
                        seeStarList.push(star);
                      }
                      //現在地から見える星座を表示する
                      for (var i of seeStarList){
                        // var li = document.createElement('li');
                        // li.id = i.name;
                        // document.getElementById('canSeeStar').appendChild(li);
                        var input = document.createElement("input");
                        input.setAttribute("type","Button");
                        input.setAttribute("value",i.name);
                        input.setAttribute("onClick", 'searchStar('+i.id+');');
                        document.getElementById('starLi').appendChild(input);

                      }
                    });





            // 地図の作成
            map = new google.maps.Map(document.getElementById('map'), {
                center: latLng,
                zoom: 17
            });
              var panorama = new google.maps.StreetViewPanorama(
                  document.getElementById('pano'), {
                    position: latLng,
                    pov: {
                      heading: directionNum,
                      pitch: altitudeNum
                    }
                  });


            // マーカーの追加
            marker = new google.maps.Marker({
                position: latLng,
                map: map
            });
        }, function() {
            alert('位置情報取得に失敗しました');
        });
         map.setStreetView(panorama);
    }


// function initialize() {
//   load(42.345573, -71.098326);
// }
//
function load(lat, lng) {
  var fenway = {lat: lat, lng: lng};
  var map = new google.maps.Map(document.getElementById('map'), {
    center: fenway,
    zoom: 14
  });
  var panorama = new google.maps.StreetViewPanorama(
      document.getElementById('pano'), {
        position: fenway,
        pov: {
          heading: 34,
          pitch: 10
        }
      });
  map.setStreetView(panorama);
}



      </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzUQO_hY340FGTACPZ3p2doh8ZUEJlqlc&callback=initMap">
    </script>

  </body>
</html>
