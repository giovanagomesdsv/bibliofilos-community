<?php
include "../../conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['id'], $_POST['pseudonimo'], $_POST['cidade'], $_POST['estado'], $_POST['telefone']) &&
        in_array($_POST['estado'], ['SP', 'MG', 'RJ'])
    ) {
        $id         = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $pseudonimo = trim(filter_input(INPUT_POST, 'pseudonimo', FILTER_SANITIZE_SPECIAL_CHARS));
        $cidade     = trim(filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS));
        $estado     = $_POST['estado'];
        $telefone   = preg_replace('/[^0-9]/', '', $_POST['telefone']);
        $instagram  = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_URL);
        $descricao  = trim(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS));

        $foto_nome = "";

         // Upload da imagem
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
        $arquivo = $_FILES['arquivo'];

        if ($arquivo['size'] > 2 * 1024 * 1024) {
            echo "<script>alert('Arquivo muito grande. Máximo 2MB.'); history.back();</script>";
            exit;
        }

        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, ['jpg', 'png'])) {
            echo "<script>alert('Apenas arquivos JPG ou PNG são permitidos.'); history.back();</script>";
            exit;
        }

        $novoNome = uniqid() . '.' . $extensao;
        $pasta = "administrador/imagens/resenhistas/";
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

        $sql = "INSERT INTO resenhistas (res_id, res_nome_fantasia, res_cidade, res_estado, res_telefone, res_foto, res_perfil, res_social) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("isssssss", $id, $pseudonimo, $cidade, $estado, $telefone, $foto_nome, $descricao, $instagram);

            if ($stmt->execute()) {
                echo '<script>alert("Resenhista cadastrado com sucesso!"); window.location.href = "resenhistas.php";</script>';
            } else {
                echo '<script>alert("Erro ao cadastrar!"); window.location.href = "cadastro_resenhista.php";</script>';
            }

            $stmt->close();
        } else {
            echo '<script>alert("Erro na preparação do cadastro."); window.location.href = "cadastro_resenhista.php";</script>';
        }

        $conn->close();
        exit;
    } else {
        echo '<script>alert("Preencha todos os campos obrigatórios corretamente."); window.location.href = "cadastro_resenhista.php";</script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Resenhistas - BACKSTAGE Community</title>
    <link rel="stylesheet" href="cadastro_resenhista.css">
</head>
<body style="background-color: #f2f2f2;">
    <form action="cadastro_resenhista.php" method="POST" enctype="multipart/form-data">
        <h1>Cadastro de Resenhistas</h1>

        <label for="id">ID:</label>
        <input type="number" name="id" required>

        <label for="pseudonimo">Pseudônimo:</label>
        <input type="text" name="pseudonimo" required>

        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" required>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="">Selecione...</option>
            <option value="SP">SP</option>
            <option value="MG">MG</option>
            <option value="RJ">RJ</option>
        </select>

        <label for="telefone">Telefone (WhatsApp):</label>
        <input type="text" name="telefone" placeholder="5511999999999" required>

        <label for="instagram">Instagram (URL):</label>
        <input type="url" name="instagram" placeholder="https://instagram.com/seuperfil">

        <label for="descricao">Perfil:</label>
        <input type="text" name="descricao">

        <label for="arquivo">Foto (JPG ou PNG):</label>
        <input type="file" name="arquivo" accept=".jpg,.jpeg,.png">

        <input type="submit" value="Cadastrar">
        <a href="resenhistas.php">Voltar</a>
    </form>
</body>
</html>
