<?php
session_start();

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'ecommerce');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Inserir feedback no banco de dados
if (isset($_POST['enviar_feedback'])) {
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $data_hora = date('Y-m-d H:i:s');

    $sql_inserir_feedback = "INSERT INTO feedbacks (comentario, data_hora) VALUES ('$comentario', '$data_hora')";
    if ($conn->query($sql_inserir_feedback) === TRUE) {
        echo "<script>alert('Obrigado pelo seu feedback!');</script>";
    } else {
        echo "<script>alert('Erro ao enviar feedback. Tente novamente.');</script>";
    }
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
    <link rel="stylesheet" href="Css/styles.css">
    <style>
        /* Estilos do carrossel principal */

        header nav a {
    color: #484646;
    margin: 0 15px;
    text-decoration: none;
    font-size: 1.4em;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    transition: color 0.3s ease, transform 0.2s ease, text-shadow 0.3s ease;
    position: relative;
}

/* Efeito ao passar o mouse */
header nav a:hover {
    color: #0073e6; /* Azul vibrante */
    transform: scale(1.1); /* Leve aumento */
    text-shadow: 3px 3px 6px rgba(0, 115, 230, 0.5); /* Sombra azul brilhante */
}

/* Adicionando sublinhado animado */
header nav a::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: -3px;
    width: 0;
    height: 3px;
    background: #0073e6;
    transition: width 0.3s ease, left 0.3s ease;
}

/* Exibir sublinhado ao passar o mouse */
header nav a:hover::after {
    width: 100%;
    left: 0;
}


/* Efeito ao passar o mouse */
header nav a:hover {
    color: #0073e6; /* Azul vibrante */
    transform: scale(1.1); /* Leve aumento */
    text-shadow: 3px 3px 6px rgba(0, 115, 230, 0.5); /* Sombra azul brilhante */
}

/* Adicionando sublinhado animado */
header nav a::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: -3px;
    width: 0;
    height: 3px;
    background:rgb(28, 111, 193);
    transition: width 0.3s ease, left 0.3s ease;
}

/* Exibir sublinhado ao passar o mouse */
header nav a:hover::after {
    width: 100%;
    left: 0;
}
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

        /* Estilos do segundo carrossel */
        .carrossel-vertical {
            position: relative;
            overflow: hidden;
            max-width: 800px;
            margin: 20px auto;
        }
        .carrossel-vertical-slides {
            display: flex;
            justify-content: space-between;
            transition: transform 0.5s ease-in-out;
        }
        .carrossel-vertical-slide {
            flex: 1;
            margin: 0 10px;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .carrossel-vertical-slide img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .carrossel-vertical-controle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 1.5rem;
            padding: 0.5rem 1rem;
            cursor: pointer;
            z-index: 1;
        }
        .carrossel-vertical-controle.anterior {
            left: -5%;
        }
        .carrossel-vertical-controle.proximo {
            right: -5%;
        }

        .feedback-section {
    background-color: #f9f9f9;
    padding: 20px;
    margin: 20px auto;
    max-width: 800px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

    /* Estilização do formulário */
    .feedback-section form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

    .feedback-section textarea {
    width: 100%;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    resize: none;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    font-family: 'Arial', sans-serif;
}

    .feedback-section textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: inset 0 4px 8px rgba(0, 123, 255, 0.1);
}

    /* Botão de envio */
    .feedback-section button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s;
    font-family: 'Arial', sans-serif;
}

    .feedback-section button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

    .feedback-section button:active {
    background-color: #004085;
    transform: scale(1);
}

    /* Lista de feedbacks */
    .feedback-list {
    margin-top: 20px;
    padding: 10px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-height: 300px;
    overflow-y: auto;
}

    .feedback-list p {
    margin: 10px 0;
    padding: 10px;
    border-bottom: 1px solid #eee;
    font-family: 'Arial', sans-serif;
}

    .feedback-list p:last-child {
    border-bottom: none;
}

    .feedback-list strong {
    color: #007bff;
    font-weight: bold;
}

    /* Responsividade */
    @media (max-width: 600px) {
    .feedback-section {
        padding: 15px;
    }

    .feedback-section textarea {
        font-size: 14px;
    }

    .feedback-section button {
        font-size: 14px;
        padding: 10px;
    }
}

        
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="header-container">
            <h1 class="logo">
                <a href="index.php">🛍️ Loja Online</a>
            </h1>
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

    <!-- Carrossel Principal -->
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
        </section>

        <!-- Segundo Carrossel -->
        <section class="carrossel-vertical">
            <button class="carrossel-vertical-controle anterior">&#10094;</button>
            <div class="carrossel-vertical-slides">
                <div class="carrossel-vertical-slide">
                    <img src="https://i.pinimg.com/564x/a7/2f/4c/a72f4c83fabe74fecc7de00db1773aaf.jpg" alt="Imagem Vertical 1">
                </div>
                <div class="carrossel-vertical-slide">"
                    <img src="https://i.pinimg.com/564x/2d/a0/4d/2da04db548668631acf75b8085a2789f.jpg" alt="Imagem Vertical 2">
                </div>
                <div class="carrossel-vertical-slide">
                    <img src="https://i.pinimg.com/564x/14/d3/26/14d3266bc1d2162fb4225542fce98ef5.jpg" alt="Imagem Vertical 3">
                </div>
            </div>
            <button class="carrossel-vertical-controle proximo">&#10095;</button>
        </section>

        <section class="feedback-section">
    <div class="container">
        <h2>Deixe seu Feedback</h2>
        <form action="" method="post">
            <textarea name="comentario" rows="5" placeholder="Escreva seu comentário aqui..." required></textarea>
            <br>
            <button type="submit" name="enviar_feedback">Enviar Feedback</button>
        </form>
        <hr>
        <h3>Feedbacks Recentes</h3>
        <div class="feedback-list">
            <?php
            // Buscar feedbacks no banco de dados
            $sql_feedbacks = "SELECT comentario, data_hora FROM feedbacks ORDER BY data_hora DESC LIMIT 5";
            $result_feedbacks = $conn->query($sql_feedbacks);

            if ($result_feedbacks->num_rows > 0) {
                while ($row = $result_feedbacks->fetch_assoc()) {
                    echo "<p><strong>" . date('d/m/Y H:i', strtotime($row['data_hora'])) . "</strong>: " . htmlspecialchars($row['comentario']) . "</p>";
                }
            } else {
                echo "<p>Sem feedbacks ainda. Seja o primeiro a comentar!</p>";
            }
            ?>
        </div>
    </div>
