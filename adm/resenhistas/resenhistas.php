<?php
include "../../conexao.php";

include "../protecao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="../resenhistas.css">
    <link rel="stylesheet" href="../geral.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ADM BC - Resenhistas</title>

    <link rel="stylesheet" href="resenhistas.css">
    <link rel="stylesheet" href="geral.css">
</head>

<body>
    <header>
        Administrador BC
    </header>


    <nav class="sidebar" id="sidebar">
        <div class="nome">

            <li class="logo_name">
                <a href="perfil/perfil.php">
                    <span class="link_name">
                        <?php echo $_SESSION['nome']; ?>
                    </span>
                </a>
            </li>


            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>

        </div>
        <ul class="nav-list">
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
                <input type="text" name="busca" placeholder="nome do resenhista">
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
                $sql_code = "SELECT 
    resenhistas.res_nome_fantasia,
    resenhistas.res_telefone,
    titulo.tit_nome,
    resenhistas.res_foto,
    usuarios.usu_nome,
    COUNT(resenhas.res_id) AS total_resenhas
FROM 
    resenhistas
LEFT JOIN 
    resenhas ON resenhistas.res_id = resenhas.res_id
LEFT JOIN 
    titulo ON resenhistas.tit_id = titulo.tit_id
LEFT JOIN usuarios ON  usuarios.usu_id = resenhistas.res_id
GROUP BY 
    usuarios.usu_nome,
    resenhistas.res_id,
    resenhistas.res_nome_fantasia,
    resenhistas.res_telefone,
    titulo.tit_nome,
    resenhistas.res_foto
";
                $sql_query = $conn->query($sql_code) or die("Erro ao consultar: " . $conn->error);

                if ($sql_query->num_rows == 0) {
                    echo "<div class='resultados'><h3>Nenhum resultado encontrado!</h3></div>";
                } else {

                    while ($dados = $sql_query->fetch_assoc()) {
                        echo "

                        <div class='resenhista-box'>
                            <div class='resenhista-info'>
                                  <a href=\"https://wa.me/{$dados['res_telefone']}?text=$mensagem\" target=\"_blank\"><img src='../imagens/resenhistas/{$dados['res_foto']}' alt='Foto do Resenhista'></a>
                                </div>
                                  <div class='cardtext'>
                                 <h3>{$dados['usu_nome']}</h3>
                                 <p><strong>Pseudônimo:</strong> {$dados['res_nome_fantasia']}</p>
                                 <p><strong>Titulo:</strong> {$dados['tit_nome']}</p>
                                 </div>
                                 
                                 <div class='resenha-contador'>
                                    <p><strong>Total de Resenhas:</strong> {$dados['total_resenhas']}</p>
                                </div> 
                          
                        </div>
            ";
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
            while ($linha = mysqli_fetch_assoc($resp_consulta)) {

                // Sanitizar dados de saída
                $nomeFantasia = htmlspecialchars($linha['res_nome_fantasia']);
                $telefone = preg_replace('/[^0-9]/', '', $linha['res_telefone']); // só números
                $titulo = htmlspecialchars($linha['tit_nome']);
                $foto = htmlspecialchars($linha['res_foto']);
                $nomeUsuario = htmlspecialchars($linha['usu_nome']);
                $totalResenhas = (int) $linha['total_resenhas'];

                // Mensagem para o WhatsApp
                $mensagem = urlencode("Olá, aqui fala a administradora do site Bibliófilos Community!");

                // Verifica se a imagem existe
                $caminhoImagem = "../imagens/resenhistas/" . $foto;
                $imgTag = file_exists($caminhoImagem)
                    ? "<img src='$caminhoImagem' alt='Foto do Resenhista' style='width:100px;'>"
                    : "<div style='width:100px; height:100px; background:#ccc;'>Sem imagem</div>";

                    echo "
                    <div class='resenhista-box'>
                        <div class='resenhista-info'>
                            <a href='https://wa.me/{$telefone}?text={$mensagem}' target='_blank'>
                                $imgTag
                            </a>
                        </div>
                            <div class='cardtext'>
                                <h3>$nomeUsuario</h3>
                                <p><strong>Pseudônimo:</strong> $nomeFantasia</p>
                                <p><strong>Título:</strong> $titulo</p>
                            </div>
                       
                        <div class='resenha-contador'>
                            <p>Total de resenhas</p>
                            $totalResenhas
                        </div>
                    </div>
                ";
            }
        } else {
            echo "<p>Erro ao executar a consulta: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
        }
        ?>

        </div>
    </main>
    <script src="../script.js"></script>
</body>

</html>