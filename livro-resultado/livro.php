
<?php 
include "../conexao.php";

$dado = $_GET['id'];

$select = "SELECT * FROM livro WHERE slug='$dado'";

if ($resultado = mysqli_query($conexao, $select)) {
    while ($livro = mysqli_fetch_array($resultado)) {
        echo "
               

               <!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{$livro['titulo']}</title>
</head>
<body>
       <h2>{$livro['titulo']}</h2>
      
      <p>{$livro['preco']}</p>

          <img src='../../gerenciador-estoque/cadastro de livros/' alt=''>


</body>
</html>

        ";
    }
}


?>

