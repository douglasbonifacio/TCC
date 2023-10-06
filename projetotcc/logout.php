<?php
// Inicialize a sessão
session_start();

// Destrua todas as variáveis de sessão
session_destroy();

// Redirecione para a página de login
header("Location: login.php");
exit;
?>
