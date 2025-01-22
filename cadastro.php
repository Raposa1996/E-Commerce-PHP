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
    <link rel="stylesheet" href="styles.css">
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
