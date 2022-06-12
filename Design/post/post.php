<?php
require_once('./common/Db.php');
// Dbクラスのインスタンスを作成
$db = new Db();
// 実行するSQL文
$sql = "INSERT INTO posts (user_id, tag_id, body, good, created_at) ";
$sql .= " VALUES (:user_id, :tag_id, :body, :good, :created_at);";
$params = [
    ':user_id' => 1,
    ':tag_id' => 1,
    ':body' => 'バイク2',
    ':good' => 3,
    ':created_at' => '2022-05-27 00:00:00',
];
// SQLを実行して結果を取得(1件)
$id = $db->query($sql, $params)->getInsertId();

echo $id;
exit;











?>
<html lang="ja">
<head>
  <meta charset="UTF-8"/>
  <title>twitter風チャット画面(会話方式)を記事に表示する方法 │ ナコさんのブログ nako-log WEB小ネタと生活ライフハック</title>
  <link rel='stylesheet' href='index.css' type='text/css' media='all' />
</head>
<body>
  <!-- ▼twitter風ここから -->
  <div class="twitter__container">
    <!-- タイトル -->
    <div class="twitter__title">
      <span class="twitter-logo"></span>
    </div>

    <!-- ▼タイムラインエリア scrollを外すと高さ固定解除 -->
    <div class="twitter__contents scroll">

      <!-- 記事エリア -->
      <div class="twitter__block">
        <figure>
          <img src="icon.png" />
        </figure>
        <div class="twitter__block-text">
          <div class="name">うさきち<span class="name_reply">@usa_tan</span></div>
          <div class="date">10分前</div>
          <div class="text">
            今日も終電だよ～<br>
          </div>
          <div class="twitter__icon">
            <span class="twitter-bubble"></span>
            <span class="twitter-loop"></span>
            <span class="twitter-heart"></span>
          </div>
        </div>
      </div>

      <!-- 記事エリア -->
      <div class="twitter__block">
        <figure>
          <img src="icon.png" />
        </figure>
        <div class="twitter__block-text">
          <div class="name">うさきち<span class="name_reply">@usa_tan</span></div>
          <div class="date">1時間前</div>
          <div class="text">
            残業でお腹空いたから朝までやってるお店でラーメン食べることにした(^o^)神の食べ物すぎる・・うまぁ
            <div class="in-pict">
              <img src="sample.jpg">
            </div>
          </div>
          <div class="twitter__icon">
            <span class="twitter-bubble">1</span>
            <span class="twitter-loop">4</span>
            <span class="twitter-heart">122</span>
          </div>
        </div>
      </div>

      <!-- 記事エリア -->
      <div class="twitter__block">
        <figure>
          <img src="icon.png" />
        </figure>
        <div class="twitter__block-text">
          <div class="name">うさきち<span class="name_reply">@usa_tan</span></div>
          <div class="date">2018/06/24 5:34</div>
          <div class="text">
            睡眠２時間で出社なんだけど…
            <a href="https://nakox.jp/">https://nakox.jp/</a>
          </div>
          <div class="twitter__icon">
            <span class="twitter-bubble">1</span>
            <span class="twitter-loop"></span>
            <span class="twitter-heart"></span>
          </div>
        </div>
      </div>


    </div>
    <!--　▲タイムラインエリア ここまで -->
  </div>
  <!--　▲twitter風ここまで -->
</body>
</html>
