<?php
include "../../conexao.php";
include "../protecao.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$usuario = $_SESSION['tipo'];
$nome = $_SESSION['nome'];
$fotoRes = $_SESSION['imagem-res'];
$fotoLiv = $_SESSION['imagem-liv'];
$id =  $_SESSION['id'];
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
    <link rel="stylesheet" type="text/css" href="resenhas.css">
    <title>Minhas resenhas - BACKSTAGE Community</title>
</head>
<body>
<header>BACKSTAGE Community</header>

<nav class='sidebar' id='sidebar'>
    <ul class='nav-list'>
        <div class='nome'>
            <li>
                <a href='../perfil/perfil.php' class="perfil">
                    <?php
                    if ($usuario == 0) {
                        $imgCaminho = "../../adm/imagens/resenhistas/" . $fotoRes;
                    } else {
                        $imgCaminho = "../../adm/imagens/livrarias/" . $fotoLiv;
                    }
                    ?>
                    <img src="<?php echo $imgCaminho; ?>" alt="" class="img-perfil">
                    <span class='link_name'><?php echo $nome ?></span>
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

        <li class="fix">
            <a href='#'>
                 <i class='bx bx-user'></i>
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
    <!-- BARRA DE PESQUISA -->
    <div class="busca-container">
        <!--Total de resenhas publicadas-->
        <div class="contador" style='padding:0.5rem; margin-top:1rem;'>
            <?php
            $stmt = $conn->prepare("SELECT COUNT(*) as total_resenhas FROM RESENHAS WHERE res_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                echo "<div><p>Resenhas publicadas: <span class='sinopseBox2'>{$row['total_resenhas']}</span></p></div>";
            }
            ?>
        </div>

        <form action="" method="GET" class="busca-form">
            <input type="text" name="busca" placeholder="pesquisar resenha">
            <button type="submit"><i class='bx bx-search'></i></button>
        </form>
    </div>

    <div class="pesquisa">
        <div class="box-card">
        <?php
        if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $pesquisa = "%" . $_GET['busca'] . "%";
    $stmt = $conn->prepare("SELECT livro_foto, livro_titulo, livro_sinopse, livro_id FROM LIVROS 
                            WHERE livro_titulo LIKE ?");
    $stmt->bind_param("s", $pesquisa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<div class='resultados'>
          <h3 style='color: #000'>Nenhum resultado encontrado!</h3>
          <a href='cadastro-livro.php'><p style='color: #ff0000ff; text-decoration: underline'>Cadastre o livro aqui!</p></a>
        </div>";
    } else {
        while ($row = $result->fetch_assoc()) {
            $livro = htmlspecialchars($row['livro_titulo']);
            $foto = htmlspecialchars($row['livro_foto']);
            $sinopse = htmlspecialchars($row['livro_sinopse']);
            $idLivro = (int)$row['livro_id'];

            echo "
            <div class='card'>
                <div class='cont'>
                    <img src='../../adm/imagens/livros/$foto' alt='foto.png' class='fotos2'>
                    <div >
                        <h2 class='text'>$livro</h2>
                        <p class='text'>$sinopse</p>
                    </div>
                </div>
                <div class='cont2'>
                                        <a href='criar-resenha.php?id=$idLivro'><button class='botao'>CRIAR RESENHA</button></a>

                </div>
            </div>";
        }
    }
    $stmt->close();
}
        ?>
        </div> 
    </div>

    <!-- Todas as resenhas -->
    <div class="box-card">
        <?php
        $stmt = $conn->prepare("SELECT livro_foto, livro_titulo, livro_sinopse, livro_id FROM LIVROS");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $livro = htmlspecialchars($row['livro_titulo']);
            $foto = htmlspecialchars($row['livro_foto']);
            $sinopse = htmlspecialchars($row['livro_sinopse']);
            $idLivro = (int)$row['livro_id'];

            echo "
            <div class='card'>
                <div class='cont'>
                    <img src='../../adm/imagens/livros/$foto' alt='foto.png' class='fotos2'>
                    <div >
                        <h2 class='text'>$livro</h2>
                        <p class='text'>$sinopse</p>
                    </div>
                </div>
                <div class='cont2'>
                                        <a href='criar-resenha.php?id=$idLivro'><button class='botao'>CRIAR RESENHA</button></a>

                </div>
            </div>";
        }
        $stmt->close();
        ?>
    </div>
</main>

<script src="../script.js"></script>
</body>
</html>
