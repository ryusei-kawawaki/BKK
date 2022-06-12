<?php
// 退会最終確認ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

// ページ名
$pageTitle = '退会最終確認';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<section class="display-4 text-center">
    <br>
    <h1>バイク乗りの交流SNS BKK 退会最終確認画面</h1>
    <br>
    <p>【最終確認】</p>
    <br><br>
    <p>「退会する」を押すと、退会が完了します。本当によろしいですか？</p>
    <br><br>
    <form action="//localhost/account/exitComplete.php" method="POST">
        <input type="hidden" name="id" value="<?= findDeepArray($request->getSession(),'user','id') ?? 0 ?>">
        <button type="submit" class="btn btn-lg btn-danger"><p class="display-4">退会する</p></button>
    </form>
    <br><br><br><br>
</section>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>