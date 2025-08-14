<?php
include "../conexao.php";

$dado = $_GET['id'];

$select = "SELECT resenha_titulo,resenha_texto,resenha_avaliacao, resenha_dtpublicacao,resenha_dtatualizacao, livro_foto, livro_sinopse, aut_foto, res_nome_fantasia, res_foto, res_perfil, res_social, livro_titulo FROM resenhas INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN LIVRO_AUTORES ON LIVRO_AUTORES.livro_id = LIVROS.livro_id INNER JOIN AUTORES ON LIVRO_AUTORES.aut_id = AUTORES.aut_id INNER JOIN RESENHISTAS ON RESENHAS.res_id = RESENHISTAS.res_id
 WHERE resenha_id = ?";
$stmt = $conn->prepare($select);
$stmt->bind_param("i", $dado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($linha = $result->fetch_assoc()) {
        $publicacao = htmlspecialchars($linha['resenha_dtpublicacao']);
        $atualizado = htmlspecialchars($linha['resenha_dtatualizacao']);
        $titulo = htmlspecialchars($linha['resenha_titulo']);
        $livro = htmlspecialchars($linha['livro_titulo']);
        $foto = htmlspecialchars($linha['livro_foto']);
        $sinopse = htmlspecialchars($linha['livro_sinopse']);
        $texto = htmlspecialchars($linha['resenha_texto']);
        $autor = htmlspecialchars($linha['aut_foto']);
        $resenhistaNome = htmlspecialchars($linha['res_nome_fantasia']);
        $resenhista = htmlspecialchars($linha['res_foto']);
        $resenhistaPerfil = htmlspecialchars($linha['res_perfil']);
        $resenhistaSocial = htmlspecialchars($linha['res_social']);
        $avaliacao = (int) $linha['resenha_avaliacao'];

        echo "      
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <link rel='stylesheet' href='../global.css'>
    <link rel='stylesheet' href='result-resenha.css'>

    <title>BIBLIÓFILOS Community - RESENHA: $titulo</title>
</head>

<body>
    <header>
        <p>Atualizado: $atualizado</p>
        <p>Publicado: $publicacao</p>
    </header>

    <div class='.container'>
        <section class='sec1'>
            <img src='../adm/imagens/livros/$foto' alt=''>
            <img src='../adm/imagens/autores/$autor' alt=''>
        </section>
        <section class='sec2'>
            <div class='cabecalho'>
                <h2>$titulo</h2>
                <p>Livro: $livro</p>
            </div>
            <div class='conteudo'>
                <div class='sinopse'>
                    <p><span>SINOPSE:</span> $sinopse</p>
                    <p>$avaliacao</p>
                </div>
                <div class='resenha'>
                    <p><span>CONTEÚDO:</span> $texto</p>
                </div>
            </div>
            <div class='resenhista'>
                <div class='imagem'>
                    <img src='../adm/imagens/resenhistas/$resenhista' alt=''>
                </div>
                <div class='resumo'>
                    <p>$resenhistaPerfil</p>
                </div>
                <div class='footer-redes'>
                    <a href='$resenhistaSocial' target='_blank' aria-label='Instagram'><i class='bx bxl-instagram'
                            style='color: #fff'></i></a>
                </div>
            </div>
        </section>
    </div>
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
            <a href='#' target='_blank' aria-label='Instagram'><i class='bx bxl-instagram' style='color: #fff'></i></a>
            <a href='#' target='_blank' aria-label='TikTok'><i class='bx bxl-tiktok' style='color: #fff'></i></a>
        </div>
    </footer>


</body>

</html>";
    }
}
?>