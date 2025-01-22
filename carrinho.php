<?php
session_start();

// Inicializa o carrinho, se ainda não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Calcula o total do carrinho
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'];
}

// Gera o HTML do carrinho
$cartItems = '';
foreach ($_SESSION['cart'] as $item) {
    $cartItems .= "<li>{$item['name']} - R$ " . number_format($item['price'], 2, ',', '.') . "</li>";
}

$response = [
    'items' => $cartItems,
    'total' => "R$ " . number_format($total, 2, ',', '.')
];

echo json_encode($response);
