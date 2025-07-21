<?php
include "../../conexao.php";
include "../protecao.php";


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

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="resenhas.css">
    <title>Criar resenhas - BACKSTAGE Community</title>
</head>

<body>
    <header>
        BACKSTAGE Community
    </header>
    <nav class='sidebar' id='sidebar'>
        <ul class='nav-list'>
            <div class='nome'>

                <li>
                    <a href='../perfil/perfil.php' class="perfil">

                        <?php
                        if ($usuario == 0) {
                            $imgCaminho = "../../adm/imagens/resenhistas/" . $fotoRes;
                        } else if ($usuario == 1) {
                            $imgCaminho = "../../adm/imagens/livrarias/" . $fotoLiv;
                        }
                        ?>

                        <img src="<?php echo $imgCaminho; ?>" alt="" class="img-perfil">
                        <span class='link_name'>
                            <?php echo $nome ?>
                        </span>
                    </a>
                </li>

                <div class='menu' id='menu'>
                    <i class='bx bx-menu'></i>
                </div>
            </div>
            <li>
                <a href='../../index.php'>
                    <i class='bx  bx-reply-stroke'></i>
                    <span class='link_name'>BIBLIÓFILOS Community</span>
                </a>
            </li>
            <!-- Apenas para livrarias -->
            <?php if ($usuario == 1): ?>
            <li>
                <a href='../anuncio/anuncios.php'>
                    <i class='bx bx-user'></i>
                    <span class='link_name'>Anúncios</span>
                </a>
            </li>
            <?php endif; ?>
            <li class="fix">
                <a href='#' class="#">
                    <i class='bx  bx-pencil-circle'></i>
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
        <div class="busca-container">

            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="nome do usuário">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
        <div class="pesquisa"> <!-- DIV DA CAIXA ONDE DENTRO APARECERÁ OS CARDS DO RESULTADO DA BUSCA-->
            
            <?php
            if (!isset($_GET['busca']) || empty($_GET['busca'])) {
                echo "<div class='resultados'></div>";
            } else {
                $pesquisa = $_GET['busca'];
                $pesquisa_como_like = "%$pesquisa%";

                $sql_code = "SELECT livro_id, livro_foto, livro_titulo, livro_sinopse FROM LIVROS WHERE livro_titulo LIKE ?";

                $stmt = $conn->prepare($sql_code) or die("Erro ao preparar: " . $conn->error);

                $stmt->bind_param("s", $pesquisa_como_like);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $titulo = htmlspecialchars($row['livro_titulo']);
                        $foto = htmlspecialchars($row['livro_foto']);
                        $sinopse = mb_strimwidth($sinopseCompleta, 0, 150, '...');
                        $idLivro = (int) $row['livro_id'];
                         echo "
                        <div class='card'>
                           <div class='cont'>
                            <img src='../../adm/imagens/livros/$foto' alt=''>
                                <div>
                                   <h2>$titulo</h2>
                                   <p>$sinopse</p>
                                </div>
                           </div>
                           <div>
                              <a href='criar-resenha.php?id={$idLivro}'> 
                                 <button>Criar Resenha</button>
                              </a>
                           </div>
                        </div>
                        ";
                    }
                } else {
                     echo "
                    <p>Livro não encontrado! <a href='cadastro-livro.php'>Cadastre agora.</a></p>
                    ";
                }
                $stmt->close();
            }
            ?>

            <div class="box-card">
                <?php
                $select = "SELECT livro_id, livro_foto, livro_titulo, livro_sinopse FROM LIVROS order by livro_dtpublicacao desc";
                $stmt = $conn->prepare($select);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $titulo = htmlspecialchars($row['livro_titulo']);
                        $foto = htmlspecialchars($row['livro_foto']);
                        $sinopseCompleta = htmlspecialchars($row['livro_sinopse']);
                        $sinopse = mb_strimwidth($sinopseCompleta, 0, 150, '...');
                        $idLivro = (int) $row['livro_id'];
                         echo "
                        <div class='card'>
                           <div class='cont'>
                            <img src='../../adm/imagens/livros/$foto' alt=''>
                                <div>
                                   <h2>$titulo</h2>
                                   <p>$sinopse</p>
                                </div>
                           </div>
                           <div>
                              <a href='criar-resenha.php?id={$idLivro}'> 
                                 <button class='button1'>Criar Resenha</button>
                              </a>
                           </div>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
        </div>
    </main>
    <script src="../script.js"></script>
</body>

</html>