<?php
include "../../conexao.php";
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido!");
}

$livro_id = (int) $_GET['id'];
$liv_id = $_SESSION['id'];      

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idioma = trim($_POST['idioma']);
    $pagina = (int) $_POST['pagina'];
    $tipo = trim($_POST['tipo']);
    $preco = (float) $_POST['preco'];
    $obs = trim($_POST['obs']);

    $status = 1;
    $dataPublicacao = date("Y-m-d");

    $sql = "INSERT INTO livrarias_livros (
                liv_id, livro_id, liv_livro_idioma, liv_livro_pag,
                liv_livro_tipo, liv_livro_preco, liv_livro_obsadicionais,
                liv_livro_status, liv_livro_dtpublicacao
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "iisssdsis",
            $liv_id,
            $livro_id,
            $idioma,
            $pagina,
            $tipo,
            $preco,
            $obs,
            $status,
            $dataPublicacao
        );

        if ($stmt->execute()) {
            header("Location: anuncios.php");
            exit();
        } else {
            echo "<p>Erro ao publicar: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Erro ao preparar: " . $conn->error . "</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Anúncios - BACKSTAGE Community</title>
</head>

<body>
    <form action="" method="POST">
        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" required>

        <label for="pagina">Páginas:</label>
        <input type="number" name="pagina" required>

        <label for="tipo">Tipo do livro:</label>
        <select name="tipo" required>
            <option value="">Selecione...</option>
            <option value="Físico">Físico</option>
            <option value="Digital">Digital</option>
        </select>

        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" required>

        <label for="obs">Observações adicionais:</label>
        <input type="text" name="obs">

        <button type="submit">Publicar</button>
    </form>
</body>

</html>
