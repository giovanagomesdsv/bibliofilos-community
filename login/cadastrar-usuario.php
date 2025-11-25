<?php
include "../conexao.php";

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nome = trim($_POST['nome']);
    $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $usuario = 1;
    $status = 0;

    $sql = "INSERT INTO USUARIOS (usu_nome, usu_email, usu_senha, usu_tipo_usuario, usu_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $nome, $email, $senha_hash, $usuario, $status);

    if ($stmt->execute()) {
        $ultimo_id = $stmt->insert_id;

        header("Location: cadastrar-livraria.php?id_usuario=" . htmlspecialchars($ultimo_id));
    } else {
        echo "<script>
                alert('Erro ao cadastrar usuário!');
              </script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" type="text/css" href="../geral.css">

</head>

<body style="background-color:#DEDEDE">
    <form action="" method="post" class="form-cadastro-usuario">
        <label for="email" class="form-label">E-mail da Livraria:</label>
        <input type="email" name="email" required class="form-input">
    
        <label for="nome" class="form-label">Nome da Livraria:</label>
        <input type="text" name="nome" required class="form-input">
    
        <label for="senha" class="form-label">Senha:</label>
        <input type="password" name="senha" required class="form-input">
    
        <input type="submit" value="Cadastrar usuário" class="form-submit">
    </form>
</body>

</html>