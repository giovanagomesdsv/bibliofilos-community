<?php 
include "../conexao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../geral.css">
    <title>BIBLIÓFILOS Community - Autores</title>
</head>

<body>
    <nav>
        <a href="../index.php">Home</a>
        <a href="../resenhas/resenhas.php">Resenhas</a>
        <a href="#">Autores</a>
        <a href="../livros/livros.php">Livros</a>
        <a href="../sobre/sobre.php">Sobre</a>
    </nav>

    <section>
         <!-- Barra de Pesquisa -->
         <div class="search-container">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Digite o título do artigo..." required>
                <button type="submit">Pesquisar</button>
            </form>
        </div>
       
        <div class="pesquisa">
            <?php
            // Pesquisa por slug (exibe um artigo específico)
            if (isset($_GET['slug'])) {
                $slug = $_GET['slug'];

                $stmt = $conexao->prepare("SELECT * FROM escritor WHERE slug = ?");
                $stmt->bind_param("s", $slug);
                $stmt->execute();

                $result = $stmt->get_result();
                $linha = $result->fetch_assoc();

                if ($linha) {
                    echo "<h1>" . htmlspecialchars($linha['nome']) . "</h1>";
                    echo " <img src='{$linha['path']}' alt=''>";
                } else {
                    echo "Artigo não encontrado.";
                }

                $stmt->close();
            }
            // Pesquisa por termo (exibe resultados da busca)
            elseif (isset($_POST['search'])) {
                $search = '%' . $_POST['search'] . '%';

                $stmt = $conexao->prepare("SELECT * FROM escritor WHERE nome LIKE ?");
                $stmt->bind_param("s", $search);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='card-container'>";
                    while ($linha = $result->fetch_assoc()) {
                        echo "<div>";
                        echo "<h2><a href='http://localhost/TCC/site-principal/autor-resultado/autor.php?id={$linha['slug']}'>" . htmlspecialchars($linha['nome']) . "</a></h2>";
                        echo "<p>" . substr(htmlspecialchars($linha['biografia']), 0, 100) . "...</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "Nenhum artigo encontrado para a pesquisa.";
                }

                $stmt->close();
            }
            ?>
        </div>
    </section>
    <main>
        <?php 
        $select = "SELECT * FROM escritor";

        if ($res = mysqli_query($conexao, $select)) {
            while ($linha = mysqli_fetch_array($res)) {
                echo "<div>";
                echo "<h2><a href='http://localhost/TCC/site-principal/autor-resultado/autor.php?id={$linha['slug']}'>" . htmlspecialchars($linha['nome']) . "</a></h2>";
                echo "<img src='../../administrador/autores/img-autores/{$linha['path']}' alt=''>";
                echo "<p>" . substr(htmlspecialchars($linha['biografia']), 0, 100) . "...</p>";
                echo "</div>";
            }
        }
        ?>
    </main>
    
</body>

</html>