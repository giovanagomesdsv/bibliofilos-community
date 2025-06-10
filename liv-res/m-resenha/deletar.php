<?php
include "../../conexao.php";

$idResenha = $_GET['id'];

$deletar = "DELETE FROM RESENHAS WHERE resenha_id = ?";
$stmt = $conn->prepare($deletar);
$stmt->bind_param("i", $idResenha);


if ($stmt && $stmt->execute()) {
    echo "
    <script>
        window.location.href = 'm-resenhas.php';
    </script>
    ";
} else {
     echo "
    <script>
        alert('Erro!!');
        window.location.href = 'm-resenhas.php';
    </script>
    ";
}

?>