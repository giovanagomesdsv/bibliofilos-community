<?php
include "../../conexao.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido!");
}

$id = (int) $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $update = "INSERT INTO RESENHAS (res_id, livro_id, resenha_titulo, resenha_texto, resenha_avaliacao) VALUES (?, ?, ?, ?, ?)";

    
    if ( $stmt->execute()) {
        echo "
        <script>
        alert('Resenha enviada com sucesso! Agradecemos pela colaboração. Antes de ser exibida no Bibliófilos Community será avaliada por um de nossos administradores com o intuito de manter o padrão de nosso site. Retornaremos o mais rápido possível indicando se foi recusada ou será necessário reajuste. Se não houver objeções será exposta diretamente para acesso dos usuários.');
        window.location.href = 'm-resenhas.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Erro ao enviar!');
        </script>
        ";
    }
    $stmt->close();
}

$SELECT = "SELECT livro_titulo, livro_foto, livro_sinopse FROM LIVROS WHERE livro_id = ?";
$stmt = $conn->prepare($SELECT);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $titulo = htmlspecialchars($row['livro_titulo']);
    $foto = htmlspecialchars($row['livro_foto']);
    $sinopse = htmlspecialchars($row['livro_sinopse']);
}
?>
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Resenha - BACKSTAGE Community
    </title>
</head>

<body>
    <main>

        <div>
            <img src='../../adm/imagens/livros/<?php echo $foto?>' alt=''>
            <div>
                <h1><?php echo $titulo ?></h1>
                <div>
                    <p><?php echo $sinopse ?></p>
                </div>
            </div>
        </div>
        <div>
            <div>
                <form method="POST">
                    <textarea name="resenha" id="resenha" rows="10" cols="70"></textarea><br>

                    <input type="submit" value="Enviar">
                </form>
            </div>
            <a href='m-resenhas.php'>
                <button>Cancela</button>
            </a>
        </div>

    </main>

</body>
</html>