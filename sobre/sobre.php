<?php 
include "../conexao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIÓFILOS Community - Sobre</title>
</head>

<body>
    <nav>
        <a href="../index.php">Home</a>
        <a href="../resenhas/resenhas.php">Resenhas</a>
        <a href="../autores/autores.php">Autores</a>
        <a href="../livros/livros.php">Livros</a>
        <a href="#">Sobre</a>
    </nav>
   
    <main>
        <?php 
        $select = " SELECT 
                ar.id_autor_resenha,
                ar.nome,
                ar.pseudonimo,
                ar.email,
                ar.path,
                ar.pontos,
                ar.telefone,
                COUNT(r.id_resenha) AS total_resenhas
            FROM 
                autor_resenha ar
            LEFT JOIN 
                resenha r 
            ON 
                ar.id_autor_resenha = r.id_autor_resenha
            GROUP BY 
                ar.id_autor_resenha, ar.nome, ar.pseudonimo, ar.email, ar.path, ar.pontos ";

        if ($resp = mysqli_query($conexao, $select)) {
            while ($resenhista = mysqli_fetch_array($resp)) {
                echo "
                  <div>
                    <img src='../../administrador/resenhistas/{$resenhista['path']}' alt=''>
                    <h3>{$resenhista['pseudonimo']}</h3>
                    <p>Resenhas: {$resenhista['total_resenhas']}</p>
                  </div>
                ";
            }
        }
        ?>
    </main>
</body>

</html>