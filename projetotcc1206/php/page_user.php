<?php
session_start();

// Verifica se a sessão está ativa e se o token de sessão é válido
if (!isset($_SESSION['login']) || empty($_SESSION['login']) || !isset($_SESSION['token']) || $_SESSION['token'] !== $_COOKIE['token']) {
    // Redireciona para a página de login se a sessão não estiver ativa ou o token de sessão for inválido
    header("Location: login.php");
    exit;
}

// Recupera o login do usuário atual
$login = $_SESSION['login'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbteste";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta o banco de dados para obter as informações do funcionário
$sql = "SELECT tfuncionarios.nome AS nomeFuncionario
        FROM tfuncionarios
        INNER JOIN tusuarios ON tfuncionarios.id = tusuarios.id
        WHERE tusuarios.login = '$login'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeFuncionario = $row['nomeFuncionario'];
} else {
    $nomeFuncionario = "Nome de usuário não encontrado";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Página do Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/page_user.css">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
        <img class="avatar" src="../img/avatar.png" alt="">
        <div class="sidebar-header-title">Bem-vindo <?php echo $nomeFuncionario; ?></div>
        <a href="#" class="sidebar-toggle">
            <i class="bi bi-chevron-left"></i>
        </a>
    </div>
    <div class="sidebar-content">
        <div class="sidebar-menu">
            <a href="#" class="active">
                <i class="bi bi-house-door"></i>
                <span>Home</span>
            </a>
            <a href="../html/holerite.html">
                <i class="bi bi-card-heading"></i>
                <span>Holerites</span>
            </a>
            <a href="cargos_salarios.php">
                <i class="bi bi-cash-coin"></i>
                <span>Cargos e Salários</span>
            </a>
            <a href="agendar_ferias.php">
                <i class="bi bi-calendar3"></i>
                <span>Férias</span>
            </a>
            <a href="controle_ponto.php">
                <i class=""></i>
                <span>Jornada</span>
            </a>
        </div>
    </div>
    <div class="sidebar-footer">
        <div class="sidebar-menu">
            <a href="../html/form.html">
                <i class="bi bi-card-checklist"></i>
                <span>Administrador</span>
            </a>
            <a href="logout.php">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>
<script>
    const sidebar = document.querySelector('.sidebar')
    const sidebarToggleBtn = document.querySelector('.sidebar-toggle')

    sidebarToggleBtn
    .onclick = (e) => {
        e.preventDefault();
        sidebar.classList.toggle('sidebar-small');
    };

    window.onresize = () => {
        if (window.innerWidth < 600) {
            sidebar.classList.add('sidebar-small');
        } else {
            sidebar.classList.remove('sidebar-small');
        }
    };
</script>
</body>
</html>
