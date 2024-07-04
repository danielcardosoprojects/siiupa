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
</head>
<body>
    <div id="loader">
        <img src="https://i.gifer.com/ZZ5H.gif" alt="Carregando..." />
    </div>
    <table id="example" class="display" style="width:100%">
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

 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = $('#example').DataTable({
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

            axios.get('apiafastamentos.php')
                .then(response => {
                    const { afastamentos, cargos, tiposAfastamentos } = response.data;

                    const cargosMap = cargos.records.reduce((map, cargo) => {
                        map[cargo.id] = cargo.titulo;
                        return map;
                    }, {});

                    const tiposAfastamentosMap = tiposAfastamentos.records.reduce((map, tipo) => {
                        map[tipo.id] = tipo.afastamento;
                        return map;
                    }, {});

                    afastamentos.records.forEach(record => {
                        const cargo = cargosMap[record.fk_funcionario.fk_cargo] || 'N/A';
                        const afastamento = tiposAfastamentosMap[record.fk_afastamentos] || 'N/A';

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
                })
                .catch(error => {
                    console.error('Erro ao buscar dados:', error);
                    hideLoader();
                });
        });
    </script>
</body>
</html>
