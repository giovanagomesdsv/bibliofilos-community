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
    <link rel="stylesheet" href="autores.css">

    <title>BIBLIÓFILOS Community - Autores</title>
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
                <a href="../resenhas/resenhas.php">Resenhas</a>
                <a class="active" href="#">Autores</a>
                <a href="../livros/livros.php">Livros</a>
                <a href="../sobre/sobre.php">Sobre</a>
            </div>
            <div>
                <div class="busca-container">
                    <form action="" method="GET" class="busca-form">
                        <input type="text" name="busca" placeholder="nome do autor">
                        <button type="submit"><i class='bx bx-search'></i></button>
                    </form>
                </div>
            </div>

        </nav>
    </div>
    <section class="sec-padrao">
        <div style="width: 100%">
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
     SELECT aut_foto, aut_nome FROM AUTORES
        WHERE  aut_nome LIKE '%$pesquisa%'
     GROUP BY aut_foto, aut_nome";
                    $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

                    if ($sql_query->num_rows == 0) {
                        echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                    } else {
                        while ($dados = $sql_query->fetch_assoc()) {

                            echo "
<div class='card-aut'>
    <div class='card-inner'>
        <div class='card-front'>
            <img src='{$dados['aut_foto']}' alt='Foto de {$dados['aut_nome']}'>
            <p>{$dados['aut_nome']}</p>
        </div>
        <div class='card-back'>
            <p>{$dados['aut_nome']}</p>
            <a href='autor.php?nome=" . urlencode($dados['aut_nome']) . "' class='info-button'>Mais informações</a>
        </div>
    </div>
</div>";
                        }
                    }
                }
                ?>
            </div>

            <div class="titulo">
                <p>Todos os autores</p>
            </div>
            <div class="resenhas-container">
                <?php

                $autores = "SELECT aut_foto, aut_nome FROM AUTORES";

                $stmt = $conn->prepare($autores);
                $stmt->execute();
                $resp = $stmt->get_result();

                if ($resp->num_rows > 0) {
                    while ($aut = $resp->fetch_assoc()) {
                        echo "
<div class='card-aut'>
    <div class='card-inner'>
        <div class='card-front'>
            <img src='{$dados['aut_foto']}' alt='Foto de {$dados['aut_nome']}'>
            <p>{$dados['aut_nome']}</p>
        </div>
        <div class='card-back'>
            <p>{$dados['aut_nome']}</p>
            <a href='autor.php?nome=" . urlencode($dados['aut_nome']) . "' class='info-button'>Mais informações</a>
        </div>
    </div>
</div>";
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <div>
        <footer class="site-footer">
            <div class="footer-logo">
                <img src="../logo.png" alt="Logo do site">
            </div>

            <div class="footer-texto">
                <h3>Participe da nossa comunidade.</h3>
                <p>Se torne um resenhista.</p>
                <p>Entre em contato já!</p>
            </div>

            <div class="footer-redes">
                <a href="#" target="_blank" aria-label="X"><i class='bx bxl-xing' style="color: #fff"></i></a>
                <a href="#" target="_blank" aria-label="Instagram"><i class='bx bxl-instagram'
                        style="color: #fff"></i></a>
                <a href="#" target="_blank" aria-label="TikTok"><i class='bx bxl-tiktok' style="color: #fff"></i></a>
            </div>
        </footer>
    </div>
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