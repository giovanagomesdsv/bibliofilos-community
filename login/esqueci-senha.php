<?php
include ("conexao.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['tipo_usuario'])) {
    $email = trim($_POST['email']);
    $tipo_usuario = (int)$_POST['tipo_usuario'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "<p style='color:red;'>E-mail inválido.</p>";
    } else {
        // Verifica se o usuário existe
        $sql = "SELECT * FROM usuarios WHERE usu_email = ? AND usu_tipo_usuario = ? AND usu_status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $tipo_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $novaSenha = substr(md5(time()), 0, 6);
            $senhaCriptografada = $novaSenha; // ou password_hash($novaSenha, PASSWORD_DEFAULT)

            // Atualiza a senha no banco
            $update = "UPDATE usuarios SET usu_senha = ? WHERE usu_email = ?";
            $stmtUpdate = $conn->prepare($update);
            $stmtUpdate->bind_param("ss", $senhaCriptografada, $email);

            if ($stmtUpdate->execute()) {
                $mensagem = "<p style='color:green;'>Senha redefinida com sucesso!</p>
                             <p style='color:blue;'>Sua nova senha temporária é: <strong>$novaSenha</strong></p>
                             <p style='color:orange;'>Por favor, faça login e altere sua senha imediatamente.</p>";
            } else {
                $mensagem = "<p style='color:red;'>Erro ao atualizar a senha. Tente novamente.</p>";
            }

            $stmtUpdate->close();
        } else {
            $mensagem = "<p style='color:red;'>Usuário não encontrado ou inativo.</p>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>

    <link rel="stylesheet" type="text/css" href="../geral.css">

    <style>

        h1{
            color:white;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        form {
            background: #333;
            padding: 30px;
            border-radius: 10px;
            background-color: var(--principal)
        }

        input, select, button {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: none;
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .mensagem {
            margin-top: 20px;
            text-align: center;
        }

        select {
        width: 100%;
        max-width: 50rem;
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 2px;
        font-size: 14px;
        border: 2px solid red;
        }

        input[type="email"] {
        width: 100%;
        max-width: 48rem;
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 2px;
        font-size: 14px;
        border: 2px solid red;
        }
        input[type="password"] {
        width: 100%;
        max-width: 30rem;
        padding: 20px;
        margin-bottom: 20px;
        border: none;
        border-radius: 2px;
        font-size: 14px;
        }
    </style>
</head>
<body>

    <h1>Recuperar Senha</h1>
    <form action="" method="POST">
        <input type="email" name="email" placeholder="Digite seu e-mail" required>
        <select name="tipo_usuario" required>
            <option value="">Selecione o tipo de usuário</option>
            <option value="0">Resenhista</option>
            <option value="1">Livraria</option>
            <option value="2">Administrador</option>
        </select>
        <button type="submit">Redefinir Senha</button>
    </form>

    <div class="mensagem">
        <?= $mensagem ?>
    </div>

</body>
</html>
