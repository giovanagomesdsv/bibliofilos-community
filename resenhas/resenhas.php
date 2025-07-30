<?php
function limitarTexto($texto, $limite, $final = '...')
{
    if (strlen($texto) <= $limite) {
        return $texto;
    }
    return substr($texto, 0, $limite) . $final;
}
?>
<?php
include "../conexao.php";
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
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="resenha.css">

    <title>BIBLIÓFILOS Community - Resenhas</title>
</head>

<body>
    <!--Primeira tela______________________________________________________________________________________________________________-->
    <div class="tela1" id="sec1">

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
                    <img src="../logo.png" alt="Logo do site">
                </a>
            </div>
            <div class="links">
                <a href='../login/login.php'>Login</a>
                <a href="../index.php">Home</a>
                <a class="active" href="#">Resenhas</a>
                <a href="../autores/autores.php">Autores</a>
                <a href="../livros/livros.php">Livros</a>
                <a href="../sobre/sobre.php">Sobre</a>
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
    </div>
    <main style="border: 1px solid red; margin-top: 10rem">

        <div style="border: 1px solid blue; width: 100%">
            <!--Resultado da pesquisa----------------------------------------------------------->
            <div class="pesquisa" style="border: 1px solid blueviolet">
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

            <!--FILTRO DOS GENEROS-->
             <div class="categorias-container">
                <button class="categorias-toggle" onclick="toggleCategorias()">Categorias ▼</button>
                <div class="generos" id="lista-categorias">
                <?php
                $resenha = "SELECT gen_nome, livro_titulo, gen_icone, resenha_id FROM GENEROS INNER JOIN LIVRO_GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id INNER JOIN LIVROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN RESENHAS ON RESENHAS.livro_id = LIVROS.livro_id;";
                $generos = "SELECT gen_nome FROM GENEROS";
                $stmt = $conn->prepare($generos);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
    
        <div>
            <a href='?genero=" . urlencode($row['gen_nome']) . "'>
                <p>{$row['gen_nome']}</p>
            </a>
        </div>
    ";
                    }
                }

                if (isset($_GET['genero']) && !empty($_GET['genero'])) {
                    $generoSelecionado = $_GET['genero'];
                    $sqlResenhas = "SELECT gen_nome, livro_titulo, gen_icone, resenha_id 
                    FROM GENEROS 
                    INNER JOIN LIVRO_GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id 
                    INNER JOIN LIVROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id 
                    INNER JOIN RESENHAS ON RESENHAS.livro_id = LIVROS.livro_id
                    WHERE gen_nome = ?";

                    $stmt = $conn->prepare($sqlResenhas);
                    $stmt->bind_param("s", $generoSelecionado);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if ($res->num_rows > 0) {
                        echo "<h2>Resenhas do gênero: " . htmlspecialchars($generoSelecionado) . "</h2>";
                        while ($resenha = $res->fetch_assoc()) {
                            echo "
            <div class='resenha'>
                <p><strong>Título:</strong> {$resenha['livro_titulo']}</p>
                <p><a href='resenha-resultado/resenha.php?id={$resenha['resenha_id']}'>Ver resenha</a></p>
            </div>
            ";
                        }
                    } else {
                        echo "<p>Nenhuma resenha encontrada para esse gênero.</p>";
                    }
                }
                $stmt->close();

                ?>
            </div>
        </div>

        <div class="titulo">
            <p>Todas as resenhas</p>
        </div>
        <?php

        $resenhas = "SELECT resenha_titulo, resenha_texto, resenha_dtpublicacao, res_nome_fantasia, livro_foto, resenha_id 
             FROM RESENHAS 
             INNER JOIN RESENHISTAS ON RESENHAS.res_id = RESENHISTAS.res_id 
             INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id ORDER BY resenha_dtpublicacao DESC";

        $stmt = $conn->prepare($resenhas);
        $stmt->execute();
        $resp = $stmt->get_result();
        $resenha = [];

        if ($resp->num_rows > 0) {
            while ($linha = $resp->fetch_assoc()) {
                $resenha[] = $linha;
            }
        }
        ?>
        <a href="../resenha-resultado/resenha.php?id=<?= isset($resenha[0]) ? $resenha[0]['resenha_id'] : '' ?>">
            <div class='resenha'>
                <img src='../adm/imagens/livros/<?= isset($resenha[0]) ? $resenha[0]['livro_foto'] : '' ?>'>
                <div class='resenha-info'>
                    <h2><?= isset($resenha[0]) ? $resenha[0]['resenha_titulo'] : '' ?></h2>
                    <p><strong>Por:</strong> <?= isset($resenha[0]) ? $resenha[0]['res_nome_fantasia'] : '' ?> -
                        </strong>
                        <?= isset($resenha[0]) ? $resenha[0]['resenha_dtpublicacao'] : '' ?></p>
                    <p><?= isset($resenha[0]) ? limitarTexto($resenha[0]['resenha_texto'], 350, '...') : '' ?></p>
                </div>
            </div>
        </a>


    </main>
    <script>
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

        function toggleCategorias() {
            const lista = document.getElementById("lista-categorias");
            lista.style.display = lista.style.display === "flex" ? "none" : "flex";
        }
    </script>
</body>

</html>