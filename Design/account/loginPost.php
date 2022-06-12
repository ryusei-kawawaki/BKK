<?php
require_once('../common/Db.php');
require_once('../common/Request.php');

// Dbクラスのインスタンスを作成
$db = new Db();
// リクエストクラスのインスタンスを作成
$request = new Request();
//$_POST//スーパーグローバル変数
//バリデーション
$request->loginValidate();

// 実行するSQL文
$sql = 'SELECT * FROM users WHERE email = :email AND deleted_at IS NULL;';
// SQLを実行して結果を取得(1件)
$params = [
    ':email' => $request->email
];
$user = $db->query($sql, $params)->get();

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
    ログイン成功
</body>
</html>