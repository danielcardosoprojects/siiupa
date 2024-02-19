<?php
@include("../bd/conectabd.php");

function trataNaoNumericos($naoNumericos)
{
    if ($naoNumericos == '' || $naoNumericos == null) {
        return 0;
    } else {
        return floatval($naoNumericos);
    }
}
class Tabela
{
    public function abreTabela($nomeid, $class, $id = '')
    {
        echo "<table name='$nomeid' id='$nomeid' class='$class' $id>";
    }
    public function fechaTabela()
    {
        echo "</tbody>";
        echo "</table>";
    }

    public function abreThead()
    {
        echo "<thead><tr>";
    }
    public function tcabecalho($entrada)
    {
        echo "<th scope='col'>$entrada</th>";
    }

    public function fechaThead()
    {
        echo "</tr></thead><tbody>";
    }

    public function tabrelinha()
    {

        echo "<tr>";
    }

    public function tpopulalinha($entrada, $mesclalinhas = '', $mesclacolunas = '')
    {
        if ($mesclalinhas != '') {
            $mesclalinhas = "rowspan='$mesclalinhas'";
        }
        echo "<td $mesclalinhas colspan='$mesclacolunas'>$entrada</td>";
    }

    public function tfechalinha()
    {

        echo "</tr>";
    }
} ?>

<script type="text/javascript" src="/siiupa/js/script.js"></script>
<script>
    function consultarMatricula(cpf) {
        const url = `https://siupa.com.br/siiupa/administracao/api/consulta_matricula.php?cpf=${cpf}`;

        return fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro na requisição: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                return data.ultimaMatricula;
            })
            .catch(error => {
                console.error('Erro:', error);
                throw error; // opcional: lançar novamente o erro para tratamento posterior
            });
    }

    function atualizarDadosFuncionario(id, dadosAtualizados, metodo = 'PUT') {
        const url = `https://siupa.com.br/siiupa/api/rh/api.php/records/tb_funcionario/${id}`;

        const opcoes = {
            method: metodo,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(dadosAtualizados),
        };

        return fetch(url, opcoes)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro na requisição: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Dados Atualizados:', data);
                return data; // opcional: retornar os dados atualizados
            })
            .catch(error => {
                console.error('Erro:', error);
                throw error; // opcional: lançar novamente o erro para tratamento posterior
            });
    }
</script>


<style type="text/css">
    .aberta {
        background-color: #fff;
        border: solid 1px green;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: green;
        cursor: default;
        border-color: green;
    }

    .fechada {
        background-color: #fff;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: blue;
        cursor: default;
        border: solid 1px green;
        border-color: blue;
    }
</style>

<?php
$idfolha = $_GET['id'];
//BUSCA O MES E ANO DA FOLHA SOMENTE PARA O TITULO
$querymesano = "SELECT fls.ref_mes, fls.ref_ano, fls.status as status_folha FROM u940659928_siupa.tb_folhas as fls WHERE fls.id=$idfolha";


if ($stmt = $conn->prepare($querymesano)) {
    $stmt->execute();
    $stmt->bind_result($ref_mes, $ref_ano, $status_folha);
    while ($stmt->fetch()) {
        $mes = mes($ref_mes);
        $ano = $ref_ano;
        $status_folha = $status_folha;
    }
    $stmt->close();
}
?>
<div class="">
    <a href="?setor=adm&sub=rh&subsub=folhas" id="voltarasfolhas" class="btn btn-secondary">
        <img src="/siiupa/imagens/icones/back.svg">
        Voltar às Folhas
    </a>
    <hr id="inicio_folha">
    <?php
    if ($status_folha == "aberta") {

    ?>
        </br>

    <?php
    } else {
    }
    ?>

    <a href="#" id="imprimirfolha" class="btn btn-outline-info">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
        </svg> Imprimir
    </a>
    <a href="#" id="exportar_excel_folha" class="btn btn-outline-info">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1h-2z" />
            <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 1.707V10.5a.5.5 0 0 1-1 0V1.707L5.354 3.854a.5.5 0 1 1-.708-.708l3-3z" />
        </svg> Exportar para Excel
    </a>

</div>


<br>

<?php
//BUSCA OS SERVIDORES DA FOLHA ESPECIFICA
$vinculo_separa = "";
$vinculo_mostra = "Todos";
$setor_separa = "";
$setor_mostra = "";

