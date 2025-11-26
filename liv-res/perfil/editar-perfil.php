<?php
session_start();
include "../../conexao.php";
include "../../protecao.php";

// variáveis de sessão
$tipoUsuario = $_SESSION['tipo'];
$nome = $_SESSION['nome'];
$fotoRes = $_SESSION['imagem-res'];
$fotoLiv = $_SESSION['imagem-liv'];
$id = $_SESSION['id'];



$id = $_SESSION['id'];

// Lógica de atualização ao submeter o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novo_nome = trim($_POST['nome']);
    $novo_email = trim($_POST['email']);
    $nova_senha = trim($_POST['senha']);

    // Validação do e-mail
    if (!filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
        echo "Erro! E-mail inválido.";
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
            echo "Erro ao atualizar.";
        }

        $stmt->close();
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

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - BACKSTAGE Community</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="perfil.css">
    <link rel="stylesheet" href="../geral.css">
</head>

<body>
    <header>
        BACKSTAGE Community
    </header>

    <nav class='sidebar' id='sidebar'>
        <ul class='nav-list'>
            <div class='nome'>
                <li class="fix">
                    <a href='../perfil/perfil.php' class="perfil">
                        <?php
                        if ($tipoUsuario == 0) {
                            $imgCaminho = "../../adm/imagens/resenhistas/" . $fotoRes;
                        } else {
                            $imgCaminho = "../../adm/imagens/livrarias/" . $fotoLiv;
                        }
                        ?>
                        <img src="<?= htmlspecialchars($imgCaminho) ?>" alt="Foto de perfil" class="img-perfil">
                        <span class='link_name'><?= htmlspecialchars($nome) ?></span>

                    </a>
                </li>
                <div class='menu' id='menu'><i class='bx bx-menu'></i></div>
            </div>

            <li>
                <a href='../../index.php'>
                    <i class='bx bx-reply-stroke'></i>
                    <span class='link_name'>BIBLIÓFILOS Community</span>
                </a>
            </li>

            <?php if ($usuario == 1): ?>
                <li>
                    <a href='../anuncio/anuncios.php'>
                        <i class='bx bx-user'></i>
                        <span class='link_name'>Anúncios</span>
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <a href='../resenha/resenhas.php'>
                    <i class='bx bx-pencil-circle'></i>
                    <span class='link_name'>CRIAR RESENHAS</span>
                </a>
            </li>

            <li>
                <a href='../m-resenha/m-resenhas.php'>
                    <i class='bx bx-book-bookmark'></i>
                    <span class='link_name'>MINHAS RESENHAS</span>
                </a>
            </li>

            <li class='sair'>
                <a href='../logout.php'><i class='bx bx-log-out'></i></a>
            </li>
        </ul>
    </nav>
    <main>

        <div class="editar-perfil-container">
            <h1>Editar Perfil</h1>
            <form method="POST">
                <div class="form-group">
                    <label>Nome:</label><br>
                    <input type="text" name="nome" value="<?= htmlspecialchars($usuario['usu_nome']) ?>"
                        required><br><br>
                </div>
                <div class="form-group">
                    <label>Email:</label><br>
                    <input type="email" name="email" value="<?= htmlspecialchars($usuario['usu_email']) ?>"
                        required><br><br>
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