<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="usuarios.css">
</head>
<body>

<?php
include "../../conexao.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT usu_status FROM usuarios WHERE usu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            $statusAtual = (int)$row['usu_status'];

            // Mapeia os rótulos dos status
            $labels = [0 => 'DESATIVADO', 1 => 'ATIVO'];

            echo "
            <form action='atualizar.php?id=" . htmlspecialchars($id) . "' method='POST' class='format'>
                <label for='status'>Status atual: <strong>{$labels[$statusAtual]}</strong></label><br><br>

                <select name='status' id='status' required>
                    <option value=''>-- Selecione novo status --</option>
                    <option value='1' " . ($statusAtual === 1 ? "selected" : "") . ">ATIVO</option>
                    <option value='0' " . ($statusAtual === 0 ? "selected" : "") . ">DESATIVADO</option>
                </select><br><br>

                <input type='submit' value='Atualizar' class='inputEditar'>
            </form>";
        } else {
            echo "<p>Usuário não encontrado.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Erro ao executar a consulta.</p>";
    }
} else {
    echo "<p>ID inválido.</p>";
}
?>

</body>
</html>
