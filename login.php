<?php
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');  // Redireciona para a página inicial se já estiver logado
    exit();
}

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'ecommerce');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o e-mail existe
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o e-mail existir, verificar a senha
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        // Verificar a senha usando password_verify
        if (password_verify($senha, $usuario['senha'])) {
            // Senha correta, iniciar a sessão
            $_SESSION['usuario_id'] = $usuario['id'];  // Alterar para 'usuario_id'
            $_SESSION['usuario_nome'] = $usuario['nome']; // Alterar para 'usuario_nome'
            
            header('Location: index.php');  // Redireciona para a página inicial
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "E-mail não encontrado!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles.css?v=1.0">

</head>
<body>

    <header>
        <h1>Login</h1>
    </header>

    <div class="login-container">
        <?php if (isset($erro)): ?>
            <p class="erro"><?= $erro; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required placeholder="Seu e-mail">

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required placeholder="Sua senha">

            <button type="submit">Entrar</button>
        </form>

        <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>

</body>
</html>
