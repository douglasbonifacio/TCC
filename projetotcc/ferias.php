<!-- Identificação do Funcionário -->
<?php
session_start();
if (isset($_SESSION["funcionario_id"])) {
    $funcionarioId = $_SESSION["funcionario_id"];
    
    // Criar uma conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbteste";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta para obter Nome do Funcionário
    $sql = "SELECT nomeFuncionario FROM tfuncionarios WHERE id = $funcionarioId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomeFuncionario = $row["nomeFuncionario"];
        echo "<p>Nome do Funcionário: " . $nomeFuncionario . "</p>";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
} else {
    echo "<p>ID do Funcionário não encontrado.</p>";
}
?>


    <!-- Resto do seu código aqui... -->
</body>
</html>


    <!-- Ano de Referência das Férias -->
    <label for="ano_referencia">Ano de Referência:</label>
    <input type="text" id="ano_referencia" name="ano_referencia"><br><br>

    <!-- Calendário para Marcar o Início e o Fim das Férias -->
    <label for="data_inicio">Data de Início:</label>
    <input type="date" id="data_inicio" name="data_inicio"><br><br>

    <label for="data_fim">Data de Fim:</label>
    <input type="date" id="data_fim" name="data_fim"><br><br>

    <!-- Botão Adicionar -->
    <input type="button" value="Adicionar" onclick="adicionarFerias()"><br><br>

    <!-- Tabela de Férias Programadas -->
    <table border="1">
        <tr>
            <th>Ano de Referência</th>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Quantidade de Dias</th>
            <th>Ação</th>
        </tr>
        <!-- Aqui você pode preencher a tabela com dados do banco de dados usando PHP -->
        <?php
        // Consulta para obter as férias programadas
        if (isset($_SESSION["funcionario_id"])) {
            $funcionarioId = $_SESSION["funcionario_id"];
            $sql = "SELECT * FROM tferias WHERE funcionario_id = $funcionarioId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ano_referencia"] . "</td>";
                    echo "<td>" . $row["data_inicio"] . "</td>";
                    echo "<td>" . $row["data_fim"] . "</td>";
                    echo "<td>" . $row["quantidade_dias"] . "</td>";
                    echo "<td><button onclick=\"finalizarFerias(" . $row["id"] . ")\">Finalizar</button></td>";
                    echo "</tr>";
                }
            }
        }
        ?>
        <!-- Repita esta linha para cada registro de férias -->
    </table>

    <!-- Funções JavaScript para Adicionar e Finalizar Férias -->
    <script>
        function adicionarFerias() {
            // Implemente a lógica para adicionar férias aqui
        }

        function finalizarFerias(feriasId) {
            // Implemente a lógica para finalizar férias aqui
        }
    </script>
</body>
</html>
