<?php
session_start(); // Inicia a sessão

// Verifica se os dados do produto foram passados
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['price'])) {
    $productId = $_POST['id'];
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];
    $productQuantity = 1; // Quantidade inicial, você pode modificar isso conforme o que for enviado

    // Verifica se já existe um carrinho na sessão
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Se não existir, cria um carrinho vazio
    }

    // Verifica se o produto já está no carrinho
    $productFound = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += $productQuantity; // Se já estiver no carrinho, aumenta a quantidade
            $productFound = true;
            break;
        }
    }

    // Se o produto não estiver no carrinho, adiciona ele
    if (!$productFound) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'quantity' => $productQuantity
        ];
    }

    // Redireciona de volta para a página de produtos ou para o modal
    header('Location: produtos.php'); // Ou outra página, dependendo do seu fluxo
    exit();
} else {
    // Se os dados não foram enviados corretamente
    echo "Erro: Dados do produto não encontrados.";
}
?>

