<?php
include "../../conexao.php";
include "../protecao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="livros.css">
    <link rel="stylesheet" href="../geral.css">
    <title>Livros - BACKSTAGE Community</title>
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
            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="nome do livro">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
            <?php
        if (!isset($_GET['busca']) || empty($_GET['busca'])) {
            echo "<div class='resultados'></div>";
        } else {

            // Proteção contra SQL Injection
            $pesquisa = $conn->real_escape_string($_GET['busca']);

            // Query de busca
            $sql_code = "SELECT livros.livro_titulo, livros.livro_foto,  livrarias_livros.liv_livro_preco, autores.aut_nome, livrarias.liv_nome
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
            $foto = htmlspecialchars($dados['livro_foto']);
            $titulo = htmlspecialchars($dados['livro_titulo']);
            $autor = htmlspecialchars($dados['aut_nome']);
            $nome = htmlspecialchars($dados['liv_nome']);
            $preco = number_format($dados['liv_livro_preco'], 2, ',', '.');

            echo "
            <div class='card card-livro'>
                <div class='imagem'>
                    <img src='../imagens/livros/$foto' alt='$titulo'>
                </div>
                <div class='informacoes'>
                    <p class='input' style='color: #000'>$titulo</p>
                    <p class='input'>Escritor: $autor</p>
                    <p class='input'>R$ $preco</p>
                    <p class='input'>$nome</p>
                </div>
            </div>";
                }
            }
        }
        ?>
          

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
    INNER JOIN autores ON livro_autores.aut_id = autores.aut_id";
$stmt = $conn->prepare($sql_code);
$stmt->execute();
$result= $stmt->get_result();

if ($result-> num_rows > 0) {
    while ($linha = mysqli_fetch_assoc($result)) {
            $foto = htmlspecialchars($linha['livro_foto']);
            $titulo = htmlspecialchars($linha['livro_titulo']);
            $autor = htmlspecialchars($linha['aut_nome']);
            $nome = htmlspecialchars($linha['liv_nome']);
            $preco = number_format($linha['liv_livro_preco'], 2, ',', '.');

            echo "
            <div class='card card-livro'>
                <div class='imagem'>
                    <img src='../imagens/livros/$foto' alt='$titulo'>
                </div>
                <div class='informacoes'>
                    <p class='input' style='color: #000'>$titulo</p>
                    <p class='input'>Escritor: $autor</p>
                    <p class='input'>R$ $preco</p>
                    <p class='input'>$nome</p>
                </div>
            </div>";
        }
    } else {
        echo "<p>Nenhum livro encontrado!</p>";
    }

?>

    </main>
    <script src="../script.js"></script>
</body>

</html>