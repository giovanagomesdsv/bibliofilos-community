<?php
include "../../conexao.php";

if (!isset($_GET['id_livro']) || empty($_GET['id_livro'])) {
    die("ID do livro não fornecido!");
}

$id_livro = (int)$_GET['id_livro'];

// Função para escapar saída HTML
function esc($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$mensagem = "";
$erro = "";

// Processa o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['genero_id'])) {
    $genero_id = (int)$_POST['genero_id'];

    // Verifica se já existe a relação
    $check = $conn->prepare("SELECT * FROM livro_generos WHERE livro_id = ? AND gen_id = ?");
    $check->bind_param("ii", $id_livro, $genero_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO livro_generos (livro_id, gen_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_livro, $genero_id);
        if ($stmt->execute()) {
            echo "
            <script>
            alert('Livro cadastrado com sucesso! Ao voltar para a página anterior selecione o livro cadastrado.');
            window.location.href = 'resenhas.php';
            </script>
            ";
            exit();
        } else {
            $erro = "Erro ao relacionar o gênero.";
        }
        $stmt->close();
    } else {
        $erro = "Este gênero já está relacionado a esse livro.";
    }

    $check->close();
}

// Busca por nome
$busca = "";
if (isset($_GET['busca'])) {
    $busca = trim($_GET['busca']);
    $busca_sql = "%" . $busca . "%";
    $stmt = $conn->prepare("SELECT gen_id, gen_nome, gen_icone FROM generos WHERE gen_nome LIKE ? ORDER BY gen_nome ASC");
    $stmt->bind_param("s", $busca_sql);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT gen_id, gen_nome, gen_icone FROM generos ORDER BY gen_nome ASC");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relacionar Gênero ao Livro</title>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="resenhas.css">
</head>
<body>
    <h2>Relacionar Gênero ao Livro</h2>

    <?php if ($mensagem): ?>
        <p class="mensagem-sucesso"><?= esc($mensagem) ?></p>
    <?php endif; ?>
    <?php if ($erro): ?>
        <p class="mensagem-erro"><?= esc($erro) ?></p>
    <?php endif; ?>

    <div class="pesquisa">
          <form method="GET" style="margin-bottom: 20px;"
              <input type="hidden" name="id_livro" value="<?= esc($id_livro) ?>" />
              <input type="text" name="busca" placeholder="Pesquisar genero" value="<?= esc($busca) ?>" />
              <button class="botao" type="submit">Buscar</button>
          </form>
    </div>

   <form method="POST">
            <input type="hidden" name="id_livro" value="<?= esc($id_livro) ?>">

            <?php if ($result && $result->num_rows > 0): ?>
                <div class="genero-container">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="genero-card">
                            <input type="radio" name="genero_id" value="<?= esc($row['gen_id']) ?>" id="gen_<?= esc($row['gen_id']) ?>">
                            <label for="gen_<?= esc($row['gen_id']) ?>">
                                <?php if (!empty($row['gen_icone'])): ?>
                                    <img src="../../adm/imagens/generos/<?= esc($row['gen_icone']) ?>" alt="<?= esc($row['gen_nome']) ?>">
                                <?php endif; ?>
                                <span><?= esc($row['gen_nome']) ?></span>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Nenhum gênero encontrado.</p>
            <?php endif; ?>

            <br><br>
            <input type="submit" value="Relacionar Gênero">
        </form>
</body>
</html>
