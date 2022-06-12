<?php
// ログイン処理ページ(phpのみ)

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

//$request->loginValidate();

$sql = "SELECT * FROM users WHERE email = :email and deleted_at IS NULL ;";
$params = ['email' => $request->email];
$user = $db->query($sql, $params)->get();

$errorMessage = '';

// ログイン失敗時は、$errorMessageにメッセージを代入する
if ($user == []) {
    $errorMessage = 'このユーザーは存在しません';
} 
elseif (!password_verify($request->password, $user['password'])) {
$errorMessage = 'パスワードが違います';
}
if ($errorMessage === '') {
    // ログイン成功(マイページに遷移)
    $request->setSession([
        'user' => [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
        ]
    ]);
    header('Location://localhost/account/mypage.php');
} else {
    // ログイン失敗(再びログインページに遷移)
    $request->setSession(['error' => ['password' => $errorMessage]]);
    header('Location://localhost/account/login.php');
}
