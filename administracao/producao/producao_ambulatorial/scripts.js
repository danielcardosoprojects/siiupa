let data = {
    "dadosPessoais": { "NumeroRegistro": "", "CidadeBairro": "" },
    "faixaEtaria": { "0a13": 0, "14a21": 0, "22a59": 0, "60ouMais": 0 },
    "sexo": { "Feminino": 0, "Masculino": 0 },
    "cartaoSUS": { "ComCartao": 0, "SemCartao": 0 },
    "classificacaoRisco": { "Classificado": 0, "NaoClassificado": 0 },
    "anamnese": { "PA": 0, "PulsoFC": 0, "FR": 0, "Saturacao": 0, "Temperatura": 0, "Peso": 0, "Glicemia": 0, "Inalacao": 0, "Crise Hipertensiva": 0 },
    "consultas": { "Medico": 0, "Enfermeiro": 0, "AssistenteSocial": 0 },
    "acidentesTransito": { "MOTO_X_CARRO": 0, "MOTO_X_MOTO": 0, "MOTO_X_VEICULO_GRANDE": 0, "MOTO_QUEDA": 0, "MOTO_OUTROS": 0, "VEICULO_GRANDE": 0, "CARRO_CAPOTAMENTO": 0, "CARRO_X_CARRO": 0, "CARRO_X_VEICULO_GRANDE": 0, "CARRO_OUTROS": 0, "ATROPELAMENTO": 0, "BICICLETA": 0 },
    "causasAcidente": { "FAB": 0, "FAF": 0, "ACIDENTE_TRABALHO": 0, "GESTANTE": 0, "AGRESSAO_FISICA": 0, "TRAUMA": 3 },
    "quedas": { "PROP_ALTURA": 0, "+1m": 0, "CAMA": 0, "ESCADA": 0, "CAVALO": 0, "QUEDA_ARVORE": 0, "REDE": 0, "TELHADO": 0, "OUTROS": 0, "TENTATIVA_SUICIDIO": 0 },
    "cities": [
        'Abaetetuba', 'Abel Figueiredo', 'Acara', 'Afua', 'Agua Azul do Norte', 'Alenquer', 'Almeirim', 'Altamira',
        'Anajas', 'Ananindeua', 'Anapu', 'Augusto Correa', 'Aurora do Para', 'Aveiro', 'Bagre', 'Baiao', 'Bannach',
        'Barcarena', 'Belem', 'Belterra', 'Benevides', 'Bom Jesus do Tocantins', 'Bonito', 'Braganca', 'Brasil Novo',
        'Brejo Grande do Araguaia', 'Breu Branco', 'Breves', 'Bujaru', 'Cachoeira do Arari', 'Cachoeira do Piria',
        'Cameta', 'Canaa dos Carajas', 'Capanema', 'Capitao Poco', 'Castanhal', 'Chaves', 'Colares', 'Conceicao do Araguaia',
        'Concordia do Para', 'Cumaru do Norte', 'Curionopolis', 'Curralinho', 'Curua', 'Curuca', 'Dom Eliseu', 'Eldorado do Carajas',
        'Faro', 'Floresta do Araguaia', 'Garrafao do Norte', 'Goianesia do Para', 'Gurupa', 'Igarape-Acu', 'Igarape-Miri',
        'Inhangapi', 'Ipixuna do Para', 'Irituia', 'Itaituba', 'Itupiranga', 'Jacareacanga', 'Jacunda', 'Juruti', 'Limoeiro do Ajuru',
        'Mae do Rio', 'Magalhaes Barata', 'Maraba', 'Maracana', 'Marapanim', 'Marituba', 'Medicilandia', 'Melgaco', 'Mocajuba', 'Moju',
        'Monte Alegre', 'Muana', 'Nova Esperanca do Piria', 'Nova Ipixuna', 'Nova Timboteua', 'Novo Progresso', 'Novo Repartimento',
        'Obidos', 'Oeiras do Para', 'Oriximina', 'Ourem', 'Ourilandia do Norte', 'Pacaja', 'Palestina do Para', 'Paragominas',
        'Parauapebas', 'Pau Darco', 'Peixe-Boi', 'Picarra', 'Placas', 'Ponta de Pedras', 'Portel', 'Porto de Moz', 'Prainha',
        'Primavera', 'Quatipuru', 'Redencao', 'Rio Maria', 'Rondon do Para', 'Ruropolis', 'Salinopolis', 'Salvaterra',
        'Santa Barbara do Para', 'Santa Cruz do Arari', 'Santa Isabel do Para', 'Santa Luzia do Para', 'Santa Maria das Barreiras',
        'Santa Maria do Para', 'Santarem', 'Santarem Novo', 'Santo Antonio do Taua', 'Sao Caetano de Odivelas', 'Sao Domingos do Araguaia',
        'Sao Domingos do Capim', 'Sao Felix do Xingu', 'Sao Francisco do Para', 'Sao Geraldo do Araguaia', 'Sao Joao da Ponta',
        'Sao Joao de Pirabas', 'Sao Joao do Araguaia', 'Sao Miguel do Guama', 'Sao Sebastiao da Boa Vista', 'Sapucaia', 'Senador Jose Porfirio',
        'Soure', 'Tailândia', 'Terra Alta', 'Terra Santa', 'Tome-Acu', 'Tracuateua', 'Trairao', 'Tucuma', 'Tucurui', 'Ulianopolis',
        'Urucara', 'Vigia', 'Viseu', 'Vitoria do Xingu', 'Xinguara'
    ],
    "neighborhoods": [
        'Agrovila Calucia', 'Agrovila 3 de outubro', 'Agrovila Bacabal', 'Agrovila Bacuri', 'Agrovila Boa Vista',
        'Agrovila C. Branco', 'Agrovila Cupiuba', 'Agrovila Iracema', 'Agrovila Itaqui', 'Agrovila João Batista',
        'Agrovila Macapazinho', 'Agrovila Nazare', 'Agrovila Pacuquara', 'Agrovila S. Terezinha', 'Agrovila S. Raimundo',
        'Ana Júlia', 'Bairro Novo', 'Betânia', 'Bom Jesus', 'Caiçara', 'Camp. Elisios', 'Camp. Lindos', 'Cariri',
        'Centro', 'Conj. Tangaras', 'Conj. Ypês', 'Cristo', 'Estrela', 'Florestal', 'Fonte Boa', 'Heliolandia', 'Ianetama',
        'Imperador', 'Imperial', 'Jaderlândia', 'Jardim Acacias', 'Jardim Castanhal', 'Jardim Modelo', 'Jardim Tropical',
        'Milagre/Sta. Lidia', 'Nova Olinda', 'Novo Caiçara', 'Novo Estrela', 'Novo Horizonte', 'Pantanal', 'Prq. Castanhais',
        'Prq. dos Buritis', 'Pirapora', 'Propira', 'Rouxinol', 'Salgadinho', 'Sta Catarina', 'Santa Helena', 'Sta Terezinha',
        'São José', 'Saudade', 'Saudade II', 'Titanlândia', 'Tókio', 'Vila do Apeú', 'Zona Rural', 'Não Identif.'
    ],
    "states": [
        'Acre', 'Alagoas', 'Amapá', 'Amazonas', 'Bahia', 'Ceará', 'Distrito Federal', 'Espírito Santo', 'Goiás', 'Maranhão',
        'Mato Grosso', 'Mato Grosso do Sul', 'Minas Gerais', 'Pará', 'Paraíba', 'Paraná', 'Pernambuco', 'Piauí',
        'Rio de Janeiro', 'Rio Grande do Norte', 'Rio Grande do Sul', 'Rondônia', 'Roraima', 'Santa Catarina', 'São Paulo',
        'Sergipe', 'Tocantins'
    ]
};

