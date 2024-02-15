<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

?>
<script>
    fetch("http://siupa.com.br/siiupa/api/rh/api.php/records/tb_funcionario?filter=status,eq,ativo&order=id,desc", {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
            /*body: JSON.stringify({
                 username: 'danielcardoso',
                 password: 'c*123c12'
             }),*/
        })
        .then(response => response.json())
        .then(data => {

            data.records.forEach((item) => {

                if (item.cpf == null) {
                    item.cpf = 11111111111;
                }
                consultaMatricula(item.cpf);
            });
        })
        .catch(error => {
            // Lide com erros aqui
            console.error('Erro na solicitação:', error);
        });


    function consultaMatricula(cpf) {
        let ncpf = manterApenasNumeros(cpf);
        fetch(`http://siupa.com.br/siiupa/administracao/api/consulta_matricula.php?cpf=${ncpf}`, {
                method: 'GET',
                headers: {
                    //   'Content-Type': 'application/json',
                },
                /*body: JSON.stringify({
                     username: 'danielcardoso',
                     password: 'c*123c12'
                 }),*/
            })
            //.then(response => response.json())
            .then(response => {
                console.log('Resposta completa:', response);
                return response.json();
            })
            .then(data => {
                console.log('Dados em JSON:', data);
            })
    }

    function manterApenasNumeros(str) {
        var resultado = '';

        for (var i = 0; i < str.length; i++) {
            var caractereAtual = str.charAt(i);

            if (!isNaN(caractereAtual)) {
                resultado += caractereAtual;
            }
        }

        return resultado;
    }

    // Exemplo de uso
</script>