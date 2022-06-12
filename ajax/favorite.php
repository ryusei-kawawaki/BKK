<?php
// Ajax投稿削除処理(phpのみ)

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
// 共通処理ここまで

$commonParams = [
    ':post_id' => $_GET['post_id'],
    ':user_id' => $_GET['user_id'],
];


// favoriteが存在するか探索
$sql = "SELECT * FROM favorites WHERE post_id = :post_id AND user_id = :user_id;";
$favorite = $db->query($sql, $commonParams)->get();
$sql = "";
$sql2 = "";

if ($favorite == []) {
    // 存在しなければfavoritesにレコードを新規作成、対象の投稿のgoodを+1する
    $sql = "INSERT INTO favorites (post_id, user_id) VALUES (:post_id, :user_id);";
    $sql2 = "UPDATE posts SET good = good + 1 WHERE id = :id;";
} else {
    // 存在すればfavoritesの該当レコードを削除、対象の投稿のgoodを-1する
    $sql = "DELETE FROM favorites WHERE post_id = :post_id and user_id = :user_id;";
    $sql2 = "UPDATE posts SET good = good - 1 WHERE id = :id;";
}
$db->query($sql, $commonParams)->get();
$db->query($sql2, [':id' => $_GET['post_id']])->get();

echo '{ "succeeded": true }';
