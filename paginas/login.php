<?php
session_start();
require_once '../includes/db.php'; // Inclua o arquivo que conecta ao banco de dados.

$mensagem = "";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if ($email && $senha) {
        // Verifica se o usuário existe no banco
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            
            // Verifica a senha
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                // $_SESSION['tipo'] = $usuario['tipo']; 

                header("Location: central.php");
                exit;
            } else {
                $mensagem = "Senha incorreta.";
            }
        } else {
            $mensagem = "Usuário não encontrado.";
        }
    } else { //Não vai ser usado
        $mensagem = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>DriveFleet - Login</title>
  <link rel="shortcut icon" href="../midia/favicon/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="../estilos/LoginAndCadastro.css">
</head>
<body>

    <!--Cabeçalho com menu responsivo-->
    <header>
        <div class="logo">DriveFleet</div>
        <nav>
            <div class="menu-icon" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="menu">
                <a href="../index.html">Home</a>
                <a href="#servicos">Entrar</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
            </div>
            <div class="menu mobile-menu">
                <a href="../index.html">Home</a>
                <a href="#servicos">Entrar</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
            </div>
        </nav>
    </header>
    <!--Cabeçalho com menu responsivo-->

    <!--Formulario de login-->
    <main>
        <div class="container">
            <div class="img-section">
            <img src="../midia/imagens/img04.png" alt="Imagem de fundo">
            </div>

            <div class="form-section">
                <form class="login-form" method="POST">
                    <h2>Entrar</h2>
                    
                    <!-- Exibe a mensagem de erro, caso exista -->
                    <?php if ($mensagem): ?>
                        <p style="color: red;"><?= $mensagem; ?></p>
                    <?php endif; ?>

                    <input type="text" name="email" placeholder="E-mail" required>
                    <input type="password" name="senha" placeholder="Senha" required>
                    <button type="submit">Login</button>

                    <div class="links">
                        <a href="#">Esqueceu a senha?</a> <!--Função a ser incrementada-->
                        <a href="cadastro.php">Criar conta</a>
                    </div>
                </form>
            </div>

        </div>
    </main>
    <!--Formulario de login-->

    <!--Script em Js-->
    <script src="../script/javascript.js"></script>

</body>
</html>