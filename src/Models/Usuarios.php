<?php

namespace MVC\Models;

class Usuarios {
    public $nome;
    public $email;
    public $senha;

    public function __construct($nome, $email, $senha) {
        if (empty($nome) || empty($email) || empty($senha)) {
            throw new \Exception("Nome, email e senha são obrigatórios");
        }

        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }
}
    