<?php
session_start();

// Verifica se a sessão está ativa e se o token de sessão é válido
if (
    !isset($_SESSION['login']) ||
    empty($_SESSION['login']) ||
    !isset($_SESSION['token']) ||
    $_SESSION['token'] !== $_COOKIE['token']
) {
    // Redireciona para a página de login se a sessão não estiver ativa ou o token de sessão for inválido
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbteste";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulte todas as férias agendadas
$sql = "SELECT f.data_inicio, f.data_fim, u.nome AS nome_funcionario FROM tferias AS f
        JOIN tfuncionarios AS u ON f.funcionario_id = u.id";

$result = $conn->query($sql);

if ($result === false) {
    die("Erro na consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Exibir as férias dos funcionários
    

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        // Certifique-se de que os nomes das colunas correspondam aos nomes da tabela do banco de dados
        echo "<td>" . $row['nome_funcionario'] . "</td>"; // Nome do funcionário
        echo "<td>" . $row['data_inicio'] . "</td>"; // Data de início
        echo "<td>" . $row['data_fim'] . "</td>"; // Data de fim
        echo "</tr>";
    }

} else {
    echo "Nenhuma férias agendada.";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>