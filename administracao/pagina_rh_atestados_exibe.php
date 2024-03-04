<?php
include_once('bd/conectabd.php');

include_once('bd/nivel.php');

$idAfastamento = $_GET['idafastamento'];
?>
<div id="box_grande">
    <?php
    $consulta_atestado = new BD;


    $sqlConsulta_Atestados = "SELECT afs.afastamento,afs.id as afastamento_id, A.*, f.nome, f.id as idf, c.titulo FROM u940659928_siupa.tb_afastamento as A inner join u940659928_siupa.tb_funcionario as f ON (A.fk_funcionario = f.id) inner join u940659928_siupa.tb_cargo AS c on (f.fk_cargo = c.id) inner join u940659928_siupa.tb_afastamentos as afs on (A.fk_afastamentos = afs.id) WHERE A.id = '$idAfastamento' order by A.id DESC";
    $resultadoConsulta_Atestados = $consulta_atestado->consulta($sqlConsulta_Atestados);

    foreach ($resultadoConsulta_Atestados as $resultado_atestado) {

        $firstDate  = new DateTime($resultado_atestado->data_inicio);
        $secondDate = new DateTime($resultado_atestado->data_fim);
        $intvl = $firstDate->diff($secondDate);
        $totalDias = $intvl->format('%R%a') + 1;
        $dias = $intvl->d;
        $dias = $dias + 1;
        //verifica se está ativo ou nome
        $dt_atual = date("Y-m-d");
        $hoje = new DateTime($dt_atual);

        //compara o formato completo da data se é maior ou igual a hoje
        if ($secondDate->format('c') >= $hoje->format('c')) {
            $classe_css = "ativo";
            $texto_etiqueta = "Ativo";
        } else {
            $classe_css = "inativo";
            $texto_etiqueta = "Inativo";
        }


        $afastamentoUtf8 = $resultado_atestado->afastamento;

        echo "<div class='box_atestados table-hover ' style='width:auto;' name='$resultado_atestado->nome'><span class='$classe_css' > $texto_etiqueta</span> <span class='tipo_afastamento'>  $afastamentoUtf8 </span><span class='nome_funcionario'>";
        echo "<a href='?setor=adm&sub=rh&subsub=perfil&id=$resultado_atestado->idf'> ";

        echo $resultado_atestado->nome . "</a></span> - <span class='nome_cargo'>" . utf8_encode($resultado_atestado->titulo) . "</span><br>";
        echo "De: <input class='data' type='date' value='" . $resultado_atestado->data_inicio . "' readonly> Até: <input class='data'  type='date' value='" . $resultado_atestado->data_fim . "' readonly><br>";

        echo "(" . $totalDias . " dias) | " . $intvl->y . " ano(s), " . $intvl->m . " mes(es) e " . $dias . " dia(s)";
        echo "<br>";
        $afastamentoObs = $resultado_atestado->afastamento_obs;
        echo "📝 $afastamentoObs";
        echo "<br>";


        echo "<button class='bt_editaAtestado form-control' style='width:100px;float:left;margin-right:5px;' data-idatestado='$resultado_atestado->id' data-idfuncionario='$resultado_atestado->fk_funcionario' data-data_inicio='$resultado_atestado->data_inicio' data-data_fim='$resultado_atestado->data_fim' data-afastamento='$resultado_atestado->afastamento' data-afastamentoid='$resultado_atestado->afastamento_id' data-nome='$resultado_atestado->nome' data-cargo='$resultado_atestado->titulo' data-afastamento_obs='$resultado_atestado->afastamento_obs'>Editar</button>";


        echo "<a id=\"excluirBtn\" class=\"btn\" data-id-afastamento=\"$idAfastamento\">Excluir</a>";






    
    
        //echo "<hr>";
    }
    ?>
    <hr>
    <div class="box_atestados table-hover border border-primary">
        <h4 class="text-bg-light p-3">Acionamentos vinculados a este atestado</h4>
        <div class="table-hover" id="acionamentosVinculados"></div>
    </div>

    <?="</div>";?>

</div>

