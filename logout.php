<?php
session_start();

// Verificar se o usuário está logado
if (isset($_SESSION['usuario_id'])) {
    // Destruir a sessão e limpar os dados
    session_unset();  // Remove todas as variáveis de sessão
    session_destroy();  // Destroi a sessão

    // Redirecionar para a página de login ou para a página inicial
    header('Location: login.php');  // Ou substitua 'login.php' por 'index.php' se preferir redirecionar para a página inicial
    exit();
} else {
    // Caso o usuário não esteja logado, redirecionar para a página de login
    header('Location: login.php');
    exit();
}
?>
