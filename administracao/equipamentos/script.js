document.addEventListener('DOMContentLoaded', function() {
    const cadastroForm = document.getElementById('cadastroEquipamento');
    const envioForm = document.getElementById('envioManutencao');
    const cautelaForm = document.getElementById('elaboracaoCautela');

    const setorSelect = document.getElementById('setor');
    const equipamentoSelect = document.getElementById('equipamento');

    // Função para carregar setores e equipamentos via API
    function loadSelectData() {
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

    loadSelectData();

    cadastroForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(cadastroForm);

        fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_equipamentos', {
            method: 'POST',
            body: JSON.stringify(Object.fromEntries(formData)),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Equipamento cadastrado com sucesso!');
            cadastroForm.reset();
        })
        .catch(error => console.error('Erro:', error));
    });

    envioForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(envioForm);

        fetch('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_equipamentos_envios', {
            method: 'POST',
            body: JSON.stringify(Object.fromEntries(formData)),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Equipamento enviado para manutenção com sucesso!');
            envioForm.reset();
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
