<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Administrador</title>
    <link rel="stylesheet" href="css/administrador.css">
</head>
<body>
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
    </form>

    <script>
        function adicionarFormacao() {
            const formacoesDiv = document.getElementById("formacoes");
            const novaFormacaoDiv = document.createElement("div");
            novaFormacaoDiv.classList.add("formacao");

            novaFormacaoDiv.innerHTML = `
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
            `;

            formacoesDiv.appendChild(novaFormacaoDiv);
        }
    </script>
</body>
</html>
