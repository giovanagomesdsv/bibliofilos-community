<?php
include "../conexao.php";

// Mostrar erros (importante enquanto desenvolve)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pegando o id_usuario da URL OU do POST
$id_usuario = 0;

if (isset($_GET['id_usuario'])) {
    $id_usuario = (int)$_GET['id_usuario'];
} elseif (isset($_POST['id_usuario'])) {
    $id_usuario = (int)$_POST['id_usuario'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Dados gerais
    $nome = trim($_POST['nome']);
    $cidade = trim($_POST['cidade']);
    $estado = $_POST['estado'];
    $endereco = trim($_POST['endereco']);
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $instagram = trim($_POST['instagram']);
    $perfil = trim($_POST['perfil']);

    if (!$email) {
        echo "<script>alert('E-mail inválido.'); history.back();</script>";
        exit;
    }

    // Upload da imagem
    if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== 0) {
        echo "<script>alert('Erro no envio da imagem.'); history.back();</script>";
        exit;
    }

    $arquivo = $_FILES['arquivo'];

    // Verifica tamanho (máx 2MB)
    if ($arquivo['size'] > 2 * 1024 * 1024) {
        echo "<script>alert('Arquivo muito grande. Máximo 2MB.'); history.back();</script>";
        exit;
    }

    // Extensão
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    if (!in_array($extensao, ['jpg', 'png'])) {
        echo "<script>alert('Apenas arquivos JPG ou PNG são permitidos.'); history.back();</script>";
        exit;
    }

    // Gerando nome único + caminho real
    $novoNome = uniqid() . '.' . $extensao;
    $pasta = "../adm/imagens/livrarias/";
    $caminho = $pasta . $novoNome;

    // Movendo upload
    if (!move_uploaded_file($arquivo['tmp_name'], $caminho)) {
        echo "<script>alert('Erro ao salvar a imagem. Verifique permissões da pasta.'); history.back();</script>";
        exit;
    }

    // Inserção no banco
    $sql = "INSERT INTO LIVRARIAS 
            (liv_id, liv_nome, liv_cidade, liv_estado, liv_endereco, liv_telefone, liv_email, liv_foto, liv_perfil, liv_social) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssssssss",
        $id_usuario,
        $nome,
        $cidade,
        $estado,
        $endereco,
        $telefone,
        $email,
        $novoNome,
        $perfil,
        $instagram
    );

    if ($stmt->execute()) {
        header("Location: aviso.php");
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar livraria: " . $conn->error . "');</script>";
        echo "<script>location.href='cadastrar-livraria.php?id_usuario=" . htmlspecialchars($id_usuario) . "';</script>";
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
    <link rel="stylesheet" href="login.css">
</head>

<body style="background-color:#DEDEDE">
    <form class="form-container3" action="" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">

        <label class="form-label3" for="nome">Nome da livraria:</label>
        <input class="form-input3" type="text" name="nome" required>

        <label class="form-label3" for="cidade">Cidade:</label>
        <input class="form-input3" type="text" name="cidade" required>

        <label class="form-label3" for="estado">Estado:</label>
        <select class="form-input3 select-input3" name="estado" required>
            <option value="">Selecione...</option>
            <option value="SP">SP</option>
            <option value="MG">MG</option>
            <option value="RJ">RJ</option>
        </select>

        <label class="form-label3" for="endereco">Endereço:</label>
        <input class="form-input3" type="text" name="endereco" required>

        <label class="form-label3" for="telefone">Telefone:</label>
        <input class="form-input3" type="text" name="telefone" placeholder="DDD + número" required>

        <label class="form-label3" for="email">E-mail da livraria:</label>
        <input class="form-input3" type="email" name="email" required>

        <label class="form-label3" for="arquivo">Selecione uma imagem:</label>
        <input class="form-input3 file-input3" type="file" name="arquivo" accept=".jpg,.png" required>

        <label class="form-label3" for="perfil">Perfil:</label>
        <input class="form-input3" type="text" name="perfil" required>

        <label class="form-label3" for="instagram">Instagram:</label>
        <input class="form-input3" type="text" name="instagram" placeholder="URL" required>

        <input class="btn-submit3" type="submit" value="Cadastrar livraria">
    </form>
</body>

</html>
