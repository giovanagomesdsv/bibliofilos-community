<?php
include "../conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = (int)$_GET['id_usuario'];
    $nome = trim($_POST['nome']);
    $cidade = trim($_POST['cidade']);
    $estado = $_POST['estado'];
    $endereco = trim($_POST['endereco']);
    $telefone   = preg_replace('/[^0-9]/', '', $_POST['telefone']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $instagram = trim($_POST['instagram']);
    $perfil = trim($_POST['perfil']);
    $path = "";

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
        $pasta = "../adm/imagens/livrarias/";
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

    // Inserindo no banco com segurança
    $stmt = $conn->prepare("INSERT INTO LIVRARIAS 
        (liv_id, liv_nome, liv_cidade, liv_estado, liv_endereco, liv_telefone, liv_email, liv_foto, liv_perfil, liv_social) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssss", $id_usuario, $nome, $cidade, $estado, $endereco, $telefone, $email, $path, $perfil, $instagram);

    if ($stmt->execute()) {
        Header("Location: aviso.php");
    } else {
        echo "<script>alert('Erro ao cadastrar livraria.'); location.href='cadastrar-livraria.php?id_usuario=". htmlspecialchars($id_usuario). "';</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livraria</title>
    <link rel="stylesheet" href="administrador/usuarios/cadastrarusuario.css">
    <link rel="stylesheet" type="text/css" href="../geral.css">

</head>

<body style="background-color:#DEDEDE">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">

        <label for="nome">Nome da livraria:</label>
        <input type="text" name="nome" required>

        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" required>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="">Selecione...</option>
            <option value="SP">SP</option>
            <option value="MG">MG</option>
            <option value="RJ">RJ</option>
        </select>

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" placeholder="DDD + numero" required>

        <label for="email">E-mail da livraria:</label>
        <input type="email" name="email" required>

        <label for="arquivo">Selecione uma imagem:</label>
        <input type="file" name="arquivo" accept=".jpg,.png" required>

        <label for="perfil">Perfil:</label>
        <input type="text" name="perfil" required>

        <label for="instagram">Instagram:</label>
        <input type="text" name="instagram" placeholder="URL" required>

        <input type="submit" value="Cadastrar livraria">
    </form>
</body>

</html>
