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
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="resenhas.css">
</head>

<body>
    <main>

        <p class='textnotificaçao1'>CADASTRAR LIVRO</p>
        <div class="card card2">
            <form method="POST" enctype="multipart/form-data">


                <div class="titulo">
                    <label for="titulo">Título:</label>
                    <input class="teste" type="text" name="titulo" required>
                </div>
                <div class="ismbimgano">
                    <div class="input-wrapper">
                        <label class="texto" for="arquivo" required>Imagem do livro:</label>
                        <input class="teste" type="file" name="arquivo" accept=".jpg,.jpeg,.png">
                    </div>

                    <div class="input-wrapper">
                        <label for="isbn">Isbn:</label>
                        <input class="teste" type="text" name="isbn">
                    </div>
                    <div class="input-wrapper">
                        <label for="ano">Ano de publicação:</label>
                        <input class="teste" type="year" name="ano" required>
                    </div>
                </div>
                <div class="ismbimgano">
                    <div class="input-wrapper">
                        <label for="idd">Classificação de idade:</label>
                        <select class="teste" name="idd" required>
                            <option class="teste" value="Livre">Livre</option>
                            <option class="teste" value="10+">10+</option>
                            <option class="teste" value="12+">12+</option>
                            <option class="teste" value="14+">14+</option>
                            <option class="teste" value="16+">16+</option>
                            <option class="teste" value="18+">18+</option>
                        </select>
                    </div>
                    <div class="input-wrapper">
                        <label for="editora">Editora:</label>
                        <input class="teste" type="text" name="editora" required>
                    </div>
                </div>
                <div class="sinop">
                    <label class="resenhabox" for="sinopse">Sinopse:</label>
                    <textarea class="resenha" name="sinopse" required></textarea>
                </div>
                <input class="botao2" type="submit" value="Enviar">
            </form>

        </div>
    </main>
</body>

</html>