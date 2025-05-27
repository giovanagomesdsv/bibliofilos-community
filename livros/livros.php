<?php
include "../conexao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIÓFILOS Community - Livros</title>
</head>

<body>
    <nav>
        <a href="../index.php">Home</a>
        <a href="../resenhas/resenhas.php">Resenhas</a>
        <a href="../autores/autores.php">Autores</a>
        <a href="#">Livros</a>
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

                $stmt = $conexao->prepare("SELECT * FROM livro WHERE slug = ?");
                $stmt->bind_param("s", $slug);
                $stmt->execute();

                $result = $stmt->get_result();
                $livro = $result->fetch_assoc();

                if ($livro) {
                    echo "<h1>" . htmlspecialchars($livro['titulo']) . "</h1>";
                    echo "<p>" . nl2br(htmlspecialchars($livro['preco'])) . "</p>";
                } else {
                    echo "Livro não encontrado.";
                }

                $stmt->close();
            }
            // Pesquisa por termo (exibe resultados da busca)
            elseif (isset($_POST['search'])) {
                $search = '%' . $_POST['search'] . '%';

                $stmt = $conexao->prepare("SELECT * FROM livro WHERE titulo LIKE ?");
                $stmt->bind_param("s", $search);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='card-container'>";
                    while ($livro = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<h2><a href='http://localhost/TCC/site-principal/livro-resultado/livro.php?id={$livro['slug']}'>" . htmlspecialchars($livro['titulo']) . "</a></h2>";
                        echo "<p>{$livro['preco']}</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "Nenhum livro encontrado para a pesquisa.";
                }

                $stmt->close();
            }
            ?>
        </div>
    </section>

    <!--Filtro-->
    <main>
        <?php
        $x = "SELECT livro.path, livro.slug, nome, titulo, preco FROM livro INNER JOIN parceria ON livro.cnpj = parceria.cnpj";

        if ($r = mysqli_query($conexao, $x)) {
            while ($livro = mysqli_fetch_array($r)) {
                echo "
        <div>
        
        <img src='../../gerenciador-estoque/cadastro de livros/img-livro/{$livro['path']}' alt=''>

        <p>{$livro['nome']}</p>

        <h2><a href='http://localhost/TCC/site-principal/livro-resultado/livro.php?id={$livro['slug']}'>" . htmlspecialchars($livro['titulo']) . "</a></h2>

        <h3>{$livro['preco']}</h3>
        </div>
        ";
            }
        }
        ?>
    </main>
    

</body>


</html>