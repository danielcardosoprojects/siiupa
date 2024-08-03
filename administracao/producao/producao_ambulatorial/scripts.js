let data = {
    "dadosPessoais": { "NumeroRegistro": "", "CidadeBairro": "" },
    "faixaEtaria": { "0a13": 0, "14a21": 0, "22a59": 0, "60ouMais": 0 },
    "sexo": { "Feminino": 0, "Masculino": 0 },
    "cartaoSUS": { "ComCartao": 0, "SemCartao": 0 },
    "classificacaoRisco": { "Classificado": 0, "NaoClassificado": 0 },
    "anamnese": { "PA": 0, "PulsoFC": 0, "FR": 0, "Saturacao": 0, "Temperatura": 0, "Peso": 0, "Glicemia": 0, "Inalacao": 0, "Crise Hipertensiva": 0 },
    "consultas": { "Medico": 0, "Enfermeiro": 0, "AssistenteSocial": 0 },
    "acidentesTransito": { "MOTO_X_CARRO": 0, "MOTO_X_MOTO": 0, "MOTO_X_VEICULO_GRANDE": 0, "MOTO_QUEDA": 0, "MOTO_OUTROS": 0, "VEICULO_GRANDE": 0, "CARRO_CAPOTAMENTO": 0, "CARRO_X_CARRO": 0, "CARRO_X_VEICULO_GRANDE": 0, "CARRO_OUTROS": 0, "ATROPELAMENTO": 0, "BICICLETA": 0 },
    "causasAcidente": { "FAB": 0, "FAF": 0, "ACIDENTE_TRABALHO": 0, "GESTANTE": 0, "AGRESSAO_FISICA": 0 },
    "traumas": { "TRAUMA": 0 },
    "quedas": { "PROP_ALTURA": 0, "+1m": 0, "CAMA": 0, "ESCADA": 0, "CAVALO": 0, "QUEDA_ARVORE": 0, "REDE": 0, "TELHADO": 0, "OUTROS": 0, "TENTATIVA_SUICIDIO": 0 },
    "cities": {
        'Abaetetuba': 0, 'Abel Figueiredo': 0, 'Acara': 0, 'Afua': 0, 'Agua Azul do Norte': 0, 'Alenquer': 0, 'Almeirim': 0, 'Altamira': 0,
        'Anajas': 0, 'Ananindeua': 0, 'Anapu': 0, 'Augusto Correa': 0, 'Aurora do Para': 0, 'Aveiro': 0, 'Bagre': 0, 'Baiao': 0, 'Bannach': 0,
        'Barcarena': 0, 'Belem': 0, 'Belterra': 0, 'Benevides': 0, 'Bom Jesus do Tocantins': 0, 'Bonito': 0, 'Braganca': 0, 'Brasil Novo': 0,
        'Brejo Grande do Araguaia': 0, 'Breu Branco': 0, 'Breves': 0, 'Bujaru': 0, 'Cachoeira do Arari': 0, 'Cachoeira do Piria': 0,
        'Cameta': 0, 'Canaa dos Carajas': 0, 'Capanema': 0, 'Capitao Poco': 0, 'Castanhal': 0, 'Chaves': 0, 'Colares': 0, 'Conceicao do Araguaia': 0,
        'Concordia do Para': 0, 'Cumaru do Norte': 0, 'Curionopolis': 0, 'Curralinho': 0, 'Curua': 0, 'Curuca': 0, 'Dom Eliseu': 0, 'Eldorado do Carajas': 0,
        'Faro': 0, 'Floresta do Araguaia': 0, 'Garrafao do Norte': 0, 'Goianesia do Para': 0, 'Gurupa': 0, 'Igarape-Acu': 0, 'Igarape-Miri': 0,
        'Inhangapi': 0, 'Ipixuna do Para': 0, 'Irituia': 0, 'Itaituba': 0, 'Itupiranga': 0, 'Jacareacanga': 0, 'Jacunda': 0, 'Juruti': 0, 'Limoeiro do Ajuru': 0,
        'Mae do Rio': 0, 'Magalhaes Barata': 0, 'Maraba': 0, 'Maracana': 0, 'Marapanim': 0, 'Marituba': 0, 'Medicilandia': 0, 'Melgaco': 0, 'Mocajuba': 0, 'Moju': 0,
        'Monte Alegre': 0, 'Muana': 0, 'Nova Esperanca do Piria': 0, 'Nova Ipixuna': 0, 'Nova Timboteua': 0, 'Novo Progresso': 0, 'Novo Repartimento': 0,
        'Obidos': 0, 'Oeiras do Para': 0, 'Oriximina': 0, 'Ourem': 0, 'Ourilandia do Norte': 0, 'Pacaja': 0, 'Palestina do Para': 0, 'Paragominas': 0,
        'Parauapebas': 0, 'Pau Darco': 0, 'Peixe-Boi': 0, 'Picarra': 0, 'Placas': 0, 'Ponta de Pedras': 0, 'Portel': 0, 'Porto de Moz': 0, 'Prainha': 0,
        'Primavera': 0, 'Quatipuru': 0, 'Redencao': 0, 'Rio Maria': 0, 'Rondon do Para': 0, 'Ruropolis': 0, 'Salinopolis': 0, 'Salvaterra': 0,
        'Santa Barbara do Para': 0, 'Santa Cruz do Arari': 0, 'Santa Isabel do Para': 0, 'Santa Luzia do Para': 0, 'Santa Maria das Barreiras': 0,
        'Santa Maria do Para': 0, 'Santarem': 0, 'Santarem Novo': 0, 'Santo Antonio do Taua': 0, 'Sao Caetano de Odivelas': 0, 'Sao Domingos do Araguaia': 0,
        'Sao Domingos do Capim': 0, 'Sao Felix do Xingu': 0, 'Sao Francisco do Para': 0, 'Sao Geraldo do Araguaia': 0, 'Sao Joao da Ponta': 0,
        'Sao Joao de Pirabas': 0, 'Sao Joao do Araguaia': 0, 'Sao Miguel do Guama': 0, 'Sao Sebastiao da Boa Vista': 0, 'Sapucaia': 0, 'Senador Jose Porfirio': 0,
        'Soure': 0, 'Tailândia': 0, 'Terra Alta': 0, 'Terra Santa': 0, 'Tome-Acu': 0, 'Tracuateua': 0, 'Trairao': 0, 'Tucuma': 0, 'Tucurui': 0, 'Ulianopolis': 0,
        'Urucara': 0, 'Vigia': 0, 'Viseu': 0, 'Vitoria do Xingu': 0, 'Xinguara': 0
    },
    "neighborhoods": {
        'Agrovila Calucia': 0, 'Agrovila 3 de outubro': 0, 'Agrovila Bacabal': 0, 'Agrovila Bacuri': 0, 'Agrovila Boa Vista': 0,
        'Agrovila C. Branco': 0, 'Agrovila Cupiuba': 0, 'Agrovila Iracema': 0, 'Agrovila Itaqui': 0, 'Agrovila Joao Batista': 0,
        'Agrovila Macapazinho': 0, 'Agrovila Nazare': 0, 'Agrovila Pacuquara': 0, 'Agrovila S. Terezinha': 0, 'Agrovila S. Raimundo': 0,
        'Ana Júlia': 0, 'Bairro Novo': 0, 'Betânia': 0, 'Bom Jesus': 0, 'Caicara': 0, 'Camp. Elisios': 0, 'Camp. Lindos': 0, 'Cariri': 0,
        'Centro': 0, 'Conj. Tangaras': 0, 'Conj. Ypês': 0, 'Cristo': 0, 'Estrela': 0, 'Florestal': 0, 'Fonte Boa': 0, 'Heliolandia': 0, 'Ianetama': 0,
        'Imperador': 0, 'Imperial': 0, 'Jaderlândia': 0, 'Jardim Acacias': 0, 'Jardim Castanhal': 0, 'Jardim Modelo': 0, 'Jardim Tropical': 0,
        'Milagre/Sta. Lidia': 0, 'Nova Olinda': 0, 'Novo Caicara': 0, 'Novo Estrela': 0, 'Novo Horizonte': 0, 'Pantanal': 0, 'Prq. Castanhais': 0,
        'Prq. dos Buritis': 0, 'Pirapora': 0, 'Propira': 0, 'Rouxinol': 0, 'Salgadinho': 0, 'Sta Catarina': 0, 'Santa Helena': 0, 'Sta Terezinha': 0,
        'Sao José': 0, 'Saudade': 0, 'Saudade II': 0, 'Titanlândia': 0, 'Tókio': 0, 'Vila do Apeú': 0, 'Zona Rural': 0, 'Nao Identif.': 0
    },
    "states": {
        'Acre': 0, 'Alagoas': 0, 'Amapá': 0, 'Amazonas': 0, 'Bahia': 0, 'Ceará': 0, 'Distrito Federal': 0, 'Espírito Santo': 0, 'Goiás': 0, 'Maranhao': 0,
        'Mato Grosso': 0, 'Mato Grosso do Sul': 0, 'Minas Gerais': 0, 'Pará': 0, 'Paraíba': 0, 'Paraná': 0, 'Pernambuco': 0, 'Piauí': 0,
        'Rio de Janeiro': 0, 'Rio Grande do Norte': 0, 'Rio Grande do Sul': 0, 'Rondônia': 0, 'Roraima': 0, 'Santa Catarina': 0, 'Sao Paulo': 0,
        'Sergipe': 0, 'Tocantins': 0
    }
};

