// Função para pegar o valor da query string 'setor'
function getSetorFromQueryString() {
    const params = new URLSearchParams(window.location.search);
    return params.get('setor');
}

// Função para armazenar o valor no localStorage
function saveSetorToLocalStorage(setor) {
    if (setor) {
        localStorage.setItem('setor', setor);
    }
}

// Função para carregar o valor do localStorage
function loadSetorFromLocalStorage() {
    return localStorage.getItem('setor');
}

// Verifica se há valor na query string e salva no localStorage
const setor = getSetorFromQueryString();

if (setor) {
    saveSetorToLocalStorage(setor);
}

// Exemplo: Usar o valor salvo
const cachedSetor = loadSetorFromLocalStorage();
if (cachedSetor) {
    console.log("Setor armazenado: ", cachedSetor);
    // Aqui você pode usar o valor armazenado conforme necessário
}
//////////////// carrega botoes dos setores ///////////////////////
// URL da API
const botao_setores_apiURL = "https://www.siupa.com.br/siiupa/api/api.php/records/tb_setor?order=setor,asc";

// Função para criar os botões dinamicamente
function botao_setores_criarBotoes(setores) {
    const botao_setores_container = document.getElementById('botao_setores_container');

    // Percorrer a lista de setores e criar os botões
    setores.forEach(setor => {
        if (cachedSetor == setor.id) {

            $('#titulo_setor').text(setor.setor);
            
       

        } else if (cachedSetor == 'todos') {
            $('#titulo_setor').text('Todos')
        }
        // Criar um botão
        const botao_setores_botao = document.createElement('button');
        botao_setores_botao.textContent = setor.setor; // Nome do setor como texto do botão
        botao_setores_botao.className = "btn btn-light";

        // Adicionar evento de clique que redireciona para a URL com o ID do setor
        botao_setores_botao.onclick = function () {
            window.location.href = `/siiupa/administracao/patrimonio/?setor=${setor.id}`;
        };

        // Adicionar o botão ao container
        botao_setores_container.appendChild(botao_setores_botao);
    });
}

// Requisição à API para obter os setores
axios.get(botao_setores_apiURL)
    .then(response => {
        const botao_setores_lista = response.data.records;
        botao_setores_criarBotoes(botao_setores_lista); // Chama a função para criar os botões
    })
    .catch(error => {
        console.error('Erro ao consultar a API:', error);
    });
    //////////////// fim carrega botoes dos setores ///////////////////////