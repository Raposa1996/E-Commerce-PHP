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
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido!";
    }
    

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
    <link rel="stylesheet" href="Css/styles.css">
    <link rel="stylesheet" href="styles.css?v=1.0">

    <style>
        .login-container {
    
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    padding: 20px;
    text-align: center;
    margin-top: 100px;
}

.login-container .erro {
    color: #ff4d4d;
    background-color: #ffe6e6;
    padding: 10px;
    border: 1px solid #ffcccc;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}

.login-container form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.login-container label {
    font-weight: bold;
    color: #333;
}

.login-container input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
}

.login-container input:focus {
    border-color: #007bff;
}

.login-container button {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-container button:hover {
    background-color: #0056b3;
}

.login-container p {
    color: #555;
    font-size: 14px;
}

.login-container p a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

.login-container p a:hover {
    text-decoration: underline;
}
    </style>


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
