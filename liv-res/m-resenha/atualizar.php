 <!-- <?php
include "../../conexao.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido!");
}

$id = (int) $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novaresenha = $_POST['resenha'];
    $avaliacao = $_POST["avaliacao"];


    $update = "UPDATE RESENHAS set resenha_texto = ?, resenha_avaliacao = ? WHERE resenha_id = ?";
    $stmt  = $conn->prepare($update);
    $stmt->bind_param("sii", $novaresenha, $avaliacao, $id);

    if ($stmt->execute()) {
        echo "
        <script>
        alert('Resenha atualizada com sucesso!');
        window.location.href = 'm-resenhas.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Erro ao atualizar!');
        </script>
        ";
    }
    $stmt->close();
}

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
}
?> -->
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
    <main class='containA'>

        <div>
            <div>
                <p class='titulos'>Publicação:<?php echo $publicacao ?></p>
                <h1><?php echo $titulo ?></h1>
                <div class='display'>
                <img src='../../adm/imagens/livros/<?php echo $foto ?>' alt='foto' class='fotos'>
                    <p class='sinopseBox'><?php echo $sinopse ?></p>
                </div>
                <p class='titulos'>Atualizado:<?php echo $atualizacao ?></p>

            </div>
        </div>
        <div>
            <div>
                <form method="POST">
                    <textarea name="resenha" id="resenha" rows="10" cols="70" class='resenhaText'><?php echo htmlspecialchars($resenha); ?></textarea><br>
                <div class='display'>
                    <label for="avaliacao" class='avali'>Avaliação do livro:</label><br>
                    <div class='rating ratingstylish'>
                        <input type="radio" id="estrela5" name="avaliacao" value="5" <?php if ($avaliacao === 5) echo 'checked'; ?><label for="estrela5">★</label>
                        <input type="radio" id="estrela4" name="avaliacao" value="4" <?php if ($avaliacao === 4) echo 'checked'; ?><label for="estrela4">★</label>
                        <input type="radio" id="estrela3" name="avaliacao" value="3" <?php if ($avaliacao === 3) echo 'checked'; ?><label for="estrela3">★</label>
                        <input type="radio" id="estrela2" name="avaliacao" value="2" <?php if ($avaliacao === 2) echo 'checked'; ?><label for="estrela2">★</label>
                        <input type="radio" id="estrela1" name="avaliacao" value="1" <?php if ($avaliacao === 1) echo 'checked'; ?><label for="estrela1">★</label>
                    </div><br><br>
                </div>
        <div class='display'>
                    <input type="submit" value="Enviar" class='btn'>
                    <a href='m-resenhas.php'>
                <button class='btn'>Cancelar</button>
            </a>
        </div>
                </form>
            </div>
        </div>

    </main>

</body>

</html>