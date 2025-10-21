<?php
include "../../conexao.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido!");
}
session_start();

$idResenhista = $_SESSION['id'];
$idLivro = (int) $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tituloResenha = $_POST["titulo"];
    $resenha = $_POST["resenha"];
    $avaliacao = $_POST["avaliacao"];

    $update = "INSERT INTO RESENHAS (res_id, livro_id, resenha_titulo, resenha_texto, resenha_avaliacao) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("iissi", $idResenhista, $idLivro, $tituloResenha, $resenha, $avaliacao);

    if ($stmt->execute()) {
        echo "
        <script>
        alert('Resenha enviada com sucesso! Agradecemos pela colaboração. Antes de ser exibida no Bibliófilos Community será avaliada por um de nossos administradores com o intuito de manter o padrão de nosso site. Retornaremos o mais rápido possível indicando se foi recusada ou será necessário reajuste. Se não houver objeções será exposta diretamente para acesso dos usuários.');
        window.location.href = 'resenhas.php';
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
$stmt->bind_param("i", $idLivro);
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
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="resenhas.css">
    <title>Criar resenha - BACKSTAGE Community
    </title>
</head>
<body>
      <header>
        BACKSTAGE Community
    </header>
    <main>
        <div class='card card1'>
            <div class='cardimgsinopse'>
                <div class="box-img">
                    <img class='imagem1' src='../../adm/imagens/livros/<?php echo $foto ?>' alt=''>
                </div>
                <div class="sinopse">
                    <h1>
                        <?php echo $titulo ?>
                    </h1>
                    <p style="color: #fff">
                        Sinopse:
                        <?php echo $sinopse ?>
                    </p>
                </div>
            </div>
            <div>
                <div>
                    <form method="POST">

                        <div>
                            <label class="resenhabox" for="resenha">Resenha:</label><br>
                            <textarea class="resenha" name="resenha" id="resenha" rows="5" cols="60"
                                required></textarea><br><br>
                        </div>

                        <label for="avaliacao">Avaliação do livro:</label><br>
                        <div class="rating">
                            <input type="radio" id="estrela5" name="avaliacao" value="5"><label for="estrela5">★</label>
                            <input type="radio" id="estrela4" name="avaliacao" value="4"><label for="estrela4">★</label>
                            <input type="radio" id="estrela3" name="avaliacao" value="3"><label for="estrela3">★</label>
                            <input type="radio" id="estrela2" name="avaliacao" value="2"><label for="estrela2">★</label>
                            <input type="radio" id="estrela1" name="avaliacao" value="1" required><label
                                for="estrela1">★</label>
                        </div><br><br>
                        <input class="botao1" type="submit" value="Enviar">
                    </form>
                </div>
                <a class="notas" href='resenhas.php'>
                    <button class="botao1">Cancelar</button>
                </a>
            </div>
        </div>
    </main>

</body>

</html>