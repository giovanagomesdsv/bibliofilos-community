<?php
include("conexao.php");
$dado = $_GET['id'];

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
           LEFT JOIN resenhas on resenhas.liv_id = resenhas.liv_id
           LEFT JOIN livro_autores ON livro_autores.livro_id = livros.livro_id 
           LEFT JOIN autores ON autores.aut_id = livro_autores.aut_id 
           WHERE livros.livro_id = ?";

$stmt = $conn->prepare($select);
$stmt->bind_param("s", $dado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Criação das variáveis individuais
    $livro_idioma       = $row['liv_livro_idioma'];
    $livro_paginas      = $row['liv_livro_pag'];
    $livro_tipo         = $row['liv_livro_tipo'];
    $livro_preco        = $row['liv_livro_preco'];
    $livro_obs          = $row['liv_livro_obsadicionais'];
    $livro_data_pub     = $row['liv_livro_dtpublicacao'];

    $nome      = $row['liv_nome'];
    $cidade    = $row['liv_cidade'];
    $estado    = $row['liv_estado'];
    $endereco  = $row['liv_endereco'];
    $telefone  = $row['liv_telefone'];
    $email     = $row['liv_email'];
    $foto      = $row['liv_foto'];
    $perfil    = $row['liv_perfil'];
    $social    = $row['liv_social'];

    $titulo             = $row['livro_titulo'];
    $sinopse            = $row['livro_sinopse'];
    $editora            = $row['livro_editora'];
    $isbn               = $row['livro_isbn'];
    $ano                = $row['livro_ano'];
    $classificacao      = $row['livro_classidd'];
    $livro_foto         = $row['livro_foto'];

    $autor              = $row['aut_nome'];
} else {
    $titulo = null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESENHA: <?php echo $titulo?> - </title>
</head>

<body>

</body>

</html>