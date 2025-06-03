<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$usuario = $_SESSION['tipo'];
$nome = $_SESSION['nome'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Bem-vindo, <?php echo $nome; ?>!</h1>

    <!-- Comum a todos -->


    <?php if ($usuario == 1): ?>
        <!-- Apenas para livrarias -->

    <?php endif; ?>
    <?php if ($usuario == 0): ?>
        <!-- Apenas para resenhistas -->
       
    <?php endif; ?>

    <p><a href="logout.php">Sair</a></p>
</body>

</html>