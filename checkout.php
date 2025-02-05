<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h2>Finalizar Compra</h2>
    <form action="http://localhost/E-Commerce-PHP/processar_pagamento.php" method="POST">
        <label for="valor">Valor:</label>
        <input type="text" id="valor" name="valor" value="100">
        <button type="submit">Pagar</button>
    </form>
</body>
</html>
