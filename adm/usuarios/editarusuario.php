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

<?php
include "../../conexao.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT usu_status FROM usuarios WHERE usu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            $statusAtual = (int)$row['usu_status'];

            // Mapeia os rótulos dos status
            $labels = [2 => 'DESATIVADO', 1 => 'ATIVO'];

            echo "
            <form action='atualizar.php?id=" . htmlspecialchars($id) . "' method='POST' class='format'>
                <label for='status'>Status atual: <strong>{$labels[$statusAtual]}</strong></label><br><br>

                <select name='status' id='status' required>
                    <option value=''>-- Selecione novo status --</option>
                    <option value='1' " . ($statusAtual === 1 ? "selected" : "") . ">ATIVO</option>
                    <option value='2' " . ($statusAtual === 2 ? "selected" : "") . ">DESATIVADO</option>
                </select><br><br>

                <input type='submit' value='Atualizar' class='inputEditar'>
            </form>";
        } else {
            echo "<p>Usuário não encontrado.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Erro ao executar a consulta.</p>";
    }
} else {
    echo "<p>ID inválido.</p>";
}
?>
        <script src="../script.js"></script>

</body>
</html>
