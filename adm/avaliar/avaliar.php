<!--<?php
include "../../conexao.php";

// Verifica se o ID foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido.");
}

$dado = (int) $_GET['id']; // Garante que o ID seja tratado como um número inteiro

// ------------------- AVALIAR RESENHA -------------------

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['avaliar'])) {
    $avaliar = (int) $_POST['avaliar'];

    // Atualiza o status da resenha no banco
    $UPDATE = "UPDATE RESENHAS SET resenha_status = ? WHERE resenha_id = ?";
    $stmt = $conn->prepare($UPDATE);
    $stmt->bind_param("ii", $avaliar, $dado);

    // Executa a atualização
    if ($stmt->execute()) {
        echo "<script>alert('Avaliado com sucesso!'); window.location.href = '../home.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao avaliar a resenha.'); window.location.href = '../home.php';</script>";
    }
    $stmt->close();
}

// ------------------- EXIBIR RESENHA -------------------

$SELECT = "
    SELECT 
        resenha_id, resenha_titulo, resenha_texto, livro_sinopse, livro_foto, res_nome_fantasia
    FROM 
        resenhas 
    INNER JOIN 
        LIVROS ON resenhas.livro_id = livros.livro_id
    INNER JOIN 
        RESENHISTAS ON resenhistas.res_id = resenhas.res_id 
    WHERE 
        resenha_id = ?f
";

// Prepara e executa a consulta para obter os dados da resenha
$stmt = $conn->prepare($SELECT);
$stmt->bind_param("i", $dado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $titulo = htmlspecialchars($row['resenha_titulo']); // Previne XSS
    $sinopse = htmlspecialchars($row['livro_sinopse']); // Previne XSS
    $texto = htmlspecialchars($row['resenha_texto']); // Previne XSS
    $foto = htmlspecialchars($row['livro_foto']); // Previne XSS
    $autor = htmlspecialchars($row['res_nome_fantasia']); // Previne XSS

    echo "
-->
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Avaliar resenha - BACKSTAGECommunity</title>
    <link rel='stylesheet' href='../home.css'>
    <link rel='stylesheet' href='../geral.css'>

</head>

<body>

    <header>
        Administrador BC
    </header>
    <main>
        <p class='avaliar'>AVALIAR RESENHA</p>
        </div>

        <div class='card'>
            <div class='cardimgsinopse'>
                <img class='imagem imgavaliar'src='../imagens/livros/{$foto}' alt=''>
                <div class='sinopse'>
                    <p>{$titulo}</p>
                    <p>Sinopse</p>
                    <p>{$sinopse}</p>

                </div>
            </div>

            <div class='cardresenha'>
                <div class='resenha'>
                    <p>RESENHA</p>
                    <p>{$texto}</p>
                    <p>{$autor}</p>
                </div>
            </div>

            <form action='?id={$dado}' method='post' class='cardforms'>
                <select class='notas' name='avaliar' required>

                    <option class='resultado' value=''>Avaliar</option>
                    <option class='resultado' value='1'>Reprovada</option>
                    <option class='resultado' value='3'>Corrigir</option>
                    <option class='resultado' value='2'>Aprovada</option>
                </select>

                <input class='teste' type='submit' value='Enviar'>
            </form>
        </div>
    </main>
    <script src="script.js"></script>
</body>

</html>
";

} else {
echo "<p>Resenha não encontrada.</p>";
}

$stmt->close();
?>