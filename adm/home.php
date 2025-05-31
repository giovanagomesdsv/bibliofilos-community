<?php
include "protecao.php";
include "../conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=h1, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="geral.css">

    <title>Home - BACKSTAGE Community</title>

</head>
<style>

</style>

<body>
    <header>
        BACKSTAGE Community
    </header>
    <nav class="sidebar" id="sidebar">
        <div class="nome">
            <li class="logo_name">
                <a href="perfil/perfil.php">
                    <span class="link_name"><?php echo $_SESSION['nome']; ?></span>
                </a>
            </li>
            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>

        </div>
        <ul class="nav-list">
            <li>
                <a href="../index.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Bibliófilos Community</span>
                </a>
            </li>
            <li class="fix">
                <a href="home.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Home</span>
                </a>
            </li>
            <li>
                <a href="livrarias/livrarias.php">
                    <i class='bx bx-user'></i>
                    <span class="link_name">Livrarias</span>
                </a>
            </li>
            <li>
                <a href="resenhistas/resenhistas.php">
                    <i class='bx bx-user-pin'></i>
                    <span class="link_name">Resenhistas</span>
                </a>
            </li>
            <li>
                <a href="livro/livros.php">
                    <i class='bx bx-book-bookmark'></i>
                    <span class="link_name">Livros</span>
                </a>
            </li>
            <li>
                <a href="usuarios/usuarios.php">
                    <i class='bx bx-book-content'></i>
                    <span class="link_name">Usuarios</span>
                </a>
            </li>
            <li class="sair">
                <a href="logout.php"><i class='bx bx-log-out'></i></a>
            </li>
        </ul>
    </nav>

    <!--começo do corpo da página-->
    <main>

        <div class="titulo">
            <h3>Olá, <?php echo $_SESSION['nome']; ?>, <br> Seja bem-vindo!</h3>
        </div>
        <div class="avaliar">
            <div class="textnotificaçao"> AVALIAR</div>


            <?php
            // --------------------- RESENHAS ---------------------
            $sql = "SELECT resenha_titulo, res_nome_fantasia, resenha_id, livro_foto 
                      FROM RESENHAS 
                INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id 
                INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id 
                     WHERE resenha_status = 0";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                while ($res = $result->fetch_assoc()) {
                    $titulo = htmlspecialchars($res['resenha_titulo']); /*Previne ataques XSS (Cross-site scripting). Converte caracteres especiais HTML em entidades seguras. */
                    $autor = htmlspecialchars($res['res_nome_fantasia']);
                    $id = (int) $res['resenha_id']; //Garante que o valor seja tratado como número inteiro
                    $foto = htmlspecialchars($res['livro_foto']);

                    echo "
          <div class='card card1'>
                <img class='imagem' src='imagens/livros/{$foto}' alt=''>
            <div class='info'>
                <p>{$titulo}</p>
                <p>- {$autor}</p>
            </div>
            <div class='acao'>
               <a href='avaliar/avaliar.php?id={$id}'>
                  <button class='botao'>Avaliar</button>
               </a>
            </div>
          </div>";
                }  
            }
            $stmt->close();

            // --------------------- LIVRARIAS ---------------------
            //uma forma difernte de fazer a mesma coisa acima
            $stmt = $conn->prepare("
            SELECT usu_id, usu_nome, liv_nome, liv_foto 
              FROM usuarios 
        INNER JOIN livrarias ON livrarias.liv_id = usuarios.usu_id 
             WHERE usu_tipo_usuario = 1 AND usu_status = 0");

            if ($stmt && $stmt->execute()) {  //Verifica se a variável existe e não é falsa e executa em seguida
                $result = $stmt->get_result();

                while ($liv = $result->fetch_assoc()) {
                    $id = (int) $liv['usu_id'];
                    $livraria = htmlspecialchars($liv['liv_nome']);
                    $usuario = htmlspecialchars($liv['usu_nome']);
                    $foto = htmlspecialchars($liv['liv_foto']);

                    echo "
          <div class='card card1'>
                <img class='imagem' src='imagens/livrarias/{$foto}' alt=''>
            <div class='info'>
                <p>{$livraria}</p>
                <p>- {$usuario}</p>
            </div>
            <div class='acao'>
               <a href='avaliar/avaliar-livraria.php?id={$id}'>
                  <button class='botao'>Avaliar</button>
               </a>
            </div>
          </div>";
                }
            }
             $stmt->close();
            ?>
        </div>
    </main>
    
    <script src="script.js"></script>
</body>

</html>