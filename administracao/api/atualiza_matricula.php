<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
   const axios = require('axios');

// Função para fazer a primeira solicitação usando Axios
axios.get('http://siupa.com.br/siiupa/api/rh/api.php/records/tb_funcionario', {
    headers: {
        'Content-Type': 'application/json'
    }
})
    .then(response => response.data)
    .then(data => {
        data.records.forEach(item => {
            if (item.cpf === null) {
                item.cpf = '11111111111';
            }
            consultaMatricula(item.cpf);
        });
    })
    .catch(error => {
        // Lide com erros aqui
        console.error('Erro na solicitação:', error);
    });

// Função para fazer a segunda solicitação usando Axios
function consultaMatricula(cpf) {
    let ncpf = manterApenasNumeros(cpf);

    axios.get(`http://siupa.com.br/siiupa/administracao/api/consulta_matricula.php?cpf=${ncpf}`)
        .then(response => response.data)
        .then(data => {
            console.log(data.ultimaMatricula);
        })
        .catch(error => {
            // Lide com erros aqui
            console.error('Erro na solicitação:', error);
        });
}

// Função para manter apenas números em uma string
function manterApenasNumeros(str) {
    let resultado = '';

    for (let i = 0; i < str.length; i++) {
        let caractereAtual = str.charAt(i);

        if (!isNaN(caractereAtual)) {
            resultado += caractereAtual;
        }
    }

    return resultado;
}

</script>