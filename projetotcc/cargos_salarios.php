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
$sql = "SELECT tfuncionarios.*, tfuncoes.cargo, tfuncoes.salario, teducacao.escolaridade, teducacao.nivel_formacao, teducacao.especializacao
        FROM tfuncionarios
        INNER JOIN tusuarios ON tfuncionarios.id = tusuarios.id
        INNER JOIN tfuncoes ON tfuncionarios.funcao_id = tfuncoes.id
        LEFT JOIN teducacao ON tfuncionarios.id = teducacao.funcionario_id
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
    echo "<p>Salário: R$ " . number_format($row['salario'], 2, ',', '.') . "</p>";
    echo "<h1>Informações de Educação</h1>";
    echo "<p>Escolaridade: " . $row['escolaridade'] . "</p>";
    echo "<p>Nível de Formação: " . $row['nivel_formacao'] . "</p>";
    echo "<p>Especialização: " . $row['especializacao'] . "</p>";
    // Exiba outras informações do funcionário e da função conforme necessário
} else {
    echo "<h1>Informações do Funcionário não encontradas</h1>";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
<button id="btn-voltar" class= "btn" onclick="voltarParaPaginaUser()">Voltar</button>
<script>
    // Função para voltar para a página do usuário
    function voltarParaPaginaUser() {
        window.location.href = 'page_user.php';
    }
</script>
</body>
</html>
    <head>
        <link rel="stylesheet" href="css/cargos_salarios.css">
    </head>
    <body>
    <button id="btn-voltar" class= "btn" onclick="voltarParaPaginaUser()">Voltar</button>
    </body>
</html>