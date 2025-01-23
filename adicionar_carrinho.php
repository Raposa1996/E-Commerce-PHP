<?php
session_start(); // Inicia a sessão

// Verifica se o carrinho já foi criado na sessão
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona item ao carrinho
$item = $_POST['item'];
$preco = $_POST['preco'];

// Verifica se o item já está no carrinho
$itemExiste = false;
foreach ($_SESSION['carrinho'] as &$produto) {
    if ($produto['item'] == $item) {
        $produto['quantidade']++;
        $produto['total'] = $produto['quantidade'] * $produto['preco'];
        $itemExiste = true;
        break;
    }
}

if (!$itemExiste) {
    $_SESSION['carrinho'][] = [
        'item' => $item,
        'preco' => $preco,
        'quantidade' => 1,
        'total' => $preco
    ];
}

// Redireciona para a página do carrinho
header('Location: carrinho.php');
exit();
?>

