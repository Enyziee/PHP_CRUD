<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>
    <?php
        use MVC\Models\DaoSingleton;

        $dao = DaoSingleton::getInstance();
        $produtos = $dao->findAllProducts();

        if (!$produtos) {
            echo '<h2>Sem produtos!</h2>';
        } else {
            foreach($produtos as $produto) {
                echo "<h3>{$produto->nome}</h3>";
                echo "<p>Preço: {$produto->preco}</p>";
                echo "<p>Descrição: {$produto->descricao}</p>";
                echo "<p>Quantidade: {$produto->quantidade}</p>";
                echo "<p>Categoria: {$produto->categoria}</p>";
                echo "<hr>";
                echo "<hr>";
            }
        }
    ?>
</body>
</html>