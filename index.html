<?php
include "conexao.php";

session_start();

// Corrigido: variável $_SESSION[''] estava sem índice. Use o índice correto.
// Exemplo:
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="geral.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>BIBLIÓFILOS Community - HOME</title>
</head>

<body>
    <!-- Primeira tela -->
    <section class="tela1" id="sec1">

    <!-- Navbar principal -->

        <nav class="navbarB">
            <div>
                 <!-- Botão Hamburguer -->
     <div class="hamburguer-btn" id="hamburguer-btn">
        <i class='bx bx-menu'></i>
    </div>

    <!-- Menu lateral controlado pelo JS -->
    <div id="menu-container">
        <?php
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 2) {
            // Menu administrador
            echo "
            <nav class='sidebar' id='sidebar'>
                <div class='nome'>
                    <li class='logo_name'>
                        <a href='adm/perfil/perfil.php'>
                            <span class='link_name'>" . htmlspecialchars($_SESSION['nome']) . "</span>
                        </a>
                    </li>
                </div>
                <ul class='nav-list'>
                    <li class='fix'>
                        <a href='adm/home.php'>
                            <i class='bx bx-home-alt-2'></i>
                            <span class='link_name'>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href='adm/livrarias/livrarias.php'>
                            <i class='bx bx-user'></i>
                            <span class='link_name'>Livrarias</span>
                        </a>
                    </li>
                    <li>
                        <a href='adm/resenhistas/resenhistas.php'>
                            <i class='bx bx-user-pin'></i>
                            <span class='link_name'>Resenhistas</span>
                        </a>
                    </li>
                    <li>
                        <a href='adm/livro/livros.php'>
                            <i class='bx bx-book-bookmark'></i>
                            <span class='link_name'>Livros</span>
                        </a>
                    </li>
                    <li>
                        <a href='adm/usuarios/usuarios.php'>
                            <i class='bx bx-book-content'></i>
                            <span class='link_name'>Usuários</span>
                        </a>
                    </li>
                    <li class='sair' style='background-color: #000'>
                        <a href='adm/logout.php'><i class='bx bx-log-out'></i></a>
                    </li>
                </ul>
            </nav>
            ";
        } elseif (isset($_SESSION['tipo']) && ($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1)) {
            $usuarioTipo = $_SESSION['tipo'];
            $imgCaminho = ($usuarioTipo == 0)
                ? "adm/imagens/resenhistas/" . htmlspecialchars($_SESSION['imagem-res'])
                : "adm/imagens/livrarias/" . htmlspecialchars($_SESSION['imagem-liv']);
            $nome = htmlspecialchars($_SESSION['nome']);

            echo "
            <nav class='sidebar' id='sidebar'>
                <div class='nome'>
                    <li class='logo_name'>
                        <a href='liv-res/perfil/perfil.php'>
                            <img src='" . $imgCaminho . "' alt='Foto de perfil' style='width:100px' />
                            <span class='link_name'>{$nome}</span>
                        </a>
                    </li>
                </div>
                <ul class='nav-list'>";
            if ($usuarioTipo == 1) {
                echo "
                    <li>
                        <a href='liv-res/anuncio/anuncios.php'>
                            <i class='bx bx-user'></i>
                            <span class='link_name'>Anúncios</span>
                        </a>
                    </li>";
            }
            echo "
                    <li>
                        <a href='liv-res/resenha/resenhas.php'>
                            <i class='bx bx-user'></i>
                            <span class='link_name'>Criar resenhas</span>
                        </a>
                    </li>
                    <li>
                        <a href='liv-res/m-resenha/m-resenhas.php'>
                            <i class='bx bx-user-pin'></i>
                            <span class='link_name'>Minhas resenhas</span>
                        </a>
                    </li>
                </ul>
            </nav>";
        }
        ?>
    </div>
                <a href="#sec1">
                    <img src="logo.png" alt="Logo do site">
                </a>
            </div>
            <div class="links">
                <a href='login/login.php'>Login</a>
                <a class="active" href="#">Home</a>
                <a href="resenhas/resenhas.php">Resenhas</a>
                <a href="autores/autores.php">Autores</a>
                <a href="livros/livros.php">Livros</a>
                <a href="sobre/sobre.php">Sobre</a>
            </div>
            <div>
                <div class="busca-container">
                    <form action="" method="GET" class="busca-form">
                        <input type="text" name="busca" placeholder="nome do resenhista">
                        <button type="submit"><i class='bx bx-search'></i></button>
                    </form>
                </div>
            </div>

        </nav>

        <div class="letreiro">
            <h3 class="nome1">Bibliófilos</h3>
            <h3 class="nome2">COMMUNITY</h3>
        </div>

        <div class="carrossel">
            <div class="change-text">
                <h3>
                    <span class="word">"Um&nbsp;livro&nbsp;é&nbsp;um&nbsp;sonho&nbsp;que&nbsp;você&nbsp;segura&nbsp;nas&nbsp;mãos."&nbsp;–&nbsp;Neil&nbsp;Gaiman</span>

                    <span class="word">"Os&nbsp;livros&nbsp;são&nbsp;os&nbsp;amigos&nbsp;mais&nbsp;silenciosos&nbsp;e&nbsp;constantes;&nbsp;os&nbsp;conselheiros&nbsp;mais&nbsp;acessíveis&nbsp;e&nbsp;sábios&nbsp;e&nbsp;os&nbsp;professores&nbsp;mais&nbsp;pacientes."&nbsp;–&nbsp;Charles&nbsp;W.&nbsp;Eliot</span>

                    <span class="word">"Um&nbsp;quarto&nbsp;sem&nbsp;livros&nbsp;é&nbsp;como&nbsp;um&nbsp;corpo&nbsp;sem&nbsp;alma."&nbsp;–&nbsp;Cícero</span>

                    <span class="word">"Os&nbsp;livros&nbsp;são&nbsp;uma&nbsp;magia&nbsp;portátil&nbsp;única."&nbsp;–&nbsp;Stephen&nbsp;King</span>

                    <span class="word">"A&nbsp;leitura&nbsp;de&nbsp;um&nbsp;bom&nbsp;livro&nbsp;é&nbsp;um&nbsp;diálogo&nbsp;incessante:&nbsp;o&nbsp;livro&nbsp;fala&nbsp;e&nbsp;a&nbsp;alma&nbsp;responde."&nbsp;–&nbsp;André&nbsp;Maurois</span>

                    <span class="word">"Sempre&nbsp;imaginei&nbsp;que&nbsp;o&nbsp;paraíso&nbsp;fosse&nbsp;uma&nbsp;espécie&nbsp;de&nbsp;biblioteca."&nbsp;–&nbsp;Jorge&nbsp;Luis&nbsp;Borges</span>

                    <span class="word">"A&nbsp;leitura&nbsp;é&nbsp;para&nbsp;a&nbsp;mente&nbsp;o&nbsp;que&nbsp;o&nbsp;exercício&nbsp;é&nbsp;para&nbsp;o&nbsp;corpo."&nbsp;–&nbsp;Joseph&nbsp;Addison</span>

                    <span class="word">"A&nbsp;pessoa&nbsp;que&nbsp;lê&nbsp;vive&nbsp;mil&nbsp;vidas&nbsp;antes&nbsp;de&nbsp;morrer.&nbsp;Quem&nbsp;não&nbsp;lê&nbsp;vive&nbsp;apenas&nbsp;uma."&nbsp;–&nbsp;George&nbsp;R.&nbsp;R.&nbsp;Martin</span>

                    <span class="word">"Quando&nbsp;penso&nbsp;em&nbsp;todos&nbsp;os&nbsp;livros&nbsp;que&nbsp;ainda&nbsp;quero&nbsp;ler,&nbsp;tenho&nbsp;a&nbsp;certeza&nbsp;de&nbsp;ser&nbsp;feliz."&nbsp;–&nbsp;Jules&nbsp;Renard</span>

                    <span class="word">"Os&nbsp;livros&nbsp;são&nbsp;o&nbsp;alimento&nbsp;da&nbsp;juventude&nbsp;e&nbsp;a&nbsp;alegria&nbsp;da&nbsp;velhice."&nbsp;–&nbsp;Marco&nbsp;Túlio&nbsp;Cícero</span>

                    <span class="word">"Um&nbsp;livro&nbsp;é&nbsp;uma&nbsp;arma&nbsp;carregada&nbsp;na&nbsp;casa&nbsp;ao&nbsp;lado.&nbsp;Queimar&nbsp;livros&nbsp;é&nbsp;o&nbsp;mesmo&nbsp;que&nbsp;matar&nbsp;a&nbsp;liberdade."&nbsp;–&nbsp;Ray&nbsp;Bradbury,&nbsp;Fahrenheit&nbsp;451</span>

                    <span class="word">"Livros&nbsp;nos&nbsp;dão&nbsp;a&nbsp;chance&nbsp;de&nbsp;viver&nbsp;vidas&nbsp;diferentes&nbsp;em&nbsp;cada&nbsp;página."&nbsp;–&nbsp;Anônimo</span>
                </h3>
            </div>
        </div>
    </section>

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
                    $mensagem = urlencode("Olá, aqui fala a administradora do site Bibliófilos Community, gostaria de solicitar mais informações sobre sua livraria/ movimentações no nosso site!");

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
    </nav>


    </section>

    <!--Segunda tela___________________________________________________________________-->
    <section>
        <?php
        $consulta = "SELECT * FROM parceria";

        if ($resultado = mysqli_query($conexao, $consulta)) {
            while ($parceria = mysqli_fetch_array($resultado)) {
                echo "
                  <p>{$parceria['nome']}</p>
                ";
            }
        }
        ?>


    </section>

    <!--Terceira tela___________________________________________________________________-->
    <section>

        <!-- Barra de Pesquisa -->
        <div class="search-container">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Digite o título do artigo..." required>
                <button type="submit">Pesquisar</button>
            </form>
        </div>

        <div class="pesquisa">
            <?php
            // Pesquisa por slug (exibe um artigo específico)
            if (isset($_GET['slug'])) {
                $slug = $_GET['slug'];

                $stmt = $conexao->prepare("SELECT * FROM resenha WHERE slug = ?");
                $stmt->bind_param("s", $slug);
                $stmt->execute();

                $result = $stmt->get_result();
                $artigo = $result->fetch_assoc();

                if ($artigo) {
                    echo "<h1>" . htmlspecialchars($artigo['titulo']) . "</h1>";
                    echo "<p>" . nl2br(htmlspecialchars($artigo['sinopse'])) . "</p>";
                } else {
                    echo "Artigo não encontrado.";
                }

                $stmt->close();
            }
            // Pesquisa por termo (exibe resultados da busca)
            elseif (isset($_POST['search'])) {
                $search = '%' . $_POST['search'] . '%';

                $stmt = $conexao->prepare("SELECT * FROM resenha WHERE titulo LIKE ?");
                $stmt->bind_param("s", $search);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='card-container'>";
                    while ($artigo = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>";
                        echo "<p>" . substr(htmlspecialchars($artigo['sinopse']), 0, 100) . "...</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "Nenhum artigo encontrado para a pesquisa.";
                }

                $stmt->close();
            }
            ?>
        </div>

        <!-- Para as resenhas -->
        <main>

            <!-- Clássicos -->
            <!--div container das resenhas-->
            <div class="classicos">
                <?php
                $consulta_classicos = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Clássicos' ORDER BY data_publicacao DESC LIMIT 6";

                if ($resultado_classicos = mysqli_query($conexao,  $consulta_classicos)) {
                    while ($artigo = mysqli_fetch_array($resultado_classicos)) {

                        // div de cada resenha

                        echo "<div>
                           <img src='../administrador/resenha/{$artigo['path']}' alt=''>
                           <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                           <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        </div>";
                    }
                }


                ?>
            </div>




            <!-- Terror -->
            <!--div container das resenhas-->
            <div class="terror">
                <?php
                $consulta_terror = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo, resenha.sinopse FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Terror' ORDER BY data_publicacao DESC LIMIT 6";

                if ($resultado = mysqli_query($conexao,  $consulta_terror)) {
                    while ($artigo = mysqli_fetch_array($resultado)) {

                        // div de cada resenha

                        echo "<div>
                        <img src='../administrador/resenha/{$artigo['path']}' alt=''>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>" . substr(htmlspecialchars($artigo['sinopse']), 0, 100) . "...</p>
                       
                     </div>";
                    }
                }


                ?>
            </div>

            <!-- Suspense e mistério -->
            <!--div container das resenhas-->
            <div class="suspense">
                <?php
                $consulta_suspense = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo, resenha.sinopse FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Suspense e mistério' ORDER BY data_publicacao DESC LIMIT 6";

                if ($resultado_suspense = mysqli_query($conexao,  $consulta_suspense)) {
                    while ($artigo = mysqli_fetch_array($resultado_suspense)) {

                        // div de cada resenha

                        echo "<div>
                        <img src='../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    }
                }


                ?>
            </div>

            <!-- Romance -->
            <!--div container das resenhas-->
            <div class="romance">
                <?php
                $consulta_romance = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo, resenha.sinopse FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Romance' ORDER BY data_publicacao DESC LIMIT 6";

                if ($resultado_romance = mysqli_query($conexao,  $consulta_romance)) {
                    while ($artigo = mysqli_fetch_array($resultado_romance)) {

                        // div de cada resenha

                        echo "<div>
                        <img src='../administrador/resenha/{$artigo['path']}' alt=''>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                         <p>" . substr(htmlspecialchars($artigo['sinopse']), 0, 100) . "...</p>
                     </div>";
                    }
                }


                ?>
            </div>

            <!-- Ficção e fantasia -->
            <!--div container das resenhas-->
            <div class="ficcao">
                <?php
                $consulta_ficcao = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo, resenha.sinopse FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'Fantasia e Ficção' ORDER BY data_publicacao DESC LIMIT 6";

                if ($resultado_ficcao = mysqli_query($conexao,  $consulta_ficcao)) {
                    while ($artigo = mysqli_fetch_array($resultado_ficcao)) {

                        // div de cada resenha

                        echo "<div>
                        <img src='../administrador/resenha/{$artigo['path']}' alt=''>
                         <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2> 
                     </div>";
                    }
                }


                ?>
            </div>

            <!-- Aventura -->
            <!--div container das resenhas-->
            <div class="aventura">
                <?php
                $consulta_aventura = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo, resenha.sinopse FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'aventura' ORDER BY data_publicacao DESC LIMIT 6";

                if ($resultado_aventura = mysqli_query($conexao,  $consulta_aventura)) {
                    while ($artigo = mysqli_fetch_array($resultado_aventura)) {

                        // div de cada resenha

                        echo "<div>
                        <img src='../administrador/resenha/{$artigo['path']}' alt=''>
                        <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2>
                         <p>" . substr(htmlspecialchars($artigo['sinopse']), 0, 100) . "...</p>
                     </div>";
                    }
                }


                ?>
            </div>

            <!-- Drama -->
            <!--div container das resenhas-->
            <div class="drama">
                <?php
                $consulta_drama = "SELECT resenha.path, resenha.slug, resenha.titulo, resenha.data_publicacao, autor_resenha.pseudonimo, resenha.sinopse FROM resenha INNER JOIN autor_resenha ON resenha.id_autor_resenha = autor_resenha.id_autor_resenha WHERE genero = 'drama' ORDER BY data_publicacao DESC LIMIT 6";

                if ($resultado_drama = mysqli_query($conexao,  $consulta_drama)) {
                    while ($artigo = mysqli_fetch_array($resultado_drama)) {

                        // div de cada resenha

                        echo "<div>
                        <img src='../administrador/resenha/{$artigo['path']}' alt=''>
                        <h2><a href='http://localhost/TCC/site-principal/resenha-resultado/resenha.php?id={$artigo['slug']}'>" . htmlspecialchars($artigo['titulo']) . "</a></h2> 
                         <p>{$artigo['pseudonimo']} ({$artigo['data_publicacao']})</p>
                     </div>";
                    }
                }


                ?>
            </div>


        </main>


    </section>


    <script src="script.js"></script>
</body>

</html>