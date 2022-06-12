<?php
// コメント送信ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$temp_user_id = findDeepArray($request->getSession(), 'user', 'id');
$user_id = $temp_user_id != '' ? $temp_user_id : 0; 

// ページ名
$pageTitle = 'コメント送信';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>



<br><br><br>

<div class="row">
    <div class="col-lg-3"></div>
    <form action="http://localhost/post/commentPost.php" method="POST" class="col-lg-6 display-6 text-left">
        <div>
            <!-- バリデーションメッセージを表示したい箇所に、これを入れる -->
            <ul>
                <?php foreach($request->getSession()['error'] ?? [] as $errorMassage) { ?>
                    <li><?= $errorMassage ?></li>
                <?php } ?>
            </ul>
        </div>

        <br><br>

        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="post_id" value="<?= $_GET['post_id'] ?? 0 ?>">

        <div class="form-group">
            <p for="body">書き込むメッセージを入力してください</p>
            <textarea name="body" class="form-control input-lg" id="bodySelect" rows="3" required
                ><?= findDeepArray($request->getSession(),'post','body') ?? $post['body'] ?></textarea>
        </div>

        <br><br>

        <button type="submit" class="btn btn-lg btn-success"><p class="display-6">投稿する！</p></button>
    </form>
    <div class="col-lg-3"></div>
</div>

<br><br><br><br><br>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
