<?php
// トップページ

// すべてのページで最初に行う共通処理
require_once('./common/Db.php');
require_once('./common/Request.php');
require_once('./common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$isTopPage = true;
// ページタイトル
$pageTitle = 'トップページ'
?>

<!-- ヘッダー読み込み -->
<?php require_once('./common/header.php'); ?>

<section class="py-5">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <p class="display-2">あなたの「想い」を、共有しませんか。</p>
                <p class="lead">
                    <br>
                    <p class="display-5">次はどこを走ろうか？この場所が最高に良かったよ！と</p>
                    <p class="display-5">お話しできる掲示板です。</p>
                </p>
                <p class="mb-0"></p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="py-5 bg-image-full"  style="background-image: url('http://localhost/img/bike_top.jpg')">
        <div style="height: 40rem"></div>
        <div class="text-center my-5">
            <a href="http://localhost/account/register.php">
                <button class="btn btn-lg btn-secondary" type="submit"><p class="display-5">さあ、はじめよう</p></button>
            </a>
        </div>
        <div style="height: 40rem"></div>
    </div>
</section>

<!-- フッター読み込み -->
<?php require_once('./common/footer.php') ?>