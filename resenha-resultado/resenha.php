
<?php
include "../conexao.php";

$dado = $_GET['id'];

$select = "SELECT resenha_titulo,resenha_texto,resenha_avaliacao,resenha_dtpublicacao,resenha_dtatualizacao, livro_foto, livro_sinopse, aut_foto, res_nome_fantasia, res_foto, res_perfil, res_social FROM resenhas INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN LIVRO_AUTORES ON LIVRO_AUTORES.livro_id = LIVROS.livro_id INNER JOIN AUTORES ON LIVRO_AUTORES.aut_id = AUTORES.aut_id INNER JOIN RESENHISTAS ON RESENHAS.res_id = RESENHISTAS.res_id
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

    <link rel='stylesheet' type='text/css' href='../geral.css'>
    <title>BIBLIÓFILOS Community - RESENHA: $titulo</title>
</head>
<body>
    <header>
       <p>$atualizado</p>
       <p>$publicacao</p>
    </header>

    <img src='../adm/imagens/livros/$foto' alt=''>
    <img src='../adm/imagens/autores/$autor' alt=''>


    <h2>RESENHA: $titulo</h2>
    <p>SINOPSE: $sinopse</p>
    <p>$avaliacao</p>
    <p>CONTEÚDO: $texto</p>

    <div>
        <img src='../adm/imagens/resenhistas/$resenhista' alt=''>
        <p>$resenhistaPerfil</p>
        <div>
            <a href='$resenhistaSocial'></a>
        </div>
    </div>

</body>
</html>
        ";
    }
}
?>
