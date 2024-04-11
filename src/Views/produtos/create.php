<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Produto</title>
</head>
<body>
    <form action="saveproduct" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br><br>
        
        <label for="preco">Preço:</label>
        <input type="number" name="preco" id="preco" required><br><br>
        
        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" required><br><br>

        <label for="quantidade">Quantidade:</label>
        <input type="text" name="quantidade" id="quantidade" required><br><br>
        
        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria" required><br><br>

        <input type="submit" value="Criar Produto">
    </form>
</body>
</html>