<?php
// コメント登録処理ページ(PHPのみ)

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

// $request->commentVaridate();

$sql = "INSERT INTO comments (user_id, post_id, body, created_at, updated_at) ";
$sql .= " VALUES (:user_id, :post_id, :body, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());";
$params = [
    ':user_id' => $request->user_id,
    ':post_id' => $request->post_id,
    ':body' => $request->body,
];
$user_id = $db->query($sql, $params);

$request->setSession(['commented' => true]);

header('Location:http://localhost/post/post.php?post_id='.$request->post_id);
