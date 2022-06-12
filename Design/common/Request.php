<?php

class Request {

    private $session = [];

    function __construct()
    {
        foreach($_GET as $key => $value) {
            $this->{$key} = $value;
        }

        foreach($_POST as $key => $value) {
            $this->{$key} = $value;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        foreach($_SESSION as $key => $value) {
            $this->session[$key] = $value;
        }
    }

    public function setSession(array $params) {
        foreach ($params as $key => $value) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->session[$key] = $value;
            $_SESSION[$key] = $value;
        }
    }

    public function dropSession(array $keys) {
        foreach ($keys as $key) {
            if ($key) {
                unset($this->session[$key]);
                unset($_SESSION[$key]);
            } else {
                $this->session = [];
                $_SESSION = [];
            }
        }
    }

    public function postValidate() {
        $isValidate = false;

        // ここから、各ページごとのバリデーションルールを記述
        if (!is_int($this->post_id)) {
            $isValidate = true;
        }

        // データに不備がある場合はリダイレクト
        if ($isValidate === true) {
            $this->setSession($_POST);
            $this->_redirect('http://localhost/post.php');
        }
    }

    public function loginValidate() {
        $isValidate = false;

        // ここから、各ページごとのバリデーションルールを記述
        if ($this->email == null) {
            // emailが未入力又は存在しない場合
            $isValidate = true;
        }
        if ($this->email == mb_strlen()) {
            // emailが255文字以上の処理の場合
            $isValidate = true;
        }
        // データに不備がある場合はリダイレクト
        if ($isValidate === true) {
            $this->setSession($_POST);
            $this->_redirect('http://localhost/post.php');
        }
    }

    //#region 内部関数

    private function _redirect($url = null) {
        if ($url) {
            header('Location:' . $url);
        } else {
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    //#endregion
}