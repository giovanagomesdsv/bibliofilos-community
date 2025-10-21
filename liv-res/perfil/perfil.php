<?php
session_start();
include "../../conexao.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$sql = "SELECT usu_email, usu_nome, usu_senha, usu_data_criacao, usu_status FROM usuarios WHERE usu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// variáveis de sessão
$tipoUsuario = $_SESSION['tipo'];
$nome = $_SESSION['nome'];
$fotoRes = $_SESSION['imagem-res'];
$fotoLiv = $_SESSION['imagem-liv'];
$id = $_SESSION['id'];

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Apenas 1 link correto para os ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" type="text/css" href="perfil.css">
    <title>Perfil - BACKSTAGE Community</title>
</head>
<body>
<header>BACKSTAGE Community</header>

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
    <div class="perfil-container">
        <h1>Perfil do Usuário</h1>
        <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['usu_nome']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($usuario['usu_email']) ?></p>
        <p><strong>Senha:</strong> <?= str_repeat('*', strlen($usuario['usu_senha'])) ?></p>
        <p><strong>Data de Criação:</strong> <?= date("d/m/Y H:i", strtotime($usuario['usu_data_criacao'])) ?></p>
        <p><strong>Status:</strong> <span class="status"><?= $usuario['usu_status'] ? "Ativo" : "Inativo" ?></span></p>
        <a href="editar-perfil.php">Editar perfil</a>
    </div>
    </main>
    <script src="../script.js"></script>
</body>
</html>
