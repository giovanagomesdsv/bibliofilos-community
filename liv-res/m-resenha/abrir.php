<?php
include "../../conexao.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido!");
}

$id = (int) $_GET['id'];

$SELECT = "SELECT resenha_titulo, resenha_texto, resenha_avaliacao, resenha_dtpublicacao,
resenha_dtatualizacao, livro_foto, livro_sinopse FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id WHERE resenha_id = ?";
$stmt = $conn->prepare($SELECT);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $titulo = htmlspecialchars($row['resenha_titulo']);
    $foto = htmlspecialchars($row['livro_foto']);
    $sinopse = htmlspecialchars($row['livro_sinopse']);
    $resenha = htmlspecialchars($row['resenha_texto']);
    $publicacao = htmlspecialchars($row['resenha_dtpublicacao']);
    $atualizacao = htmlspecialchars($row['resenha_dtatualizacao']);
    $avaliacao = (int) ($row['resenha_avaliacao']);

    echo "
    <!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" type="text/css" href="../geral.css">
    <link rel="stylesheet" type="text/css" href="m-resenhas.css">
    <title>Resenha - BACKSTAGE Community
    </title>

</head>

<body>
     <header>
        BACKSTAGE Community
    </header>
     <main>
        <div class='card card1'>
            <div class='cardimgsinopse'>
                <div class="box-img">
                    <img class='imagem1' src='../../adm/imagens/livros/<?php echo $foto ?>' alt=''>
                </div>
                <div class="sinopse">
                    <h1>
                        <?php echo $titulo ?>
                    </h1>
                    <p class="texto">
                        Sinopse:
                        <?php echo $sinopse ?>
                    </p>
                </div>
            </div>
            <div>
                <div>
                    <form method="POST">

                        <div>
                            <label class="resenhabox" for="resenha">Resenha:</label><br>
                            <textarea class="resenha" name="resenha" id="resenha" rows="5" cols="60"
                                required></textarea><br><br>
                        </div>

                        <label for="avaliacao">Avaliação do livro:</label><br>
                        <div class="rating">
                            <input type="radio" id="estrela5" name="avaliacao" value="5"><label for="estrela5">★</label>
                            <input type="radio" id="estrela4" name="avaliacao" value="4"><label for="estrela4">★</label>
                            <input type="radio" id="estrela3" name="avaliacao" value="3"><label for="estrela3">★</label>
                            <input type="radio" id="estrela2" name="avaliacao" value="2"><label for="estrela2">★</label>
                            <input type="radio" id="estrela1" name="avaliacao" value="1" required><label
                                for="estrela1">★</label>
                        </div><br><br>

                    </form>
                </div>
                <a class="notas" href='m-resenhas.php'>
                    <button class="botao1">Voltar</button>
                </a>
            </div>
        </div>
    </main>
</body>

</html>    ";
}
?>