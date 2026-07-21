<?php
// Campo oculto "data de criação" preenchido automaticamente pelo sistema
$data_criacao = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização Cadastral Radiologia UPA Castanhal</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 22px;
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #34495e;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 15px;
        }
        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background: #2c7be5;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #1a5fc0;
        }
        #mensagem {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Atualização Cadastral Radiologia UPA Castanhal</h1>

    <form id="formCadastro" method="POST" action="salvar_cadastro.php">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required maxlength="150">

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00">

        <label for="data_nascimento">Data de nascimento</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>

        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" required maxlength="255">

        <label for="telefone">Telefone</label>
        <input type="tel" id="telefone" name="telefone" required maxlength="20" placeholder="(00) 00000-0000">

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required maxlength="150">

        <!-- Campo oculto, preenchido automaticamente pelo sistema -->
        <input type="hidden" id="data_criacao" name="data_criacao" value="<?php echo $data_criacao; ?>">

        <button type="submit">Enviar</button>
    </form>

    <div id="mensagem"></div>
</div>

<script>
document.getElementById('formCadastro').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const dados = new FormData(form);

    fetch('salvar_cadastro.php', {
        method: 'POST',
        body: dados
    })
    .then(res => res.text())
    .then(resposta => {
        document.getElementById('mensagem').innerText = resposta;
        if (resposta.includes('sucesso')) {
            form.reset();
            document.getElementById('data_criacao').value = '<?php echo $data_criacao; ?>';
        }
    })
    .catch(() => {
        document.getElementById('mensagem').innerText = 'Erro ao enviar o formulário. Tente novamente.';
    });
});
</script>
</body>
</html>