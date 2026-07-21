<?php
session_start();
@include_once('../../bd/nivel.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Atualização Cadastral Radiologia UPA Castanhal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.11/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
       
        h1 { font-size: 22px; text-align: center; color: #2c3e50; margin-bottom: 25px; }
        table.dataTable { font-size: 14px; }
        .btn-acao { margin-right: 5px; }
    </style>
</head>
<body>
<div class="container-painel">
    <h1>Painel de Cadastros - Radiologia UPA Castanhal</h1>

    <table id="tabelaCadastros" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Nascimento</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Cadastrado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Cadastro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="edit_id" name="id">

                    <label class="form-label mt-2">Nome</label>
                    <input type="text" class="form-control" id="edit_nome" name="nome" required maxlength="150">

                    <label class="form-label mt-2">CPF</label>
                    <input type="text" class="form-control" id="edit_cpf" name="cpf" required maxlength="14" inputmode="numeric">

                    <label class="form-label mt-2">Data de nascimento</label>
                    <input type="date" class="form-control" id="edit_data_nascimento" name="data_nascimento" required>

                    <label class="form-label mt-2">Endereço</label>
                    <input type="text" class="form-control" id="edit_endereco" name="endereco" required maxlength="255">

                    <label class="form-label mt-2">Telefone</label>
                    <input type="text" class="form-control" id="edit_telefone" name="telefone" required maxlength="15" inputmode="numeric">

                    <label class="form-label mt-2">E-mail</label>
                    <input type="email" class="form-control" id="edit_email" name="email" required maxlength="150">

                    <div id="msgEditar" class="mt-3 fw-bold"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarEdicao">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.11/js/dataTables.bootstrap5.min.js"></script>

<script>
let tabela;

function mascaraCpf(valor) {
    let v = valor.replace(/\D/g, '').slice(0, 11);
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    return v;
}

function mascaraTelefone(valor) {
    let v = valor.replace(/\D/g, '').slice(0, 11);
    if (v.length > 10) {
        v = v.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (v.length > 5) {
        v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else if (v.length > 2) {
        v = v.replace(/(\d{2})(\d{0,5})/, '($1) $2');
    } else {
        v = v.replace(/(\d*)/, '($1');
    }
    return v;
}

function formatarData(dataIso) {
    if (!dataIso) return '';
    const partes = dataIso.split(' ')[0].split('-');
    return partes[2] + '/' + partes[1] + '/' + partes[0];
}

$(document).ready(function () {
    tabela = $('#tabelaCadastros').DataTable({
        ajax: {
            url: '/siiupa/administracao/radiologia/listar_cadastros.php',
            dataSrc: 'data'
        },
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.11/i18n/pt-BR.json'
        },
        columns: [
            { data: 'nome' },
            { data: 'cpf', render: data => mascaraCpf(data) },
            { data: 'data_nascimento', render: data => formatarData(data) },
            { data: 'endereco' },
            { data: 'telefone' },
            { data: 'email' },
            { data: 'data_criacao', render: data => formatarData(data) + ' ' + data.split(' ')[1] },
            {
                data: null,
                orderable: false,
                render: function (row) {
                    return `
                        <button class="btn btn-sm btn-warning btn-acao btn-editar" data-id="${row.id}">Editar</button>
                        <button class="btn btn-sm btn-danger btn-acao btn-excluir" data-id="${row.id}">Excluir</button>
                    `;
                }
            }
        ]
    });

    $('#tabelaCadastros tbody').on('click', '.btn-editar', function () {
        const dados = tabela.row($(this).closest('tr')).data();

        $('#edit_id').val(dados.id);
        $('#edit_nome').val(dados.nome);
        $('#edit_cpf').val(mascaraCpf(dados.cpf));
        $('#edit_data_nascimento').val(dados.data_nascimento.split(' ')[0]);
        $('#edit_endereco').val(dados.endereco);
        $('#edit_telefone').val(dados.telefone);
        $('#edit_email').val(dados.email);
        $('#msgEditar').text('');

        new bootstrap.Modal(document.getElementById('modalEditar')).show();
    });

    $('#edit_cpf').on('input', function () { this.value = mascaraCpf(this.value); });
    $('#edit_telefone').on('input', function () { this.value = mascaraTelefone(this.value); });

    $('#btnSalvarEdicao').on('click', function () {
        const dados = $('#formEditar').serialize();

        $.post('/siiupa/administracao/radiologia/editar_cadastro.php', dados, function (resposta) {
            $('#msgEditar').text(resposta.message);
            if (resposta.success) {
                tabela.ajax.reload(null, false);
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
                }, 800);
            }
        }, 'json');
    });

    $('#tabelaCadastros tbody').on('click', '.btn-excluir', function () {
        const id = $(this).data('id');

        if (!confirm('Tem certeza que deseja excluir este cadastro?')) return;

        $.post('/siiupa/administracao/radiologia/excluir_cadastro.php', { id: id }, function (resposta) {
            alert(resposta.message);
            if (resposta.success) {
                tabela.ajax.reload(null, false);
            }
        }, 'json');
    });
});
</script>
</body>
</html>