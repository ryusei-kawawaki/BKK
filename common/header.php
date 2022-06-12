<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>BKK - <?= $pageTitle ?? '' ?></title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="//localhost/bootstrap/template/assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="//localhost/bootstrap/template/css/styles.css" rel="stylesheet" />
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="//localhost/bootstrap/template/js/scripts.js"></script>
    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-bottom: 0px;">
            <div class="container">
                <a class="navbar-brand" href="http://localhost/index.php"><span class="mb-0 h1">BKK</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a href="http://localhost/account/register.php"
                            <?= $headerMode === 'register' ? ' class="nav-link active" aria-current="page" ' : ' class="nav-link" ' ?>>
                            <span class="mb-0 h5">新規登録</a></li>　　
                        <li class="nav-item"><a href="http://localhost/account/mypage.php"
                            <?= $headerMode === 'mypage' ? ' class="nav-link active" aria-current="page" ' : ' class="nav-link" ' ?>>
                            <span class="mb-0 h5">マイページ</a></li>　　
                        <li class="nav-item"><a href="http://localhost/post/postList.php"
                            <?= $headerMode === 'postList' ? ' class="nav-link active" aria-current="page" ' : ' class="nav-link" ' ?>>
                            <span class="mb-0 h5">投稿一覧</a></li>　　
                        <?php if (findDeepArray($request->getSession(), 'user', 'id') === '') { ?>
                            <li class="nav-item"><a href="http://localhost/account/login.php"
                                <?= $headerMode === 'login' ? ' class="nav-link active" aria-current="page" ' : ' class="nav-link" ' ?>>
                                <span class="mb-0 h5">ログイン</a></li>　　
                        <?php } else { ?>
                            <li class="nav-item"><a href="http://localhost/account/logout.php"
                                <?= $headerMode === 'logout' ? ' class="nav-link active" aria-current="page" ' : ' class="nav-link" ' ?>>
                                <span class="mb-0 h5">ログアウト</a></li>　　
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- <header class="py-5 bg-image-full"  style="background-image: url('http://localhost/img/bike_top.jpg')"> -->
        <header class="py-5 bg-image-full"  style="background-image: url('http://localhost/img/header.jpg')">
            <?php if ($isTopPage) { ?>
                <div style="height: 5rem"></div>
                <p class="display-1">　　<mark>バイク好きの為の匿名掲示板 - 「BKK」</mark></p>
                <div style="height: 15rem"></div>
                <!-- <div class="text-center my-5">
                    <a href="http://localhost/account/register.php">
                        <button class="btn btn-lg btn-primary" type="submit">さあ、はじめよう</button>
                    </a>
                </div> -->
            <?php } else { ?>
                <div style="height: 20rem"></div>
            <?php } ?>
        </header>