<?php
include "../../conexao.php";
include "../protecao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="usuarios.css">
    <title>Usuarios - BACKSTAGE Community</title>
</head>

<body>
    <header>
        BACKSTAGE Community
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
            <!-- BARRA DE PESQUISA -->
        <div class="busca-container">
             <!--Botão de cadastro de usuário-->
            <div class='botao'>
                <a href="cadastrarusuario.php">Cadastrar usuário</a>
            </div> 
            
            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="nome do usuário">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
        <div class="pesquisa"> <!-- DIV DA CAIXA ONDE DENTRO APARECERÁ OS CARDS DO RESULTADO DA BUSCA-->
            <?php
            if (!isset($_GET['busca']) || empty($_GET['busca'])) {
                echo "<div class='resultados'></div>";
            } else {

                // Proteção contra SQL Injection
                $pesquisa = $conn->real_escape_string($_GET['busca']);

                // Query de busca
                $sql_code = "SELECT usu_nome, usu_id, usu_tipo_usuario, usu_status FROM usuarios WHERE usu_nome LIKE '%$pesquisa%' ";
                $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

                if ($sql_query->num_rows == 0) {
                    echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                } else {
                while ($row = $sql_query->fetch_assoc()) {
                        $status = (int) $row['usu_status'];
                        $usuario = (int) $row['usu_tipo_usuario']; 
                        $nomeUsuario = htmlspecialchars($row['usu_nome']);

                    if ($status == 0) {

                        if ($usuario == 0) {
                            echo "
                        <div class='card containerInput inativo'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                            <p class='inputID'>RESENHISTA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else if ($usuario == 1) {
                            echo "
                        <div class='card containerInput inativo'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                         <p class='inputID'>LIVRARIA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else {
                            echo "
                            <div class='card containerInput inativo'>
                            <text>NOME DE USUARIO</text>
                             <p class='input'>$nomeUsuario</p>
                            <div class='containerBtnInput'>
                             <p class='inputID'>ADMINISTRADOR</p>
                              <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                            </div>
                           </div>
                         ";
                        }
                    } else {
                        if ($usuario == 0) {
                            echo "
                        <div class='card containerInput'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                            <p class='inputID'>RESENHISTA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else if ($usuario == 1) {
                            echo "
                        <div class='card containerInput'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                         <p class='inputID'>LIVRARIA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else {
                            echo "
                        <div class='card containerInput'>
                            <text>NOME DO USUARIO</text>
                            <p class='input'>$nomeUsuario</p>
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
            }
            ?>
        </div>
        <!--CONTAGEM DE USUÁRIOS-------------------------------------------------------------->
        <div>
            <?php
            $sql = "SELECT usu_tipo_usuario, COUNT(*) AS quantidade
            FROM usuarios
            GROUP BY usu_tipo_usuario";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
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
                    <div class='card containerInput'>
                        <div class="linha">
                            <span class='textUsuario'>USÚARIO:</span>
                            <h3 class='inputContagem'>{$tipos[$tipo]}</h3>
                        </div>
                        <div class="linha">
                            <span class='textUsuario'>QUANTIDADE:</span>
                            <p class='inputContagem'>$quantidade</p>
                        </div>
                    </div>
                    ";
                }
            }
            $stmt->close();
            ?>
        </div>

        <div>
            <?php
            $consulta = "SELECT usu_nome, usu_id, usu_status, usu_tipo_usuario 
                         FROM usuarios 
                         order by usu_data_criacao desc";
            $stmt = $conn->prepare($consulta);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {       
                while ($row = $result->fetch_assoc()) {
                        $status = (int) $row['usu_status'];
                        $usuario = (int) $row['usu_tipo_usuario']; 
                        $nomeUsuario = htmlspecialchars($row['usu_nome']);

                    if ($status == 0) {

                        if ($usuario == 0) {
                            echo "
                        <div class='card containerInput inativo'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                            <p class='inputID'>RESENHISTA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else if ($usuario == 1) {
                            echo "
                        <div class='card containerInput inativo'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                         <p class='inputID'>LIVRARIA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else {
                            echo "
                            <div class='card containerInput inativo'>
                            <text>NOME DE USUARIO</text>
                             <p class='input'>$nomeUsuario</p>
                            <div class='containerBtnInput'>
                             <p class='inputID'>ADMINISTRADOR</p>
                              <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                            </div>
                           </div>
                         ";
                        }
                    } else {
                        if ($usuario == 0) {
                            echo "
                        <div class='card containerInput'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                            <p class='inputID'>RESENHISTA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else if ($usuario == 1) {
                            echo "
                        <div class='card containerInput'>
                        <text>NOME DE USUARIO</text>
                         <p class='input'>$nomeUsuario</p>
                        <div class='containerBtnInput'>
                         <p class='inputID'>LIVRARIA</p>
                          <a href='editarusuario.php?id={$row['usu_id']}'><div class='botao'>ATUALIZAR</div></a>
                        </div>
                       </div>
                     ";
                        } else {
                            echo "
                        <div class='card containerInput'>
                            <text>NOME DO USUARIO</text>
                            <p class='input'>$nomeUsuario</p>
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