//botoes não ativos

$bt_efetivos = "btn-outline-primary";
$bt_temporarios = "btn-outline-primary";
$bt_prestadores = "btn-outline-primary";
$bt_intermitente = "btn-outline-primary";
$bt_administrativo = "btn-outline-primary";
$bt_enfermagem = "btn-outline-primary";
$bt_odontologos = "btn-outline-primary";
$bt_rx = "btn-outline-primary";
$bt_enfermeiros = "btn-outline-primary";
$bt_tenfermagem = "btn-outline-primary";


//prepara o link de filtro
if (isset($_GET['vinculo'])) {
    $vinculo_link = $_GET['vinculo'];
} else {
    $vinculo_link = "";
}
if (isset($_GET['folha_setor'])) {
    $setor_link = "&folha_setor=" . $_GET['folha_setor'];
} else {
    $setor_link = "";
}

//busca o vinculo se tiver
if (isset($_GET['vinculo'])) {
    if ($_GET['vinculo'] == "efetivos") {
        $vinculo_separa = "AND func.vinculo like ('%EFET%')";
        $vinculo_mostra = "EFETIVOS";
        $bt_efetivos = "btn-primary";
    }
    if ($_GET['vinculo'] == "temporarios") {
        $vinculo_separa = "AND func.vinculo like('%TEMP%')";
        $vinculo_mostra = "TEMPORARIOS";
        $bt_temporarios = "btn-primary";
    }

    if ($_GET['vinculo'] == "prestadores") {
        $vinculo_separa = "AND func.vinculo like('%PRESTADOR%')";
        $vinculo_mostra = "PRESTADORES";
        $bt_prestadores = "btn-primary";
        $vinculo_link = "";
    }
    if ($_GET['vinculo'] == "intermitente") {
        $vinculo_separa = "AND func.vinculo NOT IN ('EFETIVO','TEMPORARIO','COMISSIONADO-TEMP')";
        $vinculo_mostra = "ACIONAMENTO - ÓBITO EM DOMICÍLIO";
        $bt_intermitente = "btn-primary";
    }
}
//busca o setor se tiver
if (isset($_GET['folha_setor'])) {
    if ($_GET['folha_setor'] == "administrativo") {
        $setor_separa = "AND func.fk_setor NOT IN ('17','21','18')";
        $setor_mostra = " - ADMINISTRATIVO";
        $bt_administrativo = "btn-primary";
    }
    if ($_GET['folha_setor'] == "enfermagem") {
        $setor_separa = "AND func.fk_setor IN ('17','21')";
        $setor_mostra = " - ENFERMAGEM";
        $bt_enfermagem = "btn-primary";
    }
    if ($_GET['folha_setor'] == "enfermeiros") {
        $setor_separa = "AND func.fk_setor IN ('17')";
        $setor_mostra = " - ENFERMEIROS";
        $bt_enfermeiros = "btn-primary";
    }
    if ($_GET['folha_setor'] == "tenfermagem") {
        $setor_separa = "AND func.fk_setor IN ('21')";
        $setor_mostra = " - TEC. Enfermagem";
        $bt_tenfermagem = "btn-primary";
    }
    if ($_GET['folha_setor'] == "odontologiaSuperior") {
        $setor_separa = "AND func.fk_setor IN ('12')";
        $setor_mostra = " - <span class='tituloSetor'>Odontologia</span>";
        $bt_odontologos = "btn-primary";
    }
    if ($_GET['folha_setor'] == "raiox") {
        $setor_separa = "AND func.fk_setor IN ('10')";
        $setor_mostra = " - <span class='tituloSetor'>Raio-x</span>";
        $bt_rx = "btn-primary";
    }
} else {
    $setor_separa = "";
    $setor_mostra = "";
}
//titulo
//echo "<h1>Folha de Pagamento </br>$mes/$ano</h1><h2>$vinculo_mostra</h2>";
?>

Vínculo: <a class="btn btn-outline-primary" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>">TODOS</a>
<a class="btn <?php echo $bt_efetivos; ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=efetivos<?php echo $setor_link; ?>">EFETIVOS</a>
<a class="btn <?php echo $bt_temporarios; ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=temporarios<?php echo $setor_link; ?>">TEMPORARIOS</a>
<a class="btn <?php echo $bt_prestadores; ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=prestadores">MÉDICOS - Prestadores</a>

