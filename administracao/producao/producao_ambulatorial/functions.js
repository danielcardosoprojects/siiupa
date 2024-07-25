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
    const categoriaDados = data[categoria.toLowerCase()];
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
