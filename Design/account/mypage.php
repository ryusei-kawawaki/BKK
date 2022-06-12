<?php 

require_once('./common/Db.php');
// Dbクラスのインスタンスを作成
$db = new Db();
// 実行するSQL文
$sql = 'SELECT * FROM users WHERE id = 1;';
// SQLを実行して結果を取得(1件)
$user = $db->query($sql)->get();

var_dump($user);

echo $user['email'];









?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>