<?php

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$request->dropSession(['user']);

// ページ名
$pageTitle = 'ログアウト画面';
$headerMode = 'logout';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<br><br><br>

<section class="display-4 text-center row">
    <br><br><br><br>
    <p>ログアウトが完了しました。</p>
    <br>
    <div class="col-3"></div>
    <div class="col-3">
        <a href="//localhost/index.php">
            <button class="btn btn-lg btn-info"><p class="display-5">トップページ</p></button>
        </a>
    </div>
    <div class="col-3">
        <a href="//localhost/account/login.php">
            <button class="btn btn-lg btn-success"><p class="display-5">再ログイン</p></button>
        </a>
    </div>
    <div class="col-3"></div>
    <br><br><br><br><br><br>
</section>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