<br>
Setor:
<a class="btn <?php echo $bt_administrativo; ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=<?php echo $vinculo_link; ?>&folha_setor=administrativo">ADMINISTRATIVO</a>
<a class="btn <?php echo $bt_enfermagem ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=<?php echo $vinculo_link; ?>&folha_setor=enfermagem">ENFERMAGEM</a>
<a class="btn <?php echo $bt_enfermeiros ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=<?php echo $vinculo_link; ?>&folha_setor=enfermeiros">Enfermeiros</a>
<a class="btn <?php echo $bt_tenfermagem ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=<?php echo $vinculo_link; ?>&folha_setor=tenfermagem">Tec. Enfermagem</a>
<a class="btn <?php echo $bt_odontologos ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=<?php echo $vinculo_link; ?>&folha_setor=odontologiaSuperior">ODONTÓLOGOS</a>
<a class="btn <?php echo $bt_rx ?>" href="?setor=adm&sub=rh&subsub=rhfolhaexibe&id=<?php echo $_GET['id']; ?>&vinculo=<?php echo $vinculo_link; ?>&folha_setor=raiox">Raio-X</a>

</br>

</br>
<?php
if ($status_folha == "aberta") {
?>
    <!-- <a href="?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor&idfolha=<?php echo $_GET['id']; ?>" id="btAddServidor2" id-antigo="bcadastrarFUNCIONARIO" class="btn btn-success">
    <img src="/siiupa/imagens/icones/personadd.svg">
    Adicionar servidor nesta folha
</a> -->


    <a class="btn btn-success" id="btAddServidor" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <img src="/siiupa/imagens/icones/personadd.svg">
        Adicionar servidor nesta folha
    </a>

<?php
}
?>
<hr />
<form id="pesquisaAtestados" class="form">
    <strong>Buscar servidores já adicionados:</strong>
    <input id="entrada" type="txt" placeholder="Digite o nome que deseja buscar" class="form-control">
</form>
<strong id="quantidade"></strong>
<span id="saidaTxt"></span><br><br>
<?php
if ($status_folha == "aberta") {
    echo '<div class="aberta" style="text-align:center">FOLHA ABERTA <svg width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
   <path d="M368,0c-61.758,0-112,50.242-112,112v112H64c-17.672,0-32,14.328-32,32v224c0,17.672,14.328,32,32,32h288
       c17.672,0,32-14.328,32-32V256c0-17.672-14.328-32-32-32h-32V112c0-26.469,21.531-48,48-48c26.469,0,48,21.531,48,48v80
       c0,17.672,14.328,32,32,32c17.672,0,32-14.328,32-32v-80C480,50.242,429.758,0,368,0z M224,397.063V432c0,8.836-7.164,16-16,16
       c-8.836,0-16-7.164-16-16v-34.938c-18.602-6.613-32-24.195-32-45.063c0-26.512,21.488-48,48-48s48,21.488,48,48
       C256,372.867,242.602,390.449,224,397.063z" fill="green"/>
   </svg></div>';
} else {
    echo '<div class="fechada" style="text-align:center">FOLHA FECHADA <svg width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 406.481 406.481" style="enable-background:new 0 0 406.481 406.481;" xml:space="preserve">
<rect x="78.241" y="175" style="fill:#1EA6C6;" width="250" height="231.481"/>
<path style="fill:#B3B3B3;" d="M302.269,175V99.028c0-26.454-10.296-51.315-29-70.019C254.574,10.306,229.704,0,203.241,0
   c-54.602,0-99.028,44.426-99.028,99.028V175h35.185V99.028c0-35.204,28.639-63.843,63.843-63.843
   c17.065,0,33.093,6.639,45.139,18.704c12.065,12.056,18.704,28.083,18.704,45.139V175H302.269z"/>
<polygon style="fill:#FFFFFF;" points="191.957,343.55 149.008,300.356 159.645,289.78 190.779,321.092 245.788,252.753 
   257.473,262.158 "/>

</svg>
</div>';
}
echo "<div id='folha_impressao' style='font-size:12px'>"; ///                   ABRE AREA DE IMPRESSAO    
?>
<style type="text/css">
    .cabecalho_folha {

        width: 33% !important;

    }

    .tituloSetor {
        font-size: 22px;
    }

    .logo_direito {
        text-align: right !important;
    }

    .logo_centro {
        text-align: center;
        font-size: 11px;
    }
