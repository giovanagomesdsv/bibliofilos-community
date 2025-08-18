<?php
include "../conexao.php";
$dado = $_GET['id'];

$select = "SELECT aut_nome FROM AUTORES WHERE aut_id = ?";
$stmt = $conn->prepare($select);
$stmt->bind_param("i", $dado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<body>
    <h1>{$row['aut_nome']}</h1>
</body>
</html>
        ";
    }
}
?>