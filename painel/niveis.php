<?php
$api_url = 'https://www.siupa.com.br/siiupa/api/rh/api.php/records/tb_niveis_acesso';

function make_api_request($url, $method, $data = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nivel = $_POST['nivel'];
    $descricao = $_POST['descricao'];

    $data = ['nivel' => $nivel, 'descricao' => $descricao];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Atualizar
        $id = $_POST['id'];
        $url = $api_url . '/' . $id;
        $response = make_api_request($url, 'PUT', $data);
        if (isset($response['code']) && $response['code'] == 200) {
            $message = "Nível de acesso atualizado com sucesso.";
        } else {
            $message = "Erro ao atualizar nível de acesso.";
        }
    } else {
        // Inserir
        $response = make_api_request($api_url, 'POST', $data);
        if (isset($response['code']) && $response['code'] == 200) {
            $message = "Nível de acesso criado com sucesso.";
        } else {
            $message = "Erro ao criar nível de acesso.";
        }
    }
}

// Excluir
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $url = $api_url . '/' . $id;
    $response = make_api_request($url, 'DELETE');
    if (isset($response['code']) && $response['code'] == 200) {
        $message = "Nível de acesso excluído com sucesso.";
    } else {
        $message = "Erro ao excluir nível de acesso.";
    }
}

// Selecionar todos os níveis de acesso
$response = make_api_request($api_url, 'GET');
$records = $response['records'] ?? [];
?>

<div class="container">
    <h2 class="my-4">Gerenciamento de Níveis de Acesso</h2>

    <?php if ($message): ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="" id="niveis">
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
        <?php foreach ($records as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nivel']; ?></td>
                <td><?php echo $row['descricao']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editNivel('<?php echo $row['id']; ?>', '<?php echo $row['nivel']; ?>', '<?php echo $row['descricao']; ?>')">Editar</button>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
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
