<?php

// 何度も使う処理を関数にして、すべてのページで使えるようにする
$isTopPage = false;
$headerMode = '';

/**
 * セッションを開始する関数
 */
function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * テーブルから取得した複数のレコードから、指定されたカラムの値でレコードを探索する(デフォルトはid)
 */
function getRecord(array $dataList, string $value, string $column = 'id') {
    foreach ($dataList as $data) {
        if ($data[$column] == $value) {
            return $data;
        }
    }
    return [];
}

/**
 * テーブルから取得した複数のレコードから、指定されたカラムの値でレコードをフィルタリングする(デフォルトはid)
 */
function filterRecord(array $dataList, string $value, string $column = 'id') {
    $res = [];
    foreach ($dataList as $data) {
        if ($data[$column] == $value) {
            $res[] = $data;
        }
    }
    return $res;
}

/**
 * ログインしていなければ、ログインページへ遷移する関数
 */
function checkAuth(Request $request) {
    if (!isset($request->getSession()['user'])) {
        header('Location:http://localhost/account/login.php');
    }
}

/**
 * 何重にもネストした連想配列を探索・存在しなければ空文字を返す
 */
function findDeepArray($array, ...$keys) {
    $tempArray = $array;
    foreach ($keys as $key) {
        if (isset($tempArray[$key])) {
            $tempArray = $tempArray[$key];
        } else {
            return '';
        }
    }
    return $tempArray;
}