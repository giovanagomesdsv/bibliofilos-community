<?php
include "../../conexao.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido!");
}

$id = (int) $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novaresenha = $_POST['resenha'];

    $update = "UPDATE RESENHAS set resenha_texto = ? WHERE resenha_id = ?";
    $stmt  = $conn->prepare($update);
    $stmt->bind_param("si", $novaresenha, $id);
    
    if ( $stmt->execute()) {
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
?>
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Resenha - BACKSTAGE Community
    </title>
</head>

<body>
    <main>

        <div>
            <img src='../../adm/imagens/livros/<?php echo $foto?>' alt=''>
            <div>
                <h1><?php echo $titulo ?></h1>
                <div>
                    <p><?php echo $sinopse ?></p>
                </div>
                <p>Avaliação:<?php echo $avaliacao ?></p>
                <p>Publicação:<?php echo $publicacao ?></p>
                <p>Atualizado:<?php echo $atualizacao ?></p>
            </div>
        </div>
        <div>
            <div>
                <form method="POST">
                    <textarea name="resenha" id="resenha" rows="10" cols="70"><?php echo htmlspecialchars($resenha); ?></textarea><br>

                    <input type="submit" value="Atualizar">
                </form>
            </div>
            <a href='m-resenhas.php'>
                <button>Cancela</button>
            </a>
        </div>

    </main>

</body>
</html>