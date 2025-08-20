<?php
include "../conexao.php";
$dado = $_GET['id'];

$select = "SELECT aut_nome, aut_bio, aut_foto, livro_foto 
           FROM AUTORES 
           INNER JOIN LIVRO_AUTORES ON AUTORES.aut_id = LIVRO_AUTORES.aut_id 
           INNER JOIN LIVROS ON LIVROS.livro_id = LIVRO_AUTORES.livro_id  
           WHERE AUTORES.aut_id = ?";
$stmt = $conn->prepare($select);
$stmt->bind_param("i", $dado);
$stmt->execute();
$result = $stmt->get_result();

$livros = [];
$autor = "";
$bio = "";
$foto = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Captura os dados do autor uma única vez
        if (empty($autor)) {
            $autor = htmlspecialchars($row['aut_nome']);
            $bio = htmlspecialchars($row['aut_bio']);
            $foto = htmlspecialchars($row['aut_foto']);
        }

        // Adiciona cada livro ao array
        $livros[] = htmlspecialchars($row['livro_foto']);
    }
}
?>

<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php echo $autor; ?></title>
    <style>
        .container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .box-livros {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .box-livros img {
            width: 120px;
            height: auto;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <header>
        <h1><?php echo $autor; ?></h1>
    </header>

    <div class='container'>
        <section>
            <img src='../adm/imagens/autores/<?php echo $foto; ?>' alt='Foto de <?php echo $autor; ?>' width='200'>
        </section>
        <section>
            <p><?php echo nl2br($bio); ?></p>
        </section>
    </div>

    <div class="box-livros">
        <?php foreach ($livros as $livro): ?>
            <img src='../adm/imagens/livros/<?php echo $livro; ?>' alt='Capa do livro'>
        <?php endforeach; ?>
    </div>
</body>
</html>
