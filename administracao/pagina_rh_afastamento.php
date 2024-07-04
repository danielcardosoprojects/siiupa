<style>
    #loader {
        display: none;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        padding: 20px;
    }
    #loader img {
        border-radius: 50%;
    }
</style>

<div id="loader">
    <img src="https://www.blogson.com.br/wp-content/uploads/2017/10/loading-gif-transparent-10.gif" alt="Carregando..." />
</div>
<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Em Vigor</th>
            <th>Afastamento</th>
            <th>Funcionário</th>
            <th>Setor</th>
            <th>CPF</th>
            <th>Cargo</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Duração</th>
            
            
            <th>Observações</th>
            <th>Criado em</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        const table = $('#example').DataTable({
            "pageLength": 15,
            "order": [[0, "desc"]]
        });

        const showLoader = () => {
            $('#loader').show();
        };

        const hideLoader = () => {
            $('#loader').hide();
        };

        const formatDateBR = (dateString) => {
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('pt-BR', options);
        };

        const calculateDuration = (start, end) => {
            const startDate = new Date(start);
            const endDate = new Date(end);
            const diff = new Date(endDate - startDate);
            const years = diff.getUTCFullYear() - 1970;
            const months = diff.getUTCMonth();
            const days = diff.getUTCDate();
            return `${years} anos, ${months} meses, ${days} dias`;
        };

        const isActive = (start, end) => {
            const today = new Date();
            return today >= new Date(start) && today <= new Date(end) ? 'Sim' : 'Não';
        };

        showLoader();

        axios.get('administracao/apiafastamentos.php')
            .then(response => {
                const { afastamentos, cargos, setores, tiposAfastamentos } = response.data;

                const cargosMap = cargos.records.reduce((map, cargo) => {
                    map[cargo.id] = cargo.titulo;
                    return map;
                }, {});

                const setoresMap = setores.records.reduce((map, setor) => {
                    
                    map[setor.id] = setor.setor;
                    return map;
                }, {});

                const tiposAfastamentosMap = tiposAfastamentos.records.reduce((map, tipo) => {
                    map[tipo.id] = tipo.afastamento;
                    return map;
                }, {});

                afastamentos.records.forEach(record => {
                    const cargo = cargosMap[record.fk_funcionario.fk_cargo] || 'N/A';
                    const setor = setoresMap[record.fk_funcionario.fk_setor] || 'N/A';
                    const afastamento = tiposAfastamentosMap[record.fk_afastamentos] || 'N/A';
                    const dataInicio = formatDateBR(record.data_inicio);
                    const dataFim = formatDateBR(record.data_fim);
                    const duracao = calculateDuration(record.data_inicio, record.data_fim);
                    const emVigor = isActive(record.data_inicio, record.data_fim);

                    table.row.add([
                        record.id,
                        emVigor,
                        afastamento,
                        record.fk_funcionario.nome,
                        setor,
                        record.fk_funcionario.cpf,
                        cargo,
                        dataInicio,
                        dataFim,
                        duracao,
                        
                        
                        record.afastamento_obs,
                        formatDateBR(record.created_at)
                    ]).draw();
                });

                hideLoader();
            })
            .catch(error => {
                console.error('Erro ao buscar dados:', error);
                hideLoader();
            });
    });
</script>
