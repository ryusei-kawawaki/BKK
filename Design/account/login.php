<?php









?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    ログイン画面
    <form action="http://localhost/account/loginPost.php" method="POST">
        メールアドレス:<input type="email" name="email">
        パスワード:<input type="password" name="password">
        <input type="submit" value="送信">
    </form>
</body>
</html>