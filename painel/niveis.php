<?php
require 'api_niveis.php';
require 'api_usuarios.php';

$message_niveis = '';
$message_usuarios = '';

// CRUD para Níveis de Acesso
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nivel'])) {
    $nivel = $_POST['nivel'];
    $descricao = $_POST['descricao'];

    $data = ['nivel' => $nivel, 'descricao' => $descricao];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Atualizar
        $id = $_POST['id'];
        $url = $api_url . '/' . $id;
        $result = make_api_request($url, 'PUT', $data);
        if ($result['http_code'] >= 200 && $result['http_code'] < 300) {
            $message_niveis = "Nível de acesso atualizado com sucesso.";
        } else {
            $message_niveis = "Erro ao atualizar nível de acesso.";
        }
    } else {
        // Inserir
        $result = make_api_request($api_url, 'POST', $data);
        if ($result['http_code'] >= 200 && $result['http_code'] < 300) {
            $message_niveis = "Nível de acesso criado com sucesso.";
        } else {
            $message_niveis = "Erro ao criar nível de acesso.";
        }
    }
}

// Excluir Níveis de Acesso
if (isset($_GET['delete_nivel'])) {
    $id = $_GET['delete_nivel'];
    $url = $api_url . '/' . $id;
    $result = make_api_request($url, 'DELETE');
    if ($result['http_code'] >= 200 && $result['http_code'] < 300) {
        $message_niveis = "Nível de acesso excluído com sucesso.";
    } else {
        $message_niveis = "Erro ao excluir nível de acesso.";
    }
}

// Selecionar todos os níveis de acesso
$result = make_api_request($api_url, 'GET');
$niveis = $result['response']['records'] ?? [];

// CRUD para Usuários
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $nivel = $_POST['nivel_usuario'];

    $data = ['nome' => $nome, 'nivel' => $nivel];

    if (isset($_POST['id_usuario']) && !empty($_POST['id_usuario'])) {
        // Atualizar
        $id = $_POST['id_usuario'];
        $url = $api_url . '/' . $id;
        $result = make_api_request($url, 'PUT', $data);
        if ($result['http_code'] >= 200 && $result['http_code'] < 300) {
            $message_usuarios = "Usuário atualizado com sucesso.";
        } else {
            $message_usuarios = "Erro ao atualizar usuário.";
        }
    } else {
        // Inserir
        $result = make_api_request($api_url, 'POST', $data);
        if ($result['http_code'] >= 200 && $result['http_code'] < 300) {
            $message_usuarios = "Usuário criado com sucesso.";
        } else {
            $message_usuarios = "Erro ao criar usuário.";
        }
    }
}

// Excluir Usuários
if (isset($_GET['delete_usuario'])) {
    $id = $_GET['delete_usuario'];
    $url = $api_url . '/' . $id;
    $result = make_api_request($url, 'DELETE');
    if ($result['http_code'] >= 200 && $result['http_code'] < 300) {
        $message_usuarios = "Usuário excluído com sucesso.";
    } else {
        $message_usuarios = "Erro ao excluir usuário.";
    }
}

// Selecionar todos os usuários
$result = make_api_request($api_url, 'GET');
$usuarios = $result['response']['records'] ?? [];
?>

<div class="container">
    <h2 class="my-4">Gerenciamento de Níveis de Acesso</h2>

    <?php if ($message_niveis): ?>
        <div class="alert alert-info">
            <?php echo $message_niveis; ?>
        </div>
    <?php endif; ?>

    <form id="niveis" method="post" action="?setor=adm&sub=niveis">
        <div class="form-group">
            <label for="nivel">Nível</label>
            <input type="number" class="form-control" id="nivel" name="nivel" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao"></textarea>
        </div>
        <input type="hidden" name="id" id="id">
        <button type="button" class="btn btn-primary" onclick="submitForm('niveis')">Salvar</button>
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
        <?php foreach ($niveis as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nivel']; ?></td>
                <td><?php echo $row['descricao']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editNivel('<?php echo $row['id']; ?>', '<?php echo $row['nivel']; ?>', '<?php echo $row['descricao']; ?>')">Editar</button>
                    <a href="?setor=adm&sub=niveis&delete_nivel=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="my-4">Gerenciamento de Usuários</h2>

    <?php if ($message_usuarios): ?>
        <div class="alert alert-info">
            <?php echo $message_usuarios; ?>
        </div>
    <?php endif; ?>

    <form id="usuarios" method="post" action="?setor=adm&sub=niveis">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="nivel_usuario">Nível</label>
            <select class="form-control" id="nivel_usuario" name="nivel_usuario" required>
                <?php foreach ($niveis as $nivel): ?>
                    <option value="<?php echo $nivel['nivel']; ?>"><?php echo $nivel['descricao']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" name="id_usuario" id="id_usuario">
        <button type="button" class="btn btn-primary" onclick="submitForm('usuarios')">Salvar</button>
    </form>

    <hr>

    <h3 class="my-4">Lista de Usuários</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Nível</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['nivel']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editUsuario('<?php echo $row['id']; ?>', '<?php echo $row['nome']; ?>', '<?php echo $row['nivel']; ?>')">Editar</button>
                    <a href="?setor=adm&sub=niveis&delete_usuario=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function submitForm(formId) {
    document.getElementById(formId).submit();
}

function editNivel(id, nivel, descricao) {
    document.getElementById('id').value = id;
    document.getElementById('nivel').value = nivel;
    document.getElementById('descricao').value = descricao;
}

function editUsuario(id, nome, nivel) {
    document.getElementById('id_usuario').value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('nivel_usuario').value = nivel;
}
</script>
