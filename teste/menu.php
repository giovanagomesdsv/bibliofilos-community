<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="sty.css">
    <title>menu</title>
</head>


<body>
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

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const btn = document.getElementById("hamburguer-btn");
                const menuContainer = document.getElementById("menu-container");

                btn.addEventListener("click", () => {
                    menuContainer.classList.toggle("active");
                });
            });
        </script>
</body>

</html>