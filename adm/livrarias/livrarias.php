<?php
include "../../conexao.php";


include "../../protecao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="livrarias.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>ADM BC - Livrarias</title>
</head>

<body>
    <header>
        Administrador BC
    </header>
    <nav class="sidebar" id="sidebar">
        <div class="nome">

            <li class="logo_name">
                <a href="perfil/perfil.php">
                    <span class="link_name">
                        <?php echo $_SESSION['nome']; ?>
                    </span>
                </a>
            </li>


            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>

        </div>
        <ul class="nav-list">
            <li>
                <a href="../home.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Home</span>
                </a>
            </li>
            <li class="fix">
                <a href="livrarias.php">
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
            <li class="sair">
                <a href="../logout.php"><i class='bx bx-log-out'></i></a>
            </li>
        </ul>
    </nav>

<<<<<<< Updated upstream
    <!--EXIBE OS CARDS DAS LIVRARIAS-->
    <div class="busca-container">
=======
<!--EXIBE OS CARDS DAS LIVRARIAS-->
<div class="busca-container">
>>>>>>> Stashed changes
            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="nome do resenhista">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
    </div>

<<<<<<< Updated upstream
    <div class="pesquisa">
        <?php
=======

       
        <!-- <div class="pesquisa">
            <?php
            if (!isset($_GET['busca']) || empty($_GET['busca'])) {
                echo "<div class='resultados'></div>";
            } else {
>>>>>>> Stashed changes

if (!isset($_GET['busca']) || empty(trim($_GET['busca']))) {
    echo "<div class='resultados'></div>";
} else {
    // Proteção contra SQL Injection
    $pesquisa = $conn->real_escape_string($_GET['busca']);

    // Query de busca
    $sql_code = "
        SELECT 
            liv_nome, liv_cidade, liv_estado, liv_endereco, liv_email, liv_foto, liv_telefone, livrarias.liv_id,
            COUNT(livrarias_livros.liv_livro_id) AS total_livros 
        FROM 
            livrarias
        LEFT JOIN 
            livrarias_livros ON livrarias.liv_id = livrarias_livros.liv_id
        WHERE 
            liv_nome LIKE '%$pesquisa%'
        GROUP BY
            livrarias.liv_id
    ";

    $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

    if ($sql_query->num_rows == 0) {
        echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
    } else {
        while ($dados = $sql_query->fetch_assoc()) {
            // Mensagem opcional para WhatsApp (pode personalizar)
            $mensagem = urlencode("Olá, gostaria de saber mais sobre sua livraria!");

            echo "
                <div class='livraria-card'>
                    <a href='https://wa.me/{$dados['liv_telefone']}?text={$mensagem}' target='_blank'>
                        <img src='../imagens/livrarias/{$dados['liv_foto']}' alt='Logo da livraria' class='livraria-card'>
                    </a>
                    <p>{$dados['liv_nome']}</p>
                    <p>{$dados['liv_email']}</p>
                    <p>{$dados['liv_cidade']} ({$dados['liv_estado']})</p>
                    <div>Total de livros: {$dados['total_livros']}</div>
                </div>
            ";
        }
    }
}
?>
    </div>


    <div>
        <main>

            <!--TODAS AS LIVRARIAS <H2>-->
            <h2>TODAS LIVRARIAS</h2>
            <div class='linha-horizontal'></div>

            <?php
        // Consulta SQL preparada
        $consulta = "
    SELECT 
        liv_nome,
        liv_cidade,
        liv_estado,
        liv_endereco,
        liv_email,
        liv_foto,
        liv_telefone,
        livrarias.liv_id,
        COUNT(livrarias_livros.liv_livro_id) AS total_livros 
    FROM 
        livrarias
    LEFT JOIN 
        livrarias_livros ON livrarias.liv_id = livrarias_livros.liv_id
    GROUP BY 
        liv_nome, liv_cidade, liv_estado, liv_endereco, liv_email, liv_foto, liv_telefone
";

        if ($stmt = $conn->prepare($consulta)) {
            // Executa a consulta
            $stmt->execute();

            // Associa os resultados
            $stmt->bind_result($liv_nome, $liv_cidade, $liv_estado, $liv_endereco, $liv_email, $liv_foto, $liv_telefone, $liv_id, $total_livros);

            // Loop para exibir os resultados
            while ($stmt->fetch()) {
                // Mensagem personalizada para o WhatsApp
                $mensagem = urlencode("Olá, aqui fala a administradora do site Bibliófilos Community, gostaria de solicitar mais informações sobre sua livraria/ movimentações no nosso site!");

                // Exibindo os dados das livrarias de maneira segura
                echo "
        <div class='card'>
            <a href=\"https://wa.me/{$liv_telefone}?text=$mensagem\" target=\"_blank\">
                <img src=\"../imagens/livrarias/{$liv_foto}\" alt=''>
            </a>
            <p>" . htmlspecialchars($liv_nome, ENT_QUOTES, 'UTF-8') . "</p>
            <p>" . htmlspecialchars($liv_email, ENT_QUOTES, 'UTF-8') . "</p>
            <p>" . htmlspecialchars($liv_cidade, ENT_QUOTES, 'UTF-8') . " ({$liv_estado})</p>
            <div class='total_livros'>Total de Livros: {$total_livros}</div>
        </div>
        ";
            }



            // Fecha o statement
            $stmt->close();
        } else {
            echo "<p>Erro ao consultar as livrarias. Tente novamente mais tarde.</p>";
        }
        ?>


    </div>
    </main>
    <script src="../script.js"></script>
</body>

</html>