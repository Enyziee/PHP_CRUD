<?php

namespace MVC\Models;

class Produtos {
    public $id;
    public $nome;
    public $descricao;
    public $quantidade;
    public $preco;
    public $categoria;

    public function __construct($nome, $descricao, $quantidade, $preco, $categoria, $id = null) {
        if (empty($nome) || empty($descricao) || empty($quantidade) || empty($preco) || empty($categoria)) {
            throw new \Exception("Todos os campos são obrigatórios");
        }

        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
        $this->categoria = $categoria;
    }

}