const letras = {
    1: "A", 2: "S", 3: "D", 4: "F", 5: "G", 6: "H", 7: "J", 8: "K", 9: "L", 10: "c", 11: "Z", 12: "X", 13: "C", 14: "V", 15: "B"
};

// Cria um evento de teclado para a tecla especificada
function simulateKeyPress(key) {
    // Cria um novo evento de teclado
    const event = new KeyboardEvent('keydown', {
        key: key,
        keyCode: key.charCodeAt(0),
        code: 'Key' + key.toUpperCase(),
        bubbles: true,
        cancelable: true
    });

    // Dispara o evento no elemento desejado, por exemplo, no document
    document.dispatchEvent(event);
}

// Simula a pressão da tecla 'A'
//simulateKeyPress('a');


let separaProntuario;

function separarProntuario(val) {
    if (val === 1) {
        separaProntuario = 1; //registra para separação
        alertify.success('Este prontuário deverá ser separado.');

    } else {
        separaProntuario = 0; //limpa separação
    }

}

function consultaSeparacao() {
    if (separaProntuario) {
        alertify.alert('Este prontuário deverá ser separado nos acidentes de trânsito.');
        separarProntuario(0);
    }
}

// Carrega dados do localStorage, se existirem
function loadData() {
    const savedData = localStorage.getItem('data');
    if (savedData) {
        data = JSON.parse(savedData);
    }
}

