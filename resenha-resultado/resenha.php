
<?php 
include "../conexao.php";

$dado = $_GET['id'];

$select = "SELECT titulo, nome, sinopse, conteudo, resenha.path as resenha_foto, escritor.path as escritor_foto FROM resenha INNER JOIN escritor ON resenha.id_escritor = escritor.id_escritor WHERE resenha.slug='$dado'";

if ($resultado = mysqli_query($conexao, $select)) {
    while ($resenha = mysqli_fetch_array($resultado)) {
        echo "
               

               <!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <link rel='stylesheet' type='text/css' href='../geral.css'>
    <title>{$resenha['titulo']}</title>
</head>
<body>
       <h2>{$resenha['titulo']}</h2>
       <h2>{$resenha['nome']}</h2>
      <p>SINOPSE: {$resenha['sinopse']}</p>
      <p>CONTEÚDO: {$resenha['conteudo']}</p>

       <img src='../../administrador/resenha/{$resenha['resenha_foto']}' alt=''>
       <img src='../../administrador/autores/{$resenha['escritor_foto']}' alt=''>


    
</body>
</html>

        ";
    }
}


?>
