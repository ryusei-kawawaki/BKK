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
        // バリデーション用のプロパティを破棄
        $_SESSION['post'] = [];
        $_SESSION['error'] = [];
    }

    public function getSession() {
        return $this->session;
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

    #region バリデーション

    public function postValidate() {
        $isValidate = false;
        $errors = [];

        #region ここから、各ページごとのバリデーションルールを記述
        // // post_idのバリデーション
        // if (!$this->post_id && !is_int($this->post_id)) {
        //     $isValidate = true;
        //     $errors['post_id'] = 'エラーが発生しました。';
        // }
        // user_idのバリデーション
        // if (!$this->user_id || !is_int($this->user_id)) {
        //     $isValidate = true;
        //     $errors['user_id'] = 'エラーが発生しました。1';
        // }
        // // tag_idのバリデーション
        // if (!$this->tag_id || !is_int($this->tag_id)) {
        //     $isValidate = true;
        //     $errors['tag_id'] = 'エラーが発生しました。2';
        // }
        // bodyのバリデーション
        if (!$this->body || mb_strlen($this->body) === 0) {
            $isValidate = true;
            $errors['body'] = '投稿内容を入力してください。';
        } elseif (mb_strlen($this->body) > 255) {
            $isValidate = true;
            $errors['body'] = '投稿内容は255字以内で入力してください';
        }
        #endregion

        // データに不備がある場合はリダイレクト
        if ($isValidate === true) {
            $this->setSession([
                'error' => $errors,
                'post' => $_POST,
            ]);

            $this->_redirect('http://localhost/post/edit.php' . ($this->post_id != '' ? '?post_id=' . $this->post_id  : ''));
        }
    }

    public function loginValidate() {
        $isValidate = false;
        $errors = [];

        #region ここから、各ページごとのバリデーションルールを記述
        // emailのバリデーション
        if (!$this->email || $this->email === '') {
            $isValidate = true;
            $errors['email'] = 'メールアドレスを入力してください。';
        } elseif (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $isValidate = true;
            $errors['email'] = '正しいメールアドレスの形式で入力してください。';
        } elseif (mb_strlen($this->email) > 255) {
            $isValidate = true;
            $errors['email'] = 'メールアドレスは255文字以内で入力してください。';
        }
        // passwordのバリデーション
        if (!$this->password || $this->password === '') {
            $isValidate = true;
            $errors['password'] = 'パスワードを入力してください';
        }

        #endregion

        // データに不備がある場合はリダイレクト
        if ($isValidate === true) {
            $this->setSession([
                'error' => $errors,
                'post' => $_POST,
            ]);
            $this->_redirect('http://localhost/account/post.php');
        }
    }

    public function commentVaridate() {
        $isValidate = false;
        $errors = [];

        #region ここから、各ページごとのバリデーションルールを記述
        // user_idのバリデーション
        // if (!$this->user_id || !is_int($this->user_id)) {
        //     $isValidate = true;
        //     $errors['user_id'] = 'エラーが発生しました。';
        // }
        // // post_idのバリデーション
        // if (!$this->post_id || !is_int($this->post_id)) {
        //     $isValidate = true;
        //     $errors['post_id'] = 'エラーが発生しました。';
        // }
        // bodyのバリデーション
        if (!$this->body || mb_strlen($this->body) === 0) {
            $isValidate = true;
            $errors['body'] = 'コメント内容を入力してください。';
        } elseif (mb_strlen($this->body) > 255) {
            $isValidate = true;
            $errors['body'] = 'コメント内容は255字以内で入力してください';
        }
        #endregion

        // データに不備がある場合はリダイレクト
        if ($isValidate === true) {
            $this->setSession([
                'error' => $errors,
                'post' => $_POST,
            ]);
            $this->_redirect('http://localhost/post/comment.php?post_id=' . $this->post_id);
        }
    }

    public function registerValidate() {
        $isValidate = false;
        $errors = [];

        #region ここから、各ページごとのバリデーションルールを記述
        // emailのバリデーション
        if (!$this->email || $this->email === '') {
            $isValidate = true;
            $errors['email'] = 'メールアドレスを入力してください。';
        } elseif (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            // 条件式が上手くいかなかったので一旦保留
            // $isValidate = true;
            // $errors['email'] = '正しいメールアドレスの形式で入力してください。';
        } elseif (mb_strlen($this->email) > 255) {
            $isValidate = true;
            $errors['email'] = 'メールアドレスは255文字以内で入力してください。';
        }
        // passwordのバリデーション
        if (!$this->password || $this->password === '') {
            $isValidate = true;
            $errors['password'] = 'パスワードを入力してください';
        }
        // password_confirmのバリデーション
        if (!$this->password_confirm || $this->password_confirm === '') {
            $isValidate = true;
            $errors['password_confirm'] = 'パスワード(確認)を入力してください。';
        } elseif ($this->password !== $this->password_confirm) {
            $isValidate = true;
            $errors['password_confirm'] = 'パスワード(確認)に、パスワードと同じ文字を入力してください';
        }
        #endregion
        // データに不備がある場合はリダイレクト
        if ($isValidate === true) {
            $this->setSession([
                'error' => $errors,
                'post' => $_POST,
            ]);
            $this->_redirect('http://localhost/account/register.php');
        }
    }
    #endregion

    #region 内部関数
    private function _redirect($url = null) {
        if ($url) {
            header('Location:' . $url);
        } else {
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    #endregion
}