<!--<?php
session_start();
include "../../conexao.php";

// Redireciona caso o usuário não esteja logado
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION['id'];
$mensagem = "";
$tipo_mensagem = ""; // 'sucesso' ou 'erro'

// Lógica de atualização ao submeter o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novo_nome  = trim($_POST['nome']);
    $novo_email = trim($_POST['email']);
    $nova_senha = trim($_POST['senha']);

    if (!empty($novo_nome) && !empty($novo_email)) {
        // Validação do e-mail
        if (!filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
            $mensagem = "Email inválido.";
            $tipo_mensagem = "erro";
        } else {
            // Atualiza com a senha, caso a nova senha tenha sido fornecida
            if (!empty($nova_senha)) {
                $senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);
                $sql = "UPDATE usuarios SET usu_nome = ?, usu_email = ?, usu_senha = ? WHERE usu_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $novo_nome, $novo_email, $senha_hash, $id);
            } else {
                // Se a senha não for fornecida, não atualiza a senha
                $sql = "UPDATE usuarios SET usu_nome = ?, usu_email = ? WHERE usu_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $novo_nome, $novo_email, $id);
            }

            if ($stmt->execute()) {
                $_SESSION['nome'] = $novo_nome;
                echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'perfil.php';</script>";
                exit();
            } else {
                $mensagem = "Erro ao atualizar perfil.";
                $tipo_mensagem = "erro";
            }

            $stmt->close();
        }
    } else {
        $mensagem = "Nome e e-mail são obrigatórios.";
        $tipo_mensagem = "erro";
    }
}

// Busca os dados atuais do usuário
$sql = "SELECT usu_nome, usu_email FROM usuarios WHERE usu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();
?>
-->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="perfil.css">
    <link rel="stylesheet" href="../geral.css">
</head>
<body>
    <header>
        Administrador BC
    </header>
    <nav class="sidebar" id="sidebar">
    <ul class="nav-list">
        <div class="nome">
            <li>
            <div class="fix"> <?php echo $_SESSION['nome']; ?></div>
            </li>
            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>
        </div>
            <li>
                <a href="../home.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Home</span>
                </a>
            </li>
            <li>
                <a href="../livrarias/livrarias.php">
                    <i class='bx bx-user'></i>
                    <span class="link_name">Livrarias</span>
                </a>
            </li>
            <li>
                <a href="../resenhistas/resenhistas.php">
                    <i class='bx bx-user-pin'></i>
                    <span class="link_name">Resenhistas</span>
                </a>
            </li>
            <li>
                <a href="../livro/livros.php">
                    <i class='bx bx-book-bookmark'></i>
                    <span class="link_name">Livros</span>
                </a>
            </li>
            <li>
                <a href="../usuarios/usuarios.php">
                    <i class='bx bx-book-content'></i>
                    <span class="link_name">Usuarios</span>
                </a>
            </li>
            <li class="../sair">
                <a href="logout.php"><i class='bx bx-log-out'></i></a>
            </li>
        </ul>
    </nav>
<main>
    <!-- Exibe mensagens de erro -->
    <?php if (!empty($mensagem)): ?>
        <script>alert("<?= htmlspecialchars($mensagem) ?>");</script>
    <?php endif; ?>
    <div class="editar-perfil-container">
    <h1>Editar Perfil</h1>
    <form method="POST">
        <div class="form-group">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['usu_nome']) ?>" required><br><br>
    </div>
    <div class="form-group">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['usu_email']) ?>" required><br><br>
    </div>
    <div class="form-group">
        <label>Nova senha:</label><br>
        <input type="password" name="senha" placeholder="Deixe em branco para manter a mesma senha"><br><br>
    </div>
        <button type="submit">Salvar Alterações</button>
    </form>
    <br>
    <a href="perfil.php">Voltar ao perfil</a>
    </div>
</main>
    <script src="../script.js"></script>
</body>
</html>
