<?php
include("../conexao.php");
$dado = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$select = "SELECT liv_livro_idioma,
                  liv_livro_pag,
                  liv_livro_tipo,
                  liv_livro_preco,
                  liv_livro_obsadicionais,
                  liv_livro_dtpublicacao, 
                  liv_nome,
                  liv_cidade,
                  liv_estado,
                  liv_endereco,
                  liv_telefone,
                  liv_email,
                  liv_foto,
                  liv_perfil,
                  liv_social,  
                  livro_titulo, 
                  livro_sinopse, 
                  livro_editora, 
                  livro_isbn, 
                  livro_ano, 
                  livro_classidd, 
                  livro_foto, 
                  aut_nome
           FROM livrarias_livros 
           LEFT JOIN livrarias ON livrarias.liv_id = livrarias_livros.liv_id 
           LEFT JOIN livros ON livros.livro_id = livrarias_livros.livro_id 
           LEFT JOIN resenhas on resenhas.livro_id = livros.livro_id
           LEFT JOIN livro_autores ON livro_autores.livro_id = livros.livro_id 
           LEFT JOIN autores ON autores.aut_id = livro_autores.aut_id 
           WHERE livrarias_livros.liv_livro_id = ?";

$stmt = $conn->prepare($select);
$stmt->bind_param("i", $dado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $preco = htmlspecialchars($row['liv_livro_preco']);
        $titulo = htmlspecialchars($row['livro_titulo']);
        $autor = htmlspecialchars($row['aut_nome']);
        $mensagem = urlencode("Olá, vim pelo site Bibliófilos Community. Gostaria de saber mais/adquirir o livro $titulo, do autor $autor que está sendo anunciado pelo valor de R$ $preco.");
        $telefone = htmlspecialchars($row['liv_telefone']);
        $foto = htmlspecialchars($row['livro_foto']);
        $ano = htmlspecialchars($row['livro_ano']);
        $editora = htmlspecialchars($row['livro_editora']);
        $sinopse = htmlspecialchars($row['livro_sinopse']);
        $nome_liv = htmlspecialchars($row['liv_nome']);
        $endereco_liv = htmlspecialchars($row['liv_endereco']);
        $cidade_liv = htmlspecialchars($row['liv_cidade']);
        $estado_liv = htmlspecialchars($row['liv_estado']);
        $isbn = htmlspecialchars($row['livro_isbn']);
        $pag = htmlspecialchars($row['liv_livro_pag']);
        $obs = htmlspecialchars($row['liv_livro_obsadicionais']);
        $tipo = htmlspecialchars($row['liv_livro_tipo']);
        $idioma = htmlspecialchars($row['liv_livro_idioma']);
        $idd = htmlspecialchars($row['livro_classidd']);


        echo "
        <!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel='stylesheet' href='../global.css'>
    <link rel='stylesheet' href='livros.css'>

    <title>RESENHA: $titulo</title>
</head>

<body>
    <header>
    </header>
    <div class='box'>
        <section class='l1'>
            <div>
                <img src='../adm/imagens/livros/$foto' alt=''>
            </div>
            <div>
                <p>$ano</p>
                <p>$editora</p>
            </div>
            <a href='https://wa.me/{$telefone}?text=$mensagem' target='_blank'>
                <button>
                    <p>Obter agora</p>
                </button>
            </a>
        </section>
        <section class='l2'>
            <div>
                <h1>$titulo</h1>
                <p>$autor</p>
                <h2>RS $preco</h2>
            </div>
            <div>
                <p>$sinopse</p>
            </div>
            <div>
                <p><span>ANUNCIADO POR:</span>  $nome_liv</p>
                <p>$endereco_liv. $cidade_liv, ($estado_liv)</p>
            </div>
            <div>
                <h3>Detalhes do produto:</h3>
                <div>
                    <p><span>isbn:</span> $isbn</p>
                    <p>$pag páginas</p>
                    <p>$obs</p>
                    <p>$tipo</p>
                    <p>$idioma</p>
                    <p>$idd</p>
                </div>
            </div>
        </section>
    </div>
    <div>
        <footer class='site-footer'>
            <div class='footer-logo'>
                <img src='../logo.png' alt='Logo do site'>
            </div>

            <div class='footer-texto'>
                <h3>Participe da nossa comunidade.</h3>
                <p>Se torne um resenhista.</p>
                <p>Entre em contato já!</p>
            </div>

            <div class='footer-redes'>
                <a href='#' target='_blank' aria-label='X'><i class='bx bxl-xing' style='color: #fff'></i></a>
                <a href='#' target='_blank' aria-label='Instagram'><i class='bx bxl-instagram'
                        style='color: #fff'></i></a>
                <a href='#' target='_blank' aria-label='TikTok'><i class='bx bxl-tiktok' style='color: #fff'></i></a>
            </div>
        </footer>
    </div>
</body>

</html>
        ";
    }


}
?>

