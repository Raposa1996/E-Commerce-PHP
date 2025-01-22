<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'ecommerce');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Loja Online</title>
    <link rel="stylesheet" href="styles.css">
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
            <a href="produtos.php" class="nav-link">Produtos</a>
            <a href="sobre.html" class="nav-link">Sobre</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                
            <?php endif; ?>
            </a>
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
                    <img src="imagens/produto1.jpg" alt="Camisetas" class="categoria-imagem">
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

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2025 Loja Online</p>
    </footer>
</body>
</html>
