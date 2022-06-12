<?php
// Ajax投稿削除処理(phpのみ)

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
// 共通処理ここまで

// 投稿の削除処理(deleted_atに値を入れる)
$sql = "UPDATE posts SET deleted_at = CURRENT_TIMESTAMP() WHERE id = :id;";
$params = [':id' => $_GET['post_id']];
$db->query($sql, $params);

echo '{ "succeeded": true }';
