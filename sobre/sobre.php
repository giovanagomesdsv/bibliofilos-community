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
    <link rel="stylesheet" href="sobre.css">

    <title>BIBLIÓFILOS Community - Sobre</title>
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
                <a href="../autores/autores.php">Autores</a>
                <a href="../livros/livros.php">Livros</a>
                <a class="active" href="#">Sobre</a>
            </div>
            <div>

            </div>

        </nav>
    </div>
    <section class="sec-padrao">
        <div style="width: 100%">
            <div class="titulo">
                <p>Resenhistas</p>
            </div>
            <div class="box-resenhista" style="">
                <?php
                $resenhista = "SELECT 
  RESENHISTAS.res_nome_fantasia, 
  RESENHISTAS.res_foto, 
  RESENHISTAS.res_social, 
  COUNT(RESENHAS.res_id) AS total_resenhas
FROM 
  RESENHISTAS
INNER JOIN 
  RESENHAS ON RESENHAS.res_id = RESENHISTAS.res_id
GROUP BY 
  RESENHISTAS.res_nome_fantasia, 
  RESENHISTAS.res_foto, 
  RESENHISTAS.res_social
  ORDER BY total_resenhas DESC";
                $stmt = $conn->prepare($resenhista);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                          <div class='card-res'>
                             <div class='imagem'>
                                <img src='../adm/imagens/resenhistas/{$row['res_foto']}' alt=''>
                             </div>
                             <div class='info'>
                                <h1>{$row['res_nome_fantasia']}</h1>
                                <h2>Resenhas: {$row['total_resenhas']}</h2>
                             </div>
                             <div class='footer-redes'>
                                <a href='{$row['res_social']}' target='_blank' aria-label='Instagram'><i class='bx bxl-instagram' style='color: #fff'></i></a>
                             </div>
                          </div>
                        ";
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