</style>
<?php

$tab = new Tabela;


$tab->abreTabela('tabelaCabecalho', $class = 'table table-sm border-white table-responsive ');
$tab->abreThead();
$tab->fechaThead();
$tab->tabrelinha();
echo "<td class='cabecalho_folha'><img src='/siiupa/imagens/gov_logo_2021.png' height='45px';></td>";
echo "<td class='cabecalho_folha logo_centro'>PREFEITURA MUNICIPAL DE CASTANHAL<br>SECRETARIA MUNICIPAL DE SAÚDE<br>COORDENAÇÃO DE URGÊNCIA E EMERGÊNCIA<br>UPA III - GOVERNADOR ALMIR GABRIEL</td>";
echo "<td class='cabecalho_folha logo_direito'><img src='/siiupa/imagens/upa_hor_logo.JPG' height='45px'></td>";

//$tab->tpopulalinha("<p class='text-center' style='font-size:11px'>PREFEITURA MUNICIPAL DE CASTANHAL<br>SECRETARIA MUNICIPAL DE SAÚDE<br>COORDENAÇÃO DE URGÊNCIA E EMERGÊNCIA<br>UPA III - GOVERNADOR ALMIR GABRIEL</p>");
//$tab->tpopulalinha('<p class="text-right"><img src="/siiupa/imagens/upa_hor_logo.JPG" height="45px"></p>');
$tab->tfechalinha();


$tab->tabrelinha();

$tab->tpopulalinha("<h5 class='text-center' style='font-size:16px' id='titulo_folha' data-titulo='Folha de Pagamento $mes-$ano'>Folha de Pagamento </br><strong>$mes/$ano</strong></h5><h6 class='text-center' style='font-size:14px'>$vinculo_mostra $setor_mostra</h6>", '', $mesclacolunas = '3');
$tab->tpopulalinha("");
$tab->tfechalinha();
$tab->fechaTabela();

$query = "SELECT fl.id as id_linha, func.id, func.matricula, func.cpf, func.vinculo, func.nome, cargo.funcao_upa, cargo.titulo, fl.adc_not, fl.ext_6, fl.ext_12, fl.ext_24, fl.acionamento, fl.transferencia, fl.fixos, fl.obs, cargo.valor_plantao, cargo.valor_acionamento, cargo.valor_transferencia FROM u940659928_siupa.tb_folha AS fl INNER JOIN u940659928_siupa.tb_funcionario AS func ON (fl.fk_funcionario = func.id) INNER JOIN u940659928_siupa.tb_cargo AS cargo ON (func.fk_cargo = cargo.id) WHERE fl.fk_folhas = '$idfolha' $vinculo_separa $setor_separa ORDER BY func.nome ASC";
ECHO $query;

if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id_linha, $func_id, $fmatricula, $fcpf, $fvinculo, $nome, $funcao_upa, $cargoTitulo, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, $fixos, $obs, $valor_plantao, $valor_acionamento, $valor_transferencia);

    $valor_geral = 0;


    $i = 0;



    echo '
