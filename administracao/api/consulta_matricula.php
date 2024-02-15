<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
$fcpfn = $_GET['cpf'];


?>
<script>
    //geratoken
    fetch("https://apionline.layoutsistemas.com.br/api/token/", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: 'danielcardoso',
                password: 'c*123c12'
            }),
        })
        .then(response => response.json())
        .then(data => {
            // Faça algo com os dados

            const token = data.access;


            const apiURL<?php echo $fcpfn; ?> = `https://apionline.layoutsistemas.com.br/api/matriculas/?cpf=<?php echo $fcpfn; ?>&entidade=796`;
            const authorizationHeader<?php echo $fcpfn; ?> = `Bearer ${token}`;

            // Fazer uma solicitação GET usando a função fetch
            fetch(apiURL<?php echo $fcpfn; ?>, {
                    method: "GET",
                    headers: {
                        "Authorization": authorizationHeader<?php echo $fcpfn; ?>
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erro na solicitação: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Verificar se a resposta foi bem-sucedida e obter o CPF

                    if (data.results && data.results.length > 0) {
                        let ultimaMatricula = 0;
                        if (data.results.length == 1) {
                            ultimaMatricula = data.results[0].matricula.replace('-', '');

                        } else {
                            data.results.map(item => {
                                // Realize as operações desejadas para cada item
                                // Neste exemplo, apenas adicionando uma nova propriedade
                                matriculaAtual = item.matricula.replace('-', '');
                                if (matriculaAtual < 3000000 & matriculaAtual > ultimaMatricula) {
                                    ultimaMatricula = matriculaAtual;
                                }

                            });

                        }
                        let matDigito = ultimaMatricula;

                        // Separando os dígitos
                        let partePrincipal = matDigito.slice(0, -1);
                        let digitoVerificador = matDigito.slice(-1);

                        // Criando o formato desejado
                        ultimaMatricula = `${partePrincipal}-${digitoVerificador}`;
                        //console.log('2024: ', ultimaMatricula);
                    document.getElementById("matriculaRecebe").innerHTML = `{\"ultimaMatricula\": \"${ultimaMatricula}\"}`;
                    } else {
                        console.log("CPF não encontrado na resposta da API.");
                    }
                })
                .catch(error => {
                    console.error("Erro na solicitação:", error);
                });

        })
        .catch(error => {
            // Lide com erros aqui
            console.error('Erro na solicitação:', error);
        });


       
</script>

<div id="matriculaRecebe"></div>