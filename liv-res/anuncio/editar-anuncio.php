<?php
include "../../conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Anúncio - BACKSTAGE Community</title>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="anuncios.css">
</head>
<body>

<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "SELECT liv_livro_idioma, liv_livro_pag, liv_livro_tipo, liv_livro_preco, liv_livro_obsadicionais, liv_livro_status 
            FROM livrarias_livros 
            WHERE liv_livro_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            $idioma = htmlspecialchars($row['liv_livro_idioma']);
            $paginas = (int) $row['liv_livro_pag'];
            $tipo = $row['liv_livro_tipo'];
            $preco = number_format((float)$row['liv_livro_preco'], 2, '.', '');
            $obs = htmlspecialchars($row['liv_livro_obsadicionais']);
            $statusAtual = (int) $row['liv_livro_status'];

            $statusLabels = [1 => 'Ativo', 2 => 'Inativo'];

            echo "
            <form action='atualizar-anuncio.php?id=$id' method='POST' class='format3'>
                <h1>Editar Anúncio</h1>

                <label for='idioma'>Idioma:</label>
                <input type='text' name='idioma' value='$idioma' required class='inputEditar3'>

                <label for='paginas'>Páginas:</label>
                <input type='number' name='paginas' value='$paginas' required class='inputEditar3'>

                <label for='tipo'>Tipo:</label>
                <select name='tipo' required class='selectResenhista3'>
                    <option value=''>Selecione...</option>
                    <option value='Físico' ".($tipo === 'Físico' ? 'selected' : '').">Físico</option>
                    <option value='Digital' ".($tipo === 'Digital' ? 'selected' : '').">Digital</option>
                </select>

                <label for='preco'>Preço:</label>
                <input type='number' name='preco' step='0.01' value='$preco' required class='inputEditar3'>

                <label for='obs'>Observações:</label>
                <input type='text' name='obs' value='$obs' class='inputEditar3'>

                <label for='status'>Disponibilidade:</label>
                <select name='status' required class='selectResenhista3'>
                    <option value='1' ".($statusAtual === 1 ? 'selected' : '').">Disponível</option>
                    <option value='0' ".($statusAtual === 0 ? 'selected' : '').">Indisponível</option>
                </select>

                <input type='submit' value='Atualizar Anúncio' class='inputEditar3'>
                <a href='anuncios.php'>Voltar</a>
            </form>";
        } else {
            echo "<p>Anúncio não encontrado.</p>";
        }
    } else {
        echo "<p>Erro ao executar consulta: " . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>ID inválido.</p>";
}
?>

</body>
</html>
