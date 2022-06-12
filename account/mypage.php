<?php
// マイページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

// ログインしていなければログインページにリダイレクト
checkAuth($request);

$user_id = findDeepArray($request->getSession(), 'user', 'id');
$tag_id = $request->tag_id ?? null;

$commonParams = [
    ':user_id' => $user_id
];

// DBからタグのマスタ情報を取得
$sql = "SELECT * FROM tags;";
$tags = $db->query($sql)->getAll();

// DBからすべての投稿一覧を取得
$param = [];
$sql = "SELECT posts.id, posts.tag_id, posts.user_id, posts.body, posts.good, posts.created_at, posts.updated_at, users.name as user_name FROM posts ";
$sql .= " JOIN users ON posts.user_id = users.id ";
$sql .= " WHERE posts.deleted_at IS NULL ";
$allPosts = [];
if ($tag_id) {
    $sql .= " AND posts.tag_id = :tag_id";
    $sql .= " ORDER BY posts.updated_at DESC;";
    $param[':tag_id'] = $tag_id;
    $allPosts = $db->query($sql, [':tag_id' => $tag_id])->getAll();
} else {
    $sql .= " ORDER BY posts.updated_at DESC;";
    $allPosts = $db->query($sql)->getAll();
}

// 自身が作成した投稿一覧を取得
$ownPosts = [];
foreach ($allPosts as $post) {
    if ($post['user_id'] == $user_id ) {
        $ownPosts[] = $post;
    }
}

// DBからユーザーのコメントを取得
$sql = "SELECT * FROM comments WHERE deleted_at IS NULL and user_id = :user_id;";
$allComments = $db->query($sql, $commonParams)->getAll();

$comments = [];
foreach ($allComments as $comment) {
    $comments[] = $comment['post_id'];
}
$uniqueComments = array_unique($comments);

// 自身がコメントした投稿一覧を一意に取得
$commentedPosts = [];
foreach($uniqueComments as $post_id) {
    $post = getRecord($allPosts, $post_id);
    if ($post != []) {
        $commentedPosts[] = $post;
    }
}

// DBから自身がいいねしたpost_idの一覧を取得
$sql = "SELECT * FROM favorites WHERE user_id = :user_id";
$favorites = $db->query($sql, $commonParams)->getAll();
$favoritedPosts = [];
foreach ($favorites as $favorite) {
    $post = getRecord($allPosts, $favorite['post_id']);
    if ($post != []) {
        $favoritedPosts[] = $post;
    }
}

// ページ名
$pageTitle = 'マイページ';
$headerMode = 'mypage';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<br><br>
<section class="rounded-pill border border-secondary">
    <br>
    <p class="text-center display-6">タグで絞りこみ</p>
    <br><br>
    <div class="row">
        <!-- タグでの絞り込みのボタン部分 -->
        <div class="col-1">
            <!-- 空白スペース用の空グリッド -->
        </div>
        <?php foreach ($tags as $tag) { ?>
            <div class="col-2">
                <a href="//localhost/account/mypage.php?tag_id=<?= $tag['id'] ?>">
                    <button class="btn-lg w-75 <?= $tag_id == $tag['id'] ? 'btn-primary' : 'btn-outline-primary' ?>">
                        <p class="display-6"><?= $tag['name'] ?></p>
                    </button>
                </a>
            </div>
        <?php } ?>
        <div class="col-1">
            <!-- 空白スペース用の空グリッド -->
        </div>
    </div>
    <br><br>
    <a href="//localhost/account/mypage.php">
        <p class="text-center display-6">絞り込みを解除</p>
    </a>
    <br>
</section>

<br><br><br><br><br>

<ul class="nav nav-tabs row">
    <li class="nav-item col-4">
        <a href="#contents1" class="nav-link active" data-toggle="tab">
            <p class="text-center display-4">あなたの作成した投稿</p>
        </a>
    </li>
    <li class="nav-item col-4">
        <a href="#contents2" class="nav-link" data-toggle="tab">
            <p class="text-center display-4">あなたがコメントした投稿</p>
        </a>
    </li>
    <li class="nav-item col-4">
        <a href="#contents3" class="nav-link" data-toggle="tab">
            <p class="text-center display-4">あなたが「いいね」した投稿</p>
        </a>
    </li>
</ul>

<br><br><br><br><br>

