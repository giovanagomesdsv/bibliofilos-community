<?php
include "../../conexao.php";

// Verifica se o ID foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não fornecido.");
}

$dado = (int) $_GET['id']; // Garante que o ID seja tratado como um número inteiro

// ------------------- AVALIAR LIVRARIA -------------------

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['avaliar'])) {
    $avaliar = (int) $_POST['avaliar'];

    // Verifica se o usuário é do tipo 'livraria' (usu_tipo_usuario = 1)
    $SELECT_USER = "SELECT usu_tipo_usuario FROM usuarios WHERE usu_id = ?";
    $stmt_user = $conn->prepare($SELECT_USER);
    $stmt_user->bind_param("i", $dado);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $tipo_usuario = $row_user['usu_tipo_usuario'];

        // Somente usuários do tipo livraria (usu_tipo_usuario = 1) podem ser avaliados
        if ($tipo_usuario == 1) {
            // Atualiza o status da livraria no banco
            $UPDATE = "UPDATE usuarios SET usu_status = ? WHERE usu_id = ?";
            $stmt = $conn->prepare($UPDATE);
            $stmt->bind_param("ii", $avaliar, $dado);

            // Executa a atualização
            if ($stmt->execute()) {
                echo "<script>alert('Avaliado com sucesso! Não se esqueça de avisar a livraria pelo email.'); window.location.href = '../home.php';</script>";
                exit();
            } else {
                echo "<script>alert('Erro ao avaliar.'); window.location.href = '../home.php';</script>";
            }
            $stmt->close();
        } else {
            // Caso não seja livraria, não será possível realizar a avaliação
            echo "<script>alert('Somente livrarias podem ser avaliadas.'); window.location.href = '../home.php';</script>";
            exit();
        }
    }
}

// ------------------- EXIBIR LIVRARIA -------------------

$SELECT = "
    SELECT 
        u.usu_nome, u.usu_email, u.usu_senha, u.usu_tipo_usuario, u.usu_status, 
        l.liv_id, l.liv_nome, l.liv_cidade, l.liv_estado, l.liv_endereco, l.liv_telefone, l.liv_email, l.liv_foto, l.liv_perfil, l.liv_social
    FROM 
        usuarios u
    LEFT JOIN 
        livrarias l ON u.usu_id = l.liv_id
    WHERE 
        u.usu_id = ? AND u.usu_tipo_usuario = 1
";

// Prepara e executa a consulta para obter os dados da livraria
$stmt = $conn->prepare($SELECT);
$stmt->bind_param("i", $dado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Dados do adm
    $nome = htmlspecialchars($row['usu_nome']);
    $email = htmlspecialchars($row['usu_email']);
    $senha = htmlspecialchars($row['usu_senha']);
    $tipo_usuario = htmlspecialchars($row['usu_tipo_usuario']);
    $status = htmlspecialchars($row['usu_status']);

    // Dados da livraria
    $liv_nome = htmlspecialchars($row['liv_nome']);
    $liv_cidade = htmlspecialchars($row['liv_cidade']);
    $liv_estado = htmlspecialchars($row['liv_estado']);
    $liv_endereco = htmlspecialchars($row['liv_endereco']);
    $liv_telefone = htmlspecialchars($row['liv_telefone']);
    $liv_email = htmlspecialchars($row['liv_email']);
    $liv_foto = htmlspecialchars($row['liv_foto']);
    $liv_perfil = htmlspecialchars($row['liv_perfil']);
    $liv_social = htmlspecialchars($row['liv_social']);

    echo "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Avaliar livraria - BACKSTAGECommunity</title>

        <link rel='stylesheet' href='home.css'>
        <link rel='stylesheet' href='geral.css'>
    </head>
    <body>

        <h2>Informações dao administrador</h2>

        <p><strong>Nome:</strong>{$nome}</p>
        <p><strong>Nome:</strong>{email}</p>

        <h2>Informações da Livraria</h2>

        <p><strong>Nome:</strong> {$liv_nome}</p>
        <p><strong>Email:</strong> {$liv_email}</p>
        <p><strong>Cidade:</strong> {$liv_cidade}</p>
        <p><strong>Estado:</strong> {$liv_estado}</p>
        <p><strong>Endereço:</strong> {$liv_endereco}</p>
        <p><strong>Telefone:</strong> {$liv_telefone}</p>
        <p><strong>Perfil:</strong> {$liv_perfil}</p>
        <p><strong>Redes Sociais:</strong> {$liv_social}</p>
        <p><strong>Status Atual:</strong> {$status}</p>

        <form action='?id={$dado}' method='post'>
            <select name='avaliar' required>
                <option value=''>Avaliar</option>
                <option value='1'>Aprovada</option>
            </select>
            <input type='submit' value='Enviar'>
        </form>

    </body>
    </html>
    ";
} else {
    echo "<p>Livraria não encontrada ou você está tentando acessar um usuário que não é uma livraria.</p>";
}

$stmt->close();
