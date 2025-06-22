<?php
include "../../conexao.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID inválido.'); window.location.href='anuncios.php';</script>";
    exit;
}

$id = (int) $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idioma = trim($_POST['idioma']);
    $paginas = (int) $_POST['paginas'];
    $tipo = trim($_POST['tipo']);
    $preco = (float) $_POST['preco'];
    $obs = trim($_POST['obs']);
    $status = (int) $_POST['status'];

    $sql = "UPDATE livrarias_livros 
            SET liv_livro_idioma = ?, 
                liv_livro_pag = ?, 
                liv_livro_tipo = ?, 
                liv_livro_preco = ?, 
                liv_livro_obsadicionais = ?, 
                liv_livro_status = ?
            WHERE liv_livro_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisdssi", $idioma, $paginas, $tipo, $preco, $obs, $status, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Anúncio atualizado com sucesso!'); window.location.href='anuncios.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar: " . addslashes($stmt->error) . "'); history.back();</script>";
    }

    $stmt->close();
}
?>
