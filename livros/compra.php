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
        echo "

        ";
    }


}
?>
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>RESENHA: {$row['livro_titulo']}</title>
</head>

<body>
    <header></header>
    <div>
        <section>
            <img src='' alt=''>
            <p></p>
            <p></p>
            <button></button>
        </section>
        <section></section>
    </div>
    <h1>{$row['livro_titulo']}</h1>
</body>

</html>