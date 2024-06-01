<?php

namespace MVC\Models;

use MVC\Models\Usuarios;
use MVC\Models\Produtos;
use PDO;
use Exception;

class DaoSingleton {

    private static $instance = null;

    private $connection = null;
    private $dsn = "mysql:host=localhost;dbname=txotagay";
    private $username = "admin";
    private $password = "root";

    private function connect() {
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
            $sucess = $stmt->execute($params);
            if (!$sucess) {
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

        if (self::$instance->connection == null) {
            self::$instance->connect();
        }

        return self::$instance;
    }

    // Acesso de dados dos Usuários

    public function saveUser(Usuarios $entity): bool {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?)";
        $params = [$entity->nome, $entity->email, $entity->senha];

        try {
            $this->query($sql, $params);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    public function findUserByEmail($email): ?Usuarios {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $params = [$email];
        $results = $this->query($sql, $params);

        if ($results[0] == null) {
            return null;
        }

        $user = new Usuarios($results[0]['nome'], $results[0]['email'], $results[0]['senha'], $results[0]['id']);

        return $user;
    }

    public function findUserById($id): ?Usuarios {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $params = [$id];
        $results = $this->query($sql, $params);

        if ($results[0] == null) {
            return null;
        }

        $user = new Usuarios($results[0]['nome'], $results[0]['email'], $results[0]['senha'], $results[0]['id']);

        return $user;
    }

    public function getAllUsers(): array {
        $sql = "SELECT * FROM usuarios";
        $results = $this->query($sql);

        if ($results == null) {
            return [];
        }

        $users = [];

        foreach ($results as $row) {
            $user = new Usuarios($row['nome'], $row['email'], $row['senha'], $row['id']);
            array_push($users, $user);
        }
        
        return $users; 
    }

    public function updateUserInfo(Usuarios $entity) {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $params = [$entity->nome, $entity->email, $entity->senha, $entity->id];
        $results = $this->query($sql, $params);

        if ($results == null) {
            return [];
        }
    }


    // Acesso de dados dos Produtos

    public function saveProduct(Produtos $entity): bool {
        $sql = "INSERT INTO produtos (nome, descricao, quantidade, preco, categoria) VALUES (?,?,?,?,?)";
        $params = [
            $entity->nome,
            $entity->descricao,
            $entity->quantidade,
            $entity->preco, 
            $entity->categoria,
        ];

        try {
            $this->query($sql, $params);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    public function findProductById($id): Produtos {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $params = [$id];
        $results = $this->query($sql, $params);

        $produto = new Produtos(
            $results[0]['nome'],
            $results[0]['descricao'],
            $results[0]['quantidade'],
            $results[0]['preco'],
            $results[0]['categoria'],
            $results[0]['id'],
        );  

        return $produto;
    }

    public function findAllProducts(): array {
        $sql = "SELECT * FROM produtos";
        $results = $this->query($sql);

        $produtos = [];

        foreach ($results as $row) {
            $user = new Produtos(
                $row['nome'],
                $row['descricao'],
                $row['quantidade'],
                $row['preco'],
                $row['categoria'],
                $row['id'],
            );
            array_push($produtos, $user);
        }

        return $produtos;
    }

    public function deleteProductById($id): bool {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $params = [$id];

        $sucess = $this->query($sql, $params);

        return $sucess;
    }


    public function saveRecord($userid, $data): bool {
        $serializedData = serialize($data);
        
        $sql = "INSERT INTO historico (userid, data) VALUES (?,?)";
        $params = [$userid, $serializedData];

        try {
            $this->query($sql, $params);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }
    public function getAllRecords($userid) {
        $sql = "SELECT * FROM historico WHERE userid = ?";
        $params = [$userid];
        $results = $this->query($sql, $params);

        $records = [];

        foreach ($results as $row) {
            $record = unserialize($row['data']);
            array_push($records, $record);
        }

        return $records;
    }
}
