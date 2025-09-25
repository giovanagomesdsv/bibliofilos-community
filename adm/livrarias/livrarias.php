<?php
include "../../conexao.php";


include "../../protecao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="livrarias.css">

    <title>Livrarias - BACKSTAGE Community</title>
</head>

<body>
    <header>
        BACKSTAGE Community
    </header>
    <nav class="sidebar" id="sidebar">
    <ul class="nav-list">
        <div class="nome">
            <li>
                <a href="../perfil/perfil.php">
                    <span class="link_name">
                        <?php echo $_SESSION['nome']; ?>
                    </span>
                </a>
            </li>
            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>
        </div>
        <li>
                <a href="../../index.php">
                <i class='bx  bx-reply-stroke'></i> 
                    <span class="link_name">Bibliófilos Community</span>
                </a>
            </li>
     
            <li>
                <a href="../home.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Home</span>
                </a>
            </li>
            <li class="fix">
                <a href="livrarias.php">
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
            <li>
                <a href="../usuarios/usuarios.php">
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

        <!--EXIBE OS CARDS DAS LIVRARIAS-->
        <div class="busca-container">
            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="nome do resenhista">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>

        <div class="pesquisa">
            <?php

            if (!isset($_GET['busca']) || empty(trim($_GET['busca']))) {
                echo "<div class='resultados'></div>";
            } else {
                // Proteção contra SQL Injection
                $pesquisa = $conn->real_escape_string($_GET['busca']);

                // Query de busca
                $sql_code = "
        SELECT livrarias.liv_id, liv_nome, liv_cidade, liv_estado, liv_endereco, liv_email, liv_foto, liv_telefone,
        COUNT(livrarias_livros.liv_livro_id) AS total_livros 
         FROM  livrarias
    LEFT JOIN  livrarias_livros ON livrarias.liv_id = livrarias_livros.liv_id
        WHERE  liv_nome LIKE '%$pesquisa%'
     GROUP BY livrarias.liv_id, liv_nome, liv_cidade, liv_estado, liv_endereco, liv_email, liv_foto, liv_telefone";
                $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

                if ($sql_query->num_rows == 0) {
                    echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                } else {
                    while ($dados = $sql_query->fetch_assoc()) {
                        $mensagem = urlencode("Olá, aqui fala a administradora do site Bibliófilos Community, gostaria de solicitar mais informações sobre sua livraria/movimentações no nosso site!");

                        $nome = htmlspecialchars($dados['liv_nome']);
                        $email = htmlspecialchars($dados['liv_email']);
                        $cidade = htmlspecialchars($dados['liv_cidade']);
                        $estado = htmlspecialchars($dados['liv_estado']);
                        $telefone = htmlspecialchars($dados['liv_telefone']);
                        $total = (int) $dados['total_livros'];
                        $foto = htmlspecialchars($dados['liv_foto']);

                        echo "
          <div class='card-liv'>
              <a href=\"https://wa.me/{$telefone}?text=$mensagem\" target=\"_blank\">
                 <img src=\"../imagens/livrarias/{$foto}\" alt=''>
              </a>
              <p>{$nome}</p>
              <p>{$email}</p>
              <p>{$cidade} ({$estado})</p>
              <div class='input'>Total de Livros: {$total}</div>
          </div>";
                    }
                }
            }

            ?>
        </div>
        <h2>TODAS LIVRARIAS</h2>
        <div class="livrarias">
            <!--TODAS AS LIVRARIAS----------------------------------------------------->

            <?php
            $consulta = "
    SELECT  liv_nome, liv_cidade, liv_estado, liv_endereco, liv_email, liv_foto, liv_telefone, livrarias.liv_id,
     COUNT(livrarias_livros.liv_livro_id) AS total_livros 
      FROM  livrarias
 LEFT JOIN livrarias_livros ON livrarias.liv_id = livrarias_livros.liv_id
  GROUP BY liv_nome, liv_cidade, liv_estado, liv_endereco, liv_email, liv_foto, liv_telefone";

            $stmt = $conn->prepare($consulta);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Loop para exibir os resultados
                while ($res = $result->fetch_assoc()) {
                    // Mensagem personalizada para o WhatsApp
                    $mensagem = urlencode("Olá, aqui fala a administradora do site Bibliófilos Community, gostaria de solicitar mais informações sobre sua livraria/ movimentações no nosso site!");

                    $nome = htmlspecialchars($res['liv_nome']);
                    $email = htmlspecialchars($res['liv_email']);
                    $cidade = htmlspecialchars($res['liv_cidade']);
                    $estado = htmlspecialchars($res['liv_estado']);
                    $telefone = htmlspecialchars($res['liv_telefone']);
                    $total = htmlspecialchars($res['total_livros']);
                    $foto = htmlspecialchars($res['liv_foto']);

                    echo "
          <div class='card-liv'>
              <a href=\"https://wa.me/{$telefone}?text=$mensagem\" target=\"_blank\">
                 <img src=\"../imagens/livrarias/{$foto}\" alt=''>
              </a>
              <p>{$nome}</p>
              <p>{$email}</p>
              <p>{$cidade} ({$estado})</p>
              <div class='input'>Total de Livros: {$total}</div>
          </div>
          
          ";
                }
            }
            $stmt->close();
            ?>


        </div>
    </main>
    <script src="../script.js"></script>
</body>

</html>