// Salva dados no localStorage
function saveData() {
    localStorage.setItem('data', JSON.stringify(data));
}

// Limpa os dados do localStorage
function clearData() {
    localStorage.removeItem('data');
    location.reload(); // Recarrega a página para aplicar as alterações
}

function normalizeText(text) {
    return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
}

function updateSuggestions(input) {
    const allData = [
        ...Object.keys(data.cities).map(city => ({ name: city, category: 'Cidade' })),
        ...Object.keys(data.neighborhoods).map(neighborhood => ({ name: neighborhood, category: 'Bairro' })),
        ...Object.keys(data.states).map(state => ({ name: state, category: 'Estado' }))
    ];
    const searchText = normalizeText(input.value);
    const suggestions = allData.filter(item => normalizeText(item.name).includes(searchText));
    const datalist = document.createElement('datalist');
    datalist.id = `datalist-suggestions`;
    clearSuggestions();
    suggestions.forEach(item => {
        const option = document.createElement('option');
        option.value = `${item.name} (${item.category})`;
        datalist.appendChild(option);
    });
    document.body.appendChild(datalist);
    input.setAttribute('list', datalist.id);
}

function clearSuggestions() {
    const existingDatalist = document.getElementById('datalist-suggestions');
    if (existingDatalist) {
        document.body.removeChild(existingDatalist);
    }
}

