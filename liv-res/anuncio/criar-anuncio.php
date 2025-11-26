<?php
include "../../conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

  <link rel="stylesheet" href="anuncios.css">
  <link rel="stylesheet" href="geral.css">
  <style>
  .livro-card {
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .livro-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.18);
    transform: translateY(-6px) scale(1.02);
    background: #f8f8f8;
  }
  </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Criar Anúncios - BACKSTAGE Community</title>
</head>

<body>

  <form action="" method="POST" class="busca-form margin busca-anuncio">
    <div class="form-group full-width">
      <label for="nome" class='Textlabel'>Nome do livro:</label>
      <input type="text" name="nome" style='color:black;' required>
    </div>
  
    <div class="form-row">
      <div class="form-group half-width">
        <label for="editora" class='Textlabel'>Editora:</label>
        <input type="text" name="editora" style='color:black;' required>
      </div>
      <div class="form-group half-width">
        <label for="ano" class='Textlabel'>Ano de publicação:</label>
        <input type="number" name="ano" style='color:black;' required>
      </div>
      
      <button type="submit"><i class='bx bx-search'></i>PROCURAR LIVRO</button>
    </div>
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
            echo '<div class="livro-result-container">';
            while ($row = $result->fetch_assoc()) {
                $titulo = htmlspecialchars($row['livro_titulo']);
                $isbn = htmlspecialchars($row['livro_isbn']);
                $foto = htmlspecialchars($row['livro_foto']);
                $id = (int) $row['livro_id'];

                echo"
                <div class='livro-card' onclick=\"window.location.href='publicar.php?id=$id'\" style='cursor:pointer; border:1px solid #2A4A64; border-radius:8px; background-color:#2A4A64; padding:16px; margin:12px 0; display:flex; align-items:center; transition:box-shadow 0.2s;'>
                  <img src='../../adm/imagens/livros/$foto' alt='Capa do livro' style='width:80px;height:120px;object-fit:cover;margin-right:16px;border-radius:4px;'>
                  <div style='flex:1;'>
                    <p style='font-weight:bold; color:white;'>$titulo</p>
                    <p style='color:#fff;'>ISBN: $isbn</p>
                  </div>
                  <div>
                  </div>
                </div>";
            }
            echo '</div>';
            }
        } else {
            echo "
        <div>
          <p>Nenhum resultado encontrado! Cadastre o livro.</p>
          <a href='../resenha/cadastro-livro.php'>Cadastrar</a>
        </div>";
        }

        $stmt->close();
    
    ?> 

</body>

</html>