const letras = {
    1: "A", 2: "S", 3: "D", 4: "F", 5: "G", 6: "H", 7: "J", 8: "K", 9: "L", 10: "Ç", 11: "Z", 12: "X", 13: "C", 14: "V", 15: "B"
};

function normalizeText(text) {
    return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
}

function updateSuggestions(input) {
    const allData = [
        ...data.cities.map(city => ({ name: city, category: 'Cidade' })),
        ...data.neighborhoods.map(neighborhood => ({ name: neighborhood, category: 'Bairro' })),
        ...data.states.map(state => ({ name: state, category: 'Estado' }))
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
    document.querySelectorAll('datalist').forEach(datalist => datalist.remove());
}

function incrementCount(selectedText) {
    const name = selectedText.replace(/\s+\(.*?\)$/, '');
    let category;
    if (data.cities.includes(name)) {
        category = 'cities';
    } else if (data.neighborhoods.includes(name)) {
        category = 'neighborhoods';
    } else if (data.states.includes(name)) {
        category = 'states';
    }

    if (category) {
        const tableBody = document.querySelector(`#${category} tbody`);
        let row = [...tableBody.rows].find(row => row.cells[0].textContent === name);

        if (row) {
            row.cells[1].textContent = parseInt(row.cells[1].textContent) + 1;
        } else {
            row = tableBody.insertRow();
            const cellName = row.insertCell(0);
            const cellCount = row.insertCell(1);
            cellName.textContent = name;
            cellCount.textContent = 1;
        }

        sortTable(tableBody);
    }
}

function sortTable(tableBody) {
    const rows = Array.from(tableBody.rows);
    rows.sort((a, b) => a.cells[0].textContent.localeCompare(b.cells[0].textContent));
    rows.forEach(row => tableBody.appendChild(row));
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
        
        
        // console.log(`data['${categoria}']['${chave}']`);

        const key = document.createElement('div');
        key.classList.add('key');
        key.textContent = letras[i];

        square.appendChild(title);
        square.appendChild(count);
        square.appendChild(key);

        fragment.appendChild(square);
        i++;
    }

    elem.appendChild(fragment);
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

$(document).ready(function () {
    
    
    populaDados("um", "dadosPessoais", "n");
    populaDados("dois", "faixaEtaria", "n");
    populaDados("tres", "sexo", "n");
    populaDados("quatro", "cartaoSUS", "n");
    populaDados("cinco", "classificacaoRisco", "n");
    populaDados("seis", "acidentesTransito", "n");
    populaDados("sete", "causasAcidente", "n");
    populaDados("oito", "quedas", "n");
    populaDados("nove", "anamnese", "s");
    populaDados("dez", "consultas", "s");

    var owl = $("#owl-carousel").owlCarousel({
        items: 1,
        loop: false,
        nav: true,  // Adicionado para mostrar navegação
        dots: false,
        autoPlay: false
    });

    function updateActiveClass() {
        $('.owl-item').removeClass('active');
        var currentIndex = owl.data('owlCarousel').currentItem;
        $('.owl-item').eq(currentIndex).addClass('active');
        
   
    }

    function proximo() {
        owl.trigger('owl.next');
        console.log(owl.data('owlCarousel').currentItem);
        updateActiveClass();
        if(owl.data('owlCarousel').currentItem === 10){
            console.log('esta aqui');
            console.log(searchBox);
            setTimeout(() => {
                searchBox.focus();
              }, "500");            
        }
    }

    function anterior() {
        console.log(owl.data('owlCarousel'));
        
        if (owl.data('owlCarousel').currentItem === 0) {
           
            totalItems = owl.data('owlCarousel').itemsAmount-1;
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
        var key = event.key.toUpperCase();
        var activeItem = $(".owl-item.active .item");

        if (key === 'ENTER') {
            proximo();
        } else if (event.key === 'ArrowLeft') {
            
            anterior();
        } else {
            activeItem.find('.count').each(function () {
                if ($(this).data('key') === key) {
                    var count = parseInt($(this).text());
                    if (event.shiftKey) {
                        count = count > 0 ? count - 1 : 0;
                        categoria = $(this).data('categoria');
                    chave = $(this).data('chave');
                    data[`${categoria}`][`${chave}`]--;
                    } else {
                        count++;
                        $(this).text(count);
                    categoria = $(this).data('categoria');
                    chave = $(this).data('chave');
                    data[`${categoria}`][`${chave}`]++;
                    }
                    
                    
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
            this.value = '';
            clearSuggestions();
            this.blur();
            // this.disabled = true; // Desativar input ao perder foco
        }
    });

    searchBox.addEventListener('blur', function() {
        // this.disabled = true; // Desativar input ao perder foco
    });
});