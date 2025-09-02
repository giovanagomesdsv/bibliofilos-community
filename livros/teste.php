<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <section class="box-filter">
        <form method="GET" action="">
            <h3>Filtrar</h3>

            <!-- Filtro por Livraria -->
            <label for="livraria">Livraria:</label>
            <select name="livraria" id="livraria">
                <option value="">Todas</option>
                <?php
                $q_livrarias = $conn->query("SELECT livraria_id, livraria_nome FROM LIVRARIAS");
                while ($l = $q_livrarias->fetch_assoc()) {
                    $selected = ($_GET['livraria'] ?? '') == $l['livraria_id'] ? "selected" : "";
                    echo "<option value='{$l['livraria_id']}' $selected>" . htmlspecialchars($l['livraria_nome']) . "</option>";
                }
                ?>
            </select>

            <!-- Filtro por Localidade -->
            <label for="localidade">Localidade:</label>
            <select name="localidade" id="localidade">
                <option value="">Todas</option>
                <?php
                $q_local = $conn->query("SELECT DISTINCT livraria_localidade FROM LIVRARIAS");
                while ($loc = $q_local->fetch_assoc()) {
                    $selected = ($_GET['localidade'] ?? '') == $loc['livraria_localidade'] ? "selected" : "";
                    echo "<option value='{$loc['livraria_localidade']}' $selected>" . htmlspecialchars($loc['livraria_localidade']) . "</option>";
                }
                ?>
            </select>

            <!-- Filtro por Gênero -->
            <label for="genero">Gênero:</label>
            <select name="genero" id="genero">
                <option value="">Todos</option>
                <?php
                $q_gen = $conn->query("SELECT DISTINCT livro_classidd FROM LIVROS");
                while ($g = $q_gen->fetch_assoc()) {
                    $selected = ($_GET['genero'] ?? '') == $g['livro_classidd'] ? "selected" : "";
                    echo "<option value='{$g['livro_classidd']}' $selected>" . htmlspecialchars($g['livro_classidd']) . "</option>";
                }
                ?>
            </select>

            <!-- Filtro por Preço -->
            <label for="preco">Preço até:</label>
            <input type="number" name="preco" id="preco" step="0.01" value="<?php echo $_GET['preco'] ?? ''; ?>">

            <br><br>
            <button type="submit">Aplicar</button>
        </form>
    </section>

    <section class="box-livros">
        <?php
        $status = 1;
        $conditions = ["liv_livro_status = ?"];
        $params = [$status];
        $types = "i";

        // Monta os filtros dinamicamente
        if (!empty($_GET['livraria'])) {
            $conditions[] = "LIVRARIAS.livraria_id = ?";
            $params[] = $_GET['livraria'];
            $types .= "i";
        }

        if (!empty($_GET['localidade'])) {
            $conditions[] = "LIVRARIAS.livraria_localidade = ?";
            $params[] = $_GET['localidade'];
            $types .= "s";
        }

        if (!empty($_GET['genero'])) {
            $conditions[] = "LIVROS.livro_classidd = ?";
            $params[] = $_GET['genero'];
            $types .= "s";
        }

        if (!empty($_GET['preco'])) {
            $conditions[] = "liv_livro_preco <= ?";
            $params[] = $_GET['preco'];
            $types .= "d";
        }

        $sql = "SELECT LIVROS.livro_titulo, LIVROS.livro_classidd, LIVROS.livro_foto, LIVRARIAS_LIVROS.liv_livro_preco, LIVRARIAS_LIVROS.liv_livro_tipo, LIVROS.livro_id  
                FROM LIVROS
                INNER JOIN LIVRARIAS_LIVROS ON LIVROS.livro_id = LIVRARIAS_LIVROS.livro_id
                INNER JOIN LIVRARIAS ON LIVRARIAS_LIVROS.livraria_id = LIVRARIAS.livraria_id
                WHERE " . implode(" AND ", $conditions);

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($dados = $result->fetch_assoc()) {
                echo "
<a href='compra.php?id={$dados['livro_id']}'>
    <div class='card-livro'>
        <div class='imagem'>
            <img src='../adm/imagens/livros/{$dados['livro_foto']}' alt='Imagem do livro'>
        </div>
        <div class='info'>
            <h1>" . htmlspecialchars($dados['livro_titulo']) . "</h1>
            <h2>R$ " . number_format($dados['liv_livro_preco'], 2, ',', '.') . "</h2>
            <p class='tipo'>Tipo: " . htmlspecialchars($dados['liv_livro_tipo']) . "</p>
            <p>" . htmlspecialchars($dados['livro_classidd']) . "</p>
        </div>
    </div>
</a>
";
            }
        } else {
            echo "<p>Nenhum livro encontrado com os filtros selecionados.</p>";
        }
        ?>
    </section>
</div>

</body>
</html>