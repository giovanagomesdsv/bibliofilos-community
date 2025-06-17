<?php
include "../../conexao.php";

if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_POST['status']) ) {

  $id = (int) $_GET['id'];
  $status = (int) $_POST['status'];

  // Prepared statement seguro
  $sql = "UPDATE usuarios SET usu_status = ? WHERE usu_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $status, $id);

  if ($stmt->execute()) {
    echo "
            <script>
                alert('Status atualizado com sucesso!');
                window.location.href = 'usuarios.php';
            </script>";
  } else {
    echo "
            <script>
                alert('Erro ao executar a atualização!');
                window.location.href = 'editarusuario.php?id=" . htmlspecialchars($id) ."';
            </script>";
  }
  $stmt->close();
} else {
  echo "
        <script>
            alert('Erro na preparação da query.');
            window.location.href = 'editarusuario.php?id=" . htmlspecialchars($id) ."';
        </script>";
}
