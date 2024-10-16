
$(document).ready(function () {

    //verifica se na url tem o setor
    setorUrl = cachedSetor != '0' && null ? `filter=setor_id,eq,${cachedSetor}&` : '';
    console.log(setorUrl);
    // Supondo que você tenha uma função para obter dados da tabela
    $('#equipamentosTable').DataTable({
        "ajax": {
            "url": `https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos?${setorUrl}join=setor_id,tb_setor&order=id,desc`,
            "dataSrc": "records"
        },
        "columns": [
            { "data": "id" },
            { "data": "nome" },
            { "data": "tipo" },
            { "data": "marca" },
            { "data": "modelo" },
            { "data": "numero_serie", "defaultContent": "" }, // Número de série pode ser null
            { "data": "data_cadastro" },
            { "data": "setor_id.setor" }, // Pega o setor do campo de associação
            {
                "data": null,
                "render": function (data, type, row) {
                    var link = "/siiupa/administracao/patrimonio/" + row.id;
                    return "<a href='" + link + "' class='btn btn-sm btn-primary'>Vizualizar</a>";
                }
            }
        ],
        "order": [[0, "desc"]]
    });
    let allData = $('#equipamentosTable').DataTable().rows().data().toArray();
    console.log(allData);
    // Crie uma lista de sugestões de todos os campos necessários
    const nomes = allData.map(item => item.nome);
    const tipos = allData.map(item => item.tipo);
    const marcas = allData.map(item => item.marca);
    const modelos = allData.map(item => item.modelo);
    const numerosSerie = allData.map(item => item.numero_serie);
    console.log(marcas);


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
        marca: document.getElementById('marca').value,
        modelo: document.getElementById('modelo').value,
        numero_serie: document.getElementById('numeroSerie').value,
        dataCadastro: formatarData(),
        itemId: document.getElementById('itemId').value,
        user_id: 1
    };

    axios.post('https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos?join=setor_id,tb_setor', data)
        .then(response => {
            // Atualize a tabela com a nova entrada
            //$('#equipamentosTable').DataTable().ajax.reload();
            //$('#itemModal').modal('hide');
            Swal.fire({
                icon: "success",
                title: "Cadastrado",
                showConfirmButton: false,
                timer: 1500
            });
            setTimeout(function () {
                window.location.href = `/siiupa/administracao/patrimonio/${response.data}`;
            }, 1600); // 3000 milissegundos = 3 segundos




        })
        .catch(error => {
            console.error("Erro ao adicionar o item:", error);
        });
});

document.getElementById('addItemBtn').addEventListener('click', function () {
    // Exibe o modal
    let selectSetor = document.getElementById('setor');
    selectSetor.value = cachedSetor;




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


//////////////// CARREFGAR ULTIMO NO FOMRULARIO



function carregaUltimo() {
    const ultimoUrl = 'https://siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos?order=id,desc&page=1,1';
    axios.get(ultimoUrl)
        .then(response => {
            // La richiesta è andata a buon fine
            const data = response.data;
            console.log(data); // Stampa la risposta completa al console

            // Estrai i dati specifici che ti interessano
            const equipamentos = data.records;
            equipamentos.forEach(equipamento => {
                console.log(equipamento);
                let setor = document.getElementById('setor');
                let nome = document.getElementById('nome');
                let tipo = document.getElementById('tipo');
                let marca = document.getElementById('marca');
                let modelo = document.getElementById('modelo');

                setor.value = equipamento.setor_id;
                nome.value = equipamento.nome;
                tipo.value = equipamento.tipo;
                marca.value = equipamento.marca;
                modelo.value = equipamento.modelo;
            });
        })
        .catch(error => {
            // Si è verificato un errore
            console.error('Errore durante la richiesta:', error);
        });
}
// Seleciona o elemento com o ID "repetirUltimo"
const botaoRepetir = document.getElementById('repetirUltimo');

// Adiciona um event listener para o evento de clique
botaoRepetir.addEventListener('click', function() {
  // Código a ser executado quando o botão for clicado
  
  carregaUltimo();
});
});