<div class="tab-content">
    <div id="contents1" class="tab-pane active row">
        <!-- 自身が作成した投稿一覧の表示部分 -->
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
        <div class="col-lg-6">
            <?php if ($ownPosts === []) { ?>
                <p class="text-center display-2">現在、あなたの作成した投稿はありません。</p>
                <br><br>
            <?php } ?>

            <?php foreach ($ownPosts as $post) { ?>
                <div class="card">
                    <br>
                    <div class="row">
                        <p class="card-title col-10 display-4"><strong><?= $post['user_name'] ?></strong>の投稿</p>
                        <div 
                            onclick="deletePost(<?= $post['id'] ?>);" 
                            class="col-2 text-right <? $post['user_id'] == findDeepArray($request->getSession(), 'user', 'id') ? '' : 'd-none' ?>"
                        >
                            <img src="//localhost/img/dustbox.jpg" alt=""  style="max-width: 30px;">
                        </div>
                    </div>
                    <br><br>
                    <div class="card-body display-6">
                        <p>更新日：<?= $post['updated_at'] ?></p>
                        <p>分類　：<mark><?= getRecord($tags, $post['tag_id'])['name'] ?></mark></p>
                        <br>
                        <p>概要　：</p>
                        <br>
                        <p><?= $post['body'] ?></p>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <button 
                                    class="btn btn-lg btn-success mx-auto d-block"
                                    onclick="sendToPostEditPage(<?= $post['id'].', '.$post['user_id'].', '.$user_id ?>);"
                                    ><p class="display-6">編集する</p></button>
                            </div>
                            <div class="col-4">
                                <?php if (getRecord($favorites, $post['id'], 'post_id') == []) { ?>
                                    <button 
                                        onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);" 
                                        class="btn btn-lg mx-auto d-block btn-outline-warning <?= 'postBtn'.$post['id'] ?>"
                                    >
                                        <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいねする！</p>
                                    </button>
                                <?php } else { ?>
                                    <button
                                        onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);"
                                        class="btn btn-lg mx-auto d-block btn-warning <?= 'postBtn'.$post['id'] ?>"
                                    >
                                        <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいね！中</p>
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="col-4">
                                <a href="//localhost/post/post.php?post_id=<?= $post['id'] ?>">
                                    <button class="btn btn-lg btn-info mx-auto d-block"><p class="display-6">コメント欄へ</p></button>
                                </a>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            <?php } ?>
            <br><br><br>
            <a href="//localhost/post/edit.php">
                <button class="btn btn-lg btn-success mx-auto d-block"><p class="display-6">投稿する！</p></button>
            </a>
        </div>
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
    </div>
    <div id="contents2" class="tab-pane row">
        <!-- 自身がコメントした投稿一覧の表示部分 -->
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
        <div class="col-lg-6">
            <!-- 自身がコメントした投稿一覧の表示部分 -->
            <?php if ($commentedPosts === []) { ?>
                <div>
                    <p class="text-center display-2">現在、あなたがコメントした投稿はありません。</p>
                    <br><br>
                    <a href="//localhost/post/postList.php">
                        <button class="btn btn-lg btn-info mx-auto d-block"><p class="display-6">投稿一覧を見る！</p></button>
                    </a>
                </div>
            <?php } ?>

            <?php foreach ($commentedPosts as $post) { ?>
                <div class="card">
                    <br>
                    <div class="row">
                        <p class="card-title col-10 display-4"><strong><?= $post['user_name'] ?></strong>の投稿</p>
                        <div 
                            onclick="deletePost(<?= $post['id'] ?>);" 
                            class="col-2 text-right <? $post['user_id'] == findDeepArray($request->getSession(), 'user', 'id') ? '' : 'd-none' ?>"
                        >
                            <img src="//localhost/img/dustbox.jpg" alt=""  style="max-width: 30px;">
                        </div>
                    </div>
                    <br><br>
                    <div class="card-body display-6">
                        <p>更新日：<?= $post['updated_at'] ?></p>
                        <p>分類　：<mark><?= getRecord($tags, $post['tag_id'])['name'] ?></mark></p>
                        <br>
                        <p>概要　：</p>
                        <br>
                        <p><?= $post['body'] ?></p>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <button
                                    class="btn btn-lg btn-success mx-auto d-block"
                                    onclick="sendToPostEditPage(<?= $post['id'].', '.$post['user_id'].', '.$user_id ?>);"
                                    ><p class="display-6">編集する</p></button>
                                </a>
                            </div>
                            <div class="col-4">
                                <?php if (getRecord($favorites, $post['id'], 'post_id') == []) { ?>
                                    <button 
                                        onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);" 
                                        class="btn btn-lg mx-auto d-block btn-outline-warning <?= 'postBtn'.$post['id'] ?>"
                                    >
                                        <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいねする！</p>
                                    </button>
                                <?php } else { ?>
                                    <button
                                        onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);"
                                        class="btn btn-lg mx-auto d-block btn-warning <?= 'postBtn'.$post['id'] ?>"
                                    >
                                        <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいね！中</p>
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="col-4">
                                <a href="//localhost/post/post.php?post_id=<?= $post['id'] ?>">
                                    <button class="btn btn-lg btn-info mx-auto d-block"><p class="display-6">コメント欄へ</p></button>
                                </a>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
    </div>
    <div id="contents3" class="tab-pane row">
        <!-- 自身がいいねした投稿一覧の表示部分 -->
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
        <div class="col-lg-6">
            <?php if ($favoritedPosts === []) { ?>
                <div>
                    <p class="text-center display-2">現在、あなたが「いいね」した投稿はありません。</p>
                    <br><br>
                    <a href="//localhost/post/postList.php">
                        <button class="btn btn-lg btn-info mx-auto d-block"><p class="display-6">投稿一覧を見る！</p></button>
                    </a>
                </div>
            <?php } ?>

            <?php foreach ($favoritedPosts as $post) { ?>
                <div class="card">
                    <br>
                    <div class="row">
                        <p class="card-title col-10 display-4"><strong><?= $post['user_name'] ?></strong>の投稿</p>
                        <div 
                            onclick="deletePost(<?= $post['id'] ?>);" 
                            class="col-2 text-right <? $post['user_id'] == findDeepArray($request->getSession(), 'user', 'id') ? '' : 'd-none' ?>"
                        >
                            <img src="//localhost/img/dustbox.jpg" alt=""  style="max-width: 30px;">
                        </div>
                    </div>
                    <br><br>
                    <div class="card-body display-6">
                        <p>更新日：<?= $post['updated_at'] ?></p>
                        <p>分類　：<mark><?= getRecord($tags, $post['tag_id'])['name'] ?></mark></p>
                        <br>
                        <p>概要　：</p>
                        <br>
                        <p><?= $post['body'] ?></p>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <button class="btn btn-lg btn-success mx-auto d-block"
                                    onclick="sendToPostEditPage(<?= $post['id'].', '.$post['user_id'].', '.$user_id ?>);"
                                    ><p class="display-6">編集する</p></button>
                            </div>
                            <div class="col-4">
                                <?php if (getRecord($favorites, $post['id'], 'post_id') == []) { ?>
                                    <button 
                                        onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);" 
                                        class="btn btn-lg mx-auto d-block btn-outline-warning <?= 'postBtn'.$post['id'] ?>"
                                    >
                                        <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいねする！</p>
                                    </button>
                                <?php } else { ?>
                                    <button
                                        onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);"
                                        class="btn btn-lg mx-auto d-block btn-warning <?= 'postBtn'.$post['id'] ?>"
                                    >
                                        <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいね！中</p>
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="col-4">
                                <a href="//localhost/post/post.php?post_id=<?= $post['id'] ?>">
                                    <button class="btn btn-lg btn-info mx-auto d-block"><p class="display-6">コメント欄へ</p></button>
                                </a>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
    </div>
