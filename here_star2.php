<!DOCTYPE html>
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
      #map, #pano {
        float: left;
        height: 45%;
        width: 45%;
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

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  </head>
  <body>
    <h1>
      指定場所から見える星座
    </h1>
    <p>
    <!-- <form id = 'form' > -->
      <div>
        <ul id ="ul">
          <li>
      <input id="location" name = "address" type = "text" size　= "70" placeholder="場所名を入力" onkeypress="keyOn();" />
      <input type ="button" value = "マップを表示" onClick="getGeocoording();">
      <input id="searchHere" name = "searchHere" type = "button" value = "現在地取得" onClick="getHere();" />
          </li>
          <li>
              <label for="errLabel"><div id="errLabel"></div></label>
          </li>
          <p>
    </ul>
    </div>
    <!-- </form> -->
    <h5>
    　 星座のボタンによって星座の方角がわかるよ！
  </h5>

  <label>現在の緯度：</label>
  <span id="lat"></span><br />
  <label>現在の経度：</label>
  <span id="lng"></span>

    <ul id ="canSeeStar">
      <li id ="starList">
      </li>
    </ul>
    <div id="map"></div>
    <div id="pano"></div>
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
    var starList = [];
    var seeStarList =[];
    var locationLat;
    var locationLng;
    var map;
    var panorama;


    function review(){
        console.log("review");

        var positionCell = panorama.getPosition();
        map.panTo(positionCell);

        lat = positionCell.lat();
        lng = positionCell.lng();
        console.log("positionCell 確認");
        console.log(positionCell.lat());
        console.log(positionCell.lng());
        console.log("positionCell 確認終了");


        $("#lat").text(lat);
        $("#lng").text(lng);
        console.log(lat);
        console.log(lng);
        console.log("review out")
    }

    function keyOn(){
      if(window.event.keyCode == 13){
        getGeocoording();
        return false;
      }
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


    function searchStar(searchId){

       Year = time.getFullYear();
       month = time.getMonth()+1;
       day = time.getDate();
       hour = time.getHours();
       minute = time.getMinutes();
       fullDate = Year+"-"+month+"-"+day;


      console.log("searcStar()");
      console.log(searchId);
      console.log(fullDate);
      console.log(hour);
      console.log(minute);
      console.log(lat);
      console.log(lng);
      $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
        {
          lat: lat,
          lng: lng,
          date: fullDate,
          hour: hour,
          min: minute,
          id : searchId,

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

          map.setCenter(fenway);
          map.setZoom(14);
          panorama.setPov({heading:directionNum, pitch:altitudeNum, zoom:0});
          // panorama.setPosition(fenway);
    }


    //住所検索結果をマップに反映させる
    function getGeocoording() {

      if($('#location').val() == ""){
        $("#errLabel").text("場所を入力してください");
        return false;
      }else{
        $("#errLabel").text("");
      }


        console.log($('#location').val());

      $.ajax({
        type: 'GET',
        url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + $('#location').val(),
        dataType: 'json',
        success: function(response){ console.log(response);
          lat = response['results'][0]['geometry']['location']['lat'];
          lng = response['results'][0]['geometry']['location']['lng'];

          $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
            {
              lat: lat,
              lng: lng,
              date: fullDate,
              hour: hour,
              min: minute,
              disp: "off"
            }
          )
          // 結果を取得したら…
          .done(function(data) {
            // 中身が空でなければ、その値を［住所］欄に反映
            seeStarList.length = 0;
            console.log(seeStarList);
            console.log("doneの中");
            console.log(lat);
            console.log(lng);

            var element = document.getElementById("starList");
            while( element.firstChild ) {
              element.removeChild(element.firstChild);
            }
            for (var i of data.result){
              var star = {id: i.id,name: i.jpName, image: i.starImage,
              altitudeNum: i.altitudeNum,directionNum: i.directionNum}
              seeStarList.push(star);
            }
            seeStarList.sort(function(a, b){
              a = katakanaToHiragana(a.name);
              b = katakanaToHiragana(b.name);
              if(a < b){
                  return -1;
              }else if(a > b){
                  return 1;
              }
              return 0;
          });
            //現在地から見える星座を表示する
            for (var i of seeStarList){
              // var li = document.createElement('li');
              // li.id = i.name;
              // document.getElementById('canSeeStar').appendChild(li);
              var input = document.createElement("input");
              input.setAttribute("id","starButton");
              input.setAttribute("type","Button");
              input.setAttribute("value",i.name);
              input.setAttribute("onClick", 'searchStar('+i.id+');');
              document.getElementById('starList').appendChild(input);

            }
          });

          load(lat,lng);
        },
        error: function(req, err){ console.log(err); }
      });


      console.log("下の緯度: "+lat);
      console.log("下の経度：　"+lng);

    }


    function katakanaToHiragana(src) {
        return src.replace(/[\u30a1-\u30f6]/g, function(match) {
            var chr = match.charCodeAt(0) - 0x60;
            return String.fromCharCode(chr);
        });
    }
    //リバースジオコーディング
    function reverseGeocoording() {

      console.log("reverseGeocoording in");
      console.log(locationLat);
      console.log(locationLng);
      $.ajax({
        type: 'GET',
        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+locationLat+","+locationLng,
        dataType: 'json',
        success: function(response){ console.log(response);
          $("#location").val(response['results'][2]["formatted_address"]);
        },
        error: function(req, err){ console.log(err); }
      });

      console.log("reverseGeocoording out");
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
            locationLat = position.coords.latitude;
            locationLng = position.coords.longitude;
            // 緯度経度の取得
            latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            console.log(lat);
            console.log(lng);
            console.log(fullDate);
            console.log(hour);
            console.log(minute);


                    $.getJSON('http://linedesign.cloudapp.net/hoshimiru/constellation?',
                      {
                        lat: lat,
                        lng: lng,
                        date: fullDate,
                        hour: hour,
                        min: minute,
                        disp: "off"
                      }
                    )
                    // 結果を取得したら…
                    .done(function(data) {
                      // 中身が空でなければ、その値を［住所］欄に反映
                      console.log(data);

                      for (var i of data.result){
                        var star = {id: i.id,name: i.jpName, image: i.starImage,
                        altitudeNum: i.altitudeNum,directionNum: i.directionNum}
                        seeStarList.push(star);
                      }
                      seeStarList.sort(function(a, b){
                        a = katakanaToHiragana(a.name);
                        b = katakanaToHiragana(b.name);
                        if(a < b){
                            return -1;
                        }else if(a > b){
                            return 1;
                        }
                        return 0;
                    });
                      //現在地から見える星座を表示する
                      for (var i of seeStarList){
                        // var li = document.createElement('li');
                        // li.id = i.name;
                        // document.getElementById('canSeeStar').appendChild(li);
                        var input = document.createElement("input");
                        input.setAttribute("id","starButton");
                        input.setAttribute("type","Button");
                        input.setAttribute("value",i.name);
                        input.setAttribute("onClick", 'searchStar('+i.id+');');
                        document.getElementById('starList').appendChild(input);

                      }
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
                      heading: 32,
                      pitch: 12
                    }
                  });

            // マーカーの追加
            // new google.maps.Marker({
            //     position: latLng,
            //     map: map
            // });
            // google.maps.event.addListener(panorama, 'tilesloaded', review);
            google.maps.event.addListener(panorama, 'position_changed', review);

            map.setStreetView(panorama);
            console.log("mapの後");
            console.log(latLng);
            console.log("latLngを分解")
            console.log(latLng.lat());
            console.log(latLng.lng());
            console.log("分解を終了");
            console.log(lat);
            console.log(lng);
        }, function() {
            alert('位置情報取得に失敗しました');
        });
    }


// function initialize() {
//   load(42.345573, -71.098326);
// }
//
function load(lat, lng) {
  var fenway = {lat: lat, lng: lng};

  map.setCenter(fenway);
  map.setZoom(17);
  panorama.setPov({heading:34, pitch:10, zoom:0});
  panorama.setPosition(fenway);

  // new google.maps.Marker({
  //     position: fenway,
  //     map: map
  //     });
}



      </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzUQO_hY340FGTACPZ3p2doh8ZUEJlqlc&callback=initMap">
    </script>

  </body>
</html>
