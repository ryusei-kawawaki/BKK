<?php
// 投稿一覧ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$temp_user_id = findDeepArray($request->getSession(), 'user', 'id');
$user_id = $temp_user_id != '' ? $temp_user_id : 0; 
$tag_id = $request->tag_id ?? null;

// 1ページに表示する投稿の数
$postCount = 10;

if (isset($_GET['page']) && is_int((int)$_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}

// DBからタグのマスタ情報を取得
$sql = "SELECT * FROM tags;";
$tags = $db->query($sql)->getAll();

// ページング用に、postsテーブルのレコード数を取得
$sql = "SELECT COUNT(*) FROM posts WHERE deleted_at IS NULL;";
$params = [];
if ($tag_id) {
    // tag_idが存在する場合、タグで絞り込み
    $sql .= " AND tag_id = :tag_id ";
    $params[':tag_id'] = $tag_id;
}
$allPostCount = (int)$db->query($sql, $params)->get()['COUNT(*)'] ?? 0;

$allPageCount = 0;
if (is_int($allPostCount)) {
    $allPageCount = ceil($allPostCount / $postCount);
}

var_dump($page);

// DBから投稿情報を取得
$sql = "SELECT posts.id, posts.tag_id, posts.body, posts.good, posts.created_at, posts.updated_at, posts.deleted_at, users.name as user_name FROM posts ";
$sql .= " JOIN users ON posts.user_id = users.id ";
$sql .= " WHERE posts.deleted_at IS NULL ";
$params = [];
if ($tag_id) {
    echo 'gooooooooooo';
    // tag_idが存在する場合、タグで絞り込み
    $sql .= " AND posts.tag_id = :tag_id ";
    $params[':tag_id'] = $tag_id;
}
$sql .= " ORDER BY posts.updated_at DESC LIMIT " . ($page - 1) * $postCount . ", " . $page * $postCount . ";";
$posts = $db->query($sql, $params)->getAll();

// DBから自身がいいねしたpost_idの一覧を取得
$sql = "SELECT * FROM favorites WHERE user_id = :user_id";
$favorites = $db->query($sql, [':user_id' => $user_id])->getAll();

// ページ名
$pageTitle = '投稿一覧';
$headerMode = 'postList';
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
                <a href="//localhost/post/postList.php?tag_id=<?= $tag['id'] . '&page='.$page ?>">
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
    <a href="//localhost/post/postList.php?page=<?= $page ?>">
        <p class="text-center display-6">絞り込みを解除</p>
    </a>
    <br>
</section>

<br><br><br><br><br>

<div>
    <div class="row">
        <!-- 投稿一覧の表示部分 -->
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
        <div class="col-lg-6">
            <?php if ($posts === []) { ?>
                <div>
                    <p class="text-center display-2">現在、表示できる投稿はありません。</p>
                    <br><br>
                    <a href="//localhost/post/edit.php">
                        <button class="btn btn-lg btn-success mx-auto d-block"><p class="display-6">投稿する！</p></button>
                    </a>
                </div>
            <?php } ?>

            <?php foreach ($posts as $post) { ?>
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
                                <a href="//localhost/post/edit.php?post_id=<?= $post['id'] ?>">
                                    <button class="btn btn-lg btn-success mx-auto d-block"><p class="display-6">編集する</p></button>
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
            <br><br>
            <!-- ページング -->
            <div class="d-flex flex-row text-center">
                <?php if ($page !== 1) { ?>
                    <a class="display-5" href="http://localhost/post/postList.php?page=<?= $page - 1 ?><?= $tag_id != null ? ('&tag_id=' . $tag_id) : '' ?>">＜前へ</a>　
                <?php } ?>
            
                <?php for ($i = 1; $i <= $allPageCount; $i++) { ?>
                    <a class="display-5" href="http://localhost/post/postList.php?page=<?= $i ?><?=  $tag_id != null ? ('&tag_id=' . $tag_id) : '' ?>"><?= $i ?></a>　
                <?php } ?>
            
                <?php if ($page < $allPageCount) { ?>
                    <a class="display-5" href="http://localhost/post/postList.php?page=<?= $page + 1 ?><?= $tag_id ? ('&tag_id=' . $tag_id) : '' ?>">次へ＞</a>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- 空白スペース用の空グリッド -->
        </div>
    </div>
</div>

<br><br><br>

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

</script>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
