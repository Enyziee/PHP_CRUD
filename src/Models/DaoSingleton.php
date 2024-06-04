<?php

namespace MVC\Models;

use MVC\Models\Usuarios;
use MVC\Models\Produtos;
use PDO;
use Exception;

class DaoSingleton {

    private static $instance = null;

    private ?PDO $connection = null;
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
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function __construct() {}

    public static function getInstance(): DaoSingleton {
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
        $sql = "INSERT INTO usuarios (nome, email, senha, role) VALUES (?,?,?,?)";
        $params = [$entity->nome, $entity->email, $entity->senha, $entity->role];

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

        $user = new Usuarios(
            $results[0]['nome'],
            $results[0]['email'],
            $results[0]['senha'],
            $results[0]['role'],
            $results[0]['id']
        );

        return $user;
    }

    public function findUserById($id): ?Usuarios {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $params = [$id];
        $results = $this->query($sql, $params);

        if ($results == false || $results[0] == false) {
            return null;
        }

        $user = new Usuarios(
            $results[0]['nome'],
            $results[0]['email'],
            $results[0]['senha'],
            $results[0]['role'],
            $results[0]['id']
        );

        return $user;
    }

    public function getAllUsers(): array {
        $sql = "SELECT * FROM usuarios";
        $results = $this->query($sql);

        if ($results == false) {
            return [];
        }

        $users = [];

        foreach ($results as $row) {
            $user = new Usuarios($row['nome'], $row['email'], $row['senha'], $row['role'], $row['id']);
            array_push($users, $user);
        }
        
        return $users; 
    }

    public function updateUserInfo(Usuarios $entity) {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, role = ? WHERE id = ?";
        $params = [$entity->nome, $entity->email, $entity->role, $entity->id];
        $results = $this->query($sql, $params);

        if ($results == false) {
            null;
        }
    }

    public function deleteUserById(string $id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $params = [$id];
        $this->query($sql, $params);
    }


    public function saveHealthInfo(string $userid, string $sexo, int $peso, int $altura, int $idade) {
        $sql = "INSERT INTO informacoes (userid, sexo, peso, altura, idade) VALUES (?,?,?,?,?)";
        $params = [$userid, $sexo, $peso, $altura, $idade];
        $this->query($sql, $params);
    }

    public function getHealthInfo(string $userid) {
        $sql = "SELECT * FROM informacoes WHERE userid = ?";
        $params = [$userid];
        $results = $this->query($sql, $params);

        if ($results == false) {
            return null;
        }

        return $results[0];
    }

    public function updateHealthInfo($userid, $sexo, $peso, $altura, $idade) {
        $sql = "UPDATE informacoes SET sexo = ?, peso = ?, altura = ?, idade = ? WHERE userid = ?";
        $params = [$sexo, $peso, $altura, $idade, $userid];
        $this->query($sql, $params);
    }
    


}
