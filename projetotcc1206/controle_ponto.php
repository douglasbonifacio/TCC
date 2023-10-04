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

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recupera o ID do funcionário com base no login atual
$login = $_SESSION['login'];
$sqlFuncionarioId = "SELECT id FROM tusuarios WHERE login = ?";
$stmtFuncionarioId = $conn->prepare($sqlFuncionarioId);
$stmtFuncionarioId->bind_param("s", $login);
$stmtFuncionarioId->execute();
$resultFuncionarioId = $stmtFuncionarioId->get_result();

if ($resultFuncionarioId->num_rows > 0) {
    $rowFuncionarioId = $resultFuncionarioId->fetch_assoc();
    $funcionarioId = $rowFuncionarioId['id'];
    
    // Consulta o banco de dados para obter os registros de horas do funcionário
    $sqlRegistros = "SELECT * FROM tregistro_horas WHERE funcionario_id = ?";
    $stmtRegistros = $conn->prepare($sqlRegistros);
    $stmtRegistros->bind_param("i", $funcionarioId);
    $stmtRegistros->execute();
    $resultRegistros = $stmtRegistros->get_result();
    
    // Consulta o nome do funcionário com base no ID
    $sqlNomeFuncionario = "SELECT nome FROM tfuncionarios WHERE id = ?";
    $stmtNomeFuncionario = $conn->prepare($sqlNomeFuncionario);
    $stmtNomeFuncionario->bind_param("i", $funcionarioId);
    $stmtNomeFuncionario->execute();
    $resultNomeFuncionario = $stmtNomeFuncionario->get_result();
    
    if ($resultNomeFuncionario->num_rows > 0) {
        $rowNomeFuncionario = $resultNomeFuncionario->fetch_assoc();
        $funcionarioNome = $rowNomeFuncionario['nome'];
    } else {
        $funcionarioNome = "Nome não encontrado"; // Pode ser um valor padrão caso o nome não seja encontrado
    }
} else {
    // Redireciona se não houver informações do funcionário
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Controle de Ponto</title>
    <link rel="stylesheet" href="css/controle_ponto.css">
</head>
<body>
    <h2>Controle de Ponto</h2>
    <h3>Funcionário: <?php echo $funcionarioNome; ?></h3>
    <table>
        <tr>
            <th>Data</th>
            <th>Entrada</th>
            <th>Saída para Almoço</th>
            <th>Volta do Almoço</th>
            <th>Saída</th>
            <th>Total de Horas</th>
        </tr>
        <?php
        while ($rowRegistro = $resultRegistros->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowRegistro['data'] . "</td>";
            echo "<td>" . $rowRegistro['entrada'] . "</td>";
            echo "<td>" . $rowRegistro['saida_almoco'] . "</td>";
            echo "<td>" . $rowRegistro['volta_almoco'] . "</td>";
            echo "<td>" . $rowRegistro['saida'] . "</td>";
            echo "<td>" . $rowRegistro['total_horas'] . " horas</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>