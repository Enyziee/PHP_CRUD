<?php 

namespace MVC\Models;

use PDO;

class DaoSingleton {

    private static $instance = null;

    private $connection = null;
    private $dsn = "mysql:host=localhost;dbname=patrick_db";
    private $username = "admin";
    private $password = "root";

    public function connect() {
        try {
            $this->connection = new PDO($this->dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Throwable $th) {
            echo "ERROR" . $th->getMessage();
            $this->connection = null;
            return null;
        }
    }

    private function query($sql) {
        $pdo = $this->connection;

        try {
            $results = $pdo->query($sql);
        } catch (\Throwable $e) {
            echo "ERROR: " . $e->getMessage();
        }

        return $results;
    }

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DaoSingleton();
        }
        
        return self::$instance;
    }

    public function findUserByEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $results = $this->query($sql);

        return $results->fetch(PDO::FETCH_ASSOC);
    }




}

?>