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

    <link rel="stylesheet" href="../geral.css">
    <title>Minhas resenhas - BACKSTAGE Community</title>
</head>

<body>
    <header>
        BACKSTAGE Community
    </header>
    <nav class='sidebar' id='sidebar'>
        <ul class='nav-list'>
            <div class='nome'>

                <li class='logo_name'>
                    <a href='../perfil/perfil.php'>

                        <?php
                        if ($usuario == 0) {
                            $imgCaminho = "../../adm/imagens/resenhistas/" . $_SESSION['imagem-res'];
                        } else if ($usuario == 1) {
                            $imgCaminho = "../../adm/imagens/livrarias/" . $_SESSION['imagem-liv'];
                        }
                        ?>

                        <img src="<?php echo $imgCaminho; ?>" alt="" style="width:100px">

                        <span class='link_name'>
                            <?php echo $_SESSION['nome'] ?>
                        </span>
                    </a>
                </li>

                <div class='menu' id='menu'>
                    <i class='bx bx-menu'></i>
                </div>
            </div>
            <li>
                <a href='../../index.php'>
                    <i class='bx bx-user'></i>
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
                    <i class='bx bx-user'></i>
                    <span class='link_name'>Criar resenhas</span>
                </a>
            </li>
            <li class="fix">
                <a href='#'>
                    <i class='bx bx-user-pin'></i>
                    <span class='link_name'>Minhas resenhas</span>
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
            <div>
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
                       <p>Resenhas publicadas:</p>
                       <p>$contagem</p>
                    </div>
                    ";
                }
                ?>

            </div>

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

                // Proteção contra SQL Injection usando prepared statements
                $pesquisa = $_GET['busca']; // Sem real_escape_string aqui
                $res_id = $id; // Substitua pelo valor correto conforme seu contexto

                // Adiciona os % aqui, não na query
                $pesquisa_como_like = "%$pesquisa%";

                // Query com placeholders
                $sql_code = "SELECT livro_foto, resenha_titulo, livro_sinopse, resenha_id FROM RESENHAS INNER JOIN LIVROS ON LIVROS.livro_id = RESENHA.livro_id WHERE resenha_titulo LIKE ? AND res_id = ?";

                // Prepara a query
                $stmt = $conn->prepare($sql_code) or die("Erro ao preparar: " . $conn->error);

                // Liga os parâmetros: "s" para string (LIKE), "i" para integer (res_id)
                $stmt->bind_param("si", $pesquisa_como_like, $res_id);

                // Executa a query
                $stmt->execute();

                // Pega os resultados
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
                        <div>
                           <div>
                              <img src='../../adm/imagens/livros/$foto' alt=''>
                              <div>
                                 <h2> $resenha</h2>
                                 <p>$sinopse</p>
                              </div>
                           </div>
                           <div>
                              <a href='abrir.php?id={$idResenha}'> 
                                 <button>Abrir resenha</button>
                              </a>
                              <a href='abrir.php?id={$idResenha}'> 
                                 <button>Atualizar resenha</button>
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
        <?php
        $code = "SELECT livro_foto, resenha_titulo, livro_sinopse, resenha_id FROM RESENHAS INNER JOIN LIVROS ON LIVROS.livro_id = RESENHAS.livro_id WHERE res_id = ?";
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
                        <div>
                           <div>
                              <img src='../../adm/imagens/livros/$foto' alt=''>
                              <div>
                                 <h2> $resenha</h2>
                                 <p>$sinopse</p>
                              </div>
                           </div>
                           <div>
                              <a href='abrir.php?id={$idResenha}'> 
                                 <button>Abrir resenha</button>
                              </a>
                              <a href='atualizar.php?id={$idResenha}'> 
                                 <button>Atualizar resenha</button>
                              </a>
                           </div>
                        </div>
                        ";
            }
        }
        $stmt->close();
        ?>

    </main>
    <script src="../script.js"></script>
</body>

</html>