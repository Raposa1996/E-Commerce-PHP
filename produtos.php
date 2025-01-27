<?php
session_start(); // Inicia a sessão

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'ecommerce');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Função para obter o número de itens no carrinho
function getCartCount() {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        return array_sum(array_column($_SESSION['cart'], 'quantity'));
    }
    return 0;
}

$cartCount = getCartCount(); // Obtém a quantidade de itens no carrinho
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Loja Online</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos gerais */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .logo a {
            color: #fff;
            text-decoration: none;
            font-size: 24px;
        }

        .navbar .nav-link {
            margin-right: 15px;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar .nav-link:hover {
            text-decoration: underline;
        }

        /* Botão do carrinho */
        .cart-button {
            background-color: #e67e22;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .cart-button:hover {
            background-color: #d35400;
        }

        /* Modal do carrinho */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .modal-content h2 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
        }

        .modal-content .close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Tabela do carrinho */
        .modal-content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .modal-content th,
        .modal-content td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .modal-content th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* Total do carrinho */
        #cartTotal {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }

        /* Botões do carrinho */
        .modal-content .btn {
            display: inline-block;
            background-color: #27ae60;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            margin-top: 20px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .modal-content .btn:hover {
            background-color: #2ecc71;
        }

        .modal-content .btn[style*="background-color: #e74c3c;"] {
            background-color: #e74c3c;
        }

        .modal-content .btn[style*="background-color: #e74c3c;"]:hover {
            background-color: #c0392b;
        }

        /* Categorias */
        .categorias-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
        }

        .categoria {
            margin: 10px;
            text-align: center;
        }

        .categoria a {
            text-decoration: none;
            color: #2c3e50;
        }

        .categoria img {
            width: 300px;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .categoria img:hover {
            transform: scale(1.05);
        }

        /* Modal de Login */
        .modal-login {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .modal-login-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-login .btn-login {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal-login .btn-login:hover {
            background-color: #45a049;
        }

        .modal-login .btn-close {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="header-container">
            <!-- Logotipo -->
            <h1 class="logo">
                <a href="index.php">🛍️ Loja Online</a>
            </h1>
            
            <!-- Barra de Navegação -->
            <nav class="navbar">
                <a href="index.php" class="nav-link">Inicio</a>
                <a href="produtos.php" class="nav-link">Produtos</a>
                <a href="sobre.html" class="nav-link">Sobre</a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="logout.php" class="nav-link">Logout</a>
                <?php endif; ?>
                
                <!-- Carrinho de Compras -->
                <div>
                    <button class="cart-button" onclick="openCart()">🛒 Carrinho (<span id="cartCount">0</span>)</button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Container das Categorias -->
    <main>
        <h2>Escolha uma Categoria</h2>
        <div class="categorias-container">
            <!-- Categoria: Camisetas -->
            <div class="categoria">
                <a href="camisetas.html">
                    <img src="imagens/imagem9.webp" alt="Camisetas" class="categoria-imagem">
                    <h3>Camisetas</h3>
                </a>
            </div>

            <!-- Categoria: Tênis -->
            <div class="categoria">
                <a href="tenis.html">
                    <img src="imagens/produto2.jpg" alt="Tênis" class="categoria-imagem">
                    <h3>Tênis</h3>
                </a>
            </div>

            <!-- Categoria: Calças -->
            <div class="categoria">
                <a href="calcas.html">
                    <img src="imagens/produto5.jpg" alt="Calças" class="categoria-imagem">
                    <h3>Calças</h3>
                </a>
            </div>
        </div>
    </main>

    <!-- Modal Carrinho -->
    <div class="modal" id="cartModal">
        <div class="modal-content">
            <button class="close" onclick="closeCart()">X</button>
            <h2>Seu Carrinho</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="cartItems"></tbody>
            </table>
            <p id="cartTotal">Total: R$ 0,00</p>
            <button class="btn" onclick="checkout()">Finalizar Compra</button>
            <button class="btn" style="background-color: #e74c3c;" onclick="clearCart()">Limpar Carrinho</button>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal-login" id="loginModal">
        <div class="modal-login-content">
            <h3>Você precisa estar logado para finalizar a compra!</h3>
            <button class="btn-login" onclick="window.location.href='login.php'">Fazer Login</button>
            <button class="btn-close" onclick="closeLoginModal()">Fechar</button>
        </div>
    </div>

    <script>
        let cart = [];

        // Função para adicionar item ao carrinho
        function addToCart(item, price) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(entry => entry.item === item);

            if (existingItem) {
                existingItem.quantity++;
                existingItem.total = existingItem.quantity * existingItem.price;
            } else {
                cart.push({ item, price, quantity: 1, total: price });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
        }

        // Função para atualizar o carrinho
        function updateCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartCount = cart.reduce((count, entry) => count + entry.quantity, 0);
            document.getElementById('cartCount').innerText = cartCount;

            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = cart
                .map(entry => `
                    <tr>
                        <td>${entry.item}</td>
                        <td>${entry.quantity}</td>
                        <td>R$ ${entry.price.toFixed(2)}</td>
                        <td>R$ ${entry.total.toFixed(2)}</td>
                    </tr>
                `)
                .join('');

            const total = cart.reduce((sum, entry) => sum + entry.total, 0);
            document.getElementById('cartTotal').innerText = `Total: R$ ${total.toFixed(2)}`;
        }

        // Função para abrir o carrinho
        function openCart() {
            document.getElementById('cartModal').style.display = 'flex';
        }

        // Função para fechar o carrinho
        function closeCart() {
            document.getElementById('cartModal').style.display = 'none';
        }

        // Função para checkout
        function checkout() {
            if (!<?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>) {
                openLoginModal();
            } else {
                alert('Compra finalizada com sucesso!');
                localStorage.removeItem('cart');
                updateCart();
                closeCart();
            }
        }

        // Função para limpar o carrinho
        function clearCart() {
            if (confirm('Você tem certeza de que deseja limpar o carrinho?')) {
                localStorage.removeItem('cart');
                updateCart();
                alert('Carrinho limpo com sucesso!');
            }
        }

        // Função para abrir o modal de login
        function openLoginModal() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        // Função para fechar o modal de login
        function closeLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Atualizar o carrinho ao carregar a página
        window.onload = function () {
            updateCart();
        };
    </script>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2025 Loja Online</p>
    </footer>
</body>
</html>
