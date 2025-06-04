<?php
include "../../conexao.php";
include "protecao.php";

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$usuario = $_SESSION['tipo'];
$nome = $_SESSION['nome'];
$fotoRes = $_SESSION['imagem-res'];
$fotoLiv = $_SESSION['imagem-liv'];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../geral.css">
    <title>Minhas resenhas - BACKSTAGE Community</title>
</head>

<body>
    <header>
        BACKSTAGE Community
    </header>
    <nav class='sidebar' id='sidebar'>
        <ul class='nav-list'>
            <div class='nome'>

                <li class='logo_name'>
                    <a href='../perfil/perfil.php'>

                        <?php
                        if ($usuario == 0) {
                            $imgCaminho = "../../adm/imagens/resenhistas/" . $_SESSION['imagem-res'];
                        } else if ($usuario == 1) {
                            $imgCaminho = "../../adm/imagens/livrarias/" . $_SESSION['imagem-liv'];
                        }
                        ?>

                        <img src="<?php echo $imgCaminho; ?>" alt="" style="width:100px">

                        <span class='link_name'>
                            <?php echo $_SESSION['nome'] ?>
                        </span>
                    </a>
                </li>

                <div class='menu' id='menu'>
                    <i class='bx bx-menu'></i>
                </div>
            </div>
            <li>
                <a href='../../index.php'>
                    <i class='bx bx-user'></i>
                    <span class='link_name'>BIBLIÓFILOS Community</span>
                </a>
            </li>
            <!-- Apenas para livrarias -->
            <?php if ($usuario == 1): ?>
                <li>
                    <a href='../anuncio/anuncios.php'>
                        <i class='bx bx-user'></i>
                        <span class='link_name'>Anúncios</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href='../resenha/resenhas.php'>
                    <i class='bx bx-user'></i>
                    <span class='link_name'>Criar resenhas</span>
                </a>
            </li>
            <li class="fix">
                <a href='#'>
                    <i class='bx bx-user-pin'></i>
                    <span class='link_name'>Minhas resenhas</span>
                </a>
            </li>

            <li class='sair'>
                <a href='../logout.php'><i class='bx bx-log-out'></i></a>
            </li>
        </ul>
    </nav>
    <main>
        <div>
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

                    // Query de busca ---------------------------------------------------------------------------------PAREI AQUI-------------------------------------------------------
                    $sql_code = "SELECT * FROM RESENHAS WHERE resenha_titulo LIKE '%$pesquisa%' ";
                    $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

                    if ($sql_query->num_rows == 0) {
                        echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                    } else {
                        while ($row = $sql_query->fetch_assoc()) {
                            $status = (int) $row['usu_status'];
                            $usuario = (int) $row['usu_tipo_usuario'];
                            $nomeUsuario = htmlspecialchars($row['usu_nome']);
                        }
                    }
                }
                ?>
            </div>


        </div>

    </main>
    <script src="../script.js"></script>
</body>

</html>