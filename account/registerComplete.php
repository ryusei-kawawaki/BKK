<?php
// 登録官僚ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

if (!password_verify($request->getSession()['_token'], $request->_token)) {
    echo 'エラーが発生しました。';
    exit;
}

$name = findDeepArray($request->getSession(),'post','name');
$email = findDeepArray($request->getSession(),'post','email');
$password = password_hash(findDeepArray($request->getSession(),'post','password'), PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, created_at, updated_at) ";
$sql .= " VALUES (:name, :email, :password, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());";
$params = [
    ':name' => $name,
    ':email' => $email,
    ':password' => $password,
];
$user_id = $db->query($sql, $params)->lastInsertId();

$request->dropSession(['user']);
$request->setSession([
    'user' => [
        'id' => $user_id,
        'email' => $email,
        'name' => $name,
    ]
]);

// ページ名
$pageTitle = '新規登録完了';

?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<br><br><br><br>
<div class="row">
    <!-- カード全体の調整グリッドシステム -->
    <div class="col-lg-1">
        <!-- 空白スペース用の空グリッド -->
    </div>
    <div class="col-lg-10">
        <div class="card-header">
            <p class="display-3">アカウント登録が完了しました。</p>
        </div>
        <div class="card-body">
            <br>
            <p class="display-4"><?= $name ?>さん、BKKへようこそ！</p>
            <br><br><br>
            <div class="row row-cols-1 row-cols-sm-2 g-3">
                <div class="col-6">
                    <div class="text-center">
                        <a href="//localhost/account/mypage.php">
                            <button type="submit" class="btn btn-lg btn-info"><p class="display-6">マイページへ</p></button>
                        </a>
                    </div>
                    <br>
                    <img src="//localhost/img/sirkit.jpg" class="card-img-top" alt="card-grid-image">
                </div>
                <div class="col-6">
                    <div class="text-center">
                        <a href="//localhost/post/postList.php">
                            <button type="submit" class="btn btn-lg btn-danger"><p class="display-6">投稿一覧へ</p></button>
                        </a>
                    </div>
                    <br>
                    <img src="//localhost/img/bikebike.jpg" class="card-img-top" alt="card-grid-image">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-1">
        <!-- 空白スペース用の空グリッド -->
    </div>
</div>
<br><br><br><br>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
