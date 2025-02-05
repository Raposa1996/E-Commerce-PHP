<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'ecommerce');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$erro = ''; // Inicializa a variável de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Sanitizar entradas
    $nome = mysqli_real_escape_string($conn, $nome);
    $email = mysqli_real_escape_string($conn, $email);
    $senha = mysqli_real_escape_string($conn, $senha);

    // Verificar se o e-mail já está cadastrado
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $erro = "E-mail já cadastrado!";
    } else {
        // Verificação simples de complexidade de senha
        if (strlen($senha) < 8) {
            $erro = "A senha deve ter pelo menos 8 caracteres.";
        } else {
            // Criptografar a senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir o novo usuário no banco de dados
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nome, $email, $senha_hash);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redireciona para a página de login após o cadastro
                header('Location: login.php');  
                exit();
            } else {
                $erro = "Erro ao cadastrar usuário!";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="Css/styles.css">
    <style>
    /* Resetando margens e padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
header h1 {
    color: #007BFF;
    text-align: center;
    margin-top: 100px;
    text-shadow: 0 0 5px #007BFF, 0 0 10px #00a2ff, 0 0 15px #00c3ff;
}


/* Estilizando o container */
.cadastro-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.2); /* Fundo levemente transparente */
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(8px); /* Aplica desfoque */
    -webkit-backdrop-filter: blur(8px); /* Compatibilidade com navegadores */
}


/* Estilizando o erro */
.erro {
    color: #ff4d4d;
    background-color: #ffe6e6;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ff4d4d;
    border-radius: 4px;
}

/* Estilizando os labels */
label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

/* Estilizando os inputs */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

/* Estilizando o botão */
button {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

/* Estilizando o link de login */
p {
    text-align: center;
    margin-top: 15px;
    font-weight: bold;
}

p a {
    color: #007BFF;
    text-decoration: none;
}

p a:hover {
    text-decoration: underline;
}

</style>
    
</head>
<body>

    <header>
        <h1>Cadastro</h1>
    </header>

    <div class="cadastro-container">
        <?php if (!empty($erro)): ?>
            <p class="erro"><?= $erro; ?></p>
        <?php endif; ?>

        <form action="cadastro.php" method="POST">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" required placeholder="Seu nome completo">

            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required placeholder="Seu e-mail">

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required placeholder="Sua senha">

            <button type="submit">Cadastrar</button>
        </form>

        <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </div>

</body>
</html>
