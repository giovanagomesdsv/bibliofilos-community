<?php
session_start();
include "../conexao.php";

error_reporting(E_ALL); // reportar todos os erros
ini_set('display_errors', 1); // muda a configuração php, ativando (1) a exibição de erros

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['senha'], $_POST['tipo_usuario'])) { // isset() garante que esses campos foram enviados e não estão null

    $email = trim($_POST['email']); //trim() remove espaços em branco no início e no fim da string
    $senha = trim($_POST['senha']);
    $tipo_usuario = (int)$_POST['tipo_usuario']; // (int) força a conversão do valor para inteiro, garantindo que você está lidando com um número (útil por segurança e organização).

    if (empty($email) || empty($senha) || $_POST['tipo_usuario'] === "") {
        echo "Preencha todos os campos.";
    } else {
        $sql_code = "SELECT * FROM usuarios WHERE usu_email = ? AND usu_tipo_usuario = ? AND usu_status = 1"; // Aqui está sendo criada uma query SQL com parâmetros (?) para evitar SQL Injection.
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
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" type="text/css" href="../geral.css">

    <title>Administrador BC - Login</title>
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
                <a href="../index.php">Bibliófilos Community</a>
            </div>
    
            <!-- Tela de login (inicialmente oculta) -->
            <div class="form-container sign-in" id="loginContainer" style="display: none;">
                <form action="" method="POST">
                    <h1>LOGIN</h1>
                    <input type="hidden" name="tipo_usuario" id="tipoSelecionado">
                    <input type="email" name="email" placeholder="EMAIL" required>
                    <input type="password" name="senha" placeholder="SENHA" required>
                    <a href="esqueci a senha/esqueci-senha.php">ESQUECEU A SENHA</a>
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