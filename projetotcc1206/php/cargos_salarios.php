<html>
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

// Consulta o banco de dados para obter as informações do funcionário e da função
$sql = "SELECT tfuncionarios.*, tfuncoes.cargo, tfuncoes.salario
        FROM tfuncionarios
        INNER JOIN tusuarios ON tfuncionarios.id = tusuarios.id
        INNER JOIN tfuncoes ON tfuncionarios.funcao_id = tfuncoes.id
        WHERE tusuarios.login = '$login'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Exibe as informações do funcionário e da função
    echo "<h1>Informações do Funcionário</h1>";
    echo "<p>Nome: " . $row['nome'] . "</p>";
    echo "<p>Data de Nascimento: " . $row['data_nascimento'] . "</p>";
    echo "<p>Telefone: " . $row['telefone'] . "</p>";
    echo "<h1>Informações da Função</h1>";
    echo "<p>Cargo: " . $row['cargo'] . "</p>";
    echo "<p>Salário: " . $row['salario'] . "</p>";
    // Exiba outras informações do funcionário e da função conforme necessário
} else {
    echo "<h1>Informações do Funcionário não encontradas</h1>";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
    <head>
        <link rel="stylesheet" href="../css/cargos_salarios.css">
    </head>
</html>
