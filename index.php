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
include "conexao.php";
session_start();

$usuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : null;
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Visitante';

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
                        <i class='bx bx-menu' style="color: #fff"></i>
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

            </div>

        </nav>

        <div class="letreiro">
            <h3 class="nome1">Bibliófilos</h3>
            <h3 class="nome2">COMMUNITY</h3>
        </div>

        <div class="carrossel">
            <div class="change-text" style="background-color: #fff">
                <h3>
                    <span
                        class="word">"Um&nbsp;livro&nbsp;é&nbsp;um&nbsp;sonho&nbsp;que&nbsp;você&nbsp;segura&nbsp;nas&nbsp;mãos."&nbsp;–&nbsp;Neil&nbsp;Gaiman</span>

                    <span
                        class="word" >"Os&nbsp;livros&nbsp;são&nbsp;os&nbsp;amigos&nbsp;mais&nbsp;silenciosos&nbsp;e&nbsp;constantes;&nbsp;os&nbsp;conselheiros&nbsp;mais&nbsp;acessíveis&nbsp;e&nbsp;sábios&nbsp;e&nbsp;os&nbsp;professores&nbsp;mais&nbsp;pacientes."&nbsp;–&nbsp;Charles&nbsp;W.&nbsp;Eliot</span>

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
SELECT 
    resenha_id, 
    resenha_titulo, 
    resenha_status, 
    livro_foto, 
    resenha_dtpublicacao, 
    resenha_avaliacao
FROM 
    resenhas 
INNER JOIN 
    livros ON resenhas.livro_id = livros.livro_id
WHERE 
    resenha_status = 0 
ORDER BY 
    resenha_avaliacao DESC, 
    resenha_dtpublicacao DESC
