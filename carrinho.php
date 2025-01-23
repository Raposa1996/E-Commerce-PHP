<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
</head>
<body>

<h2>Seu Carrinho</h2>

<?php if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalGeral = 0;
            foreach ($_SESSION['carrinho'] as $produto):
                $totalGeral += $produto['total'];
            ?>
                <tr>
                    <td><?php echo $produto['item']; ?></td>
                    <td><?php echo $produto['quantidade']; ?></td>
                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td>R$ <?php echo number_format($produto['total'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Total: R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></p>
    <a href="finalizar_compra.php">Finalizar Compra</a>
<?php else: ?>
    <p>Seu carrinho está vazio.</p>
<?php endif; ?>

</body>
</html>

