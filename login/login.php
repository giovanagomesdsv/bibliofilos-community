<?php
session_start();
include "../conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['senha'], $_POST['tipo_usuario']) && $_POST['email'] !== '' && $_POST['senha'] !== '') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $tipo_usuario = (int)$_POST['tipo_usuario'];

    $sql_code = "SELECT 
        u.usu_id, u.usu_email, u.usu_nome, u.usu_senha, u.usu_tipo_usuario, u.usu_status,

        r.res_id, r.res_foto,

        l.liv_id, l.liv_foto

    FROM usuarios u
    LEFT JOIN resenhistas r ON r.res_id = u.usu_id
    LEFT JOIN livrarias l ON l.liv_id = u.usu_id
    WHERE u.usu_email = ? AND u.usu_tipo_usuario = ? AND u.usu_status = 1";

    $stmt = $conn->prepare($sql_code);
    $stmt->bind_param("si", $email, $tipo_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Nenhum usuário encontrado com este e-mail, tipo selecionado e status ativo.');</script>";
    } else {
        $usuario_db = $result->fetch_assoc();
        echo "<script>console.log('Usuário encontrado: tipo_usuario = {$usuario_db['usu_tipo_usuario']}, status = {$usuario_db['usu_status']}');</script>";

        if (password_verify($senha, $usuario_db['usu_senha'])) {
            $_SESSION['id'] = $usuario_db['usu_id'];
            $_SESSION['nome'] = $usuario_db['usu_nome'];
            $_SESSION['tipo'] = $usuario_db['usu_tipo_usuario'];
            $_SESSION['imagem-liv'] = $usuario_db['liv_foto'];
            $_SESSION['imagem-res'] = $usuario_db['res_foto'];

            header("Location: ../index.php");
            exit;
        } else {
            echo "<script>alert('Falha ao logar! Senha incorreta');</script>";
        }
    }

    $stmt->close();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<script>alert('Por favor, preencha todos os campos antes de continuar.');</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" type="text/css" href="../geral.css">

    <title>Login - BACKSTAGE Community</title>
</head>

<body>
    <div class="container">
        <!-- Lado esquerdo (logo) -->
        <div class="left">
            <img src="backstage.jpeg" alt="Logo Bibliófilos" class="logo">
        </div>

        <!-- Lado direito -->
        <div class="right">
            <!-- Tela de seleção -->
            <div class="form-container select-type" id="selectType">
                <h2>SELECIONE O USUÁRIO</h2>
                <select id="tipo_usuario">
                    <option value="" disabled selected>SELECIONE O TIPO DE USUARIO</option>
                    <option value="2">Administrador</option>
                    <option value="0">Resenhista</option>
                    <option value="1">Livraria</option>
                </select>
                <button class="btn" id="proximoBtn">PRÓXIMO</button>
                <br>
                <a href="../index.php" class=''>Bibliófilos Community</a>
            </div>

            <!-- Tela de login (inicialmente oculta) -->
            <div class="form-container sign-in" id="loginContainer" style="display: none;">
                <form action="" method="POST">
                    <h1>LOGIN</h1>
                    <input type="hidden" name="tipo_usuario" id="tipoSelecionado">
                    <input type="email" name="email" placeholder="EMAIL" required>
                    <input type="password" name="senha" placeholder="SENHA" required>
                    <a href="esqueci-senha.php">ESQUECEU A SENHA</a>
                    <button class="btn" type="submit">ENTRAR</button>

                    <a id="cadastro-link" href="cadastrar-usuario.php" style="display: none;">Criar conta como livraria</a>
                    <a id="resenhista-link" href="#" target="_blank" style="display: none;">Quero me tornar um resenhista</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        const proximoBtn = document.getElementById('proximoBtn');
        const tipoUsuario = document.getElementById('tipo_usuario');
        const loginContainer = document.getElementById('loginContainer');
        const tipoSelecionado = document.getElementById('tipoSelecionado');
        const cadastroLink = document.getElementById('cadastro-link');
        const resenhistaLink = document.getElementById('resenhista-link');
        const selectTypeDiv = document.getElementById('selectType');

        proximoBtn.addEventListener('click', () => {
            const tipo = tipoUsuario.value;
            if (!tipo) {
                alert("Por favor, selecione o tipo de usuário.");
                return;
            }

            tipoSelecionado.value = tipo;
            loginContainer.style.display = 'block';
            selectTypeDiv.style.display = 'none';

            // Mostrar links dinâmicos
            if (tipo === "1") {
                cadastroLink.style.display = 'inline-block';
                resenhistaLink.style.display = 'none';
            } else if (tipo === "0") {
                cadastroLink.style.display = 'none';
                resenhistaLink.style.display = 'inline-block';
                const mensagem = encodeURIComponent("Olá, gostaria de me tornar um resenhista na plataforma BACKSTAGE Community.");
                resenhistaLink.href = `https://wa.me/5514997460253?text=${mensagem}`;
            } else {
                cadastroLink.style.display = 'none';
                resenhistaLink.style.display = 'none';
            }
        });
    </script>
</body>

</html>