</section>

    </main>

    <!-- Scripts -->
    <script>

        // Lógica para o carrossel principal com rotação automática
const carrosselSlides = document.querySelector('.carrossel-slides');
const carrosselSlide = document.querySelectorAll('.carrossel-slide');
const anterior = document.querySelector('.carrossel-controle.anterior');
const proximo = document.querySelector('.carrossel-controle.proximo');

let indiceAtual = 0;
const intervalo = 3000; // Tempo em milissegundos para trocar as imagens (3 segundos)

function mostrarSlide(index) {
    const largura = carrosselSlide[0].clientWidth;
    carrosselSlides.style.transform = `translateX(${-index * largura}px)`;
}

// Funções para avançar e voltar
function avancarSlide() {
    indiceAtual = (indiceAtual === carrosselSlide.length - 1) ? 0 : indiceAtual + 1;
    mostrarSlide(indiceAtual);
}

function voltarSlide() {
    indiceAtual = (indiceAtual === 0) ? carrosselSlide.length - 1 : indiceAtual - 1;
    mostrarSlide(indiceAtual);
}

// Adicionar eventos nos botões
anterior.addEventListener('click', voltarSlide);
proximo.addEventListener('click', avancarSlide);

// Configurar rotação automática
let intervaloRotacao = setInterval(avancarSlide, intervalo);

// Pausar o carrossel quando o usuário interagir
document.querySelector('.carrossel').addEventListener('mouseenter', () => {
    clearInterval(intervaloRotacao); // Para a rotação automática ao passar o mouse
});

document.querySelector('.carrossel').addEventListener('mouseleave', () => {
    intervaloRotacao = setInterval(avancarSlide, intervalo); // Retoma a rotação automática ao sair com o mouse
});

        // Lógica para o segundo carrossel
        const verticalSlides = document.querySelector('.carrossel-vertical-slides');
        const verticalSlide = document.querySelectorAll('.carrossel-vertical-slide');
        const verticalAnterior = document.querySelector('.carrossel-vertical-controle.anterior');
        const verticalProximo = document.querySelector('.carrossel-vertical-controle.proximo');

        let verticalIndiceAtual = 0;

        function mostrarVerticalSlide(index) {
            const largura = verticalSlide[0].clientWidth;
            verticalSlides.style.transform = `translateX(${-index * (largura + 20)}px)`; // 20px é o espaço entre os cards
        }

        verticalAnterior.addEventListener('click', () => {
            verticalIndiceAtual = (verticalIndiceAtual === 0) ? verticalSlide.length - 1 : verticalIndiceAtual - 1;
            mostrarVerticalSlide(verticalIndiceAtual);
        });

        verticalProximo.addEventListener('click', () => {
            verticalIndiceAtual = (verticalIndiceAtual === verticalSlide.length - 1) ? 0 : verticalIndiceAtual + 1;
            mostrarVerticalSlide(verticalIndiceAtual);
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
