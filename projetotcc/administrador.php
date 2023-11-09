<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Administrador</title>
    <link rel="stylesheet" href="css/administrador.css">
</head>
<body>
    <button onclick="mostrarFormulario()">Mostrar Formulário</button>
    <button onclick="mostrarFeriasAgendadas()">Mostrar Férias Agendadas</button>
    <button onclick="alterarCadastro()">Alterar Cadastro</button>

    <div id="formulario" style="display: none;">
        <div id="feriasAgendadas" style="display: none;">
        <h3>Férias Agendadas:</h3>
        <ul id="feriasList"> <!-- Use esta lista para exibir as férias agendadas -->
        </ul>
    </div>
        
    <form action="processar_cadastro.php" method="post" class="box" enctype="multipart/form-data">
        <h1>Cadastro de Funcionários</h1>
        <h2 class="form-section">Usuário do Sistema</h2>
        <label for="login">Login:</label>
        <input type="text" name="login" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <h2 class="form-section">Funcionário</h2>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" required>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" required>

        <!-- Campos de Educação -->
        <h2 class="form-section">Educação</h2>

        <!-- Formações múltiplas -->
        <div id="formacoes">
            <div class="formacao">
                <label for="escolaridade">Escolaridade:</label>
                <select name="escolaridade[]" required>
                    <option value="Ensino Médio Incompleto">Ensino Médio Incompleto</option>
                    <option value="Ensino Médio Completo">Ensino Médio Completo</option>
                    <option value="Graduação Incompleta">Graduação Incompleta</option>
                    <option value="Graduação Completa">Graduação Completa</option>
                    <!-- Adicione outras opções conforme necessário -->
                </select>

                <label for="nivel_formacao">Nível de Formação:</label>
                <select name="nivel_formacao[]" required>
                    <option value="Técnico">Técnico</option>
                    <option value="Graduação">Graduação</option>
                    <option value="Pós-Graduação">Pós-Graduação</option>
                    <option value="Mestrado">Mestrado</option>
                    <option value="Doutorado">Doutorado</option>
                    <!-- Adicione outras opções conforme necessário -->
                </select>

                <label for="especializacao">Especialização:</label>
                <input type="text" name="especializacao[]">
            </div>
        </div>
        
        <button type="button" onclick="adicionarFormacao()">Adicionar Formação</button>

        <!-- Campos de Função -->
        <h2 class="form-section">Função</h2>
        <label for="cargo">Cargo:</label>
        <input type="text" name="cargo" required>

        <label for="salario">Salário:</label>
        <input type="number" name="salario" required>

        <!-- Foto de Perfil -->
        <h2 class="form-section">Foto de Perfil</h2>
        <label for="foto">Escolha uma foto:</label>
        <input type="file" name="foto" accept="image/*">
        
        <input type="submit" value="Cadastrar">
    <button class="botao" onclick="voltarParaPaginaUser()">Voltar</button>

    <script>
        function mostrarFormulario() {
            const formularioDiv = document.getElementById("formulario");
            const feriasAgendadasDiv = document.getElementById("feriasAgendadas");

            formularioDiv.style.display = "block";
            feriasAgendadasDiv.style.display = "none";
        }

        // Adicione um evento de escuta, como um clique em um botão
document.getElementById("seuBotaoId").addEventListener("click", mostrarFeriasAgendadas);

function mostrarFeriasAgendadas() {
    // Use fetch para obter as férias agendadas
    fetch("obter_ferias_agendadas.php") // Altere a URL para a rota correta
        .then(response => {
            if (!response.ok) {
                throw new Error("Não foi possível obter as férias agendadas.");
            }
            return response.text(); // Altere para .text() para tratar a resposta como texto
        })
        .then(data => {
            const feriasList = document.getElementById("feriasList");
            feriasList.innerHTML = ""; // Limpa a lista para evitar duplicatas

            // Se os dados não estiverem no formato JSON, divida o texto em linhas
            const lines = data.split("\n");

            lines.forEach(line => {
                // Analise os dados da linha conforme necessário
                const [dataInicio, dataFim, nomeFuncionario] = line.split(","); // Supondo que os dados sejam separados por vírgula

                const listItem = document.createElement("li");
                listItem.textContent = `Data de Início: ${dataInicio} | Data de Término: ${dataFim} | Funcionário: ${nomeFuncionario}`;
                feriasList.appendChild(listItem);
            });

            // Exiba a seção de férias agendadas
            const feriasAgendadasDiv = document.getElementById("feriasAgendadas");
            feriasAgendadasDiv.style.display = "block";
        })
        .catch(error => {
            console.error("Erro ao obter férias agendadas: " + error);
            // Você pode exibir uma mensagem de erro ao usuário aqui

            
        // Esconda o formulário e a lista de férias agendadas (ou qualquer outra ação que deseje realizar)
        formularioDiv.style.display = "none";
        feriasAgendadasDiv.style.display = "none";
        });
        
}
    </script>
</body>
</html>