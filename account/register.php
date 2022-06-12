<?php
// アカウント新規登録画面

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$pageTitle = '新規登録';
$headerMode = 'register';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<section>
    <div class="container">
        <div class="row navbar-fixed-top header">
            <!-- <img class="header-img" src="//lakshmip.com/images/bond-logo.png" id="bond-logo" /> -->
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <!-- <h1 class="text-center login-title">Sign in to continue to Bootsnipp</h1> -->
                <div class="account-wall">
                    <div class="chase-logo">
                        <img class="profile-img" src="//lakshmip.com/images/chase-logo.png"
                            alt="">
                        <h1 class="text-center login-title display-3">新規登録</h1>
                        <br>
                        <p class="text-center normal-text display-6">登録情報を入力してください</p>
                        <br>
                        <!-- バリデーションメッセージを表示したい箇所に、これを入れる -->
                        <?php foreach($request->getSession()['error'] ?? [] as $errorMassage) { ?>
                            <p class="error" style="color: red; font-size: large;"><span class="glyphicon glyphicon-warning-sign left"></span> <?= $errorMassage ?></p>
                        <?php } ?>
                    </div>
                    <form class="form-signin input-group-lg" action="//localhost/account/registerConfirm.php" method="POST">
                        <input type="text" class="form-control" placeholder="名前" required
                            name="name" value="<?= findDeepArray($request->getSession(),'post','name') ?? '' ?>">
                        <br>
                        <input type="email" class="form-control" placeholder="Eメール" required
                            name="email" value="<?= findDeepArray($request->getSession(),'post','email') ?? '' ?>">
                        <br>
                        <input type="password" class="form-control" placeholder="パスワード" required name="password">
                        <br>
                        <input type="password" class="form-control" placeholder="パスワード(確認)" required name="password_confirm">
                        <br><br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">登録する</button>
                    </form>
                    <br><br><br><br><br><br><br><br>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
