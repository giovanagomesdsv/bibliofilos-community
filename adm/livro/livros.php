<?php
include "../../conexao.php";
include "../protecao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="livros.css">
    <link rel="stylesheet" href="../geral.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>ADM BC - Livros</title>
</head>

<body>
    <header>       
        Administrador BC
    </header>
    <nav class="sidebar" id="sidebar"> 
       <div class="nome">

            <li class="logo_name">
                <a href="perfil/perfil.php">
                    <span class="link_name"><?php echo $_SESSION['nome']; ?></span>
                </a>
            </li>


            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>

        </div>
        <ul class="nav-list">
            <li >
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
            <li class="fix">
                <a href="livros.php">
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
<main>
    <div class="busca-container">
        <form action="" method="GET">
            <input type="text" name="busca" placeholder="Busque as livrarias...">
            <button type="submit">Pesquisar</button>
        </form>
    </div>


    <div class="pesquisa">
        <?php
        if (!isset($_GET['busca']) || empty($_GET['busca'])) {
            echo "<div class='resultados'></div>";
        } else {

            // Proteção contra SQL Injection
            $pesquisa = $conn->real_escape_string($_GET['busca']);

            // Query de busca
            $sql_code = "SELECT 
    livros.livro_titulo, 
    livros.livro_foto, 
    livrarias_livros.liv_livro_preco, 
    autores.aut_nome, 
    livrarias.liv_nome
FROM livros
INNER JOIN livrarias_livros ON livros.livro_id = livrarias_livros.livro_id
INNER JOIN livrarias ON livrarias_livros.liv_id = livrarias.liv_id
INNER JOIN livro_autores ON livros.livro_id = livro_autores.livro_id
INNER JOIN autores ON livro_autores.aut_id = autores.aut_id
   WHERE livro_titulo LIKE '%$pesquisa%' AND liv_livro_status = '1'";
            
            $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

            if ($sql_query->num_rows == 0) {
                echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
            } else {

                while ($dados = $sql_query->fetch_assoc()) {
                    echo "
                         <div>
        <div>
           <img src='../imagens/livros/{$dados['livro_foto']}'>
        </div>
        <div>
           <p class=''>{$dados['livro_titulo']}</p>
           <p>{$dados['aut_nome']}</p>
           <p>R$ {$dados['liv_livro_preco']}</p>
           <p>{$dados['liv_nome']}</p>
        </div>
    </div>
         
            ";
                }
            }
        }
        ?>
    </div>




    <div>
    <?php
// Consulta segura utilizando Prepared Statements
$sql_code = "
    SELECT 
        livros.livro_titulo, 
        livros.livro_foto, 
        livrarias_livros.liv_livro_preco, 
        autores.aut_nome, 
        livrarias.liv_nome
    FROM livros
    INNER JOIN livrarias_livros ON livros.livro_id = livrarias_livros.livro_id
    INNER JOIN livrarias ON livrarias_livros.liv_id = livrarias.liv_id
    INNER JOIN livro_autores ON livros.livro_id = livro_autores.livro_id
    INNER JOIN autores ON livro_autores.aut_id = autores.aut_id
";

// Executando a consulta de forma segura
if ($tabela = mysqli_query($conn, $sql_code)) {
    // Verificando se há registros
    if (mysqli_num_rows($tabela) > 0) {
        while ($linha = mysqli_fetch_assoc($tabela)) {
            // Exibindo os resultados de forma estruturada
            echo "
            <div class='livro'>
                <div class='imagem'>
                    <img src='../imagens/livros/{$linha['livro_foto']}' alt='" . htmlspecialchars($linha['livro_titulo']) . "'>
                </div>
                <div class='informacoes'>
                    <p><strong>" . htmlspecialchars($linha['livro_titulo']) . "</strong></p>
                    <p>Autor: " . htmlspecialchars($linha['aut_nome']) . "</p>
                    <p>Preço: R$ " . number_format($linha['liv_livro_preco'], 2, ',', '.') . "</p>
                    <p>Livraria: " . htmlspecialchars($linha['liv_nome']) . "</p>
                </div>
            </div>";
        }
    } else {
        echo "<p>Nenhum livro encontrado!</p>";
    }
} else {
    echo "<p>Erro ao consultar os livros. Tente novamente mais tarde.</p>";
}
?>

    </div>



</main>
    <script src="../script.js"></script>
</body>

</html>