<?php
include "../../conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Criar Anúncios - BACKSTAGE Community</title>
</head>

<body>

    <form action="" method="POST" class="busca-form">
        <label for="nome">Nome do livro:</label>
        <input type="text" name="nome" required>

        <label for="editora">Editora:</label>
        <input type="text" name="editora" required>

        <label for="ano">Ano de publicação:</label>
        <input type="number" name="ano" required>

        <button type="submit"><i class='bx bx-search'></i></button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome']);
        $editora = trim($_POST['editora']);
        $ano = trim($_POST['ano']);

        $nomeLike = "%$nome%";
        $editoraLike = "%$editora%";

        $code = "SELECT livro_id, livro_titulo, livro_isbn, livro_foto 
             FROM LIVROS 
             WHERE livro_titulo LIKE ? 
             AND livro_editora LIKE ? 
             AND livro_ano = ?";

        $stmt = $conn->prepare($code);
        $stmt->bind_param("ssi", $nomeLike, $editoraLike, $ano);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $titulo = htmlspecialchars($row['livro_titulo']);
                $isbn = htmlspecialchars($row['livro_isbn']);
                $foto = htmlspecialchars($row['livro_foto']);
                $id = (int) $row['livro_id'];

                echo "
             <div>
              <div>
                <img src='../../adm/imagens/livros/$foto' alt='Capa do livro'>
              </div>
              <div>
                <p>$titulo</p>
                <p>$isbn</p>
              </div>
              <div>
                <a href='publicar.php?id=$id'>
                   <button>Usar</button>
                </a>
              </div>
            </div>";
            }
        } else {
            echo "
        <div>
          <p>Nenhum resultado encontrado! Cadastre o livro.</p>
          <a href='../resenha/cadastro-livro.php'>Cadastrar</a>
        </div>";
        }

        $stmt->close();
    }
    ?>

</body>

</html>