
var botaoCima = document.getElementById('botao-cima');
var botaoBaixo = document.getElementById('botao-baixo');
var campoPosicao = document.getElementById('campo-posicao');
var container = document.getElementById('container');
var posicaoY = -68;
let texto = "";
let contaLinhas = 1;
campoPosicao.value = -24;

const form = document.querySelector('form');
const NUMERO_DE_INPUTS = 62;
const NOMES_DE_BAIRROS = [
    'Calucia', '3 de outubro', 'Bacabal', 'Bacuri', 'Boa Vista', 'C. Branco', 'Cupiuba', 'Iracema', 'Itaqui', 'João Batista', 'Macapazinho', 'Nazare', 'Pacuquara', 'S. Terezinha', 'S. Raimundo', 'Ana Júlia', 'Bairro Novo', 'Betânia', 'Bom Jesus', 'Caiçara', 'Camp. Elisios', 'Camp. Lindos', 'Cariri', 'Centro', 'Conj. Tangaras', 'Conj. Ypês', 'Cristo', 'Estrela', 'Florestal', 'Fonte Boa', 'Heliolandia', 'Ianetama', 'Imperador', 'Imperial', 'Jaderlândia', 'Jardim Acacias', 'Jardim Castanhal', 'Jardim Modelo', 'Jardim Tropical', 'Milagre/Sta. Lidia', 'Nova Olinda', 'Novo Caiçara', 'Novo Estrela', 'Novo Horizonte', 'Pantanal', 'Prq.  Castanhais', 'Prq. dos Buritis', 'Pirapora', 'Propira', 'Rouxinol', 'Salgadinho', 'Sta Catarina', 'Santa Helena', 'Sta Terezinha', 'São José', 'Saudade ', 'Saudade II', 'Titanlândia', 'Tókio', 'Vila do Apeú', 'Zona Rural', 'Não Identif.'

];

let currentInputIndex = 0;


const dateInput = document.getElementById("dateInput");

dateInput.addEventListener("change", function () {
    const selectedDate = new Date(this.value);
    selectedDate.setUTCHours(12);
    const year = selectedDate.getFullYear().toString();
    const month = (selectedDate.getMonth() + 1).toString().padStart(2, "0");
    const day = selectedDate.getDate().toString().padStart(2, "0");
    const formattedDate = year + month + day;
    console.log(formattedDate);

    const minhaDiv = document.getElementById("container");
    const dataAtual = document.getElementById("dataAtual");
    minhaDiv.style.backgroundImage = `url('${year}${month}/${year}${month}${day}.png')`;
    dataAtual.style.backgroundImage = `url('${year}${month}/${year}${month}${day}.png')`;

    const form = document.getElementById("formulario");
    form.reset();
    let elementos = document.querySelectorAll('.tdLimpa');

    // Iterar sobre os elementos selecionados
    elementos.forEach(function (elemento) {
        // Fazer algo com cada elemento selecionado
        elemento.innerText = "";
    });

});



function criarInput() {
    const nome = NOMES_DE_BAIRROS[currentInputIndex];

    const input = document.createElement('input');
    input.type = 'number';
    input.id = currentInputIndex + 1;
    input.name = nome;
    input.placeholder = nome;

    const label = document.createElement('label');
    label.for = nome;
    label.innerHTML = "<h1>" + nome + "<h1>";

    const div = document.getElementById('formulario');
    const tabela = document.getElementById('tbody');
    div.appendChild(label);
    div.appendChild(input);
    const tr = document.createElement('tr');
    const td = document.createElement('td');
    const td2 = document.createElement('td');
    td.innerHTML = nome;
    td.name = nome;
    tr.appendChild(td);
    td2.id = `td${contaLinhas}`;
    td2.className = `tdLimpa`;
    tr.appendChild(td2);
    tabela.appendChild(tr);
    contaLinhas++;


    currentInputIndex++;

}

for (let i = 0; i < NUMERO_DE_INPUTS; i++) {
    criarInput();
}

const formulario = document.getElementById('formulario');
const inputs = formulario.querySelectorAll('input');
const labels = formulario.querySelectorAll('label');
const anterior = document.getElementById('anterior');
const proximo = document.getElementById('proximo');

