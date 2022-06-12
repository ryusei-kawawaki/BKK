<?php

class Db {

    private const DB_NAME = 'bbk';
    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASSWORD = 'kawawaki1230';

    private $dbh;
    private $stmt;

    /**
     * @param string $sql SQL
     * @param array $bindParam バインドした値
     */
    public function query(string $sql, array $bindParam = []) {
        $this->_connect();
        try {
            $this->stmt = null;
            $this->stmt = $this->dbh->prepare($sql);
            foreach ($bindParam as $key => $value) {
                $this->stmt->bindValue($key, $value, PDO::PARAM_INT);
            }
            $this->stmt->execute();
        } catch (PDOException $e) {
            echo 'SQL実行エラー' . $e->getMessage() . '\n';
            exit();
        }

        return $this;
    }

    public function get() {
        if ($this->stmt) {
            $res = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->_destroy();
            if ($res != []) {
                return $res[0];
            }
        }
        return null;
    }

    public function getAll() {
        if ($this->stmt) {
            $res = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->_destroy();
            return $res;
        }
        return [];
    }
    
    public function getInsertId() {
        if ($this->stmt) {
            $res = $this->dbh->lastInsertId();
            $this->_destroy();
            return $res;
        }
        return null;
    }
    //#region 内部関数

    private function _connect() {
        $this->_destroy();
        try {
            $this->dbh = new PDO(
                'mysql:dbname='
                    . self::DB_NAME
                    . ';host='
                    . self::DB_HOST
                , self::DB_USER
                , self::DB_PASSWORD
            );
        } catch(PDOException $e) {
            echo '接続失敗' . $e->getMessage() . '\n';
            exit();
        }
    }

    private function _destroy() {
        $this->dbh = null;
        $this->stmt = null;
    }
}