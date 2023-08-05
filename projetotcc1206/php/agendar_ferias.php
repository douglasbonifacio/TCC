<!DOCTYPE html>
<html>
<head>
    <title>Agendar Férias</title>
</head>
<body>
    <h2>Agendar Férias</h2>

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

    // Fechar a conexão com o banco de dados
    $conn->close();
    ?>

    <h3>Informações do Funcionário:</h3>
    <p>Nome: <?php echo $funcionarioNome; ?></p>

    <?php
    // Verificar se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Coletar os dados do formulário
        $dataInicio = $_POST["data_inicio"];
        $dataFim = $_POST["data_fim"];
        $funcionarioId = $_POST["funcionario_id"];

        // Conectar ao banco de dados
        $conexao = new mysqli("localhost", "root", "", "dbteste");
        if ($conexao->connect_error) {
            die("Falha na conexão: " . $conexao->connect_error);
        }

        // Inserir os dados na tabela "tferias"
        $inserirFerias = "INSERT INTO tferias (data_inicio, data_fim, funcionario_id) VALUES ('$dataInicio', '$dataFim', $funcionarioId)";
        if ($conexao->query($inserirFerias) === TRUE) {
            echo "Férias agendadas com sucesso!";
        } else {
            echo "Erro ao agendar férias: " . $conexao->error;
        }

        // Fechar a conexão com o banco de dados
        $conexao->close();
    }

    // Consultar as férias agendadas
    $conexao = new mysqli("localhost", "root", "", "dbteste");
    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    $sql = "SELECT tferias.data_inicio, tferias.data_fim, tfuncionarios.nome FROM tferias INNER JOIN tfuncionarios ON tferias.funcionario_id = tfuncionarios.id";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Férias Agendadas:</h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $dataInicio = $row['data_inicio'];
            $dataFim = $row['data_fim'];
            $nomeFuncionario = $row['nome'];
            echo "<li>Nome do Funcionário: $nomeFuncionario | Data de Início: $dataInicio | Data de Término: $dataFim</li>";
        }
        echo "</ul>";
    } else {
        echo "Nenhuma férias agendada.";
    }

    // Fechar a conexão com o banco de dados
    $conexao->close();
    ?>

    <h3>Agendar Férias:</h3>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required><br>

        <label for="data_fim">Data de Término:</label>
        <input type="date" id="data_fim" name="data_fim" required><br>

        <label for="funcionario_id">ID do Funcionário:</label>
        <input type="number" id="funcionario_id" name="funcionario_id" required><br>

        <input type="submit" value="Agendar">
    </form>
</body>
</html>

