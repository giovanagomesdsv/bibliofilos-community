<?php
include "../../conexao.php";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $titulo = $_POST['titulo'];
    $sinopse = $_POST['sinopse'];
    $editora = $_POST['editora'];
    $isbn = $_POST['isbn'];
    $ano = $_POST['ano'];
    $idd = $_POST['idd'];

    $path = "";

    // Upload da imagem
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
        $arquivo = $_FILES['arquivo'];

        if ($arquivo['size'] > 2 * 1024 * 1024) {
            echo "<script>alert('Arquivo muito grande. Máximo 2MB.'); history.back();</script>";
            exit;
        }

        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, ['jpg', 'png', 'jpeg'])) {
            echo "<script>alert('Apenas arquivos JPG ou PNG são permitidos.'); history.back();</script>";
            exit;
        }

        $novoNome = uniqid() . '.' . $extensao;
        $pasta = "../../adm/imagens/livros/";
        $caminho = $pasta . $novoNome;

        if (!move_uploaded_file($arquivo['tmp_name'], $caminho)) {
            echo "<script>alert('Erro ao salvar a imagem.'); history.back();</script>";
            exit;
        }

        $path = $novoNome;
    } else {
        echo "<script>alert('Erro no envio da imagem.'); history.back();</script>";
        exit;
    }

    $insert = "INSERT INTO LIVROS (livro_titulo, livro_sinopse, livro_editora, livro_isbn, livro_ano, livro_classidd, livro_foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("ssssiss", $titulo, $sinopse, $editora, $isbn, $ano, $idd, $path);
    
    if ($stmt->execute()) {
        $livro_id = $conn->insert_id; // Pega o ID do livro recém-inserido
        echo "
        <script>
        window.location.href = 'cadastrar_autor.php?id_livro=$livro_id';
        </script>
        ";
    } else {
        echo "<script>
            alert('Erro ao cadastrar.');
            history.back();
        </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro - BACKSTAGE Community</title>
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>

        <label for="sinopse">Sinopse:</label>
        <textarea name="sinopse" required></textarea>

        <label for="editora">Editora:</label>
        <input type="text" name="editora" required>

        <label for="isbn">Isbn:</label>
        <input type="text" name="isbn">

        <label for="ano">Ano de publicação:</label>
        <input type="year" name="ano" required>

        <label for="idd">Classificação de idade:</label>
        <select name="idd" required>
            <option value="Livre">Livre</option>
            <option value="10+">10+</option>
            <option value="12+">12+</option>
            <option value="14+">14+</option>
            <option value="16+">16+</option>
            <option value="18+">18+</option>
        </select>

        <label for="arquivo" required>Imagem do livro:</label>
        <input type="file" name="arquivo" accept=".jpg,.jpeg,.png">

        <input type="submit" value="Enviar">
    </form>
<!-- window.location.href = 'cadastrar_autor.php?id_livro=$livro_id'; -->
</body>

</html>