function addDecrementButton(category, name) {
    const button = document.createElement('button');
    button.textContent = '-';
    button.addEventListener('click', function () {
        if (data[category][name] > 0) {
            data[category][name]--;
            updateTableRow(category, name);
            saveData(); // Salva os dados sempre que houver uma alteração
        }
    });
    return button;
}

function updateTableRow(category, name) {
    const tableBody = document.querySelector(`#${category} tbody`);
    let row = [...tableBody.rows].find(row => row.cells[0].textContent === name);

    if (row) {
        row.cells[1].textContent = data[category][name];
    }
}

function incrementCount(selectedText) {
    const name = selectedText.replace(/\s+\(.*?\)$/, '');
    let category;
    if (data.cities.hasOwnProperty(name)) {
        category = 'cities';

    } else if (data.neighborhoods.hasOwnProperty(name)) {
        category = 'neighborhoods';
    } else if (data.states.hasOwnProperty(name)) {
        category = 'states';
    }





    if (category) {
        data[category][name]++;
        const tableBody = document.querySelector(`#${category} tbody`);
        let row = [...tableBody.rows].find(row => row.cells[0].textContent === name);

        if (row) {
            row.cells[1].textContent = parseInt(row.cells[1].textContent) + 1;
        } else {
            row = tableBody.insertRow();
            const cellName = row.insertCell(0);
            const cellCount = row.insertCell(1);
            const cellDecrement = row.insertCell(2); // Nova célula para o botão de decremento

            cellName.textContent = name;
            cellCount.textContent = 1;
            cellDecrement.appendChild(addDecrementButton(category, name)); // Adicionar botão de decremento
        }

        sortTable(tableBody);
        saveData(); // Salva os dados sempre que houver uma alteração
    }
}

function sortTable(tableBody) {
    const rows = Array.from(tableBody.rows);
    rows.sort((a, b) => a.cells[0].textContent.localeCompare(b.cells[0].textContent));
    rows.forEach(row => tableBody.appendChild(row));
}
function simulaTecla(categoria) {
    categoria.addEventListener('click', function () {
        simulateKeyPress($(categoria).data('key'));
    });
}
function populaDados(div, categoria, multi) {
    const elem = document.getElementById(div);
    elem.innerHTML = "<h2 class='tituloCategoria'>" + capitalize(categoria) + "</h2>";
    const categoriaDados = data[categoria];
    const fragment = document.createDocumentFragment();
    let i = 1;
    for (const chave in categoriaDados) {
        const square = document.createElement('div');
        square.classList.add('square');
        square.id = chave;
        square.dataset.key = letras[i];




        const title = document.createElement('div');
        title.classList.add('title');
        title.textContent = chave;

        const count = document.createElement('div');
        count.classList.add('count');
        count.dataset.key = letras[i];
        count.dataset.multi = multi;
        count.textContent = categoriaDados[chave];
        count.dataset.categoria = `${categoria}`;
        count.dataset.chave = `${chave}`;


        // count.onclick = function () {
        //     simulateKeyPress(`${letras[i]}`); // Simula a pressão da tecla 'a'
        // };


        const key = document.createElement('div');
        key.classList.add('key');
        key.textContent = letras[i];

        square.appendChild(title);
        square.appendChild(count);
        square.appendChild(key);

        fragment.appendChild(square);
        simulaTecla(square);
        i++;

    }

    elem.appendChild(fragment);
}

function populaTabela(category) {
    const tableBody = document.querySelector(`#${category} tbody`);
    tableBody.innerHTML = ''; // Clear existing rows

    for (const name in data[category]) {
        if (data[category].hasOwnProperty(name) && data[category][name] > 0) {
            const row = tableBody.insertRow();
            const cellName = row.insertCell(0);
            const cellCount = row.insertCell(1);
            const cellDecrement = row.insertCell(2); // New cell for decrement button

            cellName.textContent = name;
            cellCount.textContent = data[category][name];
            cellDecrement.appendChild(addDecrementButton(category, name)); // Add decrement button
        }
    }
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}





