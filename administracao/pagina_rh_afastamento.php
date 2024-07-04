<?php
//include_once($_SERVER['DOCUMENT_ROOT'].'/siiupa/bd/conectabd.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/siiupa/bd/nivel.php');
?>
 <style>
        #loader {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
    </style>


    <table id="servidores-table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Funcionário</th>
                <th>Função</th>
                <th>CPF</th>
                <th>Cargo</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Afastamento</th>
                <th>Observações</th>
                <th>Criado em</th>
            </tr>
        </thead>
    </table>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


     <!-- Axios JS -->
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- Axios JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = $('#servidores-table').DataTable({
                "pageLength": 15,
                "order": [[0, "desc"]]
            });

            const showLoader = () => {
                document.getElementById('loader').style.display = 'block';
            };

            const hideLoader = () => {
                document.getElementById('loader').style.display = 'none';
            };

            showLoader();

            axios.all([
                axios.get('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_afastamento?order=id,desc&join=tb_funcionario'),
                axios.get('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_cargo'),
                axios.get('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_afastamentos')
            ]).then(axios.spread((afastamentosResponse, cargosResponse, tiposAfastamentosResponse) => {
                const afastamentos = afastamentosResponse.data.records;
                const cargos = cargosResponse.data.records.reduce((map, cargo) => {
                    map[cargo.id] = cargo.titulo;
                    return map;
                }, {});
                const tiposAfastamentos = tiposAfastamentosResponse.data.records.reduce((map, tipo) => {
                    map[tipo.id] = tipo.afastamento;
                    return map;
                }, {});

                afastamentos.forEach(record => {
                    const cargo = cargos[record.fk_funcionario.fk_cargo] || 'N/A';
                    const afastamento = tiposAfastamentos[record.fk_afastamentos] || 'N/A';

                    table.row.add([
                        record.id,
                        record.fk_funcionario.nome,
                        record.fk_funcionario.funcao_upa,
                        record.fk_funcionario.cpf,
                        cargo,
                        record.data_inicio,
                        record.data_fim,
                        afastamento,
                        record.afastamento_obs,
                        record.created_at
                    ]).draw();
                });
                hideLoader();
            })).catch(error => {
                console.error('Erro ao buscar dados:', error);
                hideLoader();
            });

        
        });
    </script>


