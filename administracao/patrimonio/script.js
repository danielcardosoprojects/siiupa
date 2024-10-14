$(document).ready(function () {
    $('#equipamentosTable').DataTable({
        "ajax": {
            "url": "https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos?join=setor_id,tb_setor",
            "dataSrc": "records"
        },
        "columns": [
            { "data": "id" },
            { "data": "nome" },
            { "data": "tipo" },
            { "data": "modelo" },
            { "data": "numero_serie", "defaultContent": "" }, // Número de série pode ser null
            { "data": "data_cadastro" },
            { "data": "setor_id.setor" }, // Pega o setor do campo de associação
            {
                "data": null,
                "defaultContent": "<button class='btn btn-sm btn-primary'>Editar</button> <button class='btn btn-sm btn-danger'>Excluir</button>"
            }
        ]
    });
});

function formatarData(data = new Date()) {
    const ano = data.getFullYear();
    const mes = (data.getMonth() + 1).toString().padStart(2, '0'); // Mês começa em 0, então adicionamos 1 e usamos padStart para garantir 2 dígitos
    const dia = data.getDate().toString().padStart(2, '0');

    return `${ano}-${mes}-${dia}`;
}
document.getElementById('itemForm').addEventListener('submit', function (e) {
    e.preventDefault();



    // Obtendo a data formatada
    const dataAtualFormatada = formatarData();
    let data = {
        setor_id: parseInt(document.getElementById('setor').value),
        nome: document.getElementById('nome').value,
        tipo: document.getElementById('tipo').value,
        modelo: document.getElementById('modelo').value,
        numeroSerie: document.getElementById('numeroSerie').value,
        dataCadastro: formatarData(),
        itemId: document.getElementById('itemId').value,
        user_id: "<?='2';?>"
    };

    axios.post('https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos?join=setor_id,tb_setor', data)
        .then(response => {
            // Atualize a tabela com a nova entrada
            $('#equipamentosTable').DataTable().ajax.reload();
            $('#itemModal').modal('hide');
        })
        .catch(error => {
            console.error("Erro ao adicionar o item:", error);
        });
});
document.getElementById('addItemBtn').addEventListener('click', function () {
    // Exibe o modal
    let itemModal = new bootstrap.Modal(document.getElementById('itemModal'));
    itemModal.show();
});

document.addEventListener('DOMContentLoaded', function () {
    // Chama a API para obter os setores
    axios.get('https://www.siupa.com.br/siiupa/api/api.php/records/tb_setor')
        .then(function (response) {
            const setores = response.data.records;
            const setorSelect = document.getElementById('setor');

            // Popula o select de setor com os dados da API
            setores.forEach(function (setor) {
                const option = document.createElement('option');
                option.value = setor.id;
                option.textContent = setor.setor + " - " + setor.categoria;
                setorSelect.appendChild(option);
            });
        })
        .catch(function (error) {
            console.error("Erro ao carregar os setores:", error);
        });
});



