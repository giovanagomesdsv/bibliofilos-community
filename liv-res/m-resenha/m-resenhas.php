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
$id =  $_SESSION['id'];

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
    <link rel="stylesheet" type="text/css" href="m-resenhas.css">
    <title>Minhas resenhas - BACKSTAGE Community</title>
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
                        <span class='link_name'><?php echo $nome ?></span>
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
            <li>
                <a href='../resenha/resenhas.php'>
                    <i class='bx  bx-pencil-circle'></i>
                    <span class='link_name'>CRIAR RESENHAS</span>
                </a>
            </li>
            <li class="fix">
                <a href='#'>
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
                $count = "SELECT 
                           COUNT(resenhas.res_id) as total_resenhas
                            FROM RESENHAS
                      INNER JOIN RESENHISTAS
                              ON RESENHAS.res_id = RESENHISTAS.res_id
                           WHERE RESENHISTAS.res_id = ?";
                $stmt = $conn->prepare($count);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $contagem = (int) $row['total_resenhas'];

                    echo "
                    <div>
                       <p>Resenhas publicadas: <span class='sinopseBox2'> $contagem </span></p>
                    </div>
                    ";
                }
                ?>

            </div>

            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="pesquisar resenha">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
        <div class="pesquisa"> <!-- DIV DA CAIXA ONDE DENTRO APARECERÁ OS CARDS DO RESULTADO DA BUSCA-->
             <?php
            if (!isset($_GET['busca']) || empty($_GET['busca'])) {
                echo "<div class='resultados'></div>";
            } else {
                $pesquisa = $_GET['busca']; 
                $res_id = $id; 

                $pesquisa_como_like = "%$pesquisa%";

               
                $sql_code = "SELECT livro_foto, resenha_titulo, livro_sinopse, resenha_id FROM RESENHAS INNER JOIN LIVROS ON LIVROS.livro_id = RESENHAS.livro_id WHERE resenha_titulo LIKE ? AND res_id = ?";

                $stmt = $conn->prepare($sql_code) or die("Erro ao preparar: " . $conn->error);
                $stmt->bind_param("si", $pesquisa_como_like, $res_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        $resenha = htmlspecialchars($row['resenha_titulo']);
                        $foto = htmlspecialchars($row['livro_foto']);
                        $sinopse = htmlspecialchars($row['livro_sinopse']);
                        $idResenha = (int) $row['resenha_id'];

                        echo "
                          <div class='card'>
                           <div class='cont'>
                              <img src='../../adm/imagens/livros/$foto' alt='foto.png' style='border: 2px solid red;'>
                              <div>
                                 <h2 style='color: black'>$titulo</h2>
                                 <p style='color: black'>$sinopse</p>
                              </div>
                           </div>
                           <div class='cont2'>
                              <a href='abrir.php?id={$idResenha}'> 
                                 <button class='botao'>ABRIR</button>
                              </a>
                              <a href='atualizar.php?id={$idResenha}'> 
                                 <button class='botao'>ATUALIZAR</button>
                              </a>
                           </div>
                        </div>
                        ";
                    }
                }
                $stmt->close();
            }
            ?>
        </div>

        <div>
             <?php
            $consulta = "SELECT livro_foto, resenha_titulo, livro_sinopse, resenha_id, resenha_status FROM RESENHAS INNER JOIN LIVROS ON LIVROS.livro_id = RESENHAS.livro_id  WHERE res_id = ?";
            $stmt = $conn->prepare($consulta);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $resenha = htmlspecialchars($row['resenha_titulo']);
                    $foto = htmlspecialchars($row['livro_foto']);
                    $sinopse = htmlspecialchars($row['livro_sinopse']);
                    $status = htmlspecialchars($row['resenha_status']);
                    $idResenha = (int) $row['resenha_id'];

                    if ($status ==  3) {
                        echo "
                    
                        <div class="containC">
                    <div class="display">
                        <img src='../../adm/imagens/livros/$foto' alt='foto.png' class='fotos2'>

                        <div>
                        <p>$titulo</p>
                        <p class='sinopseBox2'>$sinopse</p>
                        </div>

                        <a href='atualizar.php?id={$idResenha}'>
                        <button class="ContainCBtn">CORRIGIR</button>
                        </a>
                    </div>
                    </div>
                       ";
                    } else if ($status == 1) {
                        echo "
                        <div class="containR">
                        <div class="display">
                            <img src='../../adm/imagens/livros/$foto' alt='foto.png' class="fotos2">

                            <div>
                            <p>$titulo</p>
                            <p class="sinopseBox2">$sinopse</p>
                            </div>

                            <form action='deletar.php?id={$idResenha}' method='POST'>
                            <input type='submit' value='REPROVADA' class="containRBtn">
                            </form>
                        </div>
                        </div>
                       ";
                    }
                }
            }
            ?>

        </div>

        <div class="box-card">
        <?php
        $code = "SELECT livro_foto, resenha_titulo, livro_sinopse, resenha_id FROM RESENHAS INNER JOIN LIVROS ON LIVROS.livro_id = RESENHAS.livro_id WHERE res_id = ? order by resenha_dtpublicacao desc";
        $stmt = $conn->prepare($code);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resenha = htmlspecialchars($row['resenha_titulo']);
                $foto = htmlspecialchars($row['livro_foto']);
                $sinopse = htmlspecialchars($row['livro_sinopse']);
                $idResenha = (int) $row['resenha_id'];

                echo "
                        <div class='card'>
                           <div class='cont'>
                              <img src='../../adm/imagens/livros/$foto' alt='foto.png' style='border: 2px solid red;'>
                              <div>
                                 <h2 style='color: black'>$titulo</h2>
                                 <p style='color: black'>$sinopse</p>
                              </div>
                           </div>
                           <div class='cont2'>
                              <a href='abrir.php?id={$idResenha}'> 
                                 <button class='botao'>ABRIR</button>
                              </a>
                              <a href='atualizar.php?id={$idResenha}'> 
                                 <button class='botao'>ATUALIZAR</button>
                              </a>
                           </div>
                        </div>
                        ";
            }
        }
        $stmt->close();
        ?>
        </div>

    </main>
    <script src="../script.js"></script>
</body>

</html>