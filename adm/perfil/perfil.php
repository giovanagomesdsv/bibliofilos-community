<?php
session_start();
include "../../conexao.php";

// Verifica se o usuário está logado
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

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="perfil.css">
    <link rel="stylesheet" href="../geral.css">
    <style>
        .status {
            font-weight: bold;
            color: <?= $usuario['usu_status'] ? "#f5f5f5" : "#f5f5f5" ?>;
        }
    </style>
</head>
<body>
    <header>
        Administrador BC
    </header>
    <nav class="sidebar" id="sidebar">
    <ul class="nav-list">
        <div class="nome">
            <li class="usuario">
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
