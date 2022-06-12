<?php
// 投稿新規作成・更新ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

if (($request->getSession()['error'] ?? []) == []) {
    checkAuth($request);
}


$temp_tag_id = findDeepArray($request->getSession(),'post','tag_id');
$tag_id = $temp_tag_id != '' ? $temp_tag_id : null;
$temp_body = findDeepArray($request->getSession(),'post','body');
$body = $temp_body != '' ? $body : null;

// DBからタグのマスタ情報を取得
$sql = "SELECT * FROM tags;";
$tags = $db->query($sql)->getAll();
$post = [
    'tag_id' => 0,
    'body' => '',
];

// DBから投稿情報を取得
if (isset($request->post_id)) {
    $sql = "SELECT * FROM posts WHERE id = :post_id AND deleted_at IS NULL;";
    $params = [':post_id' => $request->post_id];
    $post = $db->query($sql, $params)->get();
}

// ページ名
$pageTitle = '投稿編集';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<br><br><br>

<div class="row">
    <div class="col-lg-3"></div>
    <form action="http://localhost/post/editPost.php" method="POST" class="col-lg-6 display-6 text-left">
        <div>
            <!-- バリデーションメッセージを表示したい箇所に、これを入れる -->
            <?php foreach($request->getSession()['error'] ?? [] as $errorMassage) { ?>
                <p class="error" style="color: red; font-size: large;"><span class="glyphicon glyphicon-warning-sign left"></span> <?= $errorMassage ?></p>
            <?php } ?>
        </div>

        <input type="hidden" name="user_id" value="<?= findDeepArray($request->getSession(),'user','id') ?>">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?? '' ?>">

        <div class="form-group">
            <p for="tag_id">タグを選択してください</p>
            <select name="tag_id" class="form-control input-lg" id="tagSelect">
                <?php foreach ($tags as $tag) { ?>
                    <option value="<?= $tag['id'] ?>"
                        <?php if ($tag['id'] == ($tag_id ?? ($post['tag_id'] ?? ''))) echo ' selected '; ?>
                    ><?= $tag['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <br><br>

        <div class="form-group">
            <p for="body">概要メッセージを入力してください</p>
            <textarea name="body" class="form-control input-lg" id="bodySelect" rows="3"
                ><?= $body ?? ($post['body'] ?? '') ?></textarea>
        </div>

        <br><br>

        <button type="submit" class="btn btn-lg btn-success"><p class="display-6">投稿する！</p></button>
    </form>
    <div class="col-lg-3"></div>
</div>

<br><br><br><br><br>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
