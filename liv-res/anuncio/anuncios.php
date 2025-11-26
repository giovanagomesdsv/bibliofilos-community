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

$id = $_SESSION['id'];
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

    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="anuncios.css">
    
    <title>Anúncios - BACKSTAGE Community</title>
</head>

<body>
    <header>
        BACKSTAGE Community
    </header>
    <nav class='sidebar' id='sidebar'>
        <ul class='nav-list'>
            <div class='nome'>

                <li>
                    <a href='../perfil/perfil.php' class='perfil'>

                        <?php
                        if ($usuario == 0) {
                            $imgCaminho = "../../adm/imagens/resenhistas/" . $fotoRes;
                        } else if ($usuario == 1) {
                            $imgCaminho = "../../adm/imagens/livrarias/" . $fotoLiv;
                        }
                        ?>

                        <img src="<?php echo $imgCaminho; ?>" alt="" class='img-perfil'>
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
                <li class='fix'>
                    <a href='#'>
                        <i class='bx bx-user'></i>
                        <span class='link_name'>Anúncios</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href='../resenha/resenhas.php'>
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
        
        <div class="busca-container">
            <div class="botoes-container">
                <a href="criar-anuncio.php">
                    <button class='btnCriarAeEstoque'>Criar Anúncio</button>
                </a>
                <a href="#indisponivel">
                    <button class='btnCriarAeEstoque'>Livros sem estoque</button>
                </a>
            </div>

            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="nome do usuário">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
            <div class='anuncios-lista'>
                <?php
                if (!isset($_GET['busca']) || empty($_GET['busca'])) {
                    echo "<div></div>";
                } else {
                    $pesquisa = $_GET['busca'];
                    $pesquisa_como_like = "%$pesquisa%";
                    $sql_code = "SELECT liv_livro_id,liv_livro_idioma,liv_livro_pag,liv_livro_tipo,liv_livro_preco,liv_livro_obsadicionais,liv_livro_status, livro_titulo, livro_dtpublicacao, livro_foto FROM livrarias_livros INNER JOIN LIVROS ON livros.livro_id = livrarias_livros.livro_id WHERE livro_titulo LIKE ? AND liv_id = ?";
                    $stmt = $conn->prepare($sql_code) or die("Erro ao preparar: " . $conn->error);
                    $stmt->bind_param("si", $pesquisa_como_like, $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows == 0) {
                        echo "<div'><h3>Nenhum resultado encontrado!</h3></div>";
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            $titulo = htmlspecialchars($row['livro_titulo']);
                            $idioma = htmlspecialchars($row['liv_livro_idioma']);
                            $tipo = htmlspecialchars($row['liv_livro_tipo']);
                            $preco = htmlspecialchars($row['liv_livro_preco']);
                            $obs = htmlspecialchars($row['liv_livro_obsadicionais']);
                            $data = htmlspecialchars($row['livro_dtpublicacao']);
                            $foto = htmlspecialchars($row['livro_foto']);
                            $id = (int) $row['liv_livro_id'];
                            $pag = (int) $row['liv_livro_pag'];
                            $status = (int) $row['liv_livro_status'];
                            $statusTexto = $status === 1 ? "Disponível" : "Indisponível";
                            $statusClasse = $status === 1 ? "ativo" : "inativo";
                            echo "
                <div class='$statusClasse'>
                  <div>
                    <div>
                      <img src='../../adm/imagens/livros/$foto' alt=''>
                      <p>Publicado: $data</p>
                    </div>
                    <div>
                      <p>$titulo</p>
                      <p>$idioma</p>
                      <p>Páginas: $pag</p>
                      <p>$tipo</p>
                      <p>R$ </p>
                      <p>$obs</p>
                      <p>$statusTexto</p>
                    </div>
                  </div>
                  <div>
                    <a href='editar-anuncio.php?id=$id'>
                      <button>Atualizar</button>
                    </a>
                  </div>
                </div>";
                        }
                        $stmt->close();
                    }
                }
                ?>
            </div>

        <?php
$select = "SELECT liv_livro_id, liv_livro_idioma, liv_livro_pag, liv_livro_tipo, liv_livro_preco, liv_livro_obsadicionais, liv_livro_status, livro_titulo, livro_dtpublicacao, livro_foto 
           FROM livrarias_livros 
           INNER JOIN LIVROS ON livros.livro_id = livrarias_livros.livro_id 
           WHERE liv_id = ? 
           ORDER BY liv_livro_dtpublicacao DESC";

$stmt = $conn->prepare($select);
$stmt->bind_param("i", $id); // ID da sessão/livraria
$stmt->execute();
$result = $stmt->get_result();

$disponiveis = [];
$indisponiveis = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $livro = [
            'titulo' => htmlspecialchars($row['livro_titulo']),
            'idioma' => htmlspecialchars($row['liv_livro_idioma']),
            'tipo' => htmlspecialchars($row['liv_livro_tipo']),
            'preco' => htmlspecialchars($row['liv_livro_preco']),
            'obs' => htmlspecialchars($row['liv_livro_obsadicionais']),
            'data' => htmlspecialchars($row['livro_dtpublicacao']),
            'foto' => htmlspecialchars($row['livro_foto']),
            'id' => (int) $row['liv_livro_id'],
            'pag' => (int) $row['liv_livro_pag'],
            'status' => (int) $row['liv_livro_status']
        ];

        if ($livro['status'] == 1) {
            $disponiveis[] = $livro;
        } else {
            $indisponiveis[] = $livro;
        }
    }
}
?>
<div class="anuncios-lista">
    <?php foreach ($disponiveis as $livro): ?>
    <div class='ativo'>
        <div>
            <div>
                <img src='../../adm/imagens/livros/<?= $livro['foto'] ?>' alt=''>
                <p>Publicado: <?= $livro['data'] ?></p>
            </div>
            <div>
                <p><?= $livro['titulo'] ?></p>
                <p><?= $livro['idioma'] ?></p>
                <p>Páginas: <?= $livro['pag'] ?></p>
                <p><?= $livro['tipo'] ?></p>
                <p>R$ <?= $livro['preco'] ?></p>
                <p><?= $livro['obs'] ?></p>
                <p>Disponível</p>
            </div>
        </div>
        <div>
            <a href='editar-anuncio.php?id=<?= $livro['id'] ?>'>
                <button>Atualizar</button>
            </a>
        </div>
    </div>
<?php endforeach; ?>

</div>
<br><br>
<h2 id="indisponivel">Livros sem estoque</h2>
<div class="anuncios-lista">

<?php foreach ($indisponiveis as $livro): ?>
    <div class='inativo'>
        <div>
            <div>
                <img src='../../adm/imagens/livros/<?= $livro['foto'] ?>' alt=''>
                <p>Publicado: <?= $livro['data'] ?></p>
            </div>
            <div>
                <p><?= $livro['titulo'] ?></p>
                <p><?= $livro['idioma'] ?></p>
                <p>Páginas: <?= $livro['pag'] ?></p>
                <p><?= $livro['tipo'] ?></p>
                <p>R$ <?= $livro['preco'] ?></p>
                <p><?= $livro['obs'] ?></p>
                <p>Indisponível</p>
            </div>
        </div>
        <div>
            <a href='editar-anuncio.php?id=<?= $livro['id'] ?>'>
                <button>Atualizar</button>
            </a>
        </div>
    </div>
<?php endforeach; ?>


    </main>
    <script src="../script.js"></script>
</body>

</html>