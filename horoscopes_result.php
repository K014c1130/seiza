<DOCTYPE html>
  <link rel="stylesheet" type="text/css" href="seiza.css">
  <html>
  <fontcolor class="title">
  <head>
    <meta charset="UTF-8">
    <title>星座占いの結果</title>
  </head>
  <body>
    <?php
        $base_url = 'http://api.jugemkey.jp/api/horoscope/free/' . date("Y/m/d");
        $proxy = array(
          "http" => array(
           "proxy" => "tcp://proxy.kmt.neec.ac.jp:8080",
           'request_fulluri' => true,
          ),
        );
        $proxy_context = stream_context_create($proxy);
        $response = file_get_contents(
                          $base_url,
                          false,
                          $proxy_context
                    );
        $result = json_decode($response,true);


    ?>


    <h1 align="center"> <?= $result['horoscope'][date("Y/m/d")][$_GET['num']]['sign'] ?> :占いの結果</h1>
    <table border=1 width=500 height=500 align="center" style="color:#ffffff">
     <tr align="center"><td>結果</td><td><?= $result['horoscope'][date("Y/m/d")][$_GET['num']]['content'] ?></td></tr>

     <tr align="center"><td>金運</td><td>
        <?php for($cont = 1; $cont <= $result['horoscope'][date("Y/m/d")][$_GET['num']]['money']; $cont++){
       echo '<img src="image/money.png" width="20" height="20"">';}?>
     </td></tr>

     <tr align="center"><td>恋愛運</td><td>
       <?php for($cont = 1; $cont <= $result['horoscope'][date("Y/m/d")][$_GET['num']]['love']; $cont++){
       echo '<img src="image/love.png" width="20" height="20"">';}?>
     </td></tr>

     <tr align="center"><td>職運</td><td>
       <?php for($cont = 1; $cont <= $result['horoscope'][date("Y/m/d")][$_GET['num']]['job']; $cont++){
       echo '<img src="image/job.png" width="20" height="20"">';}?>
     </td></tr>

     <tr align="center"><td>ラッキーアイテム</td><td><?= $result['horoscope'][date("Y/m/d")][$_GET['num']]['item'] ?></td></tr>

     <tr align="center"><td>ラッキーカラー</td><td>

       <?php
         switch ($result['horoscope'][date("Y/m/d")][$_GET['num']]['color']) {

         case "シルバー":print '<FONT  style="background-color:#c0c0c0" color="#000000">';
         break;

         case "イエロー":print '<FONT  style="background-color:#ffff00" color="#000000">';
         break;

         case "グレー":print '<FONT  style="background-color:#696969" color="#ffffff">';
         break;

         case "パープル":print '<FONT  style="background-color:#800080" color="#ffffff">';
         break;

         case "ホワイト":print '<FONT  style="background-color:ffffff" color="#000000">';
         break;

         case "ブルー":print '<FONT  style="background-color:#0000ff" color="#ffffff">';
         break;

         case "ピンク":print '<FONT  style="background-color:#ffc0cb" color="#000000">';
         break;

         case "ブラック":print '<FONT  style="background-color:#000000" color="#ffffff">';
         break;

         case "レッド":print '<FONT  style="background-color:#ff0000" color="#000000">';
         break;

         case "オレンジ":print '<FONT  style="background-color:#ff4500" color="#000000">';
         break;

         case "ゴールド":print '<FONT  style="background-color:#ffd700" color="#00000">';
         break;

         case "グリーン":print '<FONT  style="background-color:#008000" color="#ffffff">';
         break;
               }

         print $result['horoscope'][date("Y/m/d")][$_GET['num']]['color'];
       ?>


        </FONT>
    </td></tr>

     <tr align="center"><td>トータル</td><td>
      <?php for($cont = 1; $cont <= $result['horoscope'][date("Y/m/d")][$_GET['num']]['total']; $cont++){
       echo '<img src="image/total.png" width="20" height="20"">';}?>
     </td></tr>

     <tr align="center"><td>星座順位</td><td><?= $result['horoscope'][date("Y/m/d")][$_GET['num']]['rank'] ?>位</td></tr>
    </table>
    <br><br>
    <center><a href="horoscopes.php">もどる</a></center>
  </body>
  </fontcolor>
  </html>
