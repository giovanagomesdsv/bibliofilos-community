<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../conexao.php";

if (!isset($_GET['id_livro']) || empty($_GET['id_livro'])) {
    die("ID não fornecido!");
}

$id_livro = $_GET['id_livro'];

// Função para escapar saída HTML
function esc($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$mensagem = "";
$erro = "";

// Processa o POST ao enviar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Primeiro, relacionar autor existente se selecionado
    if (!empty($_POST['autor_existente'])) {
        $autor_id = (int)$_POST['autor_existente'];

        // Verifica se já existe esse relacionamento para evitar duplicidade
        $check = $conn->prepare("SELECT * FROM livro_autores WHERE livro_id = ? AND aut_id = ?");
        $check->bind_param("ii", $id_livro, $autor_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO livro_autores (livro_id, aut_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_livro, $autor_id);
            if ($stmt->execute()) {
                header("Location: cadastrar_genero.php?id_livro=$id_livro");
            } else {
                $erro = "Erro ao relacionar autor.";
            }
        } else {
            $erro = "Este autor já está relacionado a esse livro.";
        }
        $check->close();
    } 
    // Se não, cadastra novo autor e relaciona
    else if (!empty($_POST['novo_nome'])) {
        $novo_nome = $_POST['novo_nome'];
        $novo_bio = $_POST['novo_bio'];

        $novo_foto_nome = "";

        // Upload da foto do novo autor
        if (isset($_FILES['novo_foto']) && $_FILES['novo_foto']['error'] === 0) {
            $arquivo = $_FILES['novo_foto'];

            if ($arquivo['size'] > 2 * 1024 * 1024) {
                $erro = "Arquivo muito grande. Máximo 2MB.";
            } else {
                $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                if (!in_array($extensao, ['jpg', 'png', 'jpeg'])) {
                    $erro = "Apenas arquivos JPG ou PNG são permitidos.";
                } else {
                    $novo_foto_nome = uniqid() . '.' . $extensao;
                    $pasta = "../../adm/imagens/autores/";
                    $caminho = $pasta . $novo_foto_nome;
                    if (!move_uploaded_file($arquivo['tmp_name'], $caminho)) {
                        $erro = "Erro ao salvar a imagem.";
                    }
                }
            }
        }

        if (!$erro) {
            $stmt = $conn->prepare("INSERT INTO autores (aut_nome, aut_bio, aut_foto) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $novo_nome, $novo_bio, $novo_foto_nome);
            if ($stmt->execute()) {
                $autor_id = $stmt->insert_id;

                // Relaciona o novo autor com o livro
                $stmt2 = $conn->prepare("INSERT INTO livro_autores (livro_id, aut_id) VALUES (?, ?)");
                $stmt2->bind_param("ii", $id_livro, $autor_id);
                if ($stmt2->execute()) {
                    header("Location: cadastrar_genero.php?id_livro=$id_livro");
                } else {
                    $erro = "Erro ao relacionar o novo autor.";
                }
                $stmt2->close();
            } else {
                $erro = "Erro ao cadastrar o novo autor.";
            }
            $stmt->close();
        }
    } else {
        $erro = "Por favor, selecione um autor existente ou cadastre um novo autor.";
    }
}

// Se foi feita uma busca, filtra autores pelo nome
$busca = "";
if (isset($_GET['busca'])) {
    $busca = trim($_GET['busca']);
    $busca_sql = "%" . $busca . "%";
    $stmt = $conn->prepare("SELECT aut_id, aut_nome, aut_foto FROM autores WHERE aut_nome LIKE ? ORDER BY aut_nome ASC");
    $stmt->bind_param("s", $busca_sql);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Lista todos autores sem filtro (ou poderia limitar a poucos)
    $result = $conn->query("SELECT aut_id, aut_nome, aut_foto FROM autores ORDER BY aut_nome ASC");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Selecionar ou Cadastrar Autor</title>
    <link rel="stylesheet" href="../geral.css">
    <link rel="stylesheet" href="resenhas.css">


</head>

<body>
      <header>
        BACKSTAGE Community
    </header>
 <main>
        <h2 style="color: #000">Selecione um autor para o livro</h2>

        <?php if ($mensagem): ?>
        <p class="mensagem-sucesso">
            <?= esc($mensagem) ?>
        </p>
        <?php endif; ?>
        <?php if ($erro): ?>
        <p class="mensagem-erro">
            <?= esc($erro) ?>
        </p>
        <?php endif; ?>
        <div class="pesquisa">
          <form method="GET" style="margin-bottom: 20px;"
              <input type="hidden" name="id_livro" value="<?= esc($id_livro) ?>" />
              <input type="text" name="busca" placeholder="Pesquisar autor pelo nome" value="<?= esc($busca) ?>" />
              <button class="botao" type="submit">Buscar</button>
          </form>
        </div>

        <form class="form1" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_livro" value="<?= esc($id_livro) ?>">

            <?php if ($result && $result->num_rows > 0): ?>
            <div class="autor-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="autor-card">
            <input type="radio" name="autor_existente" value="<?= esc($row['aut_id']) ?>"
                id="autor_<?= esc($row['aut_id']) ?>">
            <label for="autor_<?= esc($row['aut_id']) ?>">
                <img src="../../adm/imagens/autores/<?= esc($row['aut_foto']) ?>"
                    alt="<?= esc($row['aut_nome']) ?>">
                <?= esc($row['aut_nome']) ?>
            </label>
        </div>
    <?php endwhile; ?>
</div>
            <?php else: ?>
            <p>Nenhum autor encontrado.</p>
            <?php endif; ?>

            <hr>
            <div class="card card3">
                <p><strong>Ou cadastre um novo autor:</strong></p>
                <div class="namebio">
                    <div class="input-wrapper">
                        <label for="novo_foto">Foto:</label>
                        <input type="file" name="novo_foto" accept=".jpg,.jpeg,.png">
                    </div>

                    <div class="input-wrapper">
                        <label for="novo_nome">Nome:</label>
                        <input type="text" name="novo_nome" id="novo_nome">
                    </div>
                </div>
                <div class="input-wrapper">
                    <label class="resenhabox1"  for="novo_bio">Biografia:</label>
                    <textarea class="resenha1"  name="novo_bio" id="novo_bio"></textarea>
                </div>


                <br><br>
                <input class="botao1" type="submit" value="Cadastrar Autor ou Relacionar Autor Existente">
            </div>
        </form>
    </main>
</body>

</html>