$(document).ready(function () {
    loadData(); // Carrega os dados do localStorage ao carregar a página

    populaDados("um", "dadosPessoais", "n");
    populaDados("dois", "faixaEtaria", "n");
    populaDados("tres", "sexo", "n");
    populaDados("quatro", "cartaoSUS", "n");
    populaDados("cinco", "classificacaoRisco", "n");
    populaDados("seis", "acidentesTransito", "n");
    populaDados("sete", "causasAcidente", "n");
    populaDados("oito", "quedas", "n");
    populaDados("oito2", "traumas", "n");
    populaDados("nove", "anamnese", "s");
    populaDados("dez", "consultas", "s");

    populaTabela("cities"); // Populate cities table
    populaTabela("neighborhoods"); // Populate neighborhoods table
    populaTabela("states"); // Populate states table

    var owl = $("#owl-carousel").owlCarousel({
        items: 1,
        loop: false,
        nav: true,  // Adicionado para mostrar navegacao
        dots: false,
        autoPlay: false,
        touchDrag: true,
        mouseDrag: true,
        onDragged: function (event) {
            alert('teste');
        }
    });

    function updateActiveClass() {
        $('.owl-item').removeClass('active');
        var currentIndex = owl.data('owlCarousel').currentItem;
        $('.owl-item').eq(currentIndex).addClass('active');
    }
   

    function proximo() {
        owl.trigger('owl.next');
        updateActiveClass();
        if (owl.data('owlCarousel').currentItem === 11) {
            console.log(owl.data('owlCarousel'));

            setTimeout(() => {
                searchBox.focus();
            }, 500);
        }
        totalItems = owl.data('owlCarousel').itemsAmount - 1;
        currentItem = owl.data('owlCarousel').currentItem;
        if (currentItem == 0) {


            consultaSeparacao();
        }
    }

    function anterior() {


        if (owl.data('owlCarousel').currentItem === 0) {
            totalItems = owl.data('owlCarousel').itemsAmount - 1;
            for (let i = 0; i < totalItems; i++) {
                proximo();
            }
        } else {
            owl.trigger('owl.prev');
            updateActiveClass();
        }
    }

    owl.on('changed.owl.carousel', updateActiveClass);
    updateActiveClass();

    $(document, ".iframe").keydown(function (event) {
        var key = String(event.key).toUpperCase();
        console.log(key);
        var activeItem = $(".owl-item.active .item");

        if (key === 'ENTER') {
            proximo();
        } else if (event.key === 'ArrowLeft') {
            anterior();
        } else {
            activeItem.find('.count').each(function () {
                if ($(this).data('key') === key) {
                    var count = parseInt($(this).text());
                    const categoria = $(this).data('categoria');
                    const chave = $(this).data('chave');

                    //elabora o alerta para separação de prontuario
                    if (categoria == "acidentesTransito") {
                        separarProntuario(1);

                    };


                    if (event.shiftKey) {
                        count = count > 0 ? count - 1 : 0;
                        data[`${categoria}`][`${chave}`]--;
                    } else {
                        count++;
                        data[`${categoria}`][`${chave}`]++;
                    }

                    $(this).text(count);
                    saveData(); // Salva os dados sempre que houver uma alteração

                    if ($(this).data('multi') == "n") {
                        proximo();
                    }
                }
            });
        }
    });

    const searchBox = document.querySelector('.search-box');
    searchBox.addEventListener('input', function () {
        updateSuggestions(this);
    });

    searchBox.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            incrementCount(this.value);
            //verifica se é cidade e da alerta
            if (this.value.endsWith("(Cidade)")) {
                setTimeout(() => {

                    alertify.alert('Este prontuário deverá ser separado em Cidades.');

                }, 500);
            }

            this.value = '';
            clearSuggestions();
            this.blur();
        }
    });

    searchBox.addEventListener('blur', function () {
        // this.disabled = true; // Desativar input ao perder foco
    });

    // Evento de clique para o botão de limpar dados
    document.getElementById('clearDataButton').addEventListener('click', clearData);
});
