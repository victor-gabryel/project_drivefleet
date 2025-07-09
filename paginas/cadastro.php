<?php
require_once '../includes/db.php'; // Conexão com banco de dados
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if ($nome && $email && $data_nascimento && $senha && $confirmar_senha) {

        if ($senha !== $confirmar_senha) {
            $mensagem = "As senhas não coincidem.";
        } else {
            // Verifica a idade do usuário
            $data_nascimento_dt = new DateTime($data_nascimento);
            $hoje = new DateTime();
            $idade = $hoje->diff($data_nascimento_dt)->y;

            if ($idade < 18) {
                $mensagem = "Usuário menor de idade.";
            } else {
                // Verifica se o e-mail já está cadastrado
                $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $mensagem = "Este e-mail já está cadastrado.";
                } else {
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, data_nascimento, senha) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $nome, $email, $data_nascimento, $senha_hash);

                    if ($stmt->execute()) {
                        // Adicionar função de enviar email para cada usuario cadastrado
                        header("Location: login.php");
                        exit;
                    } else {
                        $mensagem = "Erro ao cadastrar usuário.";
                    }
                }
            }
        }
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>DriveFleet - Cadastro</title>
    <link rel="shortcut icon" href="../midia/favicon/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/LoginAndCadastro.css">
</head>
<body>
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
                <a href="login.php">Entrar</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
            </div>
            <div class="menu mobile-menu">
                <a href="../index.html">Home</a>
                <a href="login.php">Entrar</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="img-section">
                <img src="../midia/imagens/img05.png" alt="Imagem de fundo">
            </div>

            <div class="form-section">
                <form class="login-form" method="POST">
                    <h2>Criar Conta</h2>

                    <?php if ($mensagem): ?>
                        <p style="color: red;"><?= $mensagem; ?></p>
                    <?php endif; ?>

                    <input type="text" name="nome" placeholder="Nome completo" required>
                    <input type="email" name="email" placeholder="E-mail" required>
                    <input type="date" name="data_nascimento" required>
                    <input type="password" name="senha" placeholder="Senha" required>
                    <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required>

                    <button type="submit">Cadastrar</button>

                    <div class="links">
                        <a href="login.php">Já tem conta? Entrar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="../script/javascript.js"></script>

</body>
</html>