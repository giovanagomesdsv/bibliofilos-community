<?php
include "../../conexao.php";
include "../protecao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="usuarios.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>ADM BC - Usuarios</title>
</head>

<body style="background-color:#DEDEDE">
    <header>
        Administrador BC
    </header>
    <nav class="sidebar" id="sidebar">
        <div class="nome">

            <li class="logo_name">
                <a href="perfil/perfil.php">
                    <span class="link_name">
                        <?php echo $_SESSION['nome']; ?>
                    </span>
                </a>
            </li>


            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>

        </div>
        <ul class="nav-list">
            <li>
                <a href="../home.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Home</span>
                </a>
            </li>
            <li>
                <a href="../livrarias/livrarias.php">
                    <i class='bx bx-user'></i>
                    <span class="link_name">Livrarias</span>
                </a>
            </li>
            <li>
                <a href="../resenhistas/resenhistas.php">
                    <i class='bx bx-user-pin'></i>
                    <span class="link_name">Resenhistas</span>
                </a>
            </li>
            <li>
                <a href="../livro/livros.php">
                    <i class='bx bx-book-bookmark'></i>
                    <span class="link_name">Livros</span>
                </a>
            </li>
            <li class="fix">
                <a href="usuarios.php">
                    <i class='bx bx-book-content'></i>
                    <span class="link_name">Usuarios</span>
                </a>
            </li>
            <li class="sair">
                <a href="../logout.php"><i class='bx bx-log-out'></i></a>
            </li>
        </ul>
    </nav>

    <main>
        <!--Botão de cadastro de usuário-->
        <div class='container'>
            <div class="botao">
                <a href="cadastrarusuario.php">Cadastrar usuário</a>
            </div>

            <!-- BARRA DE PESQUISA -->
            <div class="busca">
                <form action="" method="GET" class="search-form">
                    <input type="text" name="busca" placeholder="PESQUISAR USUARIOS" class="search-input">
                </form>
            </div>
        </div>
        <div> <!-- DIV DA CAIXA ONDE DENTRO APARECERÁ OS CARDS DO RESULTADO DA BUSCA-->
            <?php
            if (!isset($_GET['busca']) || empty($_GET['busca'])) {
                echo "<div class='resultados'></div>";
            } else {

                // Proteção contra SQL Injection
                $pesquisa = $conn->real_escape_string($_GET['busca']);

                // Query de busca
                $sql_code = "SELECT usu_nome, usu_id, usu_tipo_usuario FROM usuarios WHERE usu_nome LIKE '%$pesquisa%' ";
                $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

                if ($sql_query->num_rows == 0) {
                    echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                } else {
                    while ($dados = $sql_query->fetch_assoc()) {

                        if ($dados['usu_tipo_usuario'] == 0) {
                            echo "
                <div class='containerInput'>
                        <text class='inputText'>NOME DE USUARIO</text>
                         <p class='inputNome'>Usuário: {$dados['usu_nome']}</p>
                         <text class="inputText">TIPO DE USUARIO</text>
                    <div class='containerBtnInput'>
                         <p class='inputID'>Id: {$dados['usu_id']}</p>
                          <a href='editarusuario.php?id={$dados['usu_id']}'><div class='atualizarBotao'>ATUALIZAR</div></a>
                    </div>
                </div>
                     ";
                        } else if ($dados['usu_tipo_usuario'] == 1) {
                            echo "
                <div class='containerInput'>
                        <text class='inputText'>NOME DE USUARIO</text>
                         <p class='inputNome'>Usuário: {$dados['usu_nome']}</p>
                         <text class='inputText'>TIPO DE USUARIO</text>
                         <div class='containerBtnInput'>
                         <p class='inputID'>Id: {$dados['usu.id']</p>
                          <a href='editarusuario.php?id={$dados['usu_id']}'><div class='atualizarBotao'>ATUALIZAR</div></a>
                    </div>
                </div>
                     ";
                        } else {
                            echo "
                    <div class='containerInput'>
                            <text class='inputText'>NOME DE USUARIO</text>
                             <p class='inputNome'>Usuário: {$dados['usu_nome']}</p>
                             <text class='inputText'>TIPO DE USUARIO</text>
                             <div class='containerBtnInput'>
                             <p class='inputID'>Id: {$dados['usu.id']</p>
                              <a href='editarusuario.php?id={$dados['usu_id']}'><div class='atualizarBotao'>ATUALIZAR</div></a>
                        </div>
                    </div>
                         ";
                        }
                    }
                }
            }
            ?>
        </div>
        <div>
            <?php

            $sql = "SELECT usu_tipo_usuario, COUNT(*) AS quantidade
            FROM usuarios
            GROUP BY usu_tipo_usuario";
            $stmt = $conn->prepare($sql);

            if ($stmt && $stmt->execute()) {
                $result = $stmt->get_result();

                // Array para mapear tipo para nome
                $tipos = [
                    0 => "Resenhistas",
                    1 => "Livrarias",
                    2 => "Administradores"
                ];


                while ($row = $result->fetch_assoc()) { // percorre cada linha de resultado retornada pela consulta SQL
                    $tipo = $row['usu_tipo_usuario'];
                    $quantidade = $row['quantidade'];

                    // Cria um card para cada tipo encontrado no banco
                    echo "
                        <div>
                            <h3>{$tipos[$tipo]}</h3>
                            <p>$quantidade</p>
                        </div>
                    ";
                }
            }
            $stmt->close();
            ?>
        </div>
        <div>
            <?php
            $consulta = "SELECT usu_nome, usu_id, usu_status, usu_tipo_usuario FROM usuarios order by usu_data_criacao desc";
            $stmt = $conn->prepare($consulta);


            if ($stmt &&  $stmt->execute()) {
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {

                    if ($row['usu_status'] == 0) {

                        if ($row['usu_tipo_usuario'] == 0) {
                            echo "
                        <div class='containerInput' style='background-color:rgba(119, 136, 153, .6)'>
                        <text>NOME DE USUARIO</text>
                         <p class='inputNome'>Usuário: {$row['usu_nome']}</p>
                         <p class='inputNome'>RESENHISTA</p>
                         <text>ID</text>
                        <div class='containerBtnInput'>
                         <p class='inputID'>Id: {$row['usu_id']}</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else if ($row['usu_tipo_usuario'] == 1) {
                            echo "
                        <div class='containerInput' style='background-color:rgba(119, 136, 153, .6)'>
                        <text>NOME DE USUARIO</text>
                         <p class='inputNome'>Usuário: {$row['usu_nome']}</p>
                        <div class='containerBtnInput'>
                         <p class='inputID'>LIVRARIA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else {
                            echo "
                            <div class='containerInput' style='background-color:rgba(119, 136, 153, .6)'>
                            <text>NOME DE USUARIO</text>
                             <p class='inputNome'>Usuário: {$row['usu_nome']}</p>
                            <div class='containerBtnInput'>
                             <p class='inputID'>ADMINISTRADOR</p>
                              <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                            </div>
                           </div>
                         ";
                        }
                    } else {
                        if ($row['usu_tipo_usuario'] == 0) {
                            echo "
                        <div class='containerInput'>
                        <text>NOME DE USUARIO</text>
                         <p class='inputNome'>Usuário: {$row['usu_nome']}</p>
                         <p class='inputNome'>RESENHISTA</p>
                         <text>ID</text>
                        <div class='containerBtnInput'>
                         <p class='inputID'>Id: {$row['usu_id']}</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else if ($row['usu_tipo_usuario'] == 1) {
                            echo "
                        <div class='containerInput'>
                        <text>NOME DE USUARIO</text>
                         <p class='inputNome'>Usuário: {$row['usu_nome']}</p>
                        <div class='containerBtnInput'>
                         <p class='inputID'>LIVRARIA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else {
                            echo "
                            <div class='containerInput'>
                            <text>NOME DE USUARIO</text>
                             <p class='inputNome'>Usuário: {$row['usu_nome']}</p>
                            <div class='containerBtnInput'>
                             <p class='inputID'>ADMINISTRADOR</p>
                              <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                            </div>
                           </div>
                         ";
                        }
                    }
                }
            }
            $stmt->close();
            ?>
        </div>
    </main>

    <script src="../script.js"></script>
</body>

</html>