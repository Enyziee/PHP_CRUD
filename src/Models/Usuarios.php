<?php

namespace MVC\Models;

class Usuarios {
    public $id;
    public $nome;
    public $email;
    public $role;
    public $senha;

    public function __construct($nome, $email, $senha, $role = 'user', $id = null) {
        if (empty($nome) || empty($email) || empty($senha)) {
            throw new \Exception("Missing parameters for user creation");
        }

        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->role = $role;
        $this->senha = $senha;
    }
}
    