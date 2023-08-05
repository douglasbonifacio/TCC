<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbteste";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recupera os dados do formulário
$login = $_POST['login'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$telefone = $_POST['telefone'];
$cargo = $_POST['cargo'];
$salario = $_POST['salario'];

// Verifica se o usuário já existe
$verificaUsuario = "SELECT * FROM tusuarios WHERE login = '$login'";
$resultUsuario = $conn->query($verificaUsuario);

if ($resultUsuario->num_rows > 0) {
    echo "Usuário já existe. Por favor, escolha outro login.";
    exit;
}

// Verifica se a função já existe
$verificaFuncao = "SELECT * FROM tfuncoes WHERE cargo = '$cargo'";
$resultFuncao = $conn->query($verificaFuncao);

if ($resultFuncao->num_rows > 0) {
    $row = $resultFuncao->fetch_assoc();
    $funcaoId = $row['id'];
} else {
    // Insere a função na tabela tfuncoes
    $inserirFuncao = "INSERT INTO tfuncoes (cargo, salario) VALUES ('$cargo', '$salario')";
    $resultFuncao = $conn->query($inserirFuncao);

    if ($resultFuncao) {
        $funcaoId = $conn->insert_id;
    } else {
        echo "Erro ao cadastrar a função. Por favor, tente novamente.";
        exit;
    }
}

// Insere o usuário na tabela tusuarios
$inserirUsuario = "INSERT INTO tusuarios (nome, login, senha) VALUES ('$nome', '$login', '$senha')";
$resultUsuario = $conn->query($inserirUsuario);

if (!$resultUsuario) {
    echo "Erro ao cadastrar o usuário. Por favor, tente novamente.";
    exit;
}

// Obtém o ID do usuário recém-inserido
$usuarioId = $conn->insert_id;

// Insere o funcionário na tabela tfuncionarios
$inserirFuncionario = "INSERT INTO tfuncionarios (nome, data_nascimento, telefone, funcao_id) VALUES ('$nome', '$data_nascimento', '$telefone', '$funcaoId')";
$resultFuncionario = $conn->query($inserirFuncionario);

if ($resultFuncionario) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar o funcionário. Por favor, tente novamente.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
