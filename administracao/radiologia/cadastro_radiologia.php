<?php


$data_criacao = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização Cadastral Radiologia UPA Castanhal</title>
    <style>
       

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
        input[type="date"] {
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

    <form id="formCadastro" method="POST" action="/siiupa/administracao/radiologia/salvar_cadastro.php">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required maxlength="150">

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00" inputmode="numeric">

        <label for="data_nascimento">Data de nascimento</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>

        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" required maxlength="255">

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" required maxlength="15" placeholder="(00) 00000-0000" inputmode="numeric">

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required maxlength="150">

        <!-- Campo oculto, preenchido automaticamente pelo sistema -->
        <input type="hidden" id="data_criacao" name="data_criacao" value="<?php echo $data_criacao; ?>">

        <button type="submit">Enviar</button>
    </form>

    <div id="mensagem"></div>

    <div id="confirmacao" style="display:none; text-align:center;">
        <p style="font-size: 40px; color: #2ecc71; margin: 10px 0;">&#10004;</p>
        <p style="font-weight:bold; color:#2c3e50;">Cadastro enviado com sucesso!</p>
        <p style="color:#7f8c8d; font-size:14px;">Obrigado por atualizar seus dados.</p>
    </div>
</div>

<script>
// Máscara de CPF: ###.###.###-##
document.getElementById('cpf').addEventListener('input', function (e) {
    let v = e.target.value.replace(/\D/g, '').slice(0, 11);
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = v;
});

// Máscara de telefone: (##) #####-#### ou (##) ####-####
document.getElementById('telefone').addEventListener('input', function (e) {
    let v = e.target.value.replace(/\D/g, '').slice(0, 11);
    if (v.length > 10) {
        v = v.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (v.length > 5) {
        v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else if (v.length > 2) {
        v = v.replace(/(\d{2})(\d{0,5})/, '($1) $2');
    } else {
        v = v.replace(/(\d*)/, '($1');
    }
    e.target.value = v;
});

document.getElementById('formCadastro').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const dados = new FormData(form);

    fetch('/siiupa/administracao/radiologia/salvar_cadastro.php', {
        method: 'POST',
        body: dados
    })
    .then(res => res.text())
    .then(resposta => {
        if (resposta.includes('sucesso')) {
            form.style.display = 'none';
            document.getElementById('mensagem').innerText = '';
            document.getElementById('confirmacao').style.display = 'block';
        } else {
            document.getElementById('mensagem').innerText = resposta;
        }
    })
    .catch(() => {
        document.getElementById('mensagem').innerText = 'Erro ao enviar o formulário. Tente novamente.';
    });
});
</script>
</body>
</html>