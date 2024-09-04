function showTab(tabId) {
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
}
document.addEventListener('DOMContentLoaded', function() {
    const cadastroForm = document.getElementById('cadastroEquipamento');
    const envioForm = document.getElementById('envioManutencao');
    const cautelaForm = document.getElementById('elaboracaoCautela');

    const setorSelect = document.getElementById('setor');
    const equipamentoSelect = document.getElementById('equipamento');
    const envioSelect = document.getElementById('envio');
    const enviosTableBody = document.getElementById('enviosTable').querySelector('tbody');



    // Função para carregar setores e equipamentos via API
    function loadSelectData() {
        if (setorSelect) {
            fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_setor')
                .then(response => response.json())
                .then(data => {
                    data.records.forEach(setor => {
                        let option = document.createElement('option');
                        option.value = setor.id;
                        option.text = setor.setor;
                        setorSelect.appendChild(option);
                    });
                });
        }

        if (equipamentoSelect) {
            fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_equipamentos')
                .then(response => response.json())
                .then(data => {
                    data.records.forEach(equipamento => {
                        let option = document.createElement('option');
                        option.value = equipamento.id;
                        option.text = `${equipamento.nome} (${equipamento.numero_serie})`;
                        equipamentoSelect.appendChild(option);
                    });
                });
        }

        if (envioSelect) {
            fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_envios')
                .then(response => response.json())
                .then(data => {
                    data.records.forEach(envio => {
                        let option = document.createElement('option');
                        option.value = envio.id;
                        option.text = `${envio.equipamento_id} - ${envio.data_envio}`;
                        envioSelect.appendChild(option);
                    });
                });
        }

        if (enviosTableBody) {
            fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_envios')
                .then(response => response.json())
                .then(data => {
                    data.records.forEach(envio => {
                        let row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${envio.id}</td>
                            <td>${envio.equipamento_id}</td>
                            <td>${envio.data_envio}</td>
                            <td>${envio.defeito}</td>
                            <td>${envio.responsavel_envio}</td>
                            <td><button onclick="generateCautela(${envio.id})">Gerar Cautela</button></td>
                        `;
                        enviosTableBody.appendChild(row);
                    });
                });
        }
    }

    window.generateCautela = function(envioId) {
        showTab('cautelas');
        envioSelect.value = envioId;
        const event = new Event('change');
        envioSelect.dispatchEvent(event);
    }

    loadSelectData();

    envioSelect?.addEventListener('change', function() {
        const selectedEnvioId = envioSelect.value;
        if (selectedEnvioId) {
            fetch(`https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_envios/${selectedEnvioId}`)
                .then(response => response.json())
                .then(data => {
                    const envio = data;
                    document.getElementById('data').value = envio.data_envio;
                    document.getElementById('descricao_problema').value = envio.defeito;
                });
        }
    });

    cadastroForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(cadastroForm);
        const dataAtual = new Date().toISOString().split('T')[0];
        formData.append('data_cadastro', dataAtual);

        const jsonData = JSON.stringify(Object.fromEntries(formData));

        console.log('Enviando JSON para a API:', jsonData);

        fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_equipamentos', {
            method: 'POST',
            body: jsonData,
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.status === 409) {
                throw new Error('Conflito: O equipamento já existe.');
            }
            return response.json();
        })
        .then(data => {
            alert('Equipamento cadastrado com sucesso!');
            cadastroForm.reset();
            loadSelectData();
        })
        .catch(error => {
            console.error('Erro:', error);
            if (error.message.includes('Conflito')) {
                alert('Erro: O número de série do equipamento já está cadastrado.');
            } else {
                alert('Erro ao cadastrar o equipamento. Por favor, tente novamente.');
            }
        });
    });

    envioForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(envioForm);
        const jsonData = JSON.stringify(Object.fromEntries(formData));

        console.log('Enviando JSON para a API:', jsonData);

        fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_envios', {
            method: 'POST',
            body: jsonData,
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Equipamento enviado para manutenção com sucesso!');
            envioForm.reset();
            loadSelectData();
        })
        .catch(error => console.error('Erro:', error));
    });

    cautelaForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(cautelaForm);

        // Gerar PDF ou imprimir cautela
        const data = formData.get('data');
        const descricaoProblema = formData.get('descricao_problema');

        // Criação de um elemento de impressão (div)
        const printDiv = document.createElement('div');
        printDiv.innerHTML = `
            <h1>Cautela de Equipamento</h1>
            <p>Data: ${data}</p>
            <p>Descrição do Problema: ${descricaoProblema}</p>
            <p>Assinatura:</p>
            <div style="border-bottom: 1px solid #000; width: 100%; height: 30px;"></div>
        `;

        // Imprimir a cautela
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(printDiv.innerHTML);
        printWindow.document.close();
        printWindow.print();
    });
});
