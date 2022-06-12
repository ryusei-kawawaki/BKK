<?php
// 個別の投稿ページ

// すべてのページで最初に行う共通処理
require_once('../common/Db.php');
require_once('../common/Request.php');
require_once('../common/commonMethods.php');
$db = new Db();
$request = new Request();
// 共通処理ここまで

$temp_user_id = findDeepArray($request->getSession(), 'user', 'id');
$user_id = $temp_user_id != '' ? $temp_user_id : 0; 

// DBからタグのマスタ情報を取得
$sql = "SELECT * FROM tags;";
$tags = $db->query($sql)->getAll();

// DBから投稿情報を取得
$sql = "SELECT posts.id, posts.tag_id, posts.user_id, posts.body, posts.good, posts.created_at, posts.updated_at, posts.deleted_at, users.name as user_name FROM posts ";
$sql .= " JOIN users ON posts.user_id = users.id ";
$sql .= " WHERE posts.id = :post_id AND posts.deleted_at IS NULL; ";
$params = [
    ':post_id' => $request->post_id,
];
$post = $db->query($sql, $params)->get();

// DBからコメント情報を取得
$sql = "SELECT comments.user_id, comments.body, comments.created_at, comments.updated_at, users.name as user_name FROM comments ";
$sql .= " JOIN users ON comments.user_id = users.id ";
$sql .= " WHERE comments.post_id = :post_id AND comments.deleted_at IS NULL; ";
$sql .= " ORDER BY comments.updated_at ;";
$params = ['post_id' => $request->post_id];
$comments = $db->query($sql, $params)->getAll();

$commented = isset($request->getSession()['commented']) ? true : false;
$request->dropSession(['commented']);

// DBから自身がいいねしたpost_idの一覧を取得
$sql = "SELECT * FROM favorites WHERE user_id = :user_id";
$favorites = $db->query($sql, [':user_id' => $user_id])->getAll();

// ページ名
$pageTitle = '投稿表示';
?>
<!-- ヘッダー読み込み -->
<?php require_once('../common/header.php'); ?>

<br><br><br>

<?php if ($commented) { ?>
            <div class="display-3 bg-info">コメントが投稿されました。</div>
<?php } ?>

<br><br><br>

<div class="row">
    <!-- 投稿概要の表示部分 -->
    <div class="col-lg-1">
        <!-- 空白スペース用の空グリッド -->
    </div>
    <div class="col-lg-10">
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
                    <div class="col-6">
                        <a href="//localhost/post/edit.php?post_id=<?= $post['id'] ?>">
                            <button class="w-75 btn btn-lg btn-success mx-auto d-block"><p class="display-6">編集する</p></button>
                        </a>
                    </div>
                    <div class="col-6">
                        <?php if (getRecord($favorites, $post['id'], 'post_id') == []) { ?>
                            <button 
                                onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);" 
                                class="w-75 btn btn-lg mx-auto d-block btn-outline-warning <?= 'postBtn'.$post['id'] ?>"
                            >
                                <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいねする！</p>
                            </button>
                        <?php } else { ?>
                            <button
                                onclick="putFavorite(<?= $post['id'] ?>, <?= $user_id ?? 0 ?>);"
                                class="w-75 btn btn-lg mx-auto d-block btn-warning <?= 'postBtn'.$post['id'] ?>"
                            >
                                <p class="display-6 <?= 'postTxt'.$post['id'] ?>">いいね！中</p>
                            </button>
                        <?php } ?>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <div class="col-lg-1">
        <!-- 空白スペース用の空グリッド -->
    </div>
</div>

<br><br><br>

<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6 display-6 text-center">
        <?php if ($comments == []) { ?> 
            <p class="display-2">現在、コメントはありません。</p>
        <?php } else { ?>
            <p class="display-2">コメント</p>
            <br><br>
            <?php foreach($comments as $comment) { ?>
                <div class="card">
                    <p class="card-title text-left display-5"><?= $comment['user_name'] ?></p>
                    <div class="card-body">
                        <p class="text-left"><?= $comment['body'] ?></p>
                        <p class="text-right"><?= $comment['updated_at'] ?></p>
                    </div>
                </div>
                <br><br><br>
            <?php } ?>
        <?php } ?>
        <br><br><br>
        <button type="submit" class="btn btn-lg btn-info"
            onclick="moveToCommentPage(<?= $post['id'] ?>, <?= $user_id ?>);"
        >
            <p class="display-6">コメントする</p>
        </button>
    </div>
    <div class="col-lg-3"></div>
</div>

<br><br><br><br><br>

<script>
    // window.onload = function(){
    //     // ページ読み込み時に実行したい処理
    //     const commented = <?= '' // $commented ?>;
    //     if (commented) {
    //         alert('コメントの投稿が完了しました。');
    //     }
    // }

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
            location.href = '//localhost/post/postList.php';
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

    function moveToCommentPage(post_id, user_id) {
        if (user_id === 0) {
            alert('この機能は、ログインしないと利用できません。');
        } else {
            location.href = '//localhost/post/comment.php?post_id=' + post_id;
        }
    }
</script>

<!-- フッター読み込み -->
<?php require_once('../common/footer.php') ?>
