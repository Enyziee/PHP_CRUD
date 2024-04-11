<?php

namespace MVC\Controllers;

use MVC\Controller;
use MVC\Models\DaoSingleton;
use MVC\Models\Produtos;
use MVC\Models\Usuarios;

class ProdutosController extends Controller {
    public function index() {
        $this->render('produtos/index');
    }

    public function showCreateProduct() {
        $this->render('produtos/create');
    }

    public function createProduct() {
        $dao = DaoSingleton::getInstance();

        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $categoria = $_POST['categoria'];

        $produto = new Produtos(
            $nome,
            $descricao,
            $quantidade,
            $preco,
            $categoria
        );

        $sucess = $dao->saveProduct($produto);
        if ($sucess) {
            header('Location: /produtos');
        } else {
            echo "Erro ao salvar o produto";
        }

    }

    public function deleteProduct() {
        $dao = DaoSingleton::getInstance();

        $id = $_GET['id'];

        $sucess = $dao->deleteProductById($id);
        if ($sucess) {
            header('Location: /produtos');
        } else {
            echo "Erro ao deletar o produto";
        }
    }
}