<?php
require('../bd/conectabd.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);
    $nivel = $_POST['nivel'];
    $descricao = $_POST['descricao'];

    if (isset($_POST['id'])) {
        // Atualizar
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE u940659928_siupa.tb_niveis_acesso SET nivel = ?, descricao = ? WHERE id = ?");
        $stmt->bind_param("isi", $nivel, $descricao, $id);
    } else {
        // Inserir
        $stmt = new BD;
        
        $stmt = $conn->prepare("INSERT INTO u940659928_siupa.tb_niveis_acesso (nivel, descricao) VALUES (?, ?)");
        echo($stmt);
        $stmt->bind_param("is", $nivel, $descricao);
    }
    $stmt->execute();
    $stmt->close();
}

// Excluir
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM u940659928_siupa.tb_niveis_acesso WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Selecionar todos os níveis de acesso
$result = $conn->query("SELECT * FROM u940659928_siupa.tb_niveis_acesso");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD de Níveis de Acesso</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="my-4">Gerenciamento de Níveis de Acesso</h2>

    <form method="post" action="">
        <div class="form-group">
            <label for="nivel">Nível</label>
            <input type="number" class="form-control" id="nivel" name="nivel" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao"></textarea>
        </div>
        <input type="hidden" name="id" id="id">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <hr>

    <h3 class="my-4">Lista de Níveis de Acesso</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nível</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nivel']; ?></td>
                <td><?php echo $row['descricao']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editNivel('<?php echo $row['id']; ?>', '<?php echo $row['nivel']; ?>', '<?php echo $row['descricao']; ?>')">Editar</button>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editNivel(id, nivel, descricao) {
    document.getElementById('id').value = id;
    document.getElementById('nivel').value = nivel;
    document.getElementById('descricao').value = descricao;
}
</script>
</body>
</html>
