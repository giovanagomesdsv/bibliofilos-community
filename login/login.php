<?php
session_start();
include "../conexao.php";

$email = trim($_POST['email']); //trim() remove espaços em branco no início e no fim da string
$senha = trim($_POST['senha']);
$tipo_usuario = (int)$_POST['tipo_usuario']; // (int) força a conversão do valor para inteiro, garantindo que você está lidando com um número (útil por segurança e organização).

    $sql_code = "SELECT 
    u.usu_id, u.usu_email, u.usu_nome, u.usu_senha, u.usu_tipo_usuario, 
    u.usu_data_criacao, u.usu_status,

    r.res_id, r.tit_id, r.res_nome_fantasia, r.res_cidade, r.res_estado, 
    r.res_telefone, r.res_foto, r.res_perfil, r.res_social,

    l.liv_id, l.liv_nome, l.liv_cidade, l.liv_estado, l.liv_endereco, 
    l.liv_telefone, l.liv_email, l.liv_foto, l.liv_perfil, l.liv_social

FROM usuarios u
LEFT JOIN resenhistas r ON r.res_id = u.usu_id
LEFT JOIN livrarias l ON l.liv_id = u.usu_id
WHERE u.usu_email = ? AND u.usu_tipo_usuario = ? AND u.usu_status = 1;
"; // Aqui está sendo criada uma query SQL com parâmetros (?) para evitar SQL Injection.
    $stmt = $conn->prepare($sql_code); // Isso permite executar a mesma consulta várias vezes com diferentes valores de forma segura.
    $stmt->bind_param("si", $email, $tipo_usuario);

    /* Aqui os valores reais são vinculados aos ? da query.
"si" indica os tipos dos parâmetros:
"s" = string ($email)
"i" = inteiro ($tipo_usuario) */

    $stmt->execute(); // Executa a query preparada com os valores vinculados.
    $result = $stmt->get_result(); // Recupera o resultado da execução da query.


    if ($result->num_rows === 1) { // evita login com múltiplos ou nenhum usuário correspondente.
        $usuario_db = $result->fetch_assoc();

        /* fetch_assoc() pega o resultado da consulta como um array associativo, onde os nomes das colunas viram as chaves do array.

$usuario_db agora contém os dados encontrados que foram pedidos na consulta SQL*/

        if (password_verify($senha, $usuario_db['usu_senha'])) {
            $_SESSION['id'] = $usuario_db['usu_id'];
            $_SESSION['nome'] = $usuario_db['usu_nome'];
            $_SESSION['tipo'] = $usuario_db['usu_tipo_usuario'];
            $_SESSION['imagem-liv'] = $usuario_db['liv_foto'];
            $_SESSION['imagem-res'] = $usuario_db['res_foto'];

            // Cria variáveis de sessão, que permitem manter o usuário logado durante a navegação no site.

            header("Location: ../index.php");
        } else {
            echo "
                 <script>
                  window.alert('Falha ao logar! Senha incorreta');
                 </script>
                ";
        }
    } else {
        echo "
              <script>
                  window.alert('Falha ao logar! E-mail incorreto ou usuário não autorizado.');
              </script>
            ";
    }

    $stmt->close();

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