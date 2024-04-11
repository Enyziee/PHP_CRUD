<?php 

namespace MVC\Models;

use MVC\Models\Usuarios;
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

    private function query($sql, $params = null) {
        $pdo = $this->connection;

        try {
            $stmt = $pdo->prepare($sql);
            $err = $stmt->execute($params);
            if (!$err) {
                throw new \Exception("Erro ao executar a query");
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Throwable $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DaoSingleton();
        }
        
        return self::$instance;
    }

    // Acesso de dados dos Usuários

    public function saveUser(Usuarios $entity) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?)";
        $params = [$entity->nome, $entity->email, $entity->senha];
        
        $this->query($sql, $params);
    }

    public function findUserByEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $params = [$email];
        $results = $this->query($sql, $params);
        
        return $results;
    }

}

?>