<table class="table  table-bordered  border-dark table-sm table-hover table-striped Tabela_folha" style="font-size:12px">
        <thead>
          <tr>
            <th scope="col">N#</th>
            <th scope="col">MATRICULA</th>
            <th scope="col">CPF</th>
            <th scope="col">VÍNCULO</th>
            <th scope="col">NOME</th>
            <th scope="col">CARGO</th>
            <th scope="col">ADC.NOT</th>
            <th scope="col">06h</th>
            <th scope="col">12h</th>
            <th scope="col">24h</th>
            <th scope="col">ACION.</th>
            <th scope="col">TRANSF.</th>
            <th scope="col">FIXOS</th>
            <th scope="col">VALOR TOTAL</th>
            <th scope="col" class="col-2">OBS</th>
           
            
          </tr>
        </thead>
        <tbody>
        ';

    while ($stmt->fetch()) {
        $i++;

        if ($ext_6 == "") {
            $ext_6 = 0;
        }
        if ($ext_12 == "") {
            $ext_12 = 0;
        }
        if ($ext_24 == "") {
            $ext_24 = 0;
        }
        if ($acionamento == "") {
            $acionamento = 0;
        }
        $valores_exibe[$func_id] = "";

        $transferencia = trataNaoNumericos($transferencia);
        $fixos = trataNaoNumericos($fixos);
        $valor_transferencia = trataNaoNumericos($valor_transferencia);
        $ext_6 = trataNaoNumericos($ext_6);
        $ext_12 = trataNaoNumericos($ext_12);
        $ext_24 = trataNaoNumericos($ext_24);
        $valor_total = ($ext_6 * ($valor_plantao / 2)) + ($ext_12 * $valor_plantao) + ($ext_24 * ($valor_plantao * 2)) + ($valor_acionamento * $acionamento) + ($valor_transferencia * $transferencia) + $fixos;

        if ($status_folha == "aberta") {
            // $link_para_alterar = "?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor&acao=seleciona&idservidor=$func_id&idfolha=$idfolha&subacao=alterar";
            $link_para_alterar = "/siiupa/administracao/pagina_rh_folha_adicionaservidor.php?setor=adm&sub=rh&subsub=rhfolhaadicionaservidor&acao=seleciona&idservidor=$func_id&idfolha=$idfolha&subacao=alterar";
        } else {
            $link_para_alterar = 'javascript:alert("Folha fechada. Alteração não permitida.");';
        }

        //$fcpfn = preg_replace("/[^0-9]/", "", $fcpf);
        $fcpfn = "";
        $fcpfn = strval(preg_replace("/[^0-9]/", "", $fcpf));

        $fcpfpontos = substr($fcpfn, 0, 3) . '.' . substr($fcpfn, 3, 3) . '.' . substr($fcpfn, 6, 3) . '-' . substr($fcpfn, 9, 2);

?>
        <script>
            // CONSULTAR E ATUALIZAR MATRICULAS

            // consultarMatricula('<?= $fcpfpontos ?>')
            //     .then(matricula => {
            //         console.log(<?= $fcpfn ?>);
            //         console.log('Matrícula: ', matricula);
            //         document.getElementById('<?php echo $fcpfn; ?>').textContent = matricula + " - " + "<?= $func_id ?>";
            //         const idFuncionario<?= $fcpfn ?> = <?= $func_id ?>;
            //         const dadosFuncionario<?= $fcpfn ?> = {
            //             matricula: matricula
            //         };

            //         const url<?=$fcpfn?> = 'https://siupa.com.br/siiupa/api/rh/api.php/records/tb_funcionario/<?=$func_id?>';

            //         const dadosAtualizados<?=$fcpfn?> = {
            //             matricula: matricula
            //         };

            //         const opcoes<?=$fcpfn?> = {
            //             method: 'PUT', // Método HTTP PATCH para atualização parcial
            //             headers: {
            //                 'Content-Type': 'application/json',
            //             },
            //             body: JSON.stringify(dadosAtualizados<?=$fcpfn?>),
            //         };

            //         fetch(url<?=$fcpfn?>, opcoes<?=$fcpfn?>)
            //             .then(response => {
            //                 if (!response.ok) {
            //                     throw new Error(`Erro na requisição: ${response.status}`);
            //                 }
            //                 return response.json();
            //             })
            //             .then(data => {
            //                 console.log('Dados Atualizados:', data);
            //             })
            //             .catch(error => {
            //                 console.error('Erro:', error);
            //             });

            //     })
            //     .catch(error => {
            //         console.log('erro');
            //     });
        </script>
<?php

        printf("
        
        <tr class='align-middle box_nomes' name='%s'>
        <td>%s</td>
        <td class='fmatricula' id='%s'>%s</td>
        <td class='fcpf' >%s</td>       
        <td class='fvinculo'>%s</td>
        <td id='%s'><a href='%s#offcanvasExample'class='btEditaServidor text-dark text-decoration-none' data-bs-toggle='offcanvas' role='button' aria-controls='offcanvasExample'>%s</a></td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td  class='table-responsive-lg text-right' style='text-align:right'><i>R$</i> %s</td>
        <td>%s</td>
        

      </tr>", $nome, $i, $fcpfn,  $fmatricula, $fcpfpontos, $fvinculo, $id_linha, $link_para_alterar, $nome, $cargoTitulo, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, number_format($fixos, 2, ',', '.'), number_format($valor_total, 2, ',', '.'), $obs);
        $valor_geral = $valor_geral + $valor_total;
    }
    $stmt->close();
}

