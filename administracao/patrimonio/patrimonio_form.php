<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Patrimônio</title>
    <!-- Incluindo CSS do Bootstrap e jQuery UI para autocomplete -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Cadastro de Patrimônio</h1>
        <form id="itemForm">
            <!-- Campo Setor -->
            <div class="mb-3">
                <label for="setor" class="form-label">Setor</label>
                <select class="form-select" id="setor" required>
                    <option value="">Selecione um setor</option>
                </select>
            </div>

            <!-- Campo Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" required list="suggestionsNome">
                <datalist id="suggestionsNome"></datalist>
            </div>

            <!-- Campo Tipo -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" required>
                    <option value="Equipamento">Equipamento</option>
                    <option value="Móvel">Móvel</option>
                    <option value="Material">Material</option>
                </select>
            </div>

            <!-- Campo Marca -->
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" required list="suggestionsMarca">
                <datalist id="suggestionsMarca"></datalist>
            </div>

            <!-- Campo Modelo -->
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" required list="suggestionsModelo">
                <datalist id="suggestionsModelo"></datalist>
            </div>

            <!-- Campo Número de Série -->
            <div class="mb-3">
                <label for="numeroSerie" class="form-label">Número de Série</label>
                <input type="text" class="form-control" id="numeroSerie" required list="suggestionsNumeroSerie">
                <datalist id="suggestionsNumeroSerie"></datalist>
            </div>

            <input type="hidden" id="itemId">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <!-- Incluindo JS do jQuery, Bootstrap, jQuery UI e Axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css">
    <script>
        // Função para carregar os setores da API
        function carregarSetores() {
            axios.get('https://www.siupa.com.br/siiupa/api/api.php/records/tb_setor')
                .then(function(response) {
                    const setores = response.data.records;
                    const selectSetor = document.getElementById('setor');
                    setores.forEach(function(setor) {
                        const option = document.createElement('option');
                        option.value = setor.id;
                        option.text = setor.setor;
                        selectSetor.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.log('Erro ao carregar setores:', error);
                });
        }

        // Carregar sugestões para Nome, Marca, Modelo e Número de Série
        function carregarSugestoes(campo, endpoint, datalistId) {
            axios.get(endpoint)
                .then(function(response) {
                    const suggestions = response.data.records;
                    const datalist = document.getElementById(datalistId);
                    suggestions.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item[campo];
                        datalist.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.log(`Erro ao carregar sugestões para ${campo}:`, error);
                });
        }

        // Função para carregar dados do item ao editar
        function carregarItem(itemId) {
    axios.get(`https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/${itemId}?join=setor_id,tb_setor`)
    .then(function (response) {
        const item = response.data;
        
        document.getElementById('nome').value = item.nome;
        document.getElementById('marca').value = item.marca;
        document.getElementById('modelo').value = item.modelo;
        document.getElementById('numeroSerie').value = item.numero_serie;
        document.getElementById('tipo').value = item.tipo;
        document.getElementById('setor').value = item.setor_id;
        document.getElementById('itemId').value = itemId; // Armazena o ID do item para atualizações
    })
    .catch(function (error) {
        console.log('Erro ao carregar item:', error);
    });
}


        document.addEventListener('DOMContentLoaded', function() {
            carregarSetores();

            // Obter o ID do item da URL
            const urlParams = new URLSearchParams(window.location.search);
            const itemId = urlParams.get('id');

            if (itemId) {
                carregarItem(itemId); // Carregar dados do item se o ID estiver presente
            }

            // Carregar sugestões de nome, marca, modelo, número de série
            carregarSugestoes('nome', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsNome');
            carregarSugestoes('marca', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsMarca');
            carregarSugestoes('modelo', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsModelo');
            carregarSugestoes('numeroSerie', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsNumeroSerie');
        });

        // Submissão do formulário
        document.getElementById('itemForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const nome = document.getElementById('nome').value;
            const marca = document.getElementById('marca').value;
            const modelo = document.getElementById('modelo').value;
            const numero_serie = document.getElementById('numeroSerie').value;
            const tipo = document.getElementById('tipo').value;
            const setor = document.getElementById('setor').value;
            const itemId = document.getElementById('itemId').value;

            if (!nome || !marca || !modelo || !numero_serie || !tipo || !setor) {
                alert('Preencha todos os campos.');
                return;
            }

            // Atualização ou adição de novo item
            const url = itemId ?
                `https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/${itemId}` :
                'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos';
            const metodo = itemId ? 'put' : 'post';

            axios({
                    method: metodo,
                    url: url,
                    data: {
                        nome: nome,
                        marca: marca,
                        modelo: modelo,
                        numero_serie: numero_serie,
                        tipo: tipo,
                        setor_id: setor
                    }
                })
                .then(function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "Cadastrado",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = `/siiupa/administracao/patrimonio/${response.data}`;
                    }, 1600); // 3000 milissegundos = 3 segundos
                })
                .catch(function(error) {
                    console.log('Erro ao salvar:', error);
                });
        });
    </script>
</body>

</html>