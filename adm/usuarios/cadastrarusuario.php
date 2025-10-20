<?php
include "../../conexao.php";

// Lógica de cadastro ao submeter o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $nome = trim($_POST['nome']);
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
    $usuario = (int) $_POST['usuario'];

    $sql = "INSERT INTO usuarios (usu_nome, usu_email, usu_senha, usu_tipo_usuario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $email, $senha, $usuario);

    if ($stmt->execute()) {
        $idUsuario = $stmt->insert_id;

        if ($usuario == 0) {
            // Se for resenhista, redireciona para cadastrar na tabela resenhistas
            echo "<script>
                    alert('Usuário cadastrado com sucesso! Agora cadastre os dados de resenhista.');
                    window.location.href = 'cadastrarresenhista.php?id=". htmlspecialchars($idUsuario) ."';
                </script>";
        } else {
            echo "<script>
                    alert('Administrador cadastrado com sucesso cadastrado com sucesso!');
                    window.location.href = 'usuarios.php';
                </script>";
        }
    } else {
        echo '<script>
                alert("Erro ao cadastrar o usuário.");
                window.location.href = "cadastrarusuario.php";
            </script>';
    }
    $stmt->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="usuarios.css">
    <title>Cadastrar Usuarios - BACKSTAGE Community</title>
</head>


<body>
        <header>
        BACKSTAGE Community
    </header>
    <nav class="sidebar" id="sidebar">
    <ul class="nav-list">
        <div class="nome">
            <li>
                <a href="../perfil/perfil.php">
                    <span class="link_name">
                        <?php echo $_SESSION['nome']; ?>
                    </span>
                </a>
            </li>
            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>
        </div>
        <li>
                <a href="../../index.php">
                <i class='bx  bx-reply-stroke'></i> 
                    <span class="link_name">Bibliófilos Community</span>
                </a>
            </li>
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
            <li class="fix">
                <a href="usuarios.php">
                    <i class='bx bx-book-content'></i>
                    <span class="link_name">Usuarios</span>
                </a>
            </li>
            <li class="sair">
                <a href="../logout.php"><i class='bx bx-log-out'></i></a>
            </li>
        </ul>
    </nav>
    <form action="cadastrarusuario.php" method="POST" class='format2'>
        <label for="email">E-mail:</label>
        <input type="email" name="email" required class='inputEditar2'>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" required class='inputEditar2'>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required class='inputEditar2'>

        <label for="usuario">Tipo de usuário:</label>
        <select name="usuario" id="usuario" required>
            <option value="">Selecione...</option>
            <option value="2">Administrador</option>
            <option value="0">Resenhista</option>
        </select>

        <input type="submit" value="Cadastrar usuário" class='inputConfirmar'>
    </form>
        <script src="../script.js"></script>

</body>

</html>