<?php
// 新規登録確認ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$request->registerValidate();

// emailの重複チェック
$sql = "SELECT * FROM users WHERE email = :email AND deleted_at IS NULL ;";
$params = [
    ':email' => $request->email,
];
$user = $db->query($sql, $params)->get();
if ($user !== []) {
    $request->setSession(['error' => ['email' => 'このメールアドレスは既にほかのアカウントで登録されています']]);
    header('Location://localhost/account/register.php');
}


$token = random_bytes(mt_rand(30, 40));

$request->dropSession(['_token']);
$request->setSession([
    'post' => [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
    ],
    '_token' => $token,
]);

// ページ名
$pageTitle = '新規登録・最終確認';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<br><br><br><br><br>
<div class="row">
    <!-- カード全体の調整グリッドシステム -->
    <div class="col-lg-3">
        <!-- 空白スペース用の空グリッド -->
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header center-block">
                <p class="display-5">登録確認</p>
            </div>
            <div class="card-body display-6">
                <p>以下の内容で登録します。</p>
                <br>
                <!-- 確認ウインドウ表示時は、この位置に入力内容を含んだdl,dt,ddが挿入されます。このコメント文は消しても問題ありません。 -->
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">名前：<?= $request->name ?></li>
                    <li class="list-group-item">メールアドレス：<?= $request->email ?></li>
                    <li class="list-group-item">パスワード： *********</li>
                </ul>

                <br><br>

                <div class="row">
                    <div class="col-10">
                        <form action="//localhost/account/registerComplete.php" method="POST">
                            <input type="hidden" name="_token" value="<?= password_hash($token, PASSWORD_DEFAULT) ?>">
                            <button type="submit" class="btn btn-lg btn-success">登録する</button>
                        </form>
                    </div>
                    <div class="col-2">
                        <a href="//localhost/account/register.php">
                            <button type="button" class="btn btn-lg btn-outline-danger">修正する</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <!-- 空白スペース用の空グリッド -->
    </div>
</div>

<br><br><br><br><br>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
