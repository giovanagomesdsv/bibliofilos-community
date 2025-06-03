<?php
include "../../conexao.php";

include "../protecao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="resenhistas.css">
     <title>Resenhistas - BACKSTAGE Community</title>
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
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Bibliófilos Community</span>
                </a>
            </li>
        
            <li>
                <a href="../home.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="link_name">Home</span>
                </a>
            </li>
            <li>
                <a href="../livrarias/livrarias.php">
                    <i class='bx bx-user'></i>
                    <span class="link_name">Livrarias</span>
                </a>
            </li>
            <li class="fix">
                <a href="resenhistas.php">
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
    <!--EXIBE OS CARDS DAS LIVRARIAS-->
    <main>
        <div class="busca-container">
            <form action="" method="GET" class="busca-form">
                <input type="text" name="busca" placeholder="pseudonimo do resenhista">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
        <div class="pesquisa">
            <?php
            if (!isset($_GET['busca']) || empty($_GET['busca'])) {
                echo "<div class='resultados'></div>";
            } else {

                // Proteção contra SQL Injection
                $pesquisa = $conn->real_escape_string($_GET['busca']);

                // Query de busca
                $sql_code = "SELECT resenhistas.res_nome_fantasia, resenhistas.res_telefone, titulo.tit_nome, resenhistas.res_foto, usuarios.usu_nome,
                             COUNT(resenhas.res_id) AS total_resenhas
                             FROM resenhistas
                             LEFT JOIN resenhas ON resenhistas.res_id = resenhas.res_id
                             LEFT JOIN titulo ON resenhistas.tit_id = titulo.tit_id
                             LEFT JOIN usuarios ON usuarios.usu_id = resenhistas.res_id
                             WHERE resenhistas.res_nome_fantasia LIKE '%$pesquisa%'
                             GROUP BY resenhistas.res_id, resenhistas.res_nome_fantasia, resenhistas.res_telefone, titulo.tit_nome, resenhistas.res_foto, usuarios.usu_nome";
                $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

                if ($sql_query->num_rows == 0) {
                    echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                } else {
                    while ($dados = $sql_query->fetch_assoc()) {

                        $nomeFantasia = htmlspecialchars($dados['res_nome_fantasia']);
                        $telefone = htmlspecialchars($dados['res_telefone']); 
                        $titulo = htmlspecialchars($dados['tit_nome']);
                        $foto = htmlspecialchars($dados['res_foto']);
                        $nomeUsuario = htmlspecialchars($dados['usu_nome']);
                        $totalResenhas = (int) $dados['total_resenhas']; 

                        $mensagem = urlencode("Olá, aqui fala a administradora do site Bibliófilos Community!");
 
                        echo "
                       <div class='card resenhista-box'>
                        <div class='resenhista-info'>
                            <a href='https://wa.me/{$telefone}?text={$mensagem}' target='_blank'>
                              <img class='imagem' src='../imagens/resenhistas/$foto' alt=''>
                            </a>
                        </div>
                            <div class='cardtext'>
                                <h3>$nomeUsuario</h3>
                                <p><strong>Pseudônimo:</strong> $nomeFantasia</p>
                                <p><strong>Título:</strong> $titulo</p>
                            </div>
                       
                        <div class='resenha-contador'>
                            <p>Total de resenhas:</p>
                            $totalResenhas
                        </div>
                    </div>";
                    }
                }
            }
            ?>
        </div>

        <?php
        // Consulta de resenhistas com contagem de resenhas
        $consulta = "
    SELECT 
        resenhistas.res_nome_fantasia,
        resenhistas.res_telefone,
        titulo.tit_nome,
        resenhistas.res_foto,
        usuarios.usu_nome,
        COUNT(resenhas.res_id) AS total_resenhas
    FROM resenhistas
    LEFT JOIN resenhas ON resenhistas.res_id = resenhas.res_id
    LEFT JOIN titulo ON resenhistas.tit_id = titulo.tit_id
    LEFT JOIN usuarios ON usuarios.usu_id = resenhistas.res_id
    GROUP BY 
        usuarios.usu_nome,
        resenhistas.res_id,
        resenhistas.res_nome_fantasia,
        resenhistas.res_telefone,
        titulo.tit_nome,
        resenhistas.res_foto
";

        if ($resp_consulta = mysqli_query($conn, $consulta)) {
            while ($dados = mysqli_fetch_assoc($resp_consulta)) {
                        $nomeFantasia = htmlspecialchars($dados['res_nome_fantasia']);
                        $telefone = htmlspecialchars($dados['res_telefone']); 
                        $titulo = htmlspecialchars($dados['tit_nome']);
                        $foto = htmlspecialchars($dados['res_foto']);
                        $nomeUsuario = htmlspecialchars($dados['usu_nome']);
                        $totalResenhas = (int) $dados['total_resenhas']; 

                        $mensagem = urlencode("Olá, aqui fala a administradora do site Bibliófilos Community!");
 
                        echo "
                    <div class='card resenhista-box'>
                        <div class='resenhista-info'>
                            <a href='https://wa.me/{$telefone}?text={$mensagem}' target='_blank'>
                              <img class='imagem' src='../imagens/resenhistas/$foto' alt=''>
                            </a>
                        </div>
                        <div class='cardtext'>
                            <h3>$nomeUsuario</h3>
                            <p><strong>Pseudônimo:</strong> $nomeFantasia</p>
                            <p><strong>Título:</strong> $titulo</p>
                        </div>
                        <div class='resenha-contador'>
                            <p>Total de resenhas:</p>
                            $totalResenhas
                        </div>
                    </div>";
            }
        }
        ?>
        </div>
    </main>
    <script src="../script.js"></script>
</body>

</html>