let campoAtual = 0;
const totalCampos = 62;

function exibir(campo) {
    labels[campo].style.animation = 'slide-in-up 0.4s ease-out forwards';
    inputs[campo].style.animation = 'slide-in-up 0.4s ease-out forwards';
    inputs.forEach(input => input.style.display = 'none');
    labels.forEach(label => label.style.display = 'none');
    // inputAtual.parentElement.style.animation = 'slide-out-up 0.4s ease-out forwards';
    // proximoInput.parentElement.style.animation = 'slide-in-up 0.4s ease-out forwards';

    inputs[campo].style.display = 'block';

    labels[campo].style.display = 'block';

    inputs[campo].focus();
}

function proximoCampo() {
    if (campoAtual < inputs.length - 1) {

        campoAtual++;
        exibir(campoAtual);


    }
}

function campoAnterior() {
    if (campoAtual > 0) {
        campoAtual--;
        exibir(campoAtual);

    }
}

exibir(campoAtual);

proximo.addEventListener('click', proximoCampo);
anterior.addEventListener('click', campoAnterior);

document.addEventListener('keydown', event => {
    if (event.key === 'Enter') {
        event.preventDefault();

        console.log(campoAtual + 1, totalCampos);
        if (campoAtual + 1 > totalCampos) {
            console.log('maior');
            return;
        }

        proximoCampo();
        campoPosicao.value = parseFloat(campoPosicao.value) - 24;
        atualizarPosicao();


    }
});




function atualizarPosicao() {
    var novaPosicaoY = (campoPosicao.value - 24);
    if (novaPosicaoY !== posicaoY) {
        posicaoY = novaPosicaoY;
        container.style.backgroundPosition = "-597px " + posicaoY + "px";
    }
}

botaoBaixo.addEventListener('click', function () {
    campoPosicao.value = parseFloat(campoPosicao.value) + 24;
    atualizarPosicao();
});

botaoCima.addEventListener('click', function () {
    campoPosicao.value = parseFloat(campoPosicao.value) - 24;
    atualizarPosicao();
});

campoPosicao.addEventListener('input', function () {
    atualizarPosicao();
});


document.addEventListener('keypress', function (event) {

    if (event.keyCode == 13) {
        console.log('oi');


        campoPosicao.blur(); // desfoca o campo para que a atualização da posição funcione
        campoPosicao.value = parseFloat(campoPosicao.value) - 24;
        atualizarPosicao();
    }
    if (event.keyCode == 119) {

        campoPosicao.blur(); // desfoca o campo para que a atualização da posição funcione
        campoPosicao.value = parseFloat(campoPosicao.value) + 1;
        atualizarPosicao();
    }
    if (event.keyCode == 115) {

        campoPosicao.blur(); // desfoca o campo para que a atualização da posição funcione
        campoPosicao.value = parseFloat(campoPosicao.value) - 1;
        atualizarPosicao();
    }
    if (event.keyCode == 97) {
        //A
        if (campoAtual == 0) {
            console.log('menor');
            return;
        }
        campoPosicao.blur(); // desfoca o campo para que a atualização da posição funcione
        campoPosicao.value = parseFloat(campoPosicao.value) + 24;
        atualizarPosicao();
        campoAtual--;
        exibir(campoAtual);
    }

    if (event.keyCode == 70) {
        const inputs = document.querySelectorAll("input[type='number']");
        texto = "";
        ignora2primeiros = -1;
        inputs.forEach((input) => {
            ignora2primeiros++;
            if (ignora2primeiros < 2) {

                return;
            }
            const nomeDoBairro = input.placeholder;
            const valorDoInput = input.value;
            texto += (`${valorDoInput}\n`);
            console.log(texto);
            navigator.clipboard.writeText(texto);

        });
        alert("copiado");
    }

});
const inputsC = document.querySelectorAll('input');

function handleInputChange(event) {
    console.log(event.target);

    let tdTabela = document.getElementById(`td${event.target.id}`);
    if (tdTabela) {
        tdTabela.innerText = event.target.value;
    }


}

inputsC.forEach(input => {
    input.addEventListener('input', handleInputChange);
});