<script>
    const idAfastamentoConsulta = document.getElementById("excluirBtn").getAttribute('data-id-afastamento');
    const apiUrlVerificaFK = `https://siupa.com.br/siiupa/api/rh/api.php/records/tb_acionamento?filter=fk_afastamento,eq,${idAfastamentoConsulta}&join=tb_funcionario&page=1`;

    // Realiza a consulta usando Axios
    axios.get(apiUrlVerificaFK)

        .then(response => {
            console.log(response.data.results);
            // Verifica se o campo "results" está presente e é maior que zero
            if (response.data.results && response.data.results > 0) {
                // Exibe um alert
                document.getElementById('excluirBtn').addEventListener('click', function() {
                    alert('existe um acionamento vinculado a este afastamento. Desvincule primeiro.');
                });
                //EXIBIR OS ACIONAMENTOS VINCULADOS A ESTE ATESTADO, SE HOUVER
                response.data.records.forEach(function(record) {
                    // Faça alguma operação com cada registro
                    console.log(record.fk_funcionario.nome); // Exemplo: exibindo o registro no console
                    let nome = record.fk_funcionario.nome;
                    let idAcionamento = record.id;
                    let qtdHoras = record.qtd_horas;
                    let turno = record.turno;
                    // String da data
                    const dataString = record.data_acionamento;
                    // Criar um objeto Date a partir da string
                    const data = new Date(dataString);
                    // Verificar se a data é válida e formata DD/MM/AAAA
                    const dataBr = (!isNaN(data.getTime())) ? `${data.getDate().toString().padStart(2, '0')}/${(data.getMonth() + 1).toString().padStart(2, '0')}/${data.getFullYear()}` : "Data inválida.";


                    // Encontrar a div com o id #acionamentosVinculados
                    let divAcionamentos = document.getElementById('acionamentosVinculados');

                    // Criar um novo elemento span
                    let novoSpan = document.createElement('div');
                    novoSpan.innerHTML = `<strong><a href="https://siupa.com.br/siiupa/?setor=adm&sub=rh&subsub=acionamento_exibe&id=${idAcionamento}">${dataBr} | ${qtdHoras} ${turno} | ${nome}</a></strong>`; // Adicionando HTML ao span

                    // Adicionar o novo span como filho da div #acionamentosVinculados
                    divAcionamentos.appendChild(novoSpan);
                });
            } else {
                let divAcionamentos = document.getElementById('acionamentosVinculados');

                    // Criar um novo elemento span
                    let novoSpan = document.createElement('span');
                    novoSpan.innerHTML = `Nenhum acionamento vinculado a este afastamento.`; // Adicionando HTML ao span

                    // Adicionar o novo span como filho da div #acionamentosVinculados
                    divAcionamentos.appendChild(novoSpan);
                document.getElementById('excluirBtn').addEventListener('click', function() {
                    // Obtenha o id-afastamento do atributo data
                    var idAfastamento = this.getAttribute('data-id-afastamento');


                    // Certifique-se de que há um id-funcionario válido
                    if (idAfastamento) {

                        // Construa a URL da API com o id-funcionario
                        var apiUrl = 'https://siupa.com.br/siiupa/api/rh/api.php/records/tb_afastamento/' + idAfastamento;

                        // Envie uma solicitação DELETE para a API
                        fetch(apiUrl, {
                                method: 'DELETE'
                            })
                            .then(response => {
                                if (response.ok) {
                                    alert('Afastamento excluído com sucesso.');

                                    // Redirecione para a nova página após a exclusão bem-sucedida
                                    window.location.href = 'https://siupa.com.br/siiupa/?setor=adm&sub=rh&subsub=atestados';

                                } else {
                                    alert('Erro ao excluir o afastamento:', response.statusText);
                                    // Adicione aqui qualquer lógica para lidar com erros
                                }
                            })
                            .catch(error => {
                                console.error('Erro na solicitação DELETE:', error);
                                // Adicione aqui qualquer lógica para lidar com erros de rede
                            });




                    } else {
                        console.error('ID de afastamento inválido.');
                        // Adicione aqui qualquer lógica para lidar com id-funcionario inválido
                    }
                });

            }
        })
        .catch(error => {
            // Trata os erros, exibindo um alert com a mensagem de erro
            alert('Erro ao consultar a API: ' + error.message);
        });
</script>
<style>
    #box_grande {
        display: flex;
        flex-direction: row;
        width: 100%;
        background-color: #0d6efd;
        gap: 6px;
        flex-wrap: wrap;

        justify-content: space-around;
        padding: 4px;
    }

    .ativo {
        background-color: green;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
    }

    .inativo {
        background-color: #ffc133;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #ff6433;
        cursor: default;
        border-color: #0d6efd;
    }

    .tipo_afastamento {
        background-color: #a934ff;
        padding: .1rem .2rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        text-transform: uppercase;
        font-weight: bold;
    }

    .nome_funcionario {
        font-size: 18px;
        font-weight: bold;
    }

    .nome_cargo {
        font-size: 18px;
    }

    .data {
        box-shadow: 0 0 0 0;
        border: 0 none;
        outline: 0;
        color: #000;
    }

    .box_atestados {
        border: 1px solid #ccc;
        padding: 2px;
        background-color: #fff;
        overflow: hidden;
        height: auto;
        width: 100%;
    }

    .box_atestados:hover {
        background-color: #e2e7e8;
    }

    .limpaFloat {
        clear: both;
    }

    #carregaAnexos {
        font-size: 12px;
    }

    #excluirBtn {
        background-color: #ff4d4d;
        /* Vermelho do Facebook */
        color: #fff;
        /* Texto branco */
        padding: .375rem 0.75rem;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    /* Efeito de hover para o botão */
    #excluirBtn:hover {
        background-color: #ff6666;
        /* Tom mais claro de vermelho ao passar o mouse */
    }
</style>