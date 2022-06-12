<?php
// 退会完了ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

// ユーザの削除処理(deleted_atに値を入れる)
$sql = "UPDATE users SET deleted_at = CURRENT_TIMESTAMP() WHERE id = :id;";
$params = [':id' => $request->id];
$db->query($sql, $params);

$request->dropSession(['user']);

// ページ名
$pageTitle = '退会完了';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<section class="display-4 text-center">
    <br>
    <p>退会が完了しました。</p>
    <br>
    <p>BKKをご利用いただき、ありがとうございました。</p>

    <p>もしよろしければ、以下のリンクよりアプリの評価・感想をお寄せいただけると幸いです！</p>
    <br><br>
    <div class="row">
        <div class="col-3"></div>
        <a class="col-3"><p>アンケートに答える！</p></a>
        <a href="//localhost/index.php" class="col-3"><button class="btn btn-lg btn-success"><p class="display-4">トップページ</p></button></a>
        <div class="col-3"></div>
    </div>
    <br><br><br><br>
</section>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
