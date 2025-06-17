<?php
include "../../conexao.php";

// Verifica se o ID do usuário foi passado corretamente
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
        alert('ID de usuário inválido.');
        window.location.href = 'usuarios.php';
    </script>";
    exit;
}

$res_id = (int) $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pseudonimo = trim(filter_input(INPUT_POST, 'pseudonimo', FILTER_SANITIZE_SPECIAL_CHARS));
    $cidade     = trim(filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS));
    $estado     = $_POST['estado'];
    $telefone   = preg_replace('/[^0-9]/', '', $_POST['telefone']);
    $instagram  = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_URL);
    $descricao  = trim(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS));

    $path = "";

    // Upload da imagem
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
        $arquivo = $_FILES['arquivo'];

        if ($arquivo['size'] > 2 * 1024 * 1024) {
            echo "<script>alert('Arquivo muito grande. Máximo 2MB.'); history.back();</script>";
            exit;
        }

        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, ['jpg', 'png', 'jpeg'])) {
            echo "<script>alert('Apenas arquivos JPG ou PNG são permitidos.'); history.back();</script>";
            exit;
        }

        $novoNome = uniqid() . '.' . $extensao;
        $pasta = "../imagens/resenhistas/";
        $caminho = $pasta . $novoNome;

        if (!move_uploaded_file($arquivo['tmp_name'], $caminho)) {
            echo "<script>alert('Erro ao salvar a imagem.'); history.back();</script>";
            exit;
        }

        $path = $novoNome;
    } else {
        echo "<script>alert('Erro no envio da imagem.'); history.back();</script>";
        exit;
    }

    // Insere os dados na tabela
    $sql = "INSERT INTO resenhistas (res_id, res_nome_fantasia, res_cidade, res_estado, res_telefone, res_foto, res_perfil, res_social)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $res_id, $pseudonimo, $cidade, $estado, $telefone, $path, $descricao, $instagram);

    if ($stmt->execute()) {
        echo "<script>
            alert('Resenhista cadastrado com sucesso!');
            window.location.href = 'usuarios.php';
        </script>";
    } else {
        // die("Erro na execução: " . $stmt->error);

        echo "<script>
            alert('Erro ao cadastrar!');
            window.location.href = 'usuarios.php';
        </script>";
    }

    $stmt->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Resenhistas - BACKSTAGE Community</title>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="usuarios.css">
</head>

<body>
    <form action="cadastrarresenhista.php?id=<?= htmlspecialchars($res_id) ?>" method="POST" enctype="multipart/form-data" class='format'>
        <h1>Cadastro de Resenhistas</h1>


        <label for="pseudonimo">Pseudônimo:</label>
        <input type="text" name="pseudonimo" class='inputEditar2' required>

        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" required class='inputEditar2'>

        <label for="estado">Estado:</label>
        <select name="estado" required class='selectResenhista'>
            <option value="">Selecione...</option>
            <option value="SP">SP</option>
            <option value="MG">MG</option>
            <option value="RJ">RJ</option>
        </select>

        <label for="telefone">Telefone (WhatsApp):</label>
        <input type="text" name="telefone" placeholder="DDD + numero" required class='inputEditar2'>

        <label for="instagram">Instagram (URL):</label>
        <input type="url" name="instagram" placeholder="https://instagram.com/seuperfil" class='inputEditar2'>

        <label for="descricao">Descrição sobre o resenhista:</label>
        <input type="text" name="descricao" class='inputEditar2' required>

        <label for="arquivo">Foto:</label>
        <input type="file" name="arquivo" required>

        <input type="submit" value="Cadastrar" class='tamanhoSubmit'>
        <a href="resenhistas.php">Voltar</a>
    </form>
</body>

</html>