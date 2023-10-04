<?php
session_start();

// Verifica se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos de login e senha foram preenchidos
    if (isset($_POST["login"]) && isset($_POST["senha"])) {
        // Verifica se o login e a senha são válidos
        $login = $_POST["login"];
        $senha = $_POST["senha"];

        // Verifica no banco de dados se o login e a senha correspondem a um usuário válido
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dbteste";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Consulta o banco de dados para verificar se o login e a senha estão corretos
        $sql = "SELECT * FROM tusuarios WHERE login = '$login' AND senha = '$senha'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $tipoUsuario = $row['tipo'];

            // Login bem-sucedido, cria uma sessão e gera um token de sessão
            $_SESSION["login"] = $login;
            $_SESSION["token"] = uniqid();
            setcookie("token", $_SESSION["token"], time() + (86400 * 30), "/"); // Define o cookie do token por 30 dias (ajuste conforme necessário)

            // Redireciona com base no tipo de usuário
            if ($tipoUsuario === 'administrador') {
                header("Location: administrador.php"); // Página de administrador
            } else {
                header("Location: page_user.php"); // Página de usuário normal
            }
            exit;
        } else {
            // Login inválido, exibe uma mensagem de erro
            $erroLogin = "Login ou senha inválidos.";
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    } else {
        // Campos de login e senha não foram preenchidos, exibe uma mensagem de erro
        $erroLogin = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
        
    <div class="login-card">
    <div class="column">

    <h1>Login</h1>
    <p>Após Fazer o Login, Você Pode Aproveitar nossos Recursos.</p>

    <?php if (isset($erroLogin)) { echo "<p>$erroLogin</p>"; } ?>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                
        <div class="form-item">
        <input type="text" id="login" class="form-element" placeholder="Username" name="login" required>
        </div>
        <br>
        <div class="form-item">
        <input type="password" id="senha" class="form-element" placeholder="Password" name="senha" required>
        </div>
        <div class="form-chechbox-item">
        <input type="checkbox" id="rememberMe checked">
        <label for="rememberMe">Lembrar-Me</label>
        </div>
        <div class="flex">
        <button type="submit">Entre</button id="enviar" value="Entrar">
        <a href="#">Redefina sua Senha Agora</a>
        </div>
        <p style="margin-top:3rem;margin-bottom:1.5rem">Siga o RH Vison nas Redes Sociais</p>
        <div class="social-buttons">
        <a href="#" class="facebook">
        <i class="bi bi-facebook"></i>
        </a>
        <a href="#" class="twitter">
        <i class="bi bi-twitter"></i>
        </a>
        <a href="#" class="github">
        <i class="bi bi-github"></i>
        </a>
        </div>
                        
        </form>
        </div>
        <div class="column">
        <h2>Bem-Vindo ao Portal<br>RH Vision</h2>
        <p>Se voce não tem uma conta, gostria de cadastrar agora?</p>
        <a href="#">Sign Up</a>
        </div>
        </div>
            
        <script src="valida.js"></script>
    </form>
</body>
</html>