</div>

<br><br><br><br>

<a href="//localhost/account/exitConfirm.php">
    <p class="display-4 text-right" style="margin-right: 10rem;">BKKを退会する</p>
</a>

<br><br><br><br>

<script>
    // Ajax用の関数たち
    function deletePost(post_id) {
        const msg = 'この投稿を削除します。本当によろしいですか？';
        const isDelete = confirm(msg);
        if (!isDelete) return;
        $.ajax('//localhost/ajax/deletePost.php', {
            type: 'get',
            data: { post_id: post_id },
            dataType: 'json'
        })
        .done(function(data) {
            alert('削除が完了しました。');
            window.location.reload();
        })
        .fail(function() {
            alert('削除に失敗しました。');
        });
    }

    function putFavorite(post_id, user_id) {
        if (user_id === 0) {
            alert('この機能は、ログインしないと利用できません。');
            return;
        }

        $.ajax('//localhost/ajax/favorite.php', {
            type: 'get',
            data: { 
                post_id: post_id,
                user_id: user_id,
            },
            dataType: 'json'
        })
        .done(function(data) {
            if ($('.postTxt' + post_id).text() == 'いいねする！') {
                // いいねアイコンをいいね中にする処理
                $('.postBtn' + post_id).removeClass('btn-outline-warning')
                $('.postBtn' + post_id).addClass('btn-warning')
                $('.postTxt' + post_id).text('いいね中')
            } else {
                // いいねアイコンをいいねしていない状態にする処理
                $('.postBtn' + post_id).removeClass('btn-warning')
                $('.postBtn' + post_id).addClass('btn-outline-warning')
                $('.postTxt' + post_id).text('いいねする！')
            }
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    }

    function sendToPostEditPage(post_id, owner_user_id, login_user_id = null) {
        if (login_user_id == null || owner_user_id != login_user_id) {
            alert('あなたが作成した投稿のみ編集できます。');
        } else {
            location.href = '//localhost/post/edit.php?post_id=' + post_id;
        }
    }
</script>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