function numberParaReal($numero)
{

    return  "R$ " . number_format($numero, 2, ",", ".");;
}

$valor_geral_reais = numberParaReal($valor_geral);
echo "<tr><td colspan='10' style='text-align:right'>Total: </td><td colspan='1' style='text-align:right'>$valor_geral_reais</td><td></td></tr>";
echo '</tbody>
</table>';


echo "</div>"; ///                   FECHA AREA DE IMPRESSAO    
?>



<div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Editar Servidor</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="offCanvas">



        </div>
        <div id="servCanvas"></div>


    </div>
</div>
<?php
function mes($entrada)
{
    switch ($entrada) {
        case 1:
            return "Janeiro";
        case 2:
            return "Fevereiro";
        case 3:
            return "Março";
        case 4:
            return "Abril";
        case 5:
            return "Maio";
        case 6:
            return "Junho";
        case 7:
            return "Julho";
        case 8:
            return "Agosto";
        case 9:
            return "Setembro";
        case 10:
            return "Outubro";
        case 11:
            return "Novembro";
        case 12:
            return "Dezembro";
    }
    return $entrada;
}
?>
<script>
    function loadCanvas(link) {
        $("#servCanvas").html(' <div class="spinner-border text-primary" role="status"></div>');
        $("#servCanvas").load(link);
    }
    $(function() {
        $(document).ready(function() {
            $("#btAddServidor").click(function(e) {
                e.preventDefault();
                loadCanvas('administracao/pagina_rh_folha_adicionaservidor.php?idfolha=<?= $idfolha ?>')
            });


            $(".btEditaServidor").click(function(e) {
                e.preventDefault();
                console.log(this.href);
                loadCanvas(this.href)
            });


            var busca = null;
            var boxes = $(".box_nomes"); //boxes onde contem os dados a serem pesquisados
            boxes = boxes.toArray();
            var array = [];
            var arrayValores = [];
            for (box in boxes) {
                array.push(boxes[box].attributes.name.value) //lista de valores a serem buscados

            }

            $('#pesquisaAtestados').bind('input', function() {
                busca = $('#entrada').val().toLowerCase();

                if (busca !== '') {
                    var corresponde = false;
                    var saida = Array();
                    var quantidade = 0;
                    for (var key in array) {

                        corresponde = array[key].toLowerCase().indexOf(busca) >= 0;
                        if (corresponde) {
                            saida.push(array[key]);
                            nome = array[key];
                            arrayValores[nome] = boxes[key];
                            $(boxes[key]).show();
                            quantidade += 1;
                        } else {
                            $(boxes[key]).hide();

                        }
                    }
                    if (quantidade) {
                        $('#saidaTxt').text('');
                        $('#quantidade').html(quantidade + ' resultados!<br><br>');
                        for (var ind in saida) {

                            nomeSaida = saida[ind]
                            arrayValores[nomeSaida]
                            //$('#saidaTxt').append(arrayValores[nomeSaida]);

                        }

                    } else {
                        $('#quantidade').html('');
                        $('#saidaTxt').text('Nenhum resultado...');
                        $('.box_nomes').show();
                    }

                } else {
                    $('#quantidade').html('');
                    $('#saidaTxt').text('Nenhum resultado...');

                    $('.box_nomes').show()
                }




            });
        });
        $(window).scrollTop($('#inicio_folha').offset().top);
        $("#imprimirfolha").click(function() {
            var elem = $('#folha_impressao');
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('<link rel="stylesheet" href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">');
            mywindow.document.write('</head><body >');
            //mywindow.document.write('<img src="imagens/siiupa.png">');

            mywindow.document.write(elem.html());
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            // mywindow.close();


            return true;
        });

        $('#exportar_excel_folha').click(function(e) {
            e.preventDefault();

            $(".Tabela_folha").table2excel({
                filename: $("#titulo_folha").data("titulo") + ".xls", // do include extension
                preserveColors: true
            });
        });
    });
</script>