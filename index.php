<?php
session_start();

// Verificar se o usuário está logado, caso contrário, redirecionar para a página de login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para login se não estiver logado
    exit();
}

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'ecommerce');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Buscar todos os produtos
$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Online - Bem-vindo</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos do carrossel */
        .carrossel {
            position: relative;
            overflow: hidden;
            width: 150%;
            max-width: 800px;
            margin: 0 auto;
        }
        .carrossel-slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carrossel-slide {
            min-width: 100%;
        }
        .carrossel-slide img {
            width: 100%;
            display: block;
        }
        .carrossel-controle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 1.5rem;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }
        .carrossel-controle.anterior {
            left: 10px;
        }
        .carrossel-controle.proximo {
            right: 10px;
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
            <a href="produtos.php" class="nav-link">Produtos</a>
            <a href="sobre.html" class="nav-link">Sobre</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>
           
        </nav>
    </div>
</header>


    <!-- Seção Principal -->
    <main>
        <section class="index-container">
            <div class="carrossel">
                <div class="carrossel-slides">
                    <div class="carrossel-slide">
                        <img src="https://static.netshoes.com.br/produtos/camiseta-adidas-essentials-big-logo-masculina/26/2FW-4626-026/2FW-4626-026_zoom1.jpg?ts=1695153136&ims=544x" alt="Imagem 1">
                    </div>
                    <div class="carrossel-slide">
                        <img src="https://images.tcdn.com.br/img/img_prod/311840/camiseta_adidas_ess_3_listras_feminina_branca_105309_1_90eb9dbed4eebc67391cc071ab461820.jpg" alt="Imagem 2">
                    </div>
                    <div class="carrossel-slide">
                        <img src="https://images.tcdn.com.br/img/img_prod/311840/camiseta_adidas_tiro_24_branca_e_preta_123734_2_afddee1d6e27f6e4ba83f947f07e3a18.jpg" alt="Imagem 3">
                    </div>
                </div>
                <button class="carrossel-controle anterior">&#10094;</button>
                <button class="carrossel-controle proximo">&#10095;</button>
            </div>

            <div class="texto-introducao">
    <div class="baloon">
        <h2>Sobre Nossa Loja</h2>
        <p>Bem-vindo à Loja Online! Aqui você encontra uma ampla variedade de produtos de alta qualidade a preços acessíveis.</p>
        <p>Nossa missão é oferecer a melhor experiência de compras, com atendimento de excelência e entrega rápida.</p>
    </div>
</div>


        </section>
    </main>

    <!-- Rodapé -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Loja Online. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        const slides = document.querySelector('.carrossel-slides');
        const slide = document.querySelectorAll('.carrossel-slide');
        const anterior = document.querySelector('.carrossel-controle.anterior');
        const proximo = document.querySelector('.carrossel-controle.proximo');

        let indiceAtual = 0;

        function mostrarSlide(index) {
            const largura = slide[0].clientWidth;
            slides.style.transform = `translateX(${-index * largura}px)`;
        }

        anterior.addEventListener('click', () => {
            indiceAtual = (indiceAtual === 0) ? slide.length - 1 : indiceAtual - 1;
            mostrarSlide(indiceAtual);
        });

        proximo.addEventListener('click', () => {
            indiceAtual = (indiceAtual === slide.length - 1) ? 0 : indiceAtual + 1;
            mostrarSlide(indiceAtual);
        });

        // Rotação automática (opcional)
        setInterval(() => {
            proximo.click();
        }, 5000); // Troca de slide a cada 5 segundos
    </script>
</body>
</html>

<?php
$conn->close();
?>
