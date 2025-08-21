<?php
include "../conexao.php";
$dado = $_GET['id'];

$select = "SELECT 
    AUTORES.aut_nome, 
    AUTORES.aut_bio, 
    AUTORES.aut_foto, 
    LIVROS.livro_foto, 
    AUTORES.aut_id,
    RESENHAS.resenha_id
FROM 
    AUTORES 
LEFT JOIN 
    LIVRO_AUTORES ON AUTORES.aut_id = LIVRO_AUTORES.aut_id 
LEFT JOIN 
    LIVROS ON LIVROS.livro_id = LIVRO_AUTORES.livro_id
LEFT JOIN 
    RESENHAS ON RESENHAS.livro_id = LIVROS.livro_id 
WHERE AUTORES.aut_id = ?";
$stmt = $conn->prepare($select);
$stmt->bind_param("i", $dado);
$stmt->execute();
$result = $stmt->get_result();

$livros = [];
$autor = "";
$bio = "";
$foto = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (empty($autor)) {
            $autor = htmlspecialchars($row['aut_nome']);
            $bio = htmlspecialchars($row['aut_bio']);
            $foto = htmlspecialchars($row['aut_foto']);
        }

        // Adiciona livro e resenha ao array (se tiver livro cadastrado)
        if (!empty($row['livro_foto'])) {
            $livros[] = [
                'foto' => htmlspecialchars($row['livro_foto']),
                'resenha_id' => isset($row['resenha_id']) ? (int) $row['resenha_id'] : null
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <link rel="stylesheet" href="autor.css">
    <link rel="stylesheet" href="../global.css">

    <title>BIBLIÓFILOS Community - <?php echo $autor; ?></title>
</head>

<body>
    <header>
    </header>

    <div class='container'>
        <section class="sec1">
            <img src='../adm/imagens/autores/<?php echo $foto; ?>' alt='Foto de <?php echo $autor; ?>'>
        </section>
        <section class="sec2">
            <h1><?php echo $autor; ?></h1>
            <div class="bio">
                <p><?php echo $bio ?></p>
            </div>
            <?php if (!empty($livros)): ?>
                <div class="box-livros">
                    <?php foreach ($livros as $livro): ?>
                        <?php if (!empty($livro['resenha_id'])): ?>
                            <a href="../resenha-resultado/resenha.php?id=<?php echo $livro['resenha_id']; ?>">
                                <img src='../adm/imagens/livros/<?php echo $livro['foto']; ?>'>
                            </a>
                        <?php else: ?>
                            <img src='../adm/imagens/livros/<?php echo $livro['foto']; ?>'>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>


    <footer class='site-footer'>
        <div class='footer-logo'>
            <img src='../logo.png' alt='Logo do site'>
        </div>

        <div class='footer-texto'>
            <h3>Participe da nossa comunidade.</h3>
            <p>Se torne um resenhista.</p>
            <p>Entre em contato já!</p>
        </div>

        <div class='footer-redes'>
            <a href='#' target='_blank' aria-label='X'><i class='bx bxl-xing' style='color: #fff'></i></a>
            <a href='#' target='_blank' aria-label='Instagram'><i class='bx bxl-instagram' style='color: #fff'></i></a>
            <a href='#' target='_blank' aria-label='TikTok'><i class='bx bxl-tiktok' style='color: #fff'></i></a>
        </div>
    </footer>
</body>

</html>