<?php
include "conexao.php";
session_start();

$usuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : null;
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Visitante';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Ícones -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Estilos -->
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="style.css">

    <title>BIBLIÓFILOS Community - HOME</title>
</head>

<body>
    <!--Primeira tela______________________________________________________________________________________________________________-->
    <section class="tela1" id="sec1">

        <!-- Navbar principal -->
        <nav class="navbarB">
            <div class="cont">
                <?php if (isset($usuario)): ?>
                    <div class="hamburguer-btn" id="hamburguer-btn">
                        <i class='bx bx-menu'></i>
                    </div>
                <?php endif; ?>

                <!-- Menu lateral controlado pelo JS -->
                <div id="menu-container">
                    <?php
                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 2) {
                        // Menu administrador
                        echo "
    <nav class='sidebar' id='sidebar'>
    
        <div class='nome'>
            <li>
                <a href='adm/perfil/perfil.php'>
                  <br>  <span class='link_name'>" . htmlspecialchars($_SESSION['nome']) . "</span>
                </a>
            </li>
            <div class='menu' id='menu-toggle'>
              <i class='bx bx-menu'></i>
            </div>
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
            <li class='sair'>
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
            <div class='menu' id='menu-toggle'>
                <i class='bx bx-menu'></i>
            </div>
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
             <li class='sair'>
                <a href='adm/logout.php'><i class='bx bx-log-out'></i></a>
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

        <!--Resultado da pesquisa----------------------------------------------------------->
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

        <div class="letreiro">
            <h3 class="nome1">Bibliófilos</h3>
            <h3 class="nome2">COMMUNITY</h3>
        </div>

        <div class="carrossel">
            <div class="change-text">
                <h3>
                    <span
                        class="word">"Um&nbsp;livro&nbsp;é&nbsp;um&nbsp;sonho&nbsp;que&nbsp;você&nbsp;segura&nbsp;nas&nbsp;mãos."&nbsp;–&nbsp;Neil&nbsp;Gaiman</span>

                    <span
                        class="word">"Os&nbsp;livros&nbsp;são&nbsp;os&nbsp;amigos&nbsp;mais&nbsp;silenciosos&nbsp;e&nbsp;constantes;&nbsp;os&nbsp;conselheiros&nbsp;mais&nbsp;acessíveis&nbsp;e&nbsp;sábios&nbsp;e&nbsp;os&nbsp;professores&nbsp;mais&nbsp;pacientes."&nbsp;–&nbsp;Charles&nbsp;W.&nbsp;Eliot</span>

                    <span
                        class="word">"Um&nbsp;quarto&nbsp;sem&nbsp;livros&nbsp;é&nbsp;como&nbsp;um&nbsp;corpo&nbsp;sem&nbsp;alma."&nbsp;–&nbsp;Cícero</span>

                    <span
                        class="word">"Os&nbsp;livros&nbsp;são&nbsp;uma&nbsp;magia&nbsp;portátil&nbsp;única."&nbsp;–&nbsp;Stephen&nbsp;King</span>

                    <span
                        class="word">"A&nbsp;leitura&nbsp;de&nbsp;um&nbsp;bom&nbsp;livro&nbsp;é&nbsp;um&nbsp;diálogo&nbsp;incessante:&nbsp;o&nbsp;livro&nbsp;fala&nbsp;e&nbsp;a&nbsp;alma&nbsp;responde."&nbsp;–&nbsp;André&nbsp;Maurois</span>

                    <span
                        class="word">"Sempre&nbsp;imaginei&nbsp;que&nbsp;o&nbsp;paraíso&nbsp;fosse&nbsp;uma&nbsp;espécie&nbsp;de&nbsp;biblioteca."&nbsp;–&nbsp;Jorge&nbsp;Luis&nbsp;Borges</span>

                    <span
                        class="word">"A&nbsp;leitura&nbsp;é&nbsp;para&nbsp;a&nbsp;mente&nbsp;o&nbsp;que&nbsp;o&nbsp;exercício&nbsp;é&nbsp;para&nbsp;o&nbsp;corpo."&nbsp;–&nbsp;Joseph&nbsp;Addison</span>

                    <span
                        class="word">"A&nbsp;pessoa&nbsp;que&nbsp;lê&nbsp;vive&nbsp;mil&nbsp;vidas&nbsp;antes&nbsp;de&nbsp;morrer.&nbsp;Quem&nbsp;não&nbsp;lê&nbsp;vive&nbsp;apenas&nbsp;uma."&nbsp;–&nbsp;George&nbsp;R.&nbsp;R.&nbsp;Martin</span>

                    <span
                        class="word">"Quando&nbsp;penso&nbsp;em&nbsp;todos&nbsp;os&nbsp;livros&nbsp;que&nbsp;ainda&nbsp;quero&nbsp;ler,&nbsp;tenho&nbsp;a&nbsp;certeza&nbsp;de&nbsp;ser&nbsp;feliz."&nbsp;–&nbsp;Jules&nbsp;Renard</span>

                    <span
                        class="word">"Os&nbsp;livros&nbsp;são&nbsp;o&nbsp;alimento&nbsp;da&nbsp;juventude&nbsp;e&nbsp;a&nbsp;alegria&nbsp;da&nbsp;velhice."&nbsp;–&nbsp;Marco&nbsp;Túlio&nbsp;Cícero</span>

                    <span
                        class="word">"Um&nbsp;livro&nbsp;é&nbsp;uma&nbsp;arma&nbsp;carregada&nbsp;na&nbsp;casa&nbsp;ao&nbsp;lado.&nbsp;Queimar&nbsp;livros&nbsp;é&nbsp;o&nbsp;mesmo&nbsp;que&nbsp;matar&nbsp;a&nbsp;liberdade."&nbsp;–&nbsp;Ray&nbsp;Bradbury,&nbsp;Fahrenheit&nbsp;451</span>

                    <span
                        class="word">"Livros&nbsp;nos&nbsp;dão&nbsp;a&nbsp;chance&nbsp;de&nbsp;viver&nbsp;vidas&nbsp;diferentes&nbsp;em&nbsp;cada&nbsp;página."&nbsp;–&nbsp;Anônimo</span>
                </h3>
            </div>
        </div>
    </section>

    <!--Segunda tela______________________________________________________________________________________________________________-->
    <section class="tela2" id="sec2">

        <?php
        include "conexao.php";

        // Buscar as 7 resenhas com maior avaliação (ativas)
        $sql = "
SELECT resenha_id, res_id, livro_id, resenha_titulo, resenha_texto, resenha_status, resenha_avaliacao, resenha_dtpublicacao, resenha_dtatualizacao
FROM resenhas
WHERE resenha_status = 0
ORDER BY resenha_avaliacao DESC
LIMIT 7
";
        $result = $conn->query($sql);
        $resenhas = [];

        if ($result && $result->num_rows > 0) {
            while ($res = $result->fetch_assoc()) {
                $resenhas[] = $res;
            }
        }
        ?>

        <div class="destaques">
            <div>
                <div>
                    <?= isset($resenhas[0]) ? $resenhas[0]['resenha_titulo'] : '' ?>
                </div>
                <div>
                    <div>
                        <?= isset($resenhas[1]) ? $resenhas[1]['resenha_titulo'] : '' ?>
                    </div>
                    <div>
                        <div>
                            <?= isset($resenhas[2]) ? $resenhas[2]['resenha_titulo'] : '' ?>
                        </div>
                        <div>
                            <?= isset($resenhas[3]) ? $resenhas[3]['resenha_titulo'] : '' ?>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <div>
                        <?= isset($resenhas[4]) ? $resenhas[4]['resenha_titulo'] : '' ?>
                    </div>
                    <div>
                        <?= isset($resenhas[5]) ? $resenhas[5]['resenha_titulo'] : '' ?>
                    </div>
                </div>
                <div>
                    <?= isset($resenhas[6]) ? $resenhas[6]['resenha_titulo'] : '' ?>
                </div>
            </div>
        </div>

        <div class="carrossel-cards">
            <?php
            $consulta = "SELECT liv_foto, liv_nome, liv_telefone FROM livrarias";
            $stmt = $conn->prepare($consulta);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($icon = $result->fetch_assoc()) {
                    $mensagem = urlencode("Olá, entro em contato através do Bibliófilos Community. Gostaria de obter maiores informações!");

                    echo "
                    <div>
                       <a href=\"https://wa.me/{$icon['liv_telefone']}?text=$mensagem\" target=\"_blank\">
                          <img src='adm/imagens/livrarias/{$icon['liv_foto']}' alt=''>
                       </a>
                       <p>{$icon['liv_nome']}</p>
                    </div>
                    ";
                }
            }

            ?>
        </div>

    </section>

    <!--Terceira tela______________________________________________________________________________________________________________-->
    <section class="tela3">
        <main>
            <p>olá</p>
        </main>

    </section>

    <script>
        let words = document.querySelectorAll(".word");

        words.forEach((word) => {
            let letters = word.textContent.split("");
            word.textContent = "";

            letters.forEach((letter) => {
                let span = document.createElement("span");
                span.textContent = letter;
                span.className = "letter";
                word.append(span);
            });
        });

        let currentWordIndex = 0;
        let maxWordIndex = words.length - 1;
        words[currentWordIndex].style.opacity = "1";

        let changeText = () => {
            let currentWord = words[currentWordIndex];
            let nextWord = currentWordIndex === maxWordIndex ? words[0] : words[currentWordIndex + 1];

            Array.from(currentWord.children).forEach((letter, i) => {
                setTimeout(() => {
                    letter.className = "letter out";
                }, i * 80);
            });

            nextWord.style.opacity = "1";
            Array.from(nextWord.children).forEach((letter, i) => {
                letter.className = "letter behind";
                setTimeout(() => {
                    letter.className = "letter in";
                }, 340 + i * 80);
            });

            currentWordIndex = currentWordIndex === maxWordIndex ? 0 : currentWordIndex + 1;
        };

        // ✅ Chamar a troca de texto a cada 4 segundos = 4000
        setInterval(changeText, 10000);


        document.addEventListener('DOMContentLoaded', () => {
            const hamburguerBtn = document.getElementById('hamburguer-btn');
            const menuContainer = document.getElementById('menu-container');
            const menuToggle = document.getElementById('menu-toggle');

            // Abre/fecha o menu lateral (slide-in)
            hamburguerBtn.addEventListener('click', () => {
                menuContainer.classList.toggle('active');
                sidebar.classList.toggle('abrir');
            });

            // Abre/fecha o menu lateral (slide-in)
            menuToggle.addEventListener('click', () => {
                menuContainer.classList.toggle('active');
                sidebar.classList.toggle('abrir');
            });


        });
    </script>
</body>

</html>