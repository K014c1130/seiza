<DOCTYPE html>
  <html>
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
    <table border=1 width=500 height=500 align="center">
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

     <tr align="center"><td>ラッキアイテム</td><td><?= $result['horoscope'][date("Y/m/d")][$_GET['num']]['item'] ?></td></tr>

     <tr align="center"><td>ラッキカラー</td><td><?= $result['horoscope'][date("Y/m/d")][$_GET['num']]['color'] ?></td></tr>
     
     <tr align="center"><td>トータル</td><td>
      <?php for($cont = 1; $cont <= $result['horoscope'][date("Y/m/d")][$_GET['num']]['total']; $cont++){
       echo '<img src="image/total.png" width="20" height="20"">';}?>
     </td></tr>

     <tr align="center"><td>星座順位</td><td><?= $result['horoscope'][date("Y/m/d")][$_GET['num']]['rank'] ?>位</td></tr>
    </table>


  </body>
  </html>
