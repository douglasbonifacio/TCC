<?php
// Dados de exemplo
$funcionarioNome = "João Silva";
$loginHora = date("H:i:s"); // Hora atual
$logoutHora = date("H:i:s");

// Calcular o total de horas trabalhadas
$login = strtotime($loginHora);
$logout = strtotime($logoutHora);
$totalHoras = ($logout - $login) / 3600;

// Exibir os resultados
echo "Nome do Funcionário: " . $funcionarioNome . "<br>";
echo "Hora de Login: " . $loginHora . "<br>";
echo "Hora de Logout: " . $logoutHora . "<br>";
echo "Total de Horas Trabalhadas: " . $totalHoras . " horas";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Horas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
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
    $funcionarioNome = $row['nome'];
} else {
    // Redireciona se não houver informações do funcionário
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Ponto</title>
    <style>
        body {
    background-image: url("../img/background.jpg");
}
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function registrarHoras() {
            var funcionarioNome = "<?php echo $funcionarioNome; ?>";
            var dataAtual = new Date().toLocaleDateString(); // Data atual
            var loginHora = new Date().toLocaleTimeString(); // Hora atual do sistema do usuário
            var logoutHora = "18:30:00";

            // Calcular o total de horas trabalhadas
            var login = new Date();
            var logout = new Date();
            var logoutParts = logoutHora.split(":");
            logout.setHours(logoutParts[0], logoutParts[1], logoutParts[2]);
            var totalHoras = (logout - login) / 3600000;

            // Exibir os resultados
            document.getElementById("funcionario").innerHTML = funcionarioNome;
            document.getElementById("data").innerHTML = dataAtual;
            document.getElementById("login").innerHTML = loginHora;
            document.getElementById("logout").innerHTML = logoutHora;
            document.getElementById("totalHoras").innerHTML = totalHoras.toFixed(2) + " horas";
        }
    </script>
</head>
<body onload="registrarHoras()">
    <h2>Registro de Horas</h2>
    <table>
        <tr>
            <th>Nome do Funcionário</th>
            <th>Data</th>
            <th>Hora de Login</th>
            <th>Hora de Logout</th>
            <th>Total de Horas Trabalhadas</th>
        </tr>
        <tr>
            <td id="funcionario"></td>
            <td id="data"></td>
            <td id="login"></td>
            <td id="logout"></td>
            <td id="totalHoras"></td>
        </tr>
    </table>
</body>
</html>

