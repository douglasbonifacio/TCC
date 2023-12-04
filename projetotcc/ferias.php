<!DOCTYPE html>
<html>
<head>
    <title>Agendar Férias</title>
    <link rel="stylesheet" href="css/ferias.css">
</head>
<body>
    <div  class="box">
    <h3>Agendar Férias:</h3>
   

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required><br><br>

        <label for="data_fim">Data de Término:</label>
        <input type="date" id="data_fim" name="data_fim" required><br><br>

        <label for="funcionario_id">ID do Funcionário:</label>
        <input type="number" id="funcionario_id" name="funcionario_id" required><br><br>

        <!--<input  class="botao" type="submit" value="Agendar">-->
        <button class="botao" type="submit" value="Agendar">Agendar</button>
    </form>
    </div><br>
    <button class="btn-voltar" onclick="voltarParaPaginaUser()">Voltar</button>
    <script>
    function voltarParaPaginaUser() {
        // Use o método window.location.href para redirecionar para a página "user"
        window.location.href = 'page_user.php';
    }
</script>
</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar e validar os dados do formulário
    $dataInicio = $_POST["data_inicio"];
    $dataFim = $_POST["data_fim"];
    $funcionarioId = $_POST["funcionario_id"];

    // Verifique a validade dos dados do formulário antes de prosseguir

    // Conectar ao banco de dados
    $conexao = new mysqli("localhost", "root", "", "dbteste");

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    // Inserir os dados na tabela "tferias" usando declaração preparada
    $inserirFerias = $conexao->prepare("INSERT INTO tferias (data_inicio, data_fim, funcionario_id) VALUES (?, ?, ?)");

    if ($inserirFerias) {
        $inserirFerias->bind_param("ssi", $dataInicio, $dataFim, $funcionarioId);
        if ($inserirFerias->execute()) {
            
        } else {
            echo "Erro ao agendar férias: " . $conexao->error;
        }
        $inserirFerias->close();
    } else {
        echo "Erro na preparação da declaração: " . $conexao->error;
    }

    // Consultar as férias agendadas apenas para o funcionário logado
    $sql = "SELECT data_inicio, data_fim FROM tferias WHERE funcionario_id = $funcionarioId";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Férias Agendadas:</h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $dataInicio = $row['data_inicio'];
            $dataFim = $row['data_fim'];
            echo "<li>Data de Início: $dataInicio | Data de Término: $dataFim</li>";
        }
        echo "</ul>";
        echo "Férias agendadas com sucesso!";
    } else {
        echo "Nenhuma férias agendada.";
    }

    // Fechar a conexão com o banco de dados
    $conexao->close();
}
?>