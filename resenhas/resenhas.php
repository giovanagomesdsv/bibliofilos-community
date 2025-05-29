<?php
include "../conexao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../geral.css">
    <title>BIBLIÓFILOS Community - Resenhas</title>
</head>

<body>
    <nav>
        <a href="../index.php">Home</a>
        <a href="#">Resenhas</a>
        <a href="../autores/autores.php">Autores</a>
        <a href="../livros/livros.php">Livros</a>
        <a href="../sobre/sobre.php">Sobre</a>
    </nav>

    <section>
        <form action="" method="POST">
            <input type="submit" name="classicos" value="Clássicos">
            <input type="submit" name="terror" value="Terror">
            <input type="submit" name="suspense" value="Suspense e mistério">
            <input type="submit" name="romance" value="Romance">
            <input type="submit" name="ficcao" value="Ficção e fantasia">
            <input type="submit" name="aventura" value="Aventura">
            <input type="submit" name="drama" value="Drama">
        </form>

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

                $stmt = $conexao->prepare("SELECT * FROM resenha WHERE slug = ?");
                $stmt->bind_param("s", $slug);
                $stmt->execute();

                $result = $stmt->get_result();
                $artigo = $result->fetch_assoc();

                if ($artigo) {
                    echo "<h1>" . htmlspecialchars($artigo['titulo']) . "</h1>";
                    echo "<p>" . nl2br(htmlspecialchars($artigo['sinopse'])) . "</p>";
                } else {
                    echo "Artigo não encontrado.";
                }

                $stmt->close();
            }
            // Pesquisa por termo (exibe resultados da busca)
            elseif (isset($_POST['search'])) {
                $search = '%' . $_POST['search'] . '%';

                $stmt = $conexao->prepare("SELECT * FROM resenha WHERE titulo LIKE ?");
                $stmt->bind_param("s", $search);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='card-container'>";
                    while ($artigo = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>";
                        echo "<p>" . substr(htmlspecialchars($artigo['sinopse']), 0, 100) . "...</p>";
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

    <!-- Exibe resenhas -->
    <main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['classicos'])) {
                $sql = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Clássicos' ORDER BY data_publicacao DESC ";

                $resultado = mysqli_query($conexao, $sql);

                while ($artigo = mysqli_fetch_array($resultado)) {
                    echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                }
            } elseif (isset($_POST['terror'])) {
                $sql = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Terror' ORDER BY data_publicacao DESC ";

                $resultado = mysqli_query($conexao, $sql);

                while ($artigo = mysqli_fetch_array($resultado)) {
                    echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                }
            } elseif (isset($_POST['suspense'])) {
                $sql = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Suspense e mistério' ORDER BY data_publicacao DESC ";

                $resultado = mysqli_query($conexao, $sql);

                while ($artigo = mysqli_fetch_array($resultado)) {
                    echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                }
            } elseif (isset($_POST['romance'])) {
                $sql = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Romance' ORDER BY data_publicacao DESC ";

                $resultado = mysqli_query($conexao, $sql);

                while ($artigo = mysqli_fetch_array($resultado)) {
                    echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                }
            } elseif (isset($_POST['ficcao'])) {
                $sql = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Fantasia e Ficção' ORDER BY data_publicacao DESC ";

                $resultado = mysqli_query($conexao, $sql);

                while ($artigo = mysqli_fetch_array($resultado)) {
                    echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                }
            } elseif (isset($_POST['aventura'])) {
                $sql = "SELECT resenha.path, resenha.path, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Aventura' ORDER BY data_publicacao DESC ";

                $resultado = mysqli_query($conexao, $sql);

                while ($artigo = mysqli_fetch_array($resultado)) {
                    echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                }
            } elseif (isset($_POST['drama'])) {
                $sql = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Drama' ORDER BY data_publicacao DESC ";

                $resultado = mysqli_query($conexao, $sql);

                while ($artigo = mysqli_fetch_array($resultado)) {
                    echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                }
            }
        }
        ?>

        <section>
           
            <h3>Todas as resenhas</h3>
            <?php
            $consulta = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo, genero FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha ORDER BY data_publicacao DESC";
            $result = mysqli_query($conexao, $consulta);

            if (mysqli_num_rows($result) > 0) {
                while ($artigo = mysqli_fetch_array($result)) {

                    if ($artigo["genero"] == "Clássicos") {
                        echo "<div>
                           <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                    } elseif ($artigo["genero"] == "Terror") {
                        echo "<div>
                        <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    } elseif ($artigo["genero"] == "Suspense e mistério") {
                        echo "<div>
                        <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    } elseif ($artigo["genero"] == "Romance") {
                        echo "<div>
                        <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    } elseif ($artigo["genero"] == "Fantasia e Ficção") {
                        echo "<div>
                        <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    } elseif ($artigo["genero"] == "Aventura") {
                        echo "<div>
                        <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    } elseif ($artigo["genero"] == "Drama") {
                        echo "<div>
                        <img src='../../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    }
                }
            }

            ?>
        </section>
    </main>
</body>

</html>