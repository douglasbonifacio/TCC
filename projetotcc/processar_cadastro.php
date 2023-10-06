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

// Recupera os dados do formulário e verifica a existência
$login = isset($_POST['login']) ? $_POST['login'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$salario = isset($_POST['salario']) ? $_POST['salario'] : '';

if (empty($login) || empty($senha) || empty($nome) || empty($data_nascimento) || empty($telefone) || empty($cargo) || empty($salario)) {
    echo "Por favor, preencha todos os campos obrigatórios.";
    exit;
}

// Verifica se o usuário já existe
$stmt = $conn->prepare("SELECT * FROM tusuarios WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$resultUsuario = $stmt->get_result();

if ($resultUsuario->num_rows > 0) {
    echo "Usuário já existe. Por favor, escolha outro login.";
    exit;
}

// Insere a função na tabela tfuncoes (com declaração preparada)
$stmt = $conn->prepare("INSERT INTO tfuncoes (cargo, salario) VALUES (?, ?)");
$stmt->bind_param("ss", $cargo, $salario);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $funcaoId = $stmt->insert_id;

    // Insere o funcionário na tabela tfuncionarios (com declaração preparada)
    $stmt = $conn->prepare("INSERT INTO tfuncionarios (nome, data_nascimento, telefone, funcao_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $data_nascimento, $telefone, $funcaoId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $funcionarioId = $stmt->insert_id;

        // Processamento da foto de perfil
        $nomeFoto = ''; // Inicializa a variável $nomeFoto
        if (isset($_FILES['foto'])) {
            $foto = $_FILES['foto'];

            // Diretório para onde a imagem será salva
            $dir = "fotos/";

            // Verifica se o arquivo é uma imagem
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            $fileExtension = pathinfo($foto['name'], PATHINFO_EXTENSION);

            if (!in_array($fileExtension, $allowedExtensions)) {
                echo "Apenas arquivos JPG, JPEG e PNG são permitidos.";
                exit;
            }

            // Gera um nome único para a imagem
            $nome_imagem = $funcionarioId . "_" . time() . "." . $fileExtension;

            // Caminho onde a imagem será salva
            $caminho_imagem = $dir . $nome_imagem;

            // Faz o upload da imagem para seu respectivo caminho
            if (!move_uploaded_file($foto["tmp_name"], $caminho_imagem)) {
                echo "Erro ao fazer upload da imagem.";
                exit;
            }

            // Atualiza o nome da foto no banco de dados
            $nomeFoto = $caminho_imagem;
        }

        // Insere o usuário na tabela tusuarios (com declaração preparada)
        $stmt = $conn->prepare("INSERT INTO tusuarios (nome, login, senha, foto_caminho, id_funcionario, tipo) VALUES (?, ?, ?, ?, ?, ?)");
        $tipo = 'funcionario'; // Defina o tipo de usuário como 'funcionario'
        $stmt->bind_param("ssssis", $nome, $login, $senha, $nomeFoto, $funcionarioId, $tipo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar o usuário. Por favor, tente novamente.";
        }
    } else {
        echo "Erro ao cadastrar o funcionário. Por favor, tente novamente.";
    }
} else {
    echo "Erro ao cadastrar a função. Por favor, tente novamente.";
    exit;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
