<?php

// ログインページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

// ページ名
$pageTitle = 'ログイン';
$headerMode = 'login';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<div class="container">
    <div class="row navbar-fixed-top header">
        <!-- <img class="header-img" src="//lakshmip.com/images/bond-logo.png" id="bond-logo" /> -->
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <!-- <h1 class="text-center login-title">Sign in to continue to Bootsnipp</h1> -->
            <div class="account-wall">
                <div class="chase-logo display-3">
                    <!-- <img class="profile-img" src="//lakshmip.com/images/chase-logo.png"
                        alt=""> -->
                    <br>
                    <h1 class="text-center display-3 login-title">ログイン</h1>
                    <br>
                    <!-- バリデーションメッセージを表示したい箇所に、これを入れる -->
                    <?php foreach($request->getSession()['error'] ?? [] as $errorMassage) { ?>
                        <p id="error" class="display-6 text-danger"><span class="glyphicon glyphicon-warning-sign left"></span> <?= $errorMassage ?></p>
                    <?php } ?>
                    <form class="form-signin" action="//localhost/account/loginPost.php" method="POST">
                        <input type="email" class="form-control input-lg" placeholder="Eメール" required
                            name="email" value="<?= findDeepArray($request->getSession(), 'post', 'email') ?>">
                        <br>
                        <input type="password" class="form-control input-lg" placeholder="パスワード" required name="password" value="">
                        <br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit"><p class="display-6">ログイン</p></button>
                    </form>
                </div>
                <br><br>
                <a href="//localhost/account/register.php"><p class="text-center new-account display-6">新規登録はこちら</p></a>
                <br><br><br>
            </div>
        </div>
    </div>
</div>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
