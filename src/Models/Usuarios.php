<?php

namespace MVC\Models;

class Usuarios {
    public $id;
    public $nome;
    public $email;
    public $senha;

    public function __construct($nome, $email, $senha, $id = null) {
        if (empty($nome) || empty($email) || empty($senha)) {
            throw new \Exception("Nome, email e senha são obrigatórios");
        }

        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }
}
    