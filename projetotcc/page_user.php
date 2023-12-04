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

// Consulta o banco de dados para obter as informações do funcionário, incluindo o tipo de usuário
$sql = "SELECT tfuncionarios.nome AS nomeFuncionario, tusuarios.foto_caminho AS foto, tusuarios.tipo AS tipoUsuario
        FROM tfuncionarios
        INNER JOIN tusuarios ON tfuncionarios.id = tusuarios.id_funcionario
        WHERE tusuarios.login = '$login'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeFuncionario = $row['nomeFuncionario'];
    $fotoCaminho = $row['foto']; // Caminho da foto
    $tipoUsuario = $row['tipoUsuario']; // Tipo de usuário
} else {
    $nomeFuncionario = "Nome de usuário não encontrado";
    $fotoCaminho = ""; // Se a foto não for encontrada, deixe o caminho em branco
    $tipoUsuario = ""; // Se o tipo de usuário não for encontrado, deixe em branco
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
    <link rel="stylesheet" href="css/page_user.css">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
        <img class="avatar" src="<?= $fotoCaminho ?>"> <!-- Inserir o caminho da foto aqui -->

        <div class="sidebar-header-title">Bem-vindo <?php echo $nomeFuncionario; ?></div>
        <a href="#" class="sidebar-toggle">
            <i class="bi bi-chevron-left"></i>
        </a>
    </div>
    <div class="sidebar-content">
        <!-- Resto do seu código aqui -->
        <div class="sidebar-menu">
            <a href="#" class="active">
                <i class="bi bi-house-door"></i>
                <span>Home</span>
            </a>
            <a href="holerites.php">
                <i class="bi bi-card-heading"></i>
                <span>Holerites</span>
            </a>
            <a href="cargos_salarios.php">
                <i class="bi bi-cash-coin"></i>
                <span>Cargos e Salários</span>
            </a>
            <a href="ferias.php">
                <i class="bi bi-calendar3"></i>
                <span>Férias</span>
            </a>
            <a href="controle_ponto.php">
                <i class="bi bi-calendar2"></i>
                <span>Jornada</span>
            </a>
            <?php
            // Verifica se o tipo de usuário é "administrador"
            if ($tipoUsuario === 'administrador') {
                echo '<a href="administrador.php">
                        <i class="bi bi-card-checklist"></i>
                        <span>Administrador</span>
                    </a>';
            } else {
                echo '<a href="javascript:void(0);" disabled>
                        <i class="bi bi-card-checklist"></i>
                        <span>Administrador</span>
                    </a>';
            }
            ?>
        </div>
    </div>

    <div class="conteudo">
            <h1>Mural de Recados</h1>

            <p><i class="bi bi-balloon-heart-fill"></i> Agradecimento a todos os professores e funcionários da Etec.</p>
            <p><i class="bi bi-snow2"></i> Desejamos um feliz natal e prospero ano novo a todos!</p>
            <p><i class="bi bi-currency-exchange"></i> Segunda parte do décimo terceiro estara liberado dia 20</p>
            <p><i class="bi bi-clipboard-plus-fill"></i> Estamos há 100 dias sem acidentes.</p>
    </div>
    
    <div class="sidebar-footer">
        <!-- Resto do seu código aqui -->
        <div class="sidebar-menu">
            <a href="logout.php">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>

<script>
    // Seu código JavaScript aqui
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