LIMIT 7
"; // MUDAR RESENHA_STATUS 
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
                <a href="resenha-resultado/resenha.php?id=<?= isset($resenhas[0]) ? $resenhas[0]['resenha_id'] : '' ?>">
                    <div class="caixa destaque-grande">
                        <img src="adm/imagens/livros/<?= isset($resenhas[0]) ? $resenhas[0]['livro_foto'] : '' ?>"
                            alt="">
                        <p><?= isset($resenhas[0]) ? $resenhas[0]['resenha_titulo'] : '' ?></p>
                    </div>
                </a>
                <div>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($resenhas[1]) ? $resenhas[1]['resenha_id'] : '' ?>">
                        <div class="caixa destaque-medio">
                            <img src="adm/imagens/livros/<?= isset($resenhas[1]) ? $resenhas[1]['livro_foto'] : '' ?>"
                                alt="">
                            <p><?= isset($resenhas[1]) ? $resenhas[1]['resenha_titulo'] : '' ?></p>
                        </div>
                    </a>
                    <div
                        style="width: 50%; display: flex; flex-direction: column; overflow: hidden; border-radius: 8px">
                        <a
                            href="resenha-resultado/resenha.php?id=<?= isset($resenhas[2]) ? $resenhas[2]['resenha_id'] : '' ?>">
                            <div class="caixa destaque-pequeno">
                                <img src="adm/imagens/livros/<?= isset($resenhas[2]) ? $resenhas[2]['livro_foto'] : '' ?>"
                                    alt="">
                                <p><?= isset($resenhas[2]) ? $resenhas[2]['resenha_titulo'] : '' ?></p>
                            </div>
                        </a>
                        <a
                            href="resenha-resultado/resenha.php?id=<?= isset($resenhas[3]) ? $resenhas[3]['resenha_id'] : '' ?>">
                            <div class="caixa destaque-pequeno" style="margin-top: .5rem">
                                <img src="adm/imagens/livros/<?= isset($resenhas[3]) ? $resenhas[3]['livro_foto'] : '' ?>"
                                    alt="">
                                <p><?= isset($resenhas[3]) ? $resenhas[3]['resenha_titulo'] : '' ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($resenhas[4]) ? $resenhas[4]['resenha_id'] : '' ?>">
                        <div class="caixa destaque-medio">
                            <img src="adm/imagens/livros/<?= isset($resenhas[4]) ? $resenhas[4]['livro_foto'] : '' ?>"
                                alt="">
                            <p><?= isset($resenhas[4]) ? $resenhas[4]['resenha_titulo'] : '' ?></p>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($resenhas[5]) ? $resenhas[5]['resenha_id'] : '' ?>">
                        <div class="caixa destaque-medio">
                            <img src="adm/imagens/livros/<?= isset($resenhas[5]) ? $resenhas[5]['livro_foto'] : '' ?>"
                                alt="">
                            <p><?= isset($resenhas[5]) ? $resenhas[5]['resenha_titulo'] : '' ?></p>
                        </div>
                    </a>
                </div>
                <a href="resenha-resultado/resenha.php?id=<?= isset($resenhas[6]) ? $resenhas[6]['resenha_id'] : '' ?>">
                    <div class="caixa destaque-grande">
                        <img src="adm/imagens/livros/<?= isset($resenhas[6]) ? $resenhas[6]['livro_foto'] : '' ?>"
                            alt="">
                        <p><?= isset($resenhas[6]) ? $resenhas[6]['resenha_titulo'] : '' ?></p>
                    </div>
                </a>
            </div>
        </div>

    </section>

    <!--Terceira tela______________________________________________________________________________________________________________-->
    <section class="tela3">
        <main>
            <!--tipo 1-->
            <?php
            $classicos = "SELECT resenha_id, resenha_titulo, resenha_texto, livro_foto, res_nome_fantasia, gen_nome FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id INNER JOIN LIVRO_GENEROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id WHERE gen_nome = ? AND resenha_status = ? ORDER BY resenha_dtpublicacao DESC LIMIT 4"; // mudar resenha_status
            $status = 0;
            $genero = "Clássicos";
            $stmt = $conn->prepare($classicos);
            $stmt->bind_param("si", $genero, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_classicos = [];

            if ($result->num_rows > 0) {
                while ($linha = $result->fetch_assoc()) {
                    $res_classicos[] = $linha;
                }
            }
            $stmt->close();
            ?>
            <div class="titulo">
                <p>Clássicos</p>
            </div>
            <div class="box box1">
                <div class="box-vert1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_classicos[0]) ? $res_classicos[0]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_classicos[0]) ? $res_classicos[0]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_classicos[0]) ? $res_classicos[0]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_classicos[0]) ? $res_classicos[0]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_classicos[1]) ? $res_classicos[1]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_classicos[1]) ? $res_classicos[1]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_classicos[1]) ? $res_classicos[1]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_classicos[1]) ? $res_classicos[1]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="box-hor1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_classicos[2]) ? $res_classicos[2]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_classicos[2]) ? $res_classicos[2]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_classicos[2]) ? $res_classicos[2]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_classicos[2]) ? $res_classicos[2]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_classicos[3]) ? $res_classicos[3]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_classicos[3]) ? $res_classicos[3]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_classicos[3]) ? $res_classicos[3]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_classicos[3]) ? $res_classicos[3]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!--tipo 2-->
            <?php
            $horror = "SELECT resenha_id, resenha_titulo, livro_sinopse, livro_foto, res_nome_fantasia, gen_nome FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id INNER JOIN LIVRO_GENEROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id WHERE gen_nome = ? AND resenha_status = ? ORDER BY resenha_dtpublicacao DESC LIMIT 2";
            $status = 0;  // mudar resenha_status
            $genero = "Horror";
            $stmt = $conn->prepare($horror);
            $stmt->bind_param("si", $genero, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_horror = [];

            if ($result->num_rows > 0) {
                while ($linha = $result->fetch_assoc()) {
                    $res_horror[] = $linha;
                }
            }
            $stmt->close();
            ?>
            <div class="titulo">
                <p>Horror</p>
            </div>
            <div class="box box2">
                <a
                    href="resenha-resultado/resenha.php?id=<?= isset($res_horror[0]) ? $res_horror[0]['resenha_id'] : '' ?>">
                    <div class="hor2">
                        <div class="image">
                            <img src="adm/imagens/livros/<?= isset($res_horror[0]) ? $res_horror[0]['livro_foto'] : '' ?>"
                                alt="">
                        </div>
                        <div class="info">
                            <p><?= isset($res_horror[0]) ? $res_horror[0]['res_nome_fantasia'] : '' ?></p>
                            <h1><?= isset($res_horror[0]) ? $res_horror[0]['resenha_titulo'] : '' ?></h1>
                            <p>
                                <?= isset($res_horror[1]) ? limitarTexto($res_horror[1]['livro_sinopse'], 350, '...') : '' ?>
                            </p>
                        </div>
                    </div>
                </a>
                <a
                    href="resenha-resultado/resenha.php?id=<?= isset($res_horror[1]) ? $res_horror[1]['resenha_id'] : '' ?>">
                    <div class="hor2">
                        <img src="adm/imagens/livros/<?= isset($res_horror[1]) ? $res_horror[1]['livro_foto'] : '' ?>"
                            alt="">
                        <div class="info">
                            <p><?= isset($res_horror[1]) ? $res_horror[1]['res_nome_fantasia'] : '' ?></p>
                            <h1><?= isset($res_horror[1]) ? $res_horror[1]['resenha_titulo'] : '' ?></h1>
                            <p>
                                <?= isset($res_horror[1]) ? limitarTexto($res_horror[1]['livro_sinopse'], 350, '...') : '' ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!--tipo 3-->
            <?php
            $misterio = "SELECT resenha_id, resenha_titulo, livro_sinopse, livro_foto, res_nome_fantasia, gen_nome FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id INNER JOIN LIVRO_GENEROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id WHERE gen_nome = ? AND resenha_status = ? ORDER BY resenha_dtpublicacao DESC LIMIT 4";
            $status = 0;  // mudar resenha_status
            $genero = "Mistério e Suspense";
            $stmt = $conn->prepare($misterio);
            $stmt->bind_param("si", $genero, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_misterio = [];

            if ($result->num_rows > 0) {
                while ($linha = $result->fetch_assoc()) {
                    $res_misterio[] = $linha;
                }
            }
            $stmt->close();
            ?>
            <div class="titulo">
                <p> Mistério e Suspense </p>
            </div>
            <div class="box box1">
                <div class="box-hor1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_misterio[0]) ? $res_misterio[0]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_misterio[0]) ? $res_misterio[0]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_misterio[0]) ? $res_misterio[0]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_misterio[0]) ? $res_misterio[0]['res_nome_fantasia'] : '' ?></p>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_misterio[1]) ? $res_misterio[1]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_misterio[1]) ? $res_misterio[1]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_misterio[1]) ? $res_misterio[1]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_misterio[1]) ? $res_misterio[1]['res_nome_fantasia'] : '' ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="box-hor1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_misterio[2]) ? $res_misterio[2]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_misterio[2]) ? $res_misterio[2]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_misterio[2]) ? $res_misterio[2]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_misterio[2]) ? $res_misterio[2]['res_nome_fantasia'] : '' ?></p>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_misterio[3]) ? $res_misterio[3]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_misterio[3]) ? $res_misterio[3]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_misterio[3]) ? $res_misterio[3]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_misterio[3]) ? $res_misterio[3]['res_nome_fantasia'] : '' ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!--tipo 4-->
            <?php
            $romance = "SELECT resenha_id, resenha_titulo, livro_sinopse, livro_foto, res_nome_fantasia, gen_nome FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id INNER JOIN LIVRO_GENEROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id WHERE gen_nome = ? AND resenha_status = ? ORDER BY resenha_dtpublicacao DESC LIMIT 4";
            $status = 0;  // mudar resenha_status
            $genero = "Romance";
            $stmt = $conn->prepare($romance);
            $stmt->bind_param("si", $genero, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_romance = [];

            if ($result->num_rows > 0) {
                while ($linha = $result->fetch_assoc()) {
                    $res_romance[] = $linha;
                }
            }
            $stmt->close();
            ?>
            <div class="titulo">
                <p>Romance</p>
            </div>
            <div class="box box1">
                <div class="box-vert1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_romance[0]) ? $res_romance[0]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_romance[0]) ? $res_romance[0]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_romance[0]) ? $res_romance[0]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_romance[0]) ? $res_romance[0]['resenha_titulo'] : '' ?></h1>
                                <p>
                                    <?= isset($res_romance[0]) ? limitarTexto($res_romance[0]['livro_sinopse'], 350, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_romance[1]) ? $res_romance[1]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_romance[1]) ? $res_romance[1]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_romance[1]) ? $res_romance[1]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_romance[1]) ? $res_romance[1]['resenha_titulo'] : '' ?></h1>
                                <p>
                                    <?= isset($res_romance[1]) ? limitarTexto($res_romance[1]['livro_sinopse'], 350, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="box-vert1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_romance[2]) ? $res_romance[2]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_romance[2]) ? $res_romance[2]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_romance[2]) ? $res_romance[2]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_romance[2]) ? $res_romance[2]['resenha_titulo'] : '' ?></h1>
                                <p>
                                    <?= isset($res_romance[2]) ? limitarTexto($res_romance[2]['livro_sinopse'], 150, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_romance[3]) ? $res_romance[3]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_romance[3]) ? $res_romance[3]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_romance[3]) ? $res_romance[3]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_romance[3]) ? $res_romance[3]['resenha_titulo'] : '' ?></h1>
                                <p>
                                    <?= isset($res_romance[3]) ? limitarTexto($res_romance[3]['livro_sinopse'], 350, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!--tipo 1-->
            <?php
            $fantasia = "SELECT resenha_id, resenha_titulo, resenha_texto, livro_foto, res_nome_fantasia, gen_nome FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id INNER JOIN LIVRO_GENEROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id WHERE gen_nome = ? AND resenha_status = ? ORDER BY resenha_dtpublicacao DESC LIMIT 4"; // mudar resenha_status
            $status = 0;
            $genero = "Fantasia";
            $stmt = $conn->prepare($fantasia);
            $stmt->bind_param("si", $genero, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_fantasia = [];

            if ($result->num_rows > 0) {
                while ($linha = $result->fetch_assoc()) {
                    $res_fantasia[] = $linha;
                }
            }
            $stmt->close();
            ?>
            <div class="titulo">
                <p>Fantasia</p>
            </div>
            <div class="box box1">
                <div class="box-vert1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_fantasia[0]) ? $res_fantasia[0]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_fantasia[0]) ? $res_fantasia[0]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_fantasia[0]) ? $res_fantasia[0]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_fantasia[0]) ? $res_fantasia[0]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_fantasia[1]) ? $res_fantasia[1]['resenha_id'] : '' ?>">
                        <div class="vert1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_fantasia[1]) ? $res_fantasia[1]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_fantasia[1]) ? $res_fantasia[1]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_fantasia[1]) ? $res_fantasia[1]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="box-hor1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_fantasia[2]) ? $res_fantasia[2]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_fantasia[2]) ? $res_fantasia[2]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_fantasia[2]) ? $res_fantasia[2]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_fantasia[2]) ? $res_fantasia[2]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_fantasia[3]) ? $res_fantasia[3]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_fantasia[3]) ? $res_fantasia[3]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <p><?= isset($res_fantasia[3]) ? $res_fantasia[3]['res_nome_fantasia'] : '' ?></p>
                                <h1><?= isset($res_fantasia[3]) ? $res_fantasia[3]['resenha_titulo'] : '' ?></h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


            <!--tipo 2-->
            <?php
            $aventura = "SELECT resenha_id, resenha_titulo, livro_sinopse, livro_foto, res_nome_fantasia, gen_nome FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id INNER JOIN LIVRO_GENEROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id WHERE gen_nome = ? AND resenha_status = ? ORDER BY resenha_dtpublicacao DESC LIMIT 2";
            $status = 0;  // mudar resenha_status
            $genero = "Aventura";
            $stmt = $conn->prepare($aventura);
            $stmt->bind_param("si", $genero, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_aventura = [];

            if ($result->num_rows > 0) {
                while ($linha = $result->fetch_assoc()) {
                    $res_aventura[] = $linha;
                }
            }
            $stmt->close();
            ?>
            <div class="titulo">
                <p>Aventura</p>
            </div>
            <div class="box box2">
                <a
                    href="resenha-resultado/resenha.php?id=<?= isset($res_aventura[0]) ? $res_aventura[0]['resenha_id'] : '' ?>">
                    <div class="hor2">
                        <div class="image">
                            <img src="adm/imagens/livros/<?= isset($res_aventura[0]) ? $res_aventura[0]['livro_foto'] : '' ?>"
                                alt="">
                        </div>
                        <div class="info">
                            <p><?= isset($res_aventura[0]) ? $res_aventura[0]['res_nome_fantasia'] : '' ?></p>
                            <h1><?= isset($res_aventura[0]) ? $res_aventura[0]['resenha_titulo'] : '' ?></h1>
                            <p>
                                <?= isset($res_aventura[1]) ? limitarTexto($res_aventura[1]['livro_sinopse'], 350, '...') : '' ?>
                            </p>
                        </div>
                    </div>
                </a>
                <a
                    href="resenha-resultado/resenha.php?id=<?= isset($res_aventura[1]) ? $res_aventura[1]['resenha_id'] : '' ?>">
                    <div class="hor2">
                        <img src="adm/imagens/livros/<?= isset($res_aventura[1]) ? $res_aventura[1]['livro_foto'] : '' ?>"
                            alt="">
                        <div class="info">
                            <p><?= isset($res_aventura[1]) ? $res_aventura[1]['res_nome_fantasia'] : '' ?></p>
                            <h1><?= isset($res_aventura[1]) ? $res_aventura[1]['resenha_titulo'] : '' ?></h1>
                            <p>
                                <?= isset($res_aventura[1]) ? limitarTexto($res_aventura[1]['livro_sinopse'], 350, '...') : '' ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <!--tipo 3-->
            <?php
            $ficcao = "SELECT resenha_id, resenha_titulo, livro_sinopse, livro_foto, res_nome_fantasia, gen_nome FROM RESENHAS INNER JOIN LIVROS ON RESENHAS.livro_id = LIVROS.livro_id INNER JOIN RESENHISTAS ON RESENHISTAS.res_id = RESENHAS.res_id INNER JOIN LIVRO_GENEROS ON LIVROS.livro_id = LIVRO_GENEROS.livro_id INNER JOIN GENEROS ON GENEROS.gen_id = LIVRO_GENEROS.gen_id WHERE gen_nome = ? AND resenha_status = ? ORDER BY resenha_dtpublicacao DESC LIMIT 4";
            $status = 0;  // mudar resenha_status
            $genero = "Ficção";
            $stmt = $conn->prepare($ficcao);
            $stmt->bind_param("si", $genero, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_ficcao = [];

            if ($result->num_rows > 0) {
                while ($linha = $result->fetch_assoc()) {
                    $res_ficcao[] = $linha;
                }
            }
            $stmt->close();
            ?>
            <div class="titulo">
                <p>Ficção</p>
            </div>
            <div class="box box1">
                <div class="box-hor1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_ficcao[0]) ? $res_ficcao[0]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_ficcao[0]) ? $res_ficcao[0]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_ficcao[0]) ? $res_ficcao[0]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_ficcao[0]) ? $res_ficcao[0]['res_nome_fantasia'] : '' ?></p>
                                <p>
                                    <?= isset($res_ficcao[0]) ? limitarTexto($res_ficcao[0]['livro_sinopse'], 350, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_ficcao[1]) ? $res_ficcao[1]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_ficcao[1]) ? $res_ficcao[1]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_ficcao[1]) ? $res_ficcao[1]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_ficcao[1]) ? $res_ficcao[1]['res_nome_fantasia'] : '' ?></p>
                                <p>
                                    <?= isset($res_ficcao[1]) ? limitarTexto($res_ficcao[1]['livro_sinopse'], 350, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="box-hor1">
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_ficcao[2]) ? $res_ficcao[2]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_ficcao[2]) ? $res_ficcao[2]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_ficcao[2]) ? $res_ficcao[2]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_ficcao[2]) ? $res_ficcao[2]['res_nome_fantasia'] : '' ?></p>
                                <p>
                                    <?= isset($res_ficcao[2]) ? limitarTexto($res_ficcao[2]['livro_sinopse'], 350, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                    <a
                        href="resenha-resultado/resenha.php?id=<?= isset($res_ficcao[3]) ? $res_ficcao[3]['resenha_id'] : '' ?>">
                        <div class="hor1">
                            <div class="image">
                                <img src="adm/imagens/livros/<?= isset($res_ficcao[3]) ? $res_ficcao[3]['livro_foto'] : '' ?>"
                                    alt="">
                            </div>
                            <div class="info">
                                <h1><?= isset($res_ficcao[3]) ? $res_ficcao[3]['resenha_titulo'] : '' ?></h1>
                                <p><?= isset($res_ficcao[3]) ? $res_ficcao[3]['res_nome_fantasia'] : '' ?></p>
                                <p>
                                    <?= isset($res_ficcao[3]) ? limitarTexto($res_ficcao[3]['livro_sinopse'], 350, '...') : '' ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </section>
    <footer class="site-footer">
        <div class="footer-logo">
            <img src="logo.png" alt="Logo do site">
        </div>

        <div class="footer-texto">
            <h3>Participe da nossa comunidade.</h3>
            <p>Se torne um resenhista.</p>
            <p>Entre em contato já!</p>
        </div>

        <div class="footer-redes">
            <a href="#" target="_blank" aria-label="X"><i class='bx bxl-xing' style="color: #fff"></i></a>
            <a href="#" target="_blank" aria-label="Instagram"><i class='bx bxl-instagram' style="color: #fff"></i></a>
            <a href="#" target="_blank" aria-label="TikTok"><i class='bx bxl-tiktok' style="color: #fff"></i></a>
        </div>
    </footer>


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


        /*menu lateral */
        document.addEventListener('DOMContentLoaded', () => {
            const hamburguerBtn = document.getElementById('hamburguer-btn');
            const menuContainer = document.getElementById('menu-container');
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar'); // Adicionado aqui

            // Abre/fecha o menu lateral (slide-in)
            hamburguerBtn.addEventListener('click', () => {
                menuContainer.classList.toggle('active');
                sidebar.classList.toggle('abrir');
            });

            menuToggle.addEventListener('click', () => {
                menuContainer.classList.toggle('active');
                sidebar.classList.toggle('abrir');
            });
        });


    </script>
</body>

</html>