<?php
include "conexao.php";

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];

    if (!$email || empty($nome) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos corretamente.');</script>";
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $usuario = 1;
        $status = 0;

        $sql ="INSERT INTO USUARIOS (usu_nome, usu_email, usu_senha, usu_tipo_usuario, usu_status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nome, $email, $senha_hash, $usuario, $status);

        if ($stmt->execute()) {
            $ultimo_id = $stmt->insert_id;
            echo "<script>
                    alert('Usuário cadastrado com sucesso!');
                    location.href='cadastrar-livraria.php?id_usuario={$ultimo_id}';
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao cadastrar usuário!');
                  </script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="administrador/usuarios/cadastrarusuario.css">
    <link rel="stylesheet" type="text/css" href="../geral.css">

</head>
<body style="background-color:#DEDEDE">
    <form action="" method="post">
        <label for="email">E-mail do administrador:</label>
        <input type="email" name="email" required>

        <label for="nome">Nome do administrador:</label>
        <input type="text" name="nome" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <input type="submit" value="Cadastrar usuário">
    </form>
</body>
</html>
