<?php
include "../../conexao.php";
session_start();

// Verifica se veio o ID do livro
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
        alert('ID do livro inválido.');
        window.location.href = 'anuncios.php';
    </script>";
    exit;
}

$livro_id = (int) $_GET['id'];
$liv_id = $_SESSION['id'];

if (!$liv_id) {
    echo "<script>
        alert('Usuário não autenticado.');
        window.location.href = '../../login.php';
    </script>";
    exit;
}

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
            echo "<script>
                alert('Publicado com sucesso!');
                window.location.href = 'anuncios.php';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao publicar: " . addslashes($stmt->error) . "');
                history.back();
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Erro ao preparar SQL: " . addslashes($conn->error) . "');
            history.back();
        </script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Anúncios - BACKSTAGE Community</title>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="anuncios.css">
</head>

<body>
    <form action="publicar.php?id=<?= htmlspecialchars($livro_id) ?>" method="POST" class="format4">
    <h1>Publicar Anúncio</h1>

    <label for="idioma">Idioma:</label>
    <input type="text" name="idioma" required class="inputEditar4">

    <label for="pagina">Páginas:</label>
    <input type="number" name="pagina" required class="inputEditar4">

    <label for="tipo">Tipo do livro:</label>
    <select name="tipo" required class="selectResenhista4">
        <option value="">Selecione...</option>
        <option value="Físico">Físico</option>
        <option value="Digital">Digital</option>
    </select>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" name="preco" required class="inputEditar4">

    <label for="obs">Observações adicionais:</label>
    <input type="text" name="obs" class="inputEditar4">

    <input type="submit" value="Publicar" class="inputEditar4">
    <a href="anuncios.php" style="color:white;">Voltar</a>
</form>
</body>

</html>
