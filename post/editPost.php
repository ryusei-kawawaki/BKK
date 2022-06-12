<?php
// 投稿新規作成・更新の処理・完了ページ(PHPのみ)

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$request->postValidate();

$sql = '';
$params = [
    ':user_id' => $request->user_id,
    ':tag_id' => $request->tag_id,
    ':body' => $request->body,
];

if ($request->post_id == '') {
    // 新規作成の場合
    $sql = "INSERT INTO posts (user_id, tag_id, body, good, created_at, updated_at) ";
    $sql .= " VALUES (:user_id, :tag_id, :body, 0, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());";
    $post_id = $db->query($sql, $params)->lastInsertId();
} else {
    // 更新の場合
    $sql = "UPDATE users SET deleted_at = CURRENT_TIMESTAMP() WHERE id = :id;";

    $sql = "UPDATE posts SET user_id = :user_id, tag_id = :tag_id, body = :body, updated_at = CURRENT_TIMESTAMP()";
    $sql .= " WHERE id = :post_id;";
    $params[':post_id'] = $request->post_id;
    var_dump($sql, $params);
    $db->query($sql, $params);
    $post_id = $request->post_id;
}

?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php') ?>

<div class="row" class="container-fluid" style="height: 50vh;">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="h-25"></div>
        <p class="display-4 text-center h-25">投稿の編集が完了しました。</p>
        <div class="row h-50">
            <div class="col-6 text-center">
                <a href="http://localhost/post/postList.php">
                    <button class="btn btn-lg btn-info"><p class="display-4">投稿一覧へ</p></button>
                </a>
            </div>
            <div class="col-6 text-center">
                <a href="http://localhost/post/post.php?post_id=<?= $post_id ?>">
                    <button class="btn btn-lg btn-warning"><p class="display-6">編集した投